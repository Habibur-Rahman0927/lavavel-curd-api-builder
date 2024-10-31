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

    public function showCurdAndAPIGeneratorForm()
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

    public function generateCurdAndAPI(Request $request)
    {
        $modelName = $request->input('model_name');
        $softDelete = $request->has('softdelete');
        $fields = $request->input('fields');
        $relationships = $request->input('relationships');
        $createRoute = $request->has('create_route');
        $fieldNames = $request->input('fieldNames');
        $validations = $request->input('validations');
        $useCaseType = $request->input('use_case_type');

        $modelCreationResult = $this->curdGeneratorService->generateModel($modelName, $softDelete, $fields, $relationships);
        $migrationCreationResult = $this->curdGeneratorService->generateMigration($modelName, $fields, $softDelete);

        if (!$modelCreationResult['success'] || !$migrationCreationResult['success']) {
            return redirect()->back()->with('error', "Failed to create Model or Migration: " . ($modelCreationResult['error'] ?? '') . ' ' . ($migrationCreationResult['error'] ?? ''));
        }

        Artisan::call('app:service-gen', ['name' => $modelName]);
        Artisan::call('app:repository-gen', ['name' => $modelName]);
        $this->curdGeneratorService->generateOrBindServiceAndRepository($modelName);

        $createRequestResult = $this->curdGeneratorService->generateCreateRequestFile($modelName, $validations);
        $updateRequestResult = $this->curdGeneratorService->generateUpdateRequestFile($modelName, $validations);

        if (!$createRequestResult['success'] || !$updateRequestResult['success']) {
            return redirect()->back()->with('error', "Failed to create request files: " . ($createRequestResult['error'] ?? '') . ' ' . ($updateRequestResult['error'] ?? ''));
        }

        if ($useCaseType === 'curd') {
            Artisan::call('app:controller-gen', ['name' => $modelName]);
            return $this->handleCurd($modelName, $createRoute, $fieldNames);
        } elseif ($useCaseType === 'api') {
            return $this->handleApi($modelName, $createRoute, $fields);
        } elseif ($useCaseType === 'api_curd') {
            Artisan::call('app:controller-gen', ['name' => $modelName]);
            return $this->handleApiCurd($modelName, $createRoute, $fieldNames, $fields);
        }
    
        return redirect()->back()->with('error', 'Invalid Curd and api generator specified.');

    }

    private function handleCurd($modelName, $createRoute, $fieldNames)
    {
        if ($createRoute) {
            $routeResult = $this->curdGeneratorService->generateRoutes($modelName);
            if ($routeResult['success']) {
                $this->generateViews($modelName, $fieldNames);
                return redirect()->back()->with('success', 'CRUD resources created successfully with routes.');
            }
            return redirect()->back()->with('warning', 'CRUD resources created, but route generation failed.');
        }
        return redirect()->back()->with('success', 'CRUD resources created without routes.');
    }

    private function handleApi($modelName, $createRoute, $fields)
    {
        if ($createRoute) {
            $apiRouteResult = $this->curdGeneratorService->generateRoutes($modelName, true);
            if ($apiRouteResult['success']) {
                $apiControllerResult = $this->curdGeneratorService->generateApiController($modelName, $fields);
                if ($apiControllerResult['success']) {
                    return redirect()->back()->with('success', 'API resources created successfully with routes and controller.');
                }
                return redirect()->back()->with('warning', 'API resources created, but controller generation failed.');
            }
            return redirect()->back()->with('warning', 'API resources created, but route generation failed.');
        }
        return redirect()->back()->with('success', 'API resources created without routes.');
    }

    private function handleApiCurd($modelName, $createRoute, $fieldNames, $fields)
    {
        if ($createRoute) {
            $routeResult = $this->curdGeneratorService->generateRoutes($modelName);
            $apiRouteResult = $this->curdGeneratorService->generateRoutes($modelName, true);
            if ($routeResult['success'] && $apiRouteResult['success']) {
                $this->generateViews($modelName, $fieldNames);
                $apiControllerResult = $this->curdGeneratorService->generateApiController($modelName, $fields);
                if ($apiControllerResult['success']) {
                    return redirect()->back()->with('success', 'Full CRUD and API resources created successfully with routes.');
                }
                return redirect()->back()->with('warning', 'Full resources created, but API controller generation failed.');
            }
            return redirect()->back()->with('warning', 'Full resources created, but route generation failed.');
        }
        return redirect()->back()->with('success', 'Full CRUD and API resources created without routes.');
    }

    private function generateViews($modelName, $fieldNames)
    {
        $this->curdGeneratorService->generateCreateView($modelName, $fieldNames);
        $this->curdGeneratorService->generateEditView($modelName, $fieldNames);
        $indexView = $this->curdGeneratorService->generateIndexView($modelName, $fieldNames);
        
        if ($indexView['success']) {
            $this->curdGeneratorService->generateJavaScript($modelName, $fieldNames);
            $this->curdGeneratorService->addMenuItem($modelName);
            $this->curdGeneratorService->createPermission($modelName);
        }
    }

}
