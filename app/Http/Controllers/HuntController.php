<?php

namespace App\Http\Controllers;

use App\Http\Requests\HuntRequest;
use App\Models\Area;
use App\Models\Device;
use App\Models\Hunt;
use Illuminate\Http\Request;
use Phaza\LaravelPostgis\Geometries\Point;

class HuntController extends Controller
{

    /**
     * Return the given hunt for the given device
     *
     * @param Device $device
     * @param Hunt $hunt
     * @return Hunt
     */
    public function get(Device $device, Hunt $hunt)
    {
        $hunt->load('steps');
        $hunt['finished'] = $device->hunts->contains($hunt);
        $hunt['highscore'] = $hunt->highscore();
        return $hunt;
    }

    /**
     * Return list of hunt associated for the given device
     *
     * @param Device $device
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Device $device)
    {
        $hunts = Hunt::with('steps')->get();
        foreach($hunts as $hunt)
        {
            $hunt['finished'] = $device->hunts->contains($hunt);
            $hunt['highscore'] = $hunt->highscore();
        }
        return $hunts;
    }

    /**
     * Save a new hunt
     *
     * @param HuntRequest $request
     * @return string
     */
    public function store(Request $request)
    {
        $data = json_decode($request->input('json'), true);
        $hunt = new Hunt(["name" => $data['name']]);
        $hunt->treasure = new Point($data['treasure']['x'], $data['treasure']['y']);
        $hunt->save();

        foreach($data['zones'] as $key => $zone)
        {
            $area = new Area();
            $area->name = $zone["name"];
            $area->radius = $zone["radius"];
            $area->order = $key+1;
            $area->center = new Point($zone["center"]["x"], $zone["center"]["y"]);
            $hunt->steps()->save($area);
        }
        return $hunt->load("steps");
    }

    /**
     * Update the given hunt
     *
     * @param Request $request
     * @param Hunt $hunt
     * @return $this
     */
    public function update(Request $request, Hunt $hunt)
    {
        $data = json_decode($request->input('json'), true);
        $hunt->name = $data['name'];
        $hunt->treasure = new Point($data['treasure']['x'], $data['treasure']['y']);
        $hunt->update();
        $hunt->steps()->delete();

        foreach($data['zones'] as $key => $zone)
        {
            $area = new Area();
            $area->name = $zone["name"];
            $area->radius = $zone["radius"];
            $area->order = $key+1;
            $area->center = new Point($zone["center"]["x"], $zone["center"]["y"]);
            $hunt->steps()->save($area);
        }
        return $hunt->load("steps");
    }

    /**
     * Delete the given hunt
     *
     * @param Hunt $hunt
     * @return string
     * @throws \Exception
     */
    public function delete(Hunt $hunt)
    {
        $hunt->delete();
        return "OK";
    }

    /**
     * Return list of array of highscore for all hunt as an array
     *
     * @return array
     */
    public function highscore()
    {
        $data = [];
        foreach(Hunt::all() as $hunt)
            $data[$hunt->id] = $hunt->highscore(true);
        return $data;
    }
}
