<?php

namespace App\Console\Commands;
use App\Urgent;
use Illuminate\Support\Facades\Mail;
use App\Mail\UrgentAdExpireNotification;
use Illuminate\Console\Command;

class UrgentNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:urgent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'urgent ad expire notification';

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
      $urgents = Urgent::with(['product','product.user'=>function($q){
        $q->select('id','name','email');
      }])->get();

      if($urgents->count()>0){
        foreach ($urgents as $urgent) {
          if($urgent->remaining_days < 2){
            if($urgent->product->user->valid_email !=''){
            //Mail::to($urgent->product->user->email)->send(new UrgentAdExpireNotification($urgent->product));
           }
          }
        }
      }
    }
}
