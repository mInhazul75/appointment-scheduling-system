<?php

namespace App\Services;

use App\Models\BookingLink;
use App\Models\Availability;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BookingLinkService
{
    public function create()
    {
        $slug = Str::slug(Auth::user()->name . '-' . Str::random(6));

        return BookingLink::create([
            'user_id' => Auth::id(),
            'slug' => $slug,
            'active' => true,
        ]);
    }

    public function getAvailabilityBySlug($slug)
    {
        $link = BookingLink::where('slug', $slug)->where('active', true)->firstOrFail();
        return Availability::where('user_id', $link->user_id)->get();
    }
}
