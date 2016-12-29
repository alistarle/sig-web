<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Device;
use App\Models\Hunt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Register a new device
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        if(Device::where('uuid',$request->uuid)->count() > 0)
            return "Already Registred";
        $device = new Device($request->all());
        $device->hunt()->associate(Hunt::first());
        $device->step = 1;
        $device->date_begin = Carbon::now();
        $device->save();
        return "OK";
    }

    /**
     * Reset user progression
     *
     * @param Request $request
     * @param Device $device
     * @return string
     */
    public function reset(Device $device)
    {
        $device->hunt()->associate(Hunt::first());
        $device->hunts()->sync([]);
        $device->step = 1;
        $device->date_begin = Carbon::now();
        $device->update();
        return "OK";
    }

    /**
     * Update current hunt, new link or update progression
     *
     * @param Request $request
     * @param Device $device
     * @param Hunt $hunt
     * @return string
     */
    public function hunt(Request $request, Device $device, Hunt $hunt)
    {
        if($device->hunt->id != $hunt->id)
            $device->date_begin = Carbon::now();
        $device->hunt()->associate($hunt);
        if($request->has('step'))
            $device->step = $request->step;
        if($request->finished) {
            if(is_int($request->finished))
                $device->hunts()->attach($hunt, ["time" => $request->finished]);
            else
                $device->hunts()->attach($hunt, ["time" => Carbon::now()->diffInSeconds(Carbon::parse($device->date_begin))]);
        }
        $device->update();
        return "OK";
    }

    /**
     * Return user summary
     *
     * @param Device $device
     * @return \Illuminate\Database\Eloquent\Builder|static
     * @internal param Request $request
     */
    public function get(Device $device)
    {
        return $device->load('hunts','hunt');
    }

    /**
     * Return index view of the app
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $devices = Device::all();
        $hunts = Hunt::all();
        return view('welcome', compact('devices','hunts'));
    }
}
