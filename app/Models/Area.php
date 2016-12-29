<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;

class Area extends Model
{
    use PostgisTrait;

    protected $fillable = ["center", "radius", "order", "name"];

    protected $postgisFields = ['center'];

    /**
     * Return hunt of the step
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hunt()
    {
        return $this->belongsTo('App\Models\Hunt');
    }

}
