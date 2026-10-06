<?php

namespace App\Http\Controllers;

use App\Models\TvChannel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TvViewerController extends Controller
{
    /**
     * Display the TV viewer.
     */
    public function index(): Response
    {
        $channels = TvChannel::query()
            ->where('active', true)
            ->orderBy('provider')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return Inertia::render('TV/Viewer', [
            'channels' => $channels,
        ]);
    }
}