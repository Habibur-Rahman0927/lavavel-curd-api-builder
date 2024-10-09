<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrudGeneratorRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CrudGeneratorController extends Controller
{
    public function showModelForm()
    {
        $modelsPath = app_path('Models');
        $files = File::files($modelsPath);
        $modelNames = [];
        foreach ($files as $file) {
            $className = 'App\\Models\\' . $file->getFilenameWithoutExtension();

            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);

                if ($reflection->isSubclassOf(Model::class)) {
                    $modelNames[] = $reflection->getShortName();
                }
            }
        }

        return view('admin.crudGenerator.create')->with([
            'modelNames' => $modelNames
        ]);
    }

    public function generateModelWithMigration(CrudGeneratorRequest $request)
    {
        $modelName = $request->input('model_name');
        $softDelete = $request->has('softdelete');
        $fields = $request->input('fields');
        $relationships = $request->input('relationships');
        $createRoute = $request->has('create_route');

        $modelCreationResult = $this->generateModel($modelName, $softDelete, $fields, $relationships);
        $migrationCreationResult = $this->generateMigration($modelName, $fields, $softDelete);

        if ($modelCreationResult['success'] && $migrationCreationResult['success']) {
            if ($createRoute) {
                $routeCreationResult = $this->generateRoutes($modelName);
                if ($routeCreationResult['success']) {
                    return redirect()->back()->with('success', 'Model, Migration, and Routes created successfully!');
                } else {
                    return redirect()->back()->with('error', 'Model and Migration created, but failed to create routes: ' . $routeCreationResult['error']);
                }
            } else {
                return redirect()->back()->with('success', 'Model, Migration, without Routes created successfully!');
            }
            
        } else {
            return redirect()->back()->with('error', 'Failed to create Model or Migration. ' . 
                ($modelCreationResult['error'] ?? '') . ' ' . 
                ($migrationCreationResult['error'] ?? ''));
        }
    }

    protected function generateModel($modelName, $softDelete, $fields, $relationships)
    {
        $modelPath = app_path("Models/{$modelName}.php");

        try {
            // Check if the model already exists
            if (File::exists($modelPath)) {
                return ['success' => false, 'error' => "Model {$modelName} already exists."];
            }

            $modelTemplate = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n";

            // Use SoftDeletes if applicable
            if ($softDelete) {
                $modelTemplate .= "use Illuminate\Database\Eloquent\SoftDeletes;\n";
            }
            if ($relationships) {
                // Collect unique relationship types from the relationships array
                $relationshipTypes = array_unique(array_column($relationships, 'type'));

                foreach ($relationshipTypes as $type) {
                    switch ($type) {
                        case 'hasOne':
                            $modelTemplate .= "use Illuminate\Database\Eloquent\Relations\HasOne;\n";
                            break;
                        case 'hasMany':
                            $modelTemplate .= "use Illuminate\Database\Eloquent\Relations\HasMany;\n";
                            break;
                        case 'belongsTo':
                            $modelTemplate .= "use Illuminate\Database\Eloquent\Relations\BelongsTo;\n";
                            break;
                        case 'belongsToMany':
                            $modelTemplate .= "use Illuminate\Database\Eloquent\Relations\BelongsToMany;\n";
                            break;
                    }
                }
            }
            

            $modelTemplate .= "\nclass {$modelName} extends Model\n{\n";

            // Add SoftDeletes trait if applicable
            if ($softDelete) {
                $modelTemplate .= "\tuse SoftDeletes;\n\n";
            }

            // Add fillable fields
            $fillableFields = array_column($fields, 'name');
            $modelTemplate .= "\t/**\n\t * The attributes that are mass assignable.\n\t *\n\t * @var array\n\t */\n";
            $modelTemplate .= "\tprotected \$fillable = [\n\t\t'" . implode("',\n\t\t'", $fillableFields) . "'\n\t];\n";

            if ($relationships) {
                foreach ($relationships as $relationship) {
                    $relatedModel = ucfirst($relationship['related_model']);
                    $foreignKey = $relationship['foreign_key'];
                    $relationshipType = $relationship['type'];
                    $upperCaseRelationType = ucfirst($relationship['type']);
    
                    // Define the relationship method name based on the related model and type
                    $relationshipMethodName = ($relationshipType === 'belongsToMany' || $relationshipType === 'hasMany')
                        ? Str::camel(Str::plural($relatedModel))
                        : Str::camel($relatedModel);
    
                    // Check if the method already exists in the model, if so, skip adding it
                    if (preg_match("/function\s+{$relationshipMethodName}\s*\(/i", $modelTemplate)) {
                        continue;
                    }
    
                    // Define relationship method with docblock and return type
                    $modelTemplate .= "\n\t/**\n\t * Define a {$upperCaseRelationType} relationship.\n\t *\n\t * @return {$upperCaseRelationType}\n\t */\n";
                    $modelTemplate .= "\tpublic function {$relationshipMethodName}(): {$upperCaseRelationType}\n\t{\n";
                    $modelTemplate .= "\t\treturn \$this->{$relationshipType}({$relatedModel}::class, '{$foreignKey}');\n\t}\n";
                }
            }

            $modelTemplate .= "}\n";

            // Save the model file content
            File::put($modelPath, $modelTemplate);

            return ['success' => true]; // Model created successfully
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()]; // Failed to create model
        }
    }

    protected function generateRoutes($modelName)
    {
        try {
            $controllerImport = "use App\Http\Controllers\Admin\\" . $modelName . "Controller;";
            $routeContent = "\n\nRoute::resource('" . strtolower($modelName) . "', " . $modelName . "Controller::class);";
            $routeContent .= "\nRoute::get('" . strtolower($modelName) . "-list', [" . $modelName . "Controller::class, 'getDatatables'])->name('" . strtolower($modelName) . "-list');";

            $routeFilePath = base_path('routes/admin.php');
            $currentRouteFileContent = file_get_contents($routeFilePath);

            if (strpos($currentRouteFileContent, $controllerImport) === false) {
                $lines = explode("\n", $currentRouteFileContent);
                $importIndex = null;

                foreach ($lines as $index => $line) {
                    if (trim($line) === 'use Illuminate\Support\Facades\Route;') {
                        $importIndex = $index;
                        break;
                    }
                }
                if ($importIndex !== null) {
                    array_splice($lines, $importIndex, 0, $controllerImport);
                    $updatedContent = implode("\n", $lines);
                    file_put_contents($routeFilePath, $updatedContent);
                } else {
                    $currentRouteFileContent = $currentRouteFileContent .  "\n" . $controllerImport;
                    file_put_contents($routeFilePath, $currentRouteFileContent);
                }
            }
            file_put_contents($routeFilePath, $routeContent, FILE_APPEND);

            return ['success' => true];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }






    protected function generateMigration($modelName, $fields, $softDelete)
    {
        $tableName = strtolower(Str::plural($modelName));
        $migrationName = "create_{$tableName}_table";

        // Check if a migration file already exists
        $migrationFiles = glob(database_path("migrations/*_{$migrationName}.php"));
        if (!empty($migrationFiles)) {
            return ['success' => false, 'error' => "Migration for table {$tableName} already exists."];
        }

        try {
            // Start building the migration
            $migrationTemplate = "<?php\n\nuse Illuminate\Database\Migrations\Migration;\n";
            $migrationTemplate .= "use Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\n";
            $migrationTemplate .= "return new class extends Migration\n{\n";

            // Add PHPDoc for the up method
            $migrationTemplate .= "\t/**\n\t * Run the migrations.\n\t *\n\t * @return void\n\t */\n";
            $migrationTemplate .= "\tpublic function up()\n\t{\n";
            $migrationTemplate .= "\t\tSchema::create('{$tableName}', function (Blueprint \$table) {\n\t\t\t\$table->id();\n";

            // List of field types that should treat default values as numeric
            $numericTypes = [
                'integer', 'tinyInteger', 'mediumInteger', 'bigInteger', 'smallInteger', 'unsignedBigInteger',
                'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger',
                'float', 'double', 'decimal', 'boolean'
            ];

            // Loop through the fields and add them to the migration
            foreach ($fields as $field) {
                $fieldType = $field['type'];
                $fieldName = $field['name'];
                $length = isset($field['length']) ? ", {$field['length']}" : '';
                $nullable = isset($field['nullable']) ? '->nullable()' : '';
                $unique = isset($field['unique']) ? '->unique()' : '';
                $unsigned = isset($field['unsigned']) ? '->unsigned()' : '';

                // Check if the field type is numeric and assign the default value accordingly
                if (isset($field['default'])) {
                    if (in_array($fieldType, $numericTypes)) {
                        $default = "->default({$field['default']})"; // Numeric default
                    } else {
                        $default = "->default('{$field['default']}')"; // String default
                    }
                } else {
                    $default = '';
                }

                $comment = isset($field['comment']) ? "->comment('{$field['comment']}')" : '';

                // Construct the field definition
                $migrationTemplate .= "\t\t\t\$table->{$fieldType}('{$fieldName}'{$length}){$nullable}{$unique}{$unsigned}{$default}{$comment};\n";

                // If index is checked
                if (isset($field['index'])) {
                    $migrationTemplate .= "\t\t\t\$table->index('{$fieldName}');\n";
                }
            }

            // Add timestamps and soft delete fields
            $migrationTemplate .= "\t\t\t\$table->timestamps();\n";
            if ($softDelete) {
                $migrationTemplate .= "\t\t\t\$table->softDeletes();\n";
            }

            $migrationTemplate .= "\t\t});\n\t}\n\n";

            // Add PHPDoc for the down method
            $migrationTemplate .= "\t/**\n\t * Reverse the migrations.\n\t *\n\t * @return void\n\t */\n";
            $migrationTemplate .= "\tpublic function down(): void\n\t{\n";
            $migrationTemplate .= "\t\tSchema::dropIfExists('{$tableName}');\n\t}\n";

            $migrationTemplate .= "};\n";

            $migrationPath = base_path("database/migrations/" . date('Y_m_d_His') . "_{$migrationName}.php");

            // Create the migration file
            File::put($migrationPath, $migrationTemplate);

            return ['success' => true]; // Migration created successfully
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()]; // Failed to create migration
        }
    }





}
