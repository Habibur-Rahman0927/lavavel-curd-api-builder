<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RepositoryServiceGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repository-service-generate {name : The name of the files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');

        $this->generateRepositoryInterfaceFile($name);
        $this->generateImplementRepositoryFile($name);

        $this->generateServiceInterfaceFile($name);
        $this->generateImplementServiceFile($name);

        $this->info('Files generated successfully.');
    }

    private function generateRepositoryInterfaceFile($name): void
    {
        $directory = app_path("Repositories/{$name}");
        $this->createDirectoryIfNotExists($directory);

        $content = view('templates.repository.repository_interface', compact('name'))->render();
        $filePath = app_path("Repositories/{$name}/I{$name}Repository.php");
        File::put($filePath, "<?php \n \n \n". $content);
    }

    private function generateImplementRepositoryFile($name): void
    {
        $directory = app_path("Repositories/{$name}");
        $this->createDirectoryIfNotExists($directory);

        $content = view('templates.repository.repository_implement', compact('name'))->render();
        $filePath = app_path("Repositories/{$name}/{$name}Repository.php");
        File::put($filePath, "<?php \n \n \n". $content);
    }

    private function generateServiceInterfaceFile($name): void
    {
        $directory = app_path("Services/{$name}");
        $this->createDirectoryIfNotExists($directory);

        $content = view('templates.service.service_interface', compact('name'))->render();
        $filePath = app_path("Services/{$name}/I{$name}Service.php");
        File::put($filePath, "<?php \n \n \n". $content);
    }

    private function generateImplementServiceFile($name): void
    {
        $directory = app_path("Services/{$name}");
        $this->createDirectoryIfNotExists($directory);

        $content = view('templates.service.service_implement', compact('name'))->render();
        $filePath = app_path("Services/{$name}/{$name}Service.php");
        File::put($filePath, "<?php \n \n \n". $content);
    }

    

    private function createDirectoryIfNotExists($directory): void
    {
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }
    }
}
