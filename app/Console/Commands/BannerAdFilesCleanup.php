<?php

namespace App\Console\Commands;

use App\Models\BannerAd;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;

class BannerAdFilesCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:banner-ad-files-cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleans up expired banner ads images.';

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
        $yesterdayBannerAd = BannerAd::where('day', Carbon::now()->subDay()->format('Y-m-d'))->first();
        if($yesterdayBannerAd) {
            $todayBannerAd = BannerAd::where('day', Carbon::now()->format('Y-m-d'))->first();
            if($todayBannerAd) {
                if($todayBannerAd->banner_ad_request_id == $yesterdayBannerAd->banner_ad_request_id) {
                    return;
                }
            }

            $yesterdayBannerAdRequest = $yesterdayBannerAd->request;
            if($yesterdayBannerAdRequest->type == 'video') {
                $file = public_path() . '/banner-ads-resources/videos/' . $yesterdayBannerAdRequest->bannerAdResources[0]->resource;
                if(file_exists($file)) {
                    unlink($file);
                }
            } else {
                foreach($yesterdayBannerAdRequest->bannerAdResources as $bannerAdResource) {
                    $file = public_path() . '/banner-ads-resources/images/' . $bannerAdResource->resource;
                    if(file_exists($file)) {
                        unlink($file);
                    }
                }
            }
        }
    }
}
