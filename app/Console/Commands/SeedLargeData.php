<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translation;

class SeedLargeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-large';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed 100k+ translation records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Translation::factory()->count(120000)->create();
        $this->info('100k translations seeded');
    }
}
