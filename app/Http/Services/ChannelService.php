<?php

namespace App\Http\Services;

use App\Channel;

class ChannelService {

    static public function getChannels() {

        $result = Channel::all();

        $channels = [];

        foreach ($result as $channel) {
            $channels[] = [
                'id' => $channel->id,
                'title' => $channel->title,
            ];
        }

        return $channels;
    }

}
