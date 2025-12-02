<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function about()
    {
        return view('pages.about', [
            'seo' => $this->seoService->forPage('about'),
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'seo' => $this->seoService->forPage('contact'),
        ]);
    }

    public function privacy()
    {
        return view('pages.privacy', [
            'seo' => $this->seoService->forPage('privacy'),
        ]);
    }

    public function terms()
    {
        return view('pages.terms', [
            'seo' => $this->seoService->forPage('terms'),
        ]);
    }
}

