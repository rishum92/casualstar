<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         Commands\BannerAdFilesCleanup::class,
         Commands\InterestNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            /************checking expiered services***************/
		      $expired_service = DB::table('service_requests')
			                     ->select('status','confirm_date','variable_name','id')
								 ->where('service_id',10)
								 ->where('status','COMPLETED')
								 ->orderBy('created_at','DESC')
								 ->get();
							$exp_array = array();
							foreach($expired_service as $expired_service_data){
								$start_date  = $expired_service_data->confirm_date;
								$expire_date = date('Y-m-d H:i:s',strtotime($start_date.' + '.$expired_service_data->variable_name));
								if(date('Y-m-d H:i:s')>$expire_date){
									array_push($exp_array,$expired_service_data->id);
								}
                                
							} print_r($exp_array);
							DB::table('service_requests')
							    ->whereIn('id',$exp_array)
								->update(['status'=>'EXPIRED']); 
		    /*****************************************************/
        })->everyMinute();

       

                $schedule->command('command:interestnotification')
                   ->everyMinute();
        
    }
}
