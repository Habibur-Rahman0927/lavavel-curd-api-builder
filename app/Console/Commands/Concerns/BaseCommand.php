<?php

namespace App\Console\Commands\Concerns;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

abstract class BaseCommand extends Command
{
    /**
     * Generate a controller file.
     *
     * @param string $name
     * @return bool
     */
    protected function generateController(string $name): bool
    {
        $filePath = app_path("Http/Controllers/Admin/{$name}Controller.php");

        try {
            if ($this->fileExists($filePath)) {
                return false;
            }

            $content = view('templates.controller.controller', compact('name'))->render();
            File::put($filePath, "<?php \n\n\n" . $content);
            $this->info("Controller file created: {$filePath}");

            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create controller file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generate a request file.
     *
     * @param string $name
     * @param string $type
     * @return bool
     */
    protected function generateRequest(string $name, string $type): bool
    {
        $filePath = app_path("Http/Requests/{$type}{$name}Request.php");

        try {
            if ($this->fileExists($filePath)) {
                return false;
            }

            $content = view('templates.request.' . strtolower($type) . '_request', compact('name'))->render();
            File::put($filePath, "<?php \n\n\n" . $content);
            $this->info("Request file created: {$filePath}");

            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create request file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generates the service interface file.
     *
     * @param string $name The name of the service
     * @return bool
     */
    protected function generateServiceInterfaceFile(string $name): bool
    {
        $directory = app_path("Services/{$name}");

        if (!$this->createDirectoryIfNotExists($directory)) {
            return false;
        }

        $filePath = app_path("Services/{$name}/I{$name}Service.php");

        try {
            if ($this->fileExists($filePath)) {
                return false;
            }

            $content = view('templates.service.service_interface', compact('name'))->render();
            File::put($filePath, "<?php \n\n\n" . $content);
            $this->info("Service interface file created: {$filePath}");

            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create service interface file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generates the service implementation file.
     *
     * @param string $name The name of the service
     * @return bool
     */
    protected function generateImplementServiceFile(string $name): bool
    {
        $directory = app_path("Services/{$name}");

        if (!$this->createDirectoryIfNotExists($directory)) {
            return false;
        }

        $filePath = app_path("Services/{$name}/{$name}Service.php");

        try {
            if ($this->fileExists($filePath)) {
                return false;
            }

            $content = view('templates.service.service_implement', compact('name'))->render();
            File::put($filePath, "<?php \n\n\n" . $content);
            $this->info("Service implementation file created: {$filePath}");

            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create service implementation file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generates the repository interface file.
     *
     * @param string $name The name of the repository
     * @return bool
     */
    protected function generateRepositoryInterfaceFile(string $name): bool
    {
        $directory = app_path("Repositories/{$name}");

        if (!$this->createDirectoryIfNotExists($directory)) {
            return false;
        }

        $filePath = app_path("Repositories/{$name}/I{$name}Repository.php");

        try {
            if ($this->fileExists($filePath)) {
                return false;
            }

            $content = view('templates.repository.repository_interface', compact('name'))->render();
            File::put($filePath, "<?php \n\n\n" . $content);
            $this->info("Repository interface file created: {$filePath}");

            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create repository interface file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Generates the repository implementation file.
     *
     * @param string $name The name of the repository
     * @return bool
     */
    protected function generateImplementRepositoryFile(string $name): bool
    {
        $directory = app_path("Repositories/{$name}");

        if (!$this->createDirectoryIfNotExists($directory)) {
            return false;
        }

        $filePath = app_path("Repositories/{$name}/{$name}Repository.php");

        try {
            if ($this->fileExists($filePath)) {
                return false;
            }

            $content = view('templates.repository.repository_implement', compact('name'))->render();
            File::put($filePath, "<?php \n\n\n" . $content);
            $this->info("Repository implementation file created: {$filePath}");

            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create repository implementation file: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if the file already exists.
     *
     * @param string $filePath
     * @return bool
     */
    protected function fileExists(string $filePath): bool
    {
        try {
            if (File::exists($filePath)) {
                $this->error("File already exists: {$filePath}");
                return true;
            }
            return false;
        } catch (\Exception $e) {
            $this->error('Failed to check if file exists: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Creates a directory if it doesn't exist.
     *
     * @param string $directory The directory path
     * @return bool
     */
    protected function createDirectoryIfNotExists(string $directory): bool
    {
        try {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0777, true, true);
                $this->info("Directory created: {$directory}");
            }
            return true;
        } catch (\Exception $e) {
            $this->error('Failed to create directory: ' . $e->getMessage());
            return false;
        }
    }
}
