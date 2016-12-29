<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Hunt extends Model
{
    use PostgisTrait;

    protected $fillable = ["name"];

    protected $postgisFields = ['treasure'];


    /**
     * Return list of devices of the hunt
     *
     * @return $this
     */
    public function devices()
    {
        return $this->belongsToMany('App\Models\Device')->withPivot('time');
    }

    /**
     * Return list of steps of the hunt
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function steps()
    {
        return $this->hasMany('App\Models\Area');
    }

    /**
     * Return hunt best time and device UUID
     *
     * @param bool $all
     * @return array
     */
    public function highscore($all = false)
    {
        if($this->devices->count() == 0)
            return [];
        $minTime = $this->devices->min('pivot.time');
        if($all)
            return $this->devices->sortBy('pivot.time')->values();
        else
            return ["device" => $this->devices->where('pivot.time',$minTime)->first()->uuid, "time" => Carbon::now()->diffForHumans(Carbon::now()->addSeconds($minTime), true) ];
    }
}
