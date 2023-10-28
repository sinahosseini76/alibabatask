<?php

namespace Modules\Core\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class MakeModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new module';

    /**
     * The base path of module.
     *
     * @var string
     */
    protected string $basePathModule;

    /**
     * The name of module.
     *
     * @var string
     */
    protected string $moduleName;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->basePathModule = base_path('Modules');
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $name = $this->ask('Please enter the name of module');
        $this->moduleName = ucfirst($name);
        $pluralName = $this->ask('Please enter the plural name of module');
        $dependencies = $this->getDependencies();
        $this->copyDirectory($this->basePathModule . '/Example' , $this->basePathModule . '/' . $this->moduleName , $pluralName);

        //add to config file in core
//        $this->addPermissions();
        $this->registerConfig($dependencies);

        $audit = $this->ask('Do you want to register to Audit Log? (y/n)');
        if ($audit == 'y') {
            $this->registerAuditLog();
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getDependencies(): array
    {
        $listOfModules = scandir($this->basePathModule);
        $listOfModules = array_filter($listOfModules , function ($item) {
            return !in_array($item , ['.' , '..']);
        });
        $listOfModules = array_map(function ($item) {
            return strtolower($item);
        } , $listOfModules);
        $listOfModules = array_values($listOfModules);
        $dependencies  = $this->choice('Please select dependencies (separate with comma)' , $listOfModules , null , null , true);
        return array_map(function ($item) use ($listOfModules) {
            return ucfirst(trim($item));
        } , $dependencies);
    }

    /**
     * @throws Exception
     */
    private function copyDirectory(string $source , string $destination , string $pluralName = null)
    {
        if (!is_dir($destination)) {
            mkdir($destination);
        }
        $files = scandir($source);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($source . '/' . $file)) {
                if (!is_dir($destination . '/' . $file)) {
                    mkdir($destination . '/' . $file);
                }
                $this->copyDirectory($source . '/' . $file , $destination . '/' . $file , $pluralName);
            } else {
                $content = file_get_contents($source . '/' . $file);
                $content = str_replace('Example' , $this->moduleName , $content);
                $content = str_replace('example' , strtolower($this->moduleName) , $content);
                $file = str_replace('Example' , $this->moduleName , $file);
                if (str_contains($file , '2023_05_19_000000')) {
                    $file = str_replace('example' , strtolower($pluralName) , $file);
                    $file = str_replace('2023_05_19_000000' , date('Y_m_d_His') , $file);
                }
                file_put_contents($destination . '/' . $file , $content);
            }
        }
    }

    /**
     * @param array $dependencies
     * @return void
     */
    private function registerConfig(array $dependencies): void
    {
        $coreDir = scandir($this->basePathModule . '/Core/Config');
        foreach ($coreDir as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (!str_contains($file , 'modules')) {
                continue;
            }
            $lowerModuleName = strtolower($this->moduleName);
            $content = file_get_contents($this->basePathModule . '/Core/Config/' . $file);
            $lastIndex = strrpos($content , ']');
            $content = substr($content , 0 , $lastIndex);
            $content .= "    '" . $this->moduleName . "' => [\n";
            $content .= "        'name'        => '" . $this->moduleName . "' ,\n";
            $content .= "        'description' => '" . $this->moduleName . " Module' ,\n";
            $content .= "        'status'      => true ,\n";
            $content .= "        'services'    => [\n";
            $content .= "            'provider' => 'Modules\\\\$this->moduleName\\\\" . $this->moduleName . "ServiceProvider' ,\n";
            $content .= "            'lang' => [\n";
            $content .= "                'path' => 'Modules/$this->moduleName/lang' ,\n";
            $content .= "                'name' => '$lowerModuleName' ,\n";
            $content .= "            ] ,\n";
            $content .= "        ] ,\n";
            if (count($dependencies) > 0) {
                $content .= "        'dependencies' => [\n";
                foreach ($dependencies as $dependency) {
                    $content .= "            '$dependency' ,\n";
                }
                $content .= "        ] ,\n";
            } else {
                $content .= "        'dependencies' => [] ,\n";
            }
            $content .= "    ] ,\n";
            $content .= "];\n";
            file_put_contents($this->basePathModule . '/Core/Config/' . $file , $content);
        }
    }

    private function registerAuditLog()
    {
        $auditConfig = file_get_contents($this->basePathModule . '/AuditLog/Config/entities.php');
        $nameSpace = "Modules\\$this->moduleName\\Models\\$this->moduleName::class";
        $auditConfig = str_replace('];' , "    " . $nameSpace . " ," , $auditConfig);
        $auditConfig .= "];";
        file_put_contents($this->basePathModule . '/AuditLog/Config/entities.php' , $auditConfig);
    }

    private function addPermissions(){
        // add permission to permissions.json
        $content = file_get_contents(base_path('Modules/User/Database/seeds/permissions.json'));
        $lastIndex = strrpos($content , ']');
        $content = substr($content , 0 , $lastIndex);
        $content .= ",{";
        $content .= '        "name"        : "list-' . strtolower($this->moduleName) . '" ,';
        $content .= '        "group"        : "' . strtolower($this->moduleName) . '" ,';
        $content .= '        "description" : "List ' . $this->moduleName . ' Module"';
        $content .= "}";
        $content .= ",{";
        $content .= '        "name"        : "show-' . strtolower($this->moduleName) . '" ,';
        $content .= '        "group"        : "' . strtolower($this->moduleName) . '" ,';
        $content .= '        "description" : "Show ' . $this->moduleName . ' Module"';
        $content .= "}";
        $content .= ",{";
        $content .= '        "name"        : "create-' . strtolower($this->moduleName) . '" ,';
        $content .= '        "group"        : "' . strtolower($this->moduleName) . '" ,';
        $content .= '        "description" : "Create ' . $this->moduleName . ' Module"';
        $content .= "}";
        $content .= ",{";
        $content .= '        "name"        : "update-' . strtolower($this->moduleName) . '" ,';
        $content .= '        "group"        : "' . strtolower($this->moduleName) . '" ,';
        $content .= '        "description" : "Update ' . $this->moduleName . ' Module"';
        $content .= "}";
        $content .= ",{";
        $content .= '        "name"        : "delete-' . strtolower($this->moduleName) . '" ,';
        $content .= '        "group"        : "' . strtolower($this->moduleName) . '" ,';
        $content .= '        "description" : "Delete ' . $this->moduleName . ' Module"';
        $content .= "}";
        $content .= "]";
        file_put_contents(base_path('Modules/User/Database/seeds/permissions.json') , $content);
    }
}
