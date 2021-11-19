<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incidents extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = array('id', 'title', 'description', 'image', 'value', 'cor');

    public function ong()
    {
        return $this->belongsTo(Ongs::class, 'ong_id');
    }
}
