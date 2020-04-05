<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Services\GuideService;

class GuideController extends Controller {

    public function showGuide() {
        return view('guide');
    }

    public function getInfo() {
        $guid = Request::segment(2);
        $info = GuideService::getInfo($guid);

        return response()->json($info);
    }

    public function getGuide() {

        $channelId = Request::segment(2);
        $guide = GuideService::getGuide($channelId);

        return response()->json($guide);
    }

    public function renewGuide() {

        GuideService::renewGuide();
    }
}
