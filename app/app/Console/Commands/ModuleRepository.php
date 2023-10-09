<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Prettus\Repository\Generators\BindingsGenerator;
use Prettus\Repository\Generators\FileAlreadyExistsException;
use Str;

class ModuleRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-repository
    {repository : The name of the repository}
    {module : The name of the module}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run l5-repository make:entity command for a module.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module = $this->argument('module');
        $repository = $this->argument('repository');

        config(['repository.generator.basePath' => module_path($module)]);
        config(['repository.generator.rootNamespace' => config('modules.namespace').'\\'.$module.'\\']);
        config(['repository.generator.stubsOverridePath' => module_path($module)]);
        config(['repository.generator.paths.provider'=>'RepositoryServiceProvider']);
        // $this->call('make:presenter', [
        //     'name' => $repository
        // ]);

        // $this->call('make:validator', [
        //     'name' => $repository
        // ]);


        // $this->fix();

        $this->call('make:repository', [
            'name' => $repository,
            '--skip-migration' => true
        ]);
        $this->bindingRepository();
        $this->makeController();
        $this->info("{$repository} created in {$module}");
    }

    public function makeController(){
        $module = $this->argument('module');
        $repository = $this->argument('repository');
        $controller_command = 'module:make-controller';
        $this->call($controller_command,[
            'controller' => $repository,
            'module' => $module,
            '--api' => true
        ]);

        $this->call('module:make-request',[
            'name' => $repository.'CreateRequest',
            'module' => $module
        ]);
        $this->call('module:make-request',[
            'name' => $repository.'UpdateRequest',
            'module' => $module
        ]);
    }

    private function fix(): void
    {
        $module = $this->argument('module');
        $repository = $this->argument('repository');

        $files =[
            'Http/Requests/'.$repository.'CreateRequest.php',
            'Http/Requests/'.$repository.'UpdateRequest.php',
            'Http/Controllers/'.Str::plural($repository).'Controller.php',
            'Services/'.$repository.'Service.php',
        ];
        foreach ($files as $file) {
            $is_request = false;
            if(\File::exists(app_path($file))) {
                $is_request = true;
                \File::move(app_path($file), module_path($module).'/'.$file);
            }
            // $this->update_namespace($module, $file, $is_request);
        }
    }


    /**
     * @param $module
     * @param  string  $filePath
     * @param boolean $is_request
     */
    private function update_namespace($module, string $filePath, $is_request): void
    {
        $fileContent = file_get_contents(module_path($module).'/'.$filePath);
        $fileContent = str_replace('App\\', config('modules.namespace').'\\'.$module.'\\', $fileContent);
        if(!$is_request) $fileContent = str_replace(config('modules.namespace').'\\'.$module.'\Http\Requests;',
            'Illuminate\Routing\Controller;', $fileContent);
        file_put_contents(module_path($module).'/'.$filePath, $fileContent);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function bindingRepository()
    {
        $module = $this->argument('module');
        $repository = $this->argument('repository');
        try {
            $bindingGenerator = new BindingsGenerator([
                'name' => $repository,
                // 'force' => $this->option('force'),
            ]);
            // generate repository service provider
            if (!file_exists($bindingGenerator->getPath())) {
                $this->call('module:make-provider', [
                    'name' => $bindingGenerator->getConfigGeneratorClassPath($bindingGenerator->getPathConfigNode()),
                    'module' => $module
                ]);
                // placeholder to mark the place in file where to prepend repository bindings
                $provider = File::get($bindingGenerator->getPath());
                File::put($bindingGenerator->getPath(), vsprintf(str_replace('//', '%s', $provider), [
                    '//',
                    $bindingGenerator->bindPlaceholder
                ]));
            }
            $bindingGenerator->run();
            $this->info('Bindings created successfully.');
        } catch (FileAlreadyExistsException $e) {
            $this->error('Bindings already exists!');

            return false;
        }
    }
}
