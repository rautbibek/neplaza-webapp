<?php
namespace App\Console\Commands;
use App\Urgent;
use Illuminate\Console\Command;

class CheckUrgentProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'urgent:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checking urgent ad ';

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
        $urgent_ad = Urgent::where('expire_date','<=',now())->get();
        if($urgent_ad->count()>0){
            foreach($urgent_ad as $urgent){
                $urgent->delete();
            }
        }
    }
}
