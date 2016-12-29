<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function polygon()
    {
        $client = new Client();
        $res = $client->request('GET', 'http://chapka.me:8080/geoserver/SIG/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=SIG:planet_osm_polygon&maxFeatures=500&outputFormat=application%2Fjson');
        $json = json_decode($res->getBody()->getContents(), true);
        foreach($json['features'] as &$feature)
            foreach($feature['geometry']['coordinates'][0] as &$coordinate)
                $coordinate[0] = $json['bbox'][2]-$coordinate[0]+$json['bbox'][0];

        return json_encode($json);
    }
}
