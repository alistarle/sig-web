<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ["uuid", "step", "model"];

    /**
     * Return list of hunt of the device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hunts()
    {
        return $this->belongsToMany('App\Models\Hunt')->withTimestamps()->withPivot('time');
    }

    /**
     * Return current hunt of the device
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hunt()
    {
        return $this->belongsTo('App\Models\Hunt');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
