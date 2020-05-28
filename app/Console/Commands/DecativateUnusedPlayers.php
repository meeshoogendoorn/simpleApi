<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DecativateUnusedPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'players:unused';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate players last used more than 10 mins ago';

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
        DB::table("players")->where("updated_at", "<", Carbon::now()->subMinutes(15)->toDateTimeString())->update(["active" => false]);
        $this->info("Deactivated unused players");
    }
}
