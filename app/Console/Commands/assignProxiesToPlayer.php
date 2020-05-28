<?php

namespace App\Console\Commands;

use App\Player;
use Faker\Provider\Payment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class assignProxiesToPlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxies:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Proxies to players';

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
        $players = Player::all();
        foreach($players as $player) {
            $this->checkIfProxyIsActive($player);
            if (empty($player->proxy_id)){
                $player->proxy_id = DB::table("proxys")->get("proxy_id")->random()->proxy_id;
                $player->save();
            }
        }
        $this->info("assigned proxies to players");
        return true;
    }

    public function checkIfProxyIsActive($player)
    {
        if(empty($player->get_proxy)) {
            if(! empty($player->proxy_id)) {
                $player->proxy_id = null;
                $player->save();
            }
        }
        return $player;
    }
}
