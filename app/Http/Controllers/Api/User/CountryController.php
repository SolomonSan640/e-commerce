<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info($request->all());
        $data = $request->validate([
            'event' => 'required|string|in:created,updated,deleted',
        ]);

        switch ($data['event']) {
            case 'created':
                $this->createShop($request['data']);
                break;

            case 'updated':
                $this->updateShop($request['data']);
                break;

            case 'deleted':
                $this->deleteShop($request['data']['id']);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }

    private function createShop(array $data)
    {
        unset($data['id']);
        Country::create($data);
    }

    private function updateShop(array $data)
    {
        // Find the shop to update based on shop_id
        $countries = Country::where('name', $data['name'])->first();

        if ($countries) {
            // Prepare the update array with null coalescing operator (??) for defaults
            $countriesArr = [
                'name' => $data['name'],
            ];
            Log::info('Updating shop with data: ', $countriesArr);
            $countries->update($countriesArr);

            Log::info('Shop updated successfully.');
        } else {
            Log::error('Shop not found for name: ' . $data['name']);
        }
    }

    private function deleteShop($id)
    {
        $countries = Country::findOrFail($id);

        Log::info($countries);
        $countries->delete();
    }

    public function index()
    {
        App::setLocale('en');
        $countries = Country::orderBy('updated_at', 'desc')->select('id', 'name', 'iso2', 'iso3', 'currency', 'callcode', 'flag')->get();
        $response = [
            'status' => 200,
            'message' => __('success.dataRetrieved'),
            'data' => $countries,
        ];
        return response()->json($response, 200);
    }
}
