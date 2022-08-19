<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntos extends Model
{
    use HasFactory;
    protected $fillable= [
        'categoria',
        'descripcion',
        'punto',
        'fecha',
        'participante_id',
        'user_id',
    ];
    public function participante(){
        return $this->belongsTo(Participante::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
//    protected $hidden = [
//        'id',
//        'user_id',
//        'participante_id',
//        'created_at',
//        'updated_at',
//    ];
}
