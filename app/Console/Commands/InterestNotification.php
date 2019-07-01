<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Auth;

class InterestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:interestnotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //
        $myofferpost = DB::table('offer_post')
                    ->join('offer_interested_users', 'offer_post.id','=','offer_interested_users.post_id')
                    ->select('offer_post.user_id','offer_post.id as post_id')
                    ->distinct()
                    ->get();

        echo "<pre>";print_r($myofferpost);die;
    }
}
