<?php

namespace WingingIT\Themes\Commands;

use Illuminate\Console\Command;
use Nwidart\Modules\Generators\ThemeGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeThemeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'theme:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $names = $this->argument('name');
        $sourceDir = __DIR__ . '/../template';
        foreach ($names as $name) {
            $targetDir = __DIR__ . '/../../../../../Themes/' . $name;
            if (file_exists($targetDir) == false) {
                mkdir($targetDir);
                mkdir($targetDir . '/views');
                copy($sourceDir . '/DefaultTheme.php', $targetDir . '/' . $name . '.php');
                copy($sourceDir . '/views/layout.blade.php', $targetDir . '/views/layout.blade.php');


                $str = file_get_contents($targetDir . '/' . $name . '.php');

                $str = str_replace("<THEMENAME>", "$name", $str);

                file_put_contents($targetDir . '/' . $name . '.php', $str);
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The names of modules will be created.'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain module (without some resources).'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when the module already exists.'],
        ];
    }
}
