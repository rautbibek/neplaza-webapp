<?php

namespace App\Http\Controllers;

use App\Product;
use Bhaktaraz\RSSGenerator\Channel;
use Bhaktaraz\RSSGenerator\FacebookProductItem;
use Bhaktaraz\RSSGenerator\Feed;
use Bhaktaraz\RSSGenerator\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RssFeedController extends Controller
{
    public function rssFeed(){
//        $xml = "<rss xmlns:content=\"http://purl.org/rss/1.0/modules/content/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\" xmlns:atom=\"http://www.w3.org/2005/Atom\" xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
//  <channel>
//    <title>Bikribazzar</title>
//    <link>http://www.bikribazzar.com/</link>
//    <description>
//      Bikribazzar
//    </description>
//    <language>en-us</language>";
//
//        $products = Product::take(50)->get();
//        foreach($products as $product){
//            $xml .= "<item>
//      <title>$product->title</title>
//      <link>http://example.com/article.html</link>
//      <guid>2fd4e1c67a2d28fced849ee1bb76e7391b93eb12</guid>
//      <pubDate>2014-12-11T04:44:16Z</pubDate>
//      <author>{config('app.name')}</author>
//      <description>This is my first Instant Article. How awesome is this?</description>
//    </item>";
//        }
//
//        $xml .= '</channel>
//</rss>';

        $feed = new Feed();
        $channel = new Channel();
        $channel
            ->title(config('app.name'))
            ->description("bikribazzar")
            ->url(config('app.url'))
            ->appendTo($feed);

// Product feed item
        $products = Product::take(15)->with('category','scategory','status','image','brand')->get();
        foreach ($products as $product){


        $item = new FacebookProductItem();
        $item
            ->id($product->id)
            ->title($product->title)
            ->description($product->description)
            ->url(config('app.url')."/ad/detail/$product->id/$product->slug")
            ->availability($product->sold?'In Stock':'Sold Out')
            ->condition($product->status->title?? '')
            ->googleProductCategory($product->category->name.' > '.$product->scategory->name)
            ->imageLink($product->product_cover)
            ->brand($product->brand->name??'')
            ->customLabel0($product->title)
            ->customLabel1('')
            ->customLabel2('')
            ->appendTo($channel);
        }

        $response = new Response($feed);
        $response->headers->set('Content-Type', 'xml');
        return $response;
    }
}
