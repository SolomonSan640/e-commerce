<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\Notification;
use App\Models\NotificationDevice;
use App\Services\FcmService;
use Exception;
use Google\Client as GoogleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    protected $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    // public function sendNotification(Request $request)
    // {
    //     $to = $request->input('to');
    //     $title = $request->input('title');
    //     $body = $request->input('body');
    //     $data = $request->input('data', []);

    //     $response = $this->fcmService->sendNotifications($to, $title, $body, $data);

    //     return response()->json($response);
    // }

    // public function sendNotification(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'title' => 'required|string',
    //         'body' => 'required|string',
    //     ]);

    //     $user = User::find($request->user_id);
    //     $deviceToken = $user->fcm_token;

    //     if ($deviceToken) {
    //         $response = $this->fcmService->sendNotifications($deviceToken, $request->title, $request->body);
    //         return response()->json($response);
    //     }

    //     return response()->json(['message' => 'User does not have a device token'], 400);
    // }

    protected function validateCreateData($request, $id = null)
    {
        $rules = [
            'title' => [
                'required',
                'string',
                // Rule::unique('notifications')->whereNull('deleted_at'),
            ],
            'message' => [
                'required',
            ],
            'image' => [
                'required',
            ],
        ];

        // if ($id !== null) {
        //     $rules['title'][] = Rule::unique('notifications')->whereNull('deleted_at')->ignore($id);
        // }

        return Validator::make($request->all(), $rules)->validate();
    }

    public function index(Request $request)
    {
        try {
            $deviceID = DeviceToken::where("device_id", $request->device_id)->first();
            if (!$deviceID) {
                return response()->json([
                    'status' => false,
                    'message' => 'No Device Not Found',
                ]);
            }

            $page = $request['page'] ?? 1;
            $perPage = 10;

            $notiDevice = NotificationDevice::where("device_id", $deviceID->id)
                ->with('device', 'notification')->orderBy("created_at", "desc")
                ->paginate($perPage, ['*'], 'page', $page);

            // $notiDevice = $notiDevice->count();
            if (!$notiDevice->items()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No Notification were Not found.',
                    'data' => [],
                ]);
            }

            foreach ($notiDevice->items() as $item) {
                $data[] = [
                    'id' => $item->id,
                    'notification_id' => $item->notification->id,
                    'title' => $item->notification->title,
                    'body' => $item->notification->message,
                    'image' => env('APP_URL') . "/storage/" . $item->notification->image,
                    'is_read' => $item->is_read,
                    'created_at' => $item->created_at->diffForhumans(),
                    'updated_at' => $item->updated_at->diffForhumans(),
                ];
            }
            return response()->json([
                'status' => true,
                'message' => 'Notification data were found.',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Notification was failed to fetch.',
                "error" => $e->getMessage(),
            ], 200);
        }
    }

    public function store(Request $request)
    {
        try {
            $validationResult = $this->validateCreateData($request);
            $serverKey = $this->getAccessToken();
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('noti_images', 'public');
                $validationResult['image'] = $imagePath;
            }

            $notification = Notification::create([
                'title' => $validationResult['title'],
                'message' => $validationResult['message'],
                'image' => $validationResult['image'],
            ]);

            if ($request->user === 'all') {
                $devices = DeviceToken::all();
                foreach ($devices as $device) {
                    NotificationDevice::create([
                        'device_id' => $device->id,
                        'notification_id' => $notification->id,
                    ]);
                    $this->fcmService->sendNotifications($device->device_token, $notification->title, $notification->message, $serverKey, $notification->image, $notification->id);
                }
            }

            return response()->json(['status' => true, 'message' => "Notification was sent successfully"], 201);
        } catch (ValidationException $validationException) {
            return response()->json([
                'status' => false,
                'message' => 'Notification was failed.',
                'errors' => $validationException->errors(),
            ]);
        }
    }

    public function isRead(Request $request)
    {
        try {
            $notiID = $request->input('noti_id');
            $deviceID = $request->input('device_id');

            $device = DeviceToken::where('device_id', $deviceID)->first()->id;

            $notiDevice = NotificationDevice::where('notification_id', $notiID)->where('device_id', $device)->first();

            $notiDevice->update(['is_read' => 1]);
            return response()->json([
                'status' => true,
                'message' => 'Noti was read.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Notification was error.',
                'errors' => $e->getMessage(),
            ]);
        }
    }

    public function unRead(Request $request)
    {
        try {
            $deviceID = DeviceToken::where("device_id", $request->device_id)->first();
            if (!$deviceID) {
                return response()->json([
                    'status' => false,
                    'message' => 'No Device Not Found',
                ]);
            }

            $page = $request['page'] ?? 1;
            $perPage = 10;

            $notiDevice = NotificationDevice::where("device_id", $deviceID->id)
                ->where('is_read', 0)
                ->with('device', 'notification')->orderBy("created_at", "desc")
                ->paginate($perPage, ['*'], 'page', $page);

            // $notiDevice = $notiDevice->count();
            if (!$notiDevice->items()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No Notification were Not found.',
                    'data' => [],
                ]);
            }

            foreach ($notiDevice->items() as $item) {
                $data[] = [
                    'id' => $item->id,
                    'notification_id' => $item->notification->id,
                    'title' => $item->notification->title,
                    'body' => $item->notification->message,
                    'image' => env('APP_URL') . "/storage/" . $item->notification->image,
                    'is_read' => $item->is_read,
                    'created_at' => $item->created_at->diffForhumans(),
                    'updated_at' => $item->updated_at->diffForhumans(),
                ];
            }
            return response()->json([
                'status' => true,
                'message' => 'Notification data were found.',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Notification was failed to fetch.',
                "error" => $e->getMessage(),
            ], 200);
        }
    }

    protected function getAccessToken()
    {
        $pathToServiceAccount = storage_path('app/service-account-file.json');

        $client = new GoogleClient();
        $client->setAuthConfig($pathToServiceAccount);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        // Fetch access token
        $accessToken = $client->fetchAccessTokenWithAssertion();

        if (isset($accessToken['access_token'])) {
            return $accessToken['access_token'];
        } else {
            throw new Exception('Failed to obtain access token.');
        }
    }
}
