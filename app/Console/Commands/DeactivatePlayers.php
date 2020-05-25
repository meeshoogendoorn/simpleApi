<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeactivatePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'players:deactivate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate all players in the system';

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
        DB::table("players")->update(["active" => false]);
        $this->info("All players deactivated");
    }
}
