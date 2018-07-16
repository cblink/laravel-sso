<?php

namespace Cblink\Sso\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MakeSsoRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sso:route';

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
        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/../stubs/make/routes.stub'),
            FILE_APPEND
        );

        $this->info('sso route append to web.php successfully !');
    }
}
