<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CrudGeneratorRequest;
use App\Services\CurdGenerator\ICurdGeneratorService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class CrudGeneratorController extends Controller
{
    public function __construct(private ICurdGeneratorService $curdGeneratorService)
    {

    }

    public function showCurdGeneratorForm()
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

    public function generateCurd(Request $request)
    {
        $modelName = $request->input('model_name');
        $softDelete = $request->has('softdelete');
        $fields = $request->input('fields');
        $relationships = $request->input('relationships');
        $createRoute = $request->has('create_route');
        $fieldNames = $request->input('fieldNames');

        $modelCreationResult = $this->curdGeneratorService->generateModel($modelName, $softDelete, $fields, $relationships);
        $migrationCreationResult = $this->curdGeneratorService->generateMigration($modelName, $fields, $softDelete);

        if ($modelCreationResult['success'] && $migrationCreationResult['success']) {
            Artisan::call('app:controller-gen', ['name' => $modelName]);
            Artisan::call('app:service-gen', ['name' => $modelName]);
            Artisan::call('app:repository-gen', ['name' => $modelName]);
            $this->curdGeneratorService->generateOrBindServiceAndRepository($modelName);
            if ($createRoute) {
                $routeCreationResult = $this->curdGeneratorService->generateRoutes($modelName);
                if ($routeCreationResult['success']) {
                    $this->curdGeneratorService->generateCreateView($modelName, $fieldNames);
                    $this->curdGeneratorService->generateEditView($modelName, $fieldNames);
                    $indexView = $this->curdGeneratorService->generateIndexView($modelName, $fieldNames);
                    if ($indexView['success']) {
                        $this->curdGeneratorService->generateJavaScript($modelName, $fieldNames);
                        $this->curdGeneratorService->addMenuItem($modelName);
                        $this->curdGeneratorService->createPermission($modelName);
                    }
                    return redirect()->back()->with('success', 'Model, Migration, Routes and View created successfully!');
                } else {
                    return redirect()->back()->with('success', 'Model and Migration created, but failed to create routes: ' . $routeCreationResult['error']);
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

}
