<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

    protected function getCommands()
    {
        $dir      = new \RecursiveDirectoryIterator('app/Console/Commands');
        $list     = new \RecursiveIteratorIterator($dir);
        $files    = new \RegexIterator($list, '/.+\.php$/');
        $commands = parent::getCommands();

        foreach ( $files as $file )
        {
            require_once $file->getPathname();
        }

        $classes = new \RegexIterator(new \ArrayIterator(get_declared_classes()), '/Commands/');

        foreach ( $classes as $class )
        {
            $reflect = new \ReflectionClass($class);

            if ( ! $reflect->isAbstract() )
            {
                array_push($commands, $class);
            }
        }

        return $commands;
    }
}
