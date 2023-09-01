<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class sekolahController extends Controller
{
    public function indexgender()
    {
        $cacheKey = 'gender';
        $cacheTime = 60 * 60 * 24; // Cache for 24 hours

        $gender = Cache::remember($cacheKey, $cacheTime, function () {
            try {
                $client = new Client();
                $response = $client->request('GET', 'https://api.rajaongkir.com/starter/gender', [
                    'headers' => [
                        'key' => env('RAJAONGKIR_API_KEY'),
                        'content-type' => 'application/x-www-form-urlencoded'
                    ],
                ]);

                $gender = json_decode($response->getBody())->rajaongkir->results;
            } catch (GuzzleException $e) {
                // Handle any exception from Guzzle
                $gender = [$e->getMessage()];
            }

            return $gender;
        });

        return $gender;
    }

    public function indexCity(Request $request, $id)
    {
        $cacheKey = 'cities_' . $id;
        $cacheTime = 60 * 60 * 24; // Cache for 24 hours

        $cities = Cache::remember($cacheKey, $cacheTime, function () use ($id) {
            try {
                $client = new Client();
                $response = $client->request('GET', 'https://api.rajaongkir.com/starter/city', [
                    'headers' => [
                        'key' => env('RAJAONGKIR_API_KEY'),
                        'content-type' => 'application/x-www-form-urlencoded'
                    ],
                    'query' => [
                        'gender' => $id,
                    ],
                ]);

                $cities = json_decode($response->getBody())->rajaongkir->results;
            } catch (GuzzleException $e) {
                // Handle any exception from Guzzle
                $cities = [$e->getMessage()];
            }

            return $cities;
        });

        return $cities;
    }
}
