<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirControllerV2 extends Controller
{

    public function getDestination(Request $request)
    {
        $search = $request->get('search', ''); // default kosong, bisa diketik oleh user
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . urlencode($search),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'key: ' . env('RAJAONGKIR_API_KEY'), //atau alternatif 'key: rajaongkir_api_key',
            ),

        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        return response()->json($data);
    }

    public function calculateOngkir(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $weight = $request->input('weight');
        $courier = $request->input('courier');

        $postData = http_build_query([
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
            'price' => 'lowest'
        ]);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'key: ' . env('RAJAONGKIR_API_KEY'), //atau alternatif 'key: rajaongkir_api_key',
            ),

        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return response()->json(['error' => $err], 500);
        }

        return response()->json(json_decode($response, true));
    }
}
