<?php

namespace App\Console\Commands;
use App\Featured;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class CheckFeaturedProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feature:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the feature product is expored or not';

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
        $featured = Featured::where('expire_date','<',now())->get();

        foreach($featured as $feature){
            $feature->delete();
        }

    }
}
