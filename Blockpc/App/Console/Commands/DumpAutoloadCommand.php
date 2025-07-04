<?php

declare(strict_types=1);

namespace Blockpc\App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;

final class DumpAutoloadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blockpc:dump-autoload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate framework autoload files';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Foundation\Composer
     */
    protected $composer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Composer $composer)
    {
        parent::__construct();

        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->composer->dumpAutoloads();
        $this->info('Autoload files regenerated.');
    }
}
