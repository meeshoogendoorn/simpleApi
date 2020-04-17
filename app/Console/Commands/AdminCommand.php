<?php

namespace App\Console\Commands;

use http\Client\Curl\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set mees018299@gmail.com as admin';

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
        $email = $this->ask("What's the admin email address");

        DB::table("users")->where("email", "=", $email)->update(["admin" => true]);
    }
}
