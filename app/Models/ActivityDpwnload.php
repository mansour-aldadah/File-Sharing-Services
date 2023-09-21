<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDpwnload extends Model
{
    use HasFactory;

    public function downloads(){
        return $this->belongsTo(File::class , 'file_id' , 'id');
    }
}
