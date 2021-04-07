<?php
namespace App\Console\Commands;
use App\Product;
use App\Events\ProductDeletedEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductDeletedMail;
use Illuminate\Console\Command;

class RepordedAdDelete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reported';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'reported ad delete';

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
      $products = Product::select('id','productid','title','user_id','created_at')->has('report')
              ->with(['report','product_image','user'=>function($q){
                  $q->select('id','name','email');
                }])->withCount('report')->get();
      foreach ($products as $product) {
        if($product->report_count>25){
          if($product->user->valid_email !=''){
            Mail::to($product->user->email)->send(new ProductDeletedMail($product));
          }
          event(new ProductDeletedEvent($product));
          foreach ($product->product_image as $p) {
              $p->delete();
          }
          $product->delete();
        }
      }
    }
}
