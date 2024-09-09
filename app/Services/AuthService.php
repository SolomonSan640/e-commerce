<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    public function authenticate($email, $password, $site_url)
    {
        $baseUrl = config('services.api.base_url');
        $response = Http::post("{$baseUrl}/login", [
            'email' => $email,
            'password' => $password,
            'site_url' => $site_url
        ]);
        return $response->json();
    }
}
