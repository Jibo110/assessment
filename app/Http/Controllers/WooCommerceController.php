<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Import the HTTP facade
use App\Models\Product; 

class WooCommerceController extends Controller
{
    public function storeProduct(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        // Create a new product record in the database
        $product = Product::create([
            'name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'quantity' => $validatedData['quantity'],
        ]);

        // Return a response
        return response()->json(['message' => 'Product stored successfully', 'product' => $product], 201);
    }

    public function fetchProducts()
    {
        $response = Http::withBasicAuth('CONSUMER_KEY', 'CONSUMER_SECRET')
            ->get('http://localhost/wordpress/wp-json/wc/v3/products');

        if ($response->successful()) {
            return $response->json(); // Return the product data
        }

        return response()->json(['error' => 'Unable to fetch products'], 500);
    }
}
