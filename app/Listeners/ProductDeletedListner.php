<?php

namespace App\Listeners;
use App\Product;
use Illuminate\Support\Facades\Cache;
use App\Events\ProductDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProductDeletedListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
      $p = Product::findOrFail($event->product->id);
      //$p->category->decrement('product_count');
      //$p->scategory->decrement('product_count');
      //$p->city->decrement('product_count');
      //$p->nhood->decrement('product_count');
      Cache::forget('urgent-ads');
      Cache::forget('premium-ads');
      cache::forget('meghamenu');
    }
}
