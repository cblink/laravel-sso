<?php

namespace Cblink\Sso\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateSso extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sso:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commands description';

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
        $name = $this->ask('the sso name ?');

        $appId = strtolower('sso'.str_random('13'));

        $secret = md5($appId.time());

        DB::table(config('sso.table'))->insert([
            'name' => $name,
            'app_id' => $appId,
            'secret' => $secret
        ]);

        $this->info('create sso successfully !');
        $this->table(['name', 'app id', 'secret'], [[$name, $appId, $secret]]);
    }
}
