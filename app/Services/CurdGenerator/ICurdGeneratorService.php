<?php 


namespace App\Services\CurdGenerator;
use App\Services\IBaseService;

interface ICurdGeneratorService extends IBaseService
{
    public function generateModel($modelName, $softDelete, $fields, $relationships);

    public function generateMigration($modelName, $fields, $softDelete);

    public function generateOrBindServiceAndRepository($modelName);

    public function generateRoutes($modelName);

    public function generateCreateView($modelName, $fields);

    public function generateEditView($modelName, $fields);

    public function generateIndexView($modelName, $fields);

    public function generateJavaScript($modelName, $fields);

    public function addMenuItem($modelName);

    public function createPermission($modelName);

    public function generateCreateRequestFile($modelName, $validations);

    public function generateUpdateRequestFile($modelName, $validations);
}
