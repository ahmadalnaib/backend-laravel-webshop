<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Login and get Bearer Token, then use it to fetch product data.
     */
    public function getProductData()
    {
        // Step 1: Make an API request to login and get the bearer token
        $loginResponse = Http::post('http://192.168.200.56:8000/api/v1/login/via-token/n7dp3qklxu92vq1lmbhyzaosnhkpye6jtmt9xcwrkf8spyumganx5i4jvl7bzohe', []);

        if ($loginResponse->successful()) {
            // Step 2: Extract the token from the login response
            $token = $loginResponse->json('body.token');

            // Step 3: Define the payload to be sent with the product data request
            $payload = [
                [
                    "name" => "timestamp",
                    "type" => "C",
                    "value" => "19700101000000000"
                ],
                [
                    "name"=> "getbilder",
                    "type"=> "L",
                    "value"=> "true"
                ],
                [
                    "name"=> "getpreis",
                    "type"=> "L",
                    "value"=> "true"
                ]
            ];

            // Step 4: Use the token to fetch the product data
            $productResponse = Http::withToken($token)
                                    ->post('http://192.168.200.56:8000/api/v1/execute/WEBSHOP_GETARTIKELDATEN', $payload);

            // Step 5: Check if the product data response was successful
            if ($productResponse->successful()) {
                // Handle the response, return the product data
                $products = $productResponse->json();
                return response()->json($products); // Return JSON data
            } else {
                // Handle failure, return error
                return response()->json(['error' => 'Failed to fetch product data'], 500);
            }
        } else {
            // Handle login failure, return error
            return response()->json(['error' => 'Failed to login and get token'], 500);
        }
    }
}
