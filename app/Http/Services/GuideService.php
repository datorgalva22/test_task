<?php

namespace App\Http\Services;

use App\Guide;
use App\Channel;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class GuideService {

    static public function getGuide($channelId) {

        $from = strtotime(date("Y-m-d 06:00:00"));
        $to = strtotime(date('Y-m-d H:i:s', strtotime(date("Y-m-d 05:59:00") . ' +1 day')));

        $guide = DB::table('guides')
                ->select('title', 'time_str', 'guid')
                ->where([
                    ['starts', '>=', $from],
                    ['ends', '<=', $to],
                    ['channel_id', '=', $channelId],
                ])
                ->orderBy('starts', 'asc')
                ->get();

        return $guide;
    }

    static public function getInfo($guid) {

        $from = strtotime(date("Y-m-d H:i:s"));

        $info = DB::table('guides')
                ->join('channels', 'channels.id', '=', 'guides.channel_id')
                ->select('guides.title', 'guides.time_str', 'guides.logo', 'guides.title as channel', 'channels.title as channel')
                ->where([
                    ['guides.starts', '>=', $from],
                    ['guides.guid', '=', $guid],
                ])
                ->orderBy('starts', 'asc')
                ->get();
        
        
        $res['logo'] = !empty($info[0]->logo) ? "https://ltv.lsm.lv".$info[0]->logo : "/public/images/no_logo.png";
        $res['title'] = $info[0]->title;
                
        foreach ($info as $key => $row) {
            
            unset($info[$key]->logo);
            unset($info[$key]->title);
        }
        
        $res['list'] = $info;
        
        return $res;
    }

    static public function renewGuide() {


        $API_link = ''; // paste link here

        $client = new \GuzzleHttp\Client();
        $response = $client->get($API_link);

        if ($response->getStatusCode() == 200) {

            $guide = json_decode($response->getBody(), true);

            if ($guide["error"] == 0) {

                $channelsToDb = [];
                $guideToDb = [];

                foreach ($guide["data"]["guide"] as $row) {

                    $channelsToDb[] = [
                        'id' => $row["channel"]["id"],
                        'title' => $row["channel"]["title"]
                    ];

                    foreach ($row["guide"] as $guide_row) {
                        
                        $guideToDb[] = [
                            'id' => $guide_row['id'],
                            'channel_id' => $guide_row['channel'],
                            'guid' => $guide_row['guid'],
                            'title' => $guide_row['title'],
                            'time_str' => $guide_row['time_str'],
                            'starts' => $guide_row['starts'],
                            'ends' => $guide_row['ends'],
                            'time' => $guide_row['time'],
                            'duration' => $guide_row['duration'],
                            'logo' => $guide_row["show"]['logo_large']
                        ];
                    }
                }

                DB::transaction(function () use ($channelsToDb, $guideToDb) {

                    Guide::query()->delete();
                    Channel::query()->delete();

                    DB::table('channels')->insert($channelsToDb);
                    DB::table('guides')->insert($guideToDb);
                });
            } else {

                // todo error
            }
        } else {
            // todo error
        }
    }
}
