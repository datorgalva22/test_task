<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\ChannelService;

class ChannelController extends Controller
{
    public function getChannels()
    {
        
        $channels = ChannelService::getChannels();
        return response()->json($channels);
    }
}
