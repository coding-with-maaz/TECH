<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class DownloadTokenService
{
    /**
     * Create an encrypted download token
     * 
     * @param string $downloadLink The real download link
     * @param int $movieId The movie ID
     * @param int $expiresInMinutes Token expiration time in minutes (default: 30, null for permanent)
     * @return string Encrypted token
     */
    public function createToken(string $downloadLink, int $movieId, ?int $expiresInMinutes = 30): string
    {
        $payload = [
            'link' => $downloadLink,
            'movie_id' => $movieId,
            'created_at' => Carbon::now()->timestamp,
        ];

        // If expiresInMinutes is null, make token permanent (expires in 10 years)
        if ($expiresInMinutes === null) {
            $payload['expires_at'] = Carbon::now()->addYears(10)->timestamp;
        } else {
            $payload['expires_at'] = Carbon::now()->addMinutes($expiresInMinutes)->timestamp;
        }

        return Crypt::encryptString(json_encode($payload));
    }

    /**
     * Create a permanent token for an article
     * 
     * @param string $downloadLink The real download link
     * @param int $articleId The article ID
     * @return string Encrypted permanent token
     */
    public function createPermanentToken(string $downloadLink, int $articleId): string
    {
        return $this->createToken($downloadLink, $articleId, null); // null = permanent
    }

    /**
     * Decrypt and validate download token
     * 
     * @param string $token Encrypted token
     * @return array|null Decrypted payload or null if invalid/expired
     */
    public function decryptToken(string $token): ?array
    {
        try {
            $decrypted = Crypt::decryptString($token);
            $payload = json_decode($decrypted, true);

            if (!$payload || !isset($payload['expires_at'])) {
                return null;
            }

            // Check if token is expired
            if (Carbon::createFromTimestamp($payload['expires_at'])->isPast()) {
                return null;
            }

            return $payload;
        } catch (\Exception $e) {
            \Log::error('Token decryption failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get download link from token
     * 
     * @param string $token Encrypted token
     * @return string|null Download link or null if invalid/expired
     */
    public function getDownloadLink(string $token): ?string
    {
        try {
            $payload = $this->decryptToken($token);
            if ($payload && isset($payload['link']) && !empty($payload['link'])) {
                return $payload['link'];
            }
            return null;
        } catch (\Exception $e) {
            \Log::warning('Failed to get download link from token: ' . $e->getMessage());
            return null;
        }
    }
}

