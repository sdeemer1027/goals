<?php

namespace Database\Seeders;

use App\Models\TvChannel;
use Illuminate\Database\Seeder;

class TvChannelSeeder extends Seeder
{
    /**
     * Seed the TV channels table.
     */
    public function run(): void
    {
        TvChannel::upsert(
            [
                [
                    'provider' => 'Pluto TV',
                    'name' => 'Pluto TV Movies',
                    'slug' => 'pluto-tv-movies',
                    'logo_url' => null,
                    'description' => 'Pluto TV live movie programming.',
                    'category' => 'Movies',
                    'stream_type' => 'external',
                    'stream_url' => null,
                    'embed_url' => null,
                    'external_url' => 'https://pluto.tv/us/watch/live-tv',
                    'active' => true,
                    'sort_order' => 1,
                ],

                [
                    'provider' => 'Pluto TV',
                    'name' => 'Pluto TV Entertainment',
                    'slug' => 'pluto-tv-entertainment',
                    'logo_url' => null,
                    'description' => 'Pluto TV live entertainment programming.',
                    'category' => 'Entertainment',
                    'stream_type' => 'external',
                    'stream_url' => null,
                    'embed_url' => null,
                    'external_url' => 'https://pluto.tv/us/watch/live-tv',
                    'active' => true,
                    'sort_order' => 2,
                ],

                [
                    'provider' => 'Tubi TV',
                    'name' => 'Tubi Movies',
                    'slug' => 'tubi-movies',
                    'logo_url' => null,
                    'description' => 'Tubi live movie programming.',
                    'category' => 'Movies',
                    'stream_type' => 'external',
                    'stream_url' => null,
                    'embed_url' => null,
                    'external_url' => 'https://tubitv.com/live',
                    'active' => true,
                    'sort_order' => 3,
                ],

                [
                    'provider' => 'Tubi TV',
                    'name' => 'Tubi News',
                    'slug' => 'tubi-news',
                    'logo_url' => null,
                    'description' => 'Tubi live news programming.',
                    'category' => 'News',
                    'stream_type' => 'external',
                    'stream_url' => null,
                    'embed_url' => null,
                    'external_url' => 'https://tubitv.com/live',
                    'active' => true,
                    'sort_order' => 4,
                ],

                [
                    'provider' => 'Test',
                    'name' => 'HLS Test Channel',
                    'slug' => 'hls-test-channel',
                    'logo_url' => null,
                    'description' => 'Temporary channel used to test HLS video playback.',
                    'category' => 'Test',
                    'stream_type' => 'hls',
                    'stream_url' => 'https://test-streams.mux.dev/x36xhzz/x36xhzz.m3u8',
                    'embed_url' => null,
                    'external_url' => null,
                    'active' => true,
                    'sort_order' => 5,
                ],
            ],
            ['slug'],
            [
                'provider',
                'name',
                'logo_url',
                'description',
                'category',
                'stream_type',
                'stream_url',
                'embed_url',
                'external_url',
                'active',
                'sort_order',
                'updated_at',
            ]
        );
    }
}