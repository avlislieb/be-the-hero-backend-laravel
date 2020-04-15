<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ongs extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = array('id', 'name', 'email', 'whatsapp', 'city', 'uf');

    public function Incidents()
    {
        return $this->hasMany(Incidents::class, 'ong_id');
    }

    public static function generateTokenId()
    {
        return substr(uniqid('', true), 15);
    }
}
