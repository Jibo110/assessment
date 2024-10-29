<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class FetchStockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:stock';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch updated stock data from WooCommerce';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Initialize Guzzle client and make API call
        $client = new Client();
        $url = 'http://localhost/wordpress/wp-json/wc/v3/products';
        $consumerKey = env('CONSUMER_KEY'); 
$consumerSecret = env('CONSUMER_SECRET');


        try {
            $response = $client->request('GET', $url, [
                'auth' => [$consumerKey, $consumerSecret],
            ]);

            $products = json_decode($response->getBody(), true);

            // Save or update products in your database here
            // Example: Iterate and save products
            foreach ($products as $product) {
                // Assuming you have a method to save or update
                $this->storeProductData($product);
            }

            $this->info('Stock data fetched and stored successfully!'); // Log success message
        } catch (\Exception $e) {
            $this->error('Failed to fetch stock data: ' . $e->getMessage()); // Log error message
        }

        return Command::SUCCESS;
    }

    private function storeProductData($product)
    {
        // Save or update the product in your database
        // Example logic for saving/updating the product
    }
}
