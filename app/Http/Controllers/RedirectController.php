<?php

namespace App\Http\Controllers;

use App\Models\ClickLog;
use App\Models\Product;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    /**
     * Redirect to the affiliate link and log the click.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToAffiliate(Request $request, Product $product)
    {
        // Log the click
        ClickLog::create([
            'product_id' => $product->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referer' => $request->header('referer'),
        ]);
        
        // Increment click count
        $product->increment('click_count');
        
        // Redirect to affiliate link
        return redirect()->away($product->affiliate_url);
    }
}