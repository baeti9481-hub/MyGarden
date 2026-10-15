<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey  = env('RAJAONGKIR_API_KEY');
        $this->baseUrl = env('RAJAONGKIR_BASE_URL', 'https://rajaongkir.komerce.id/api/v1');
    }

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get($this->baseUrl . '/destination/province');

        return response()->json($response->json());
    }

   public function getCities(Request $request)
{
    $provinceId = $request->input('province_id');

    $response = Http::withHeaders([
        'key' => $this->apiKey
    ])->get($this->baseUrl . '/destination/city/' . $provinceId); // ✅ province_id di URL

    return response()->json($response->json());
}
public function getCost(Request $request)
{
    $response = Http::withHeaders([
        'key' => $this->apiKey
    ])->asForm() // ✅ x-www-form-urlencoded
    ->post($this->baseUrl . '/calculate/district/domestic-cost', [
        'origin'      => $request->input('origin'),
        'destination' => $request->input('destination'),
        'weight'      => $request->input('weight'),
        'courier'     => $request->input('courier'),
        'price'       => 'lowest',
    ]);

    return response()->json($response->json());
}
public function getDistricts(Request $request)
{
    $cityId = $request->input('city_id');

    $response = Http::withHeaders([
        'key' => $this->apiKey
    ])->get($this->baseUrl . '/destination/district/' . $cityId);

    return response()->json($response->json());
}
}