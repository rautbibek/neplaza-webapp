<?php

namespace App\Observers;
use Illuminate\Support\Str;
use App\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $p_id = IdGenerator::generate(['table' => 'products', 'field'=>'productid', 'length' => 10, 'prefix' =>'NPA-']);
        $product->slug = Str::slug($product->title);
        $product->productid = $p_id;
        $product->save();
        $product->category->increment('product_count');
        $product->scategory->increment('product_count');
        $product->city->increment('product_count');
        $product->nhood->increment('product_count');
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {

    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {

    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }

}
