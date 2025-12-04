<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FacebookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    protected $facebookService;

    public function __construct(FacebookService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    /**
     * Display settings page
     */
    public function index()
    {
        return view('admin.settings.index', [
            'facebookEnabled' => config('services.facebook.enabled', false),
            'facebookPageId' => config('services.facebook.page_id'),
            'facebookApiVersion' => config('services.facebook.api_version', 'v18.0'),
        ]);
    }

    /**
     * Update Facebook settings
     */
    public function updateFacebook(Request $request)
    {
        $validated = $request->validate([
            'enabled' => 'nullable|boolean',
            'page_id' => 'nullable|string|max:255',
            'page_access_token' => 'nullable|string|max:500',
            'api_version' => 'nullable|string|max:10',
        ]);

        // Only update access token if a new one is provided
        if (empty($validated['page_access_token'])) {
            // Keep existing token if not provided
            $validated['page_access_token'] = config('services.facebook.page_access_token', '');
        }

        // Update .env file
        $envFile = base_path('.env');
        
        if (file_exists($envFile) && is_writable($envFile)) {
            $envContent = file_get_contents($envFile);
            
            // Update or add Facebook settings
            $settings = [
                'FACEBOOK_ENABLED' => ($validated['enabled'] ?? false) ? 'true' : 'false',
                'FACEBOOK_PAGE_ID' => $validated['page_id'] ?? '',
                'FACEBOOK_PAGE_ACCESS_TOKEN' => $validated['page_access_token'] ?? config('services.facebook.page_access_token', ''),
                'FACEBOOK_API_VERSION' => $validated['api_version'] ?? 'v18.0',
            ];

            foreach ($settings as $key => $value) {
                // Escape special characters in value
                $escapedValue = preg_replace('/([\\$`])/', '\\\\$1', $value);
                
                if (preg_match("/^{$key}=.*/m", $envContent)) {
                    $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$escapedValue}", $envContent);
                } else {
                    // Add at the end if it doesn't exist
                    $envContent = rtrim($envContent) . "\n{$key}={$escapedValue}\n";
                }
            }

            file_put_contents($envFile, $envContent);
            
            // Clear config cache
            Artisan::call('config:clear');
        } else {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Unable to update .env file. Please check file permissions or update manually.');
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Facebook settings updated successfully.');
    }

    /**
     * Test Facebook connection
     */
    public function testFacebook()
    {
        $result = $this->facebookService->verifyToken();
        
        return response()->json($result);
    }
}

