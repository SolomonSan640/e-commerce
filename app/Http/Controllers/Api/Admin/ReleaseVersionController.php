<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReleaseVersion;
use App\Rules\ApkFile;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ReleaseVersionController extends Controller
{
    public function index()
    {
        // $releaseVersions = ReleaseVersion::where('is_release', 1)->get();
        $releaseVersions = ReleaseVersion::orderBy('updated_at', 'desc')->get();
        if ($releaseVersions->isEmpty()) {
            return response()->json(['status' => 200, 'message' => 'There was not data'], 200);
        }
        foreach ($releaseVersions as $releaseVersion) {
            $data[] = [
                'id' => $releaseVersion->id,
                'file_path' => $releaseVersion->file_path,
                'number' => $releaseVersion->number,
                'published_at' => $releaseVersion->published_at,
                'is_release' => $releaseVersion->is_release,
                'force_update' => $releaseVersion->force_update,
                'created_at' => $releaseVersion->created_at,
                'updated_at' => $releaseVersion->updated_at,
            ];
        }
        return response()->json(['status' => 200, 'message' => 'There was not data', 'data' => $data], 200);

    }

    public function store(Request $request)
    {
        try {
            $file = $request->file('file_path');

            $validatedData = $request->validate([
                'number' => 'required|regex:/^\d+\.\d+\.\d+$/|unique:release_versions,number',
                'published_at' => 'required|date',
                'file_path' => ['required', 'file', 'max:102400', new ApkFile],
            ]);
            $validatedData['is_release'] = $request->is_release == 'true' ? 1 : 0;
            $validatedData['force_update'] = $request->force_update == 'true' ? 1 : 0;
            if ($file->isValid()) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                if ($validatedData['number'][0] == '0') {
                    $number = $validatedData['number'] . "_Beta";
                    $originalName = $number;
                } else {
                    $originalName = $validatedData['number'];
                }

                $uniqueName = "ECO_{$originalName}.apk";
                $path = $file->storeAs('apks', $uniqueName, 'public');
                $validatedData['file_path'] = $path;
            }

            ReleaseVersion::create($validatedData);
            return response()->json(['status' => 201, 'message' => 'Data was created'], 201);

        } catch (ValidationException $e) {
            return response()->json(['status' => 422, 'message' => 'Validation Error', 'errors' => $e->errors()], 422);

        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'An error occurred', report($e)], 500);
        }
    }

    public function show($id)
    {
        try {
            $releaseVersion = ReleaseVersion::findOrFail($id);
            $data = [
                'id' => $releaseVersion->id,
                'file_path' => $releaseVersion->file_path,
                'number' => $releaseVersion->number,
                'published_at' => $releaseVersion->published_at,
                'is_release' => $releaseVersion->is_release,
                'created_at' => $releaseVersion->created_at,
                'updated_at' => $releaseVersion->updated_at,
            ];
            return response()->json(['status' => 200, 'message' => 'Data was fetched', 'data' => $data], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 200, 'message' => 'Data not found'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'An error occurred'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $releaseVersion = ReleaseVersion::findOrFail($id);

            $validatedData = $request->validate([
                'number' => 'required|regex:/^\d+\.\d+\.\d+$/|unique:release_versions,number,' . $releaseVersion->id,
                'published_at' => 'required|date',
                'file_path' => $request->hasFile('file_path') ? ['nullable', 'file', 'max:102400', new ApkFile] : ['nullable'],

            ]);
            $validatedData['is_release'] = $request->is_release == 'true' ? 1 : 0;
            $validatedData['force_update'] = $request->force_update == 'true' ? 1 : 0;

            if ($request->input('file_path')) {
                $validatedData['file_path'] = $request->input('file_path');
            }
            if ($request->hasFile('file_path') && $request->file('file_path')->isValid()) {
                // Delete old APK file if it exists
                if ($releaseVersion->file_path) {
                    \Storage::disk('public')->delete($releaseVersion->file_path);
                }

                $file = $request->file('file_path');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                if ($validatedData['number'][0] == '0') {
                    $number = $validatedData['number'] . "_Beta";
                    $originalName = $number;
                } else {
                    $originalName = $validatedData['number'];
                }

                $uniqueName = "ECO_{$originalName}.apk";
                $path = $file->storeAs('apks', $uniqueName, 'public');
                $validatedData['file_path'] = $path;
            }

            $releaseVersion->update($validatedData);
            return response()->json(['status' => 200, 'message' => 'Data was updated'], 200);

        } catch (ValidationException $e) {
            return response()->json(['status' => 422, 'message' => 'Validation Error'], 422);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'An error occurred'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $releaseVersion = ReleaseVersion::findOrFail($id);

            if ($releaseVersion->file_path) {
                Storage::disk('public')->delete($releaseVersion->file_path);
            }

            $releaseVersion->delete();

            return response()->json(['status' => 200, 'message' => 'Data was deleted'], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 200, 'message' => 'Data not found'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'An error occurred'], 500);
        }
    }
}
