<?php

namespace Legodion\Lucid\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class ModelCommand extends GeneratorCommand
{
    protected $name = 'lucid:model';
    protected $type = 'Model';

    public function handle()
    {
        if (parent::handle() === false && !$this->option('force')) {
            return false;
        }

        if ($this->argument('name') == 'User') {
            (new Filesystem)->delete([
                database_path('factories/UserFactory.php'),
                database_path('migrations/2014_10_12_000000_create_users_table.php'),
            ]);
        }

        if ($this->option('resource')) {
            $this->call('lucid:resource', [
                'name' => $this->argument('name'),
                '--force' => $this->option('force'),
            ]);
        }
    }

    protected function getStub()
    {
        return $this->argument('name') == 'User'
            ? __DIR__ . '/../Stubs/UserModel.php'
            : __DIR__ . '/../Stubs/Model.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\Models';
    }

    protected function getOptions()
    {
        return [
            ['resource', 'r', InputOption::VALUE_NONE],
            ['force', null, InputOption::VALUE_NONE],
        ];
    }
}