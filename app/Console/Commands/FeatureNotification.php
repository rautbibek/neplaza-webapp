<?php

namespace App\Console\Commands;
use App\Featured;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeatureAdExpireNotification;
use Illuminate\Console\Command;

class FeatureNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:feature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Featured Ad Expire email Notification';

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
     * @return int
     */
    public function handle()
    {
        $featured = Featured::with(['product','product.user'=>function($q){
          $q->select('id','name','email');
        }])->get();
        if($featured->count()>0){
          foreach ($featured as $feature) {
            if($feature->remaining_days == 3){
              if($feature->product->user->valid_email !=''){
               Mail::to($feature->product->user->email)->send(new FeatureAdExpireNotification($feature->product));
             }
            }
          }
        }
    }
}
