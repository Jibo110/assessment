<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Product;

class ProductController extends Controller
{
    public function fetchProductsFromWooCommerce()
    {
        // WooCommerce API details
        $url = 'http://localhost/wordpress/wp-json/wc/v3/products';
        $consumerKey = env('WOOCOMMERCE_CONSUMER_KEY');
        $consumerSecret = env('WOOCOMMERCE_CONSUMER_SECRET');
        
        $client = new Client();
        
        try {
            $response = $client->get($url, [
                'auth' => [$consumerKey, $consumerSecret],
            ]);

            $products = json_decode($response->getBody(), true);

            // Save products to Laravel's database
            foreach ($products as $product) {
                Product::updateOrCreate(
                    ['name' => $product['name']],
                    [
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $product['stock_quantity'],
                    ]
                );
            }

            return response()->json(['message' => 'Products fetched and saved successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
