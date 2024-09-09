<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdSlider;
use App\Traits\ImageUploadTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AdSliderController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $ads = AdSlider::where('is_show', 1)->get();
        if ($ads->isEmpty()) {
            return response()->json(['status' => true, 'message' => 'Slider Not Found','data' => []], 200);
        }
        foreach ($ads as $ad) {
            $data[] = [
                'id' => $ad->id,
                'image' => $ad->image,
                'description' => $ad->description,
                'is_show' => ($ad->is_show === 1) ? true : false,
            ];
        }
        return response()->json(['status' => true, 'message' => __('success.dataRetrieved'), 'data' => $data], 200);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($request->country));
        $validationResult = $this->validateCreateData($request, null);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request, null);
            $data->fill($data->toArray());

            $folderName = 'AdSlider';
            $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image

            $data['image'] = $imageFileName;
            $data->save();
            DB::commit();
            return response()->json(['status' => 201, 'message' => __('success.dataCreated', ['attribute' => 'AdSlider'])], 201);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataCreatedFailed', ['attribute' => 'AdSlider'])], 400);
        }
    }

    public function edit($id)
    {
        $adsliders = AdSlider::findOrFail($id);
        return response()->json(['status' => 200, 'message' => __('success.dataRetrieved'), 'data' => $adsliders], 200);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $this->setLocale(strtolower($request->country));
        $validationResult = $this->validateCreateData($request, $id);
        if ($validationResult !== null) {
            return $validationResult;
        }
        try {
            $data = $this->getCreateData($request, $id);
            $adsliders = AdSlider::findOrFail($id);
            $adsliders->fill($data->toArray());

            $folderName = 'AdSlider';
            $imageFileName = $this->singleImage($request, 'image', $folderName); // use trait to upload image
            $adsliders['image'] = $imageFileName;
            $adsliders->update();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataUpdated', ['attribute' => 'AdSlider'])], 201);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'AdSlider'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataUpdatedFailed', ['attribute' => 'AdSlider'])], 400);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $adsliders = AdSlider::findOrFail($id);
            $adsliders->delete();
            DB::commit();
            return response()->json(['status' => 200, 'message' => __('success.dataDeleted', ['attribute' => 'AdSlider'])], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(['status' => 404, 'message' => __('error.dataNotFound', ['attribute' => 'AdSlider'])], 404);
        } catch (Throwable $e) {
            report($e);
            DB::rollBack();
            return response()->json(['status' => 400, 'message' => __('error.dataDeletedFailed', ['attribute' => 'AdSlider'])], 400);
        }
    }

    protected function getCreateData($request, $id)
    {
        $data = [];

        $data['description'] = $request->description;
        return new AdSlider($data);
    }

    protected function validateCreateData($request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ], [
            'image.required' => __('validation.dataNameRequire', ['attribute' => 'Ad Slider Image']),
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        return null;
    }

    private function setLocale($country)
    {
        $supportedLocales = ['en', 'mm'];
        if (in_array($country, $supportedLocales)) {
            app()->setLocale($country);
        } else {
            app()->setLocale('en');
        }
    }
}
