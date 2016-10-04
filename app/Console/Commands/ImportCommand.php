<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\Importer\ImporterInterface;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all data into the database';

    /**
     * @var App\Contracts\Importer\ImporterInterface
     */
    protected $importer;

    /**
     * Tables the importer supports.
     *
     * Order is important to satisfy foreign key constraints.
     *
     * @var array
     */
    protected $tables = [
        'items',
        'bosses',
        'characters',
        'monsters',
        'pickup_types',
        'pickups',
        'pill_appearances',
        'chapters',
        'environments',
    ];

    /**
     * Create a new command instance.
     *
     * @param  \App\Contracts\Importer\ImporterInterface $importer
     * @return void
     */
    public function __construct(ImporterInterface $importer)
    {
        parent::__construct();
        $this->importer = $importer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $paths = [];

        foreach ($this->tables as $table) {
            $paths[$table] = data_path($table.'.csv');
        }
        $this->importer->import($paths);
    }
}
