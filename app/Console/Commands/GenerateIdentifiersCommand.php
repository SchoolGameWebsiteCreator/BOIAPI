<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateIdentifiersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate-ids {count=1} {--length=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate random identifiers for use in data sets';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $generated = [];

        for ($i = 1; $i <= $this->argument('count'); $i++) {
            $str = str_random($this->option('length'));

            if (in_array($str, $generated)) {
                $i--;
            } else {
                $this->line($str);
            }
        }
    }
}
