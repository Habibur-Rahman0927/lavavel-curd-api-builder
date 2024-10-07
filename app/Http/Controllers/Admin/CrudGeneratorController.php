<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use Illuminate\Database\Eloquent\Model;

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

    public function generateModelWithMigration()
    {

    }
}
