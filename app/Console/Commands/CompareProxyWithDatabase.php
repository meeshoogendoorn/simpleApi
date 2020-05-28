<?php

namespace App\Console\Commands;

use App\Http\Controllers\Proxy\ProxyController;
use App\Proxy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CompareProxyWithDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proxies:check {--assign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check proxies';

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
        $proxies = $this->getAllSavedProxies();

        if($proxies->isEmpty())
            $this->saveAllProxies();

        $this->checkAllProxies($proxies);

        if($this->option("assign"))
            $this->call("proxies:assign");

        return true;
    }

    public function getAllProxies()
    {
        $controller = new ProxyController();
        $proxies_json = $controller->index();
        return json_decode($proxies_json);
    }

    public function getAllSavedProxies()
    {
        return DB::table("proxys")->get();
    }

    public function saveAllProxies()
    {
        $proxies = $this->getAllProxies();

        if($proxies->status !== "yes") {
            $this->error("Could'nt retrieve new proxies.");
            exit(1);
        }

        foreach ($proxies->list as $proxy){
            $this->saveProxy($proxy);
        }

        $this->info("Saved all proxies");
        exit(1);
    }

    public function setupCheckInTable()
    {
        return DB::table("proxys")->update(["checked" => false]);
    }

    public function checkAllProxies($savedProxies)
    {
        $this->setupCheckInTable();

        $proxies = $this->getAllProxies();

        if($proxies->status !== "yes") {
            $this->error("Could'nt retrieve new proxies.");
            exit(1);
        }

        foreach($proxies->list as $proxy){
            if(! DB::table("proxys")->where("proxy_id", "=", $proxy->id)->exists())
                $this->saveProxy($proxy);
            else
                DB::table("proxys")->where("proxy_id", "=", $proxy->id)->update(["checked" => true]);
        }

        DB::table("proxys")->where("checked", "=", false)->delete();

        $this->info("All saved proxies are checked");
    }

    public function saveProxy($proxy)
    {
        $newProxy = new Proxy();
        $newProxy->proxy_id = $proxy->id;
        $newProxy->version = $proxy->version;
        $newProxy->ip = $proxy->ip;
        $newProxy->host = $proxy->host;
        $newProxy->port = $proxy->port;
        $newProxy->user = $proxy->user;
        $newProxy->pass = $proxy->pass;
        $newProxy->type = $proxy->type;
        $newProxy->country = $proxy->country;
        $newProxy->date = $proxy->date;
        $newProxy->date_end = $proxy->date_end;
        $newProxy->descr = $proxy->descr;
        $newProxy->active = $proxy->active;
        $newProxy->save();
        $this->info("Saved proxy with id". $newProxy->proxy_id);
    }
}
