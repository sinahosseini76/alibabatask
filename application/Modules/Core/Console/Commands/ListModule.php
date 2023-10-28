<?php

namespace Modules\Core\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class ListModule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:list
                            {--compact : Compact list of all module}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of all module';

    /**
     * @throws Exception
     */
    public function handle()
    {
        $config = config('modules');
        $array = [];
        foreach ($config as $item){
            if ($item['status']){
                $status = "<fg=green>Enabled</>";
            }else{
                $status = "<fg=red>Disabled</>";
            }
            $description = $item['description'] ?? 'No description';
            if ($this->option('compact')){
                $description = substr($description , 0 , 50) . '...';
            }
            $array[] = [
                'name'        => $item['name'] ,
                'description' => $description ,
                'status'      => $status ,
            ];
        }
        $this->table(['Name' , 'Description' , 'Status'] , $array);
    }
}
