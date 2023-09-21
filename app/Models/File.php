<?php

namespace App\Models;

use App\Models\Scopes\FileDeletedScope;
use App\Models\Scopes\UserFileScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class File extends Model
{
    use HasFactory;

    private static string $disk = 'local';
    protected $table = 'file';

    protected $fillable = ['title', 'user_id', 'description', 'file', 'country', 'user_agent','ip_address', 'code'];


    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }

    public static function uploadFile($file  )
    {
        // $file->file = $file_name;
        return $file->store('', self::$disk);
    }

    public static function deleteFile($file)
    {
        if ($file && Storage::disk(static::$disk)->exists($file)) {
            Storage::disk(static::$disk)->delete($file);
        }
    }

    public function scopeFindByCode(Builder $builder)
    {
        $builder->where('code', request()->route('code'));
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope(new UserFileScope());
    //     static::creating(function ($model) {
    //         if (Auth::check()) {
    //             $model->user_id = Auth::id();
    //         }
    //     });
    // }

    public function getDownloadLinkAttribute()
    {
        return URL::temporarySignedRoute('files.downloadForm', now()->addMinutes(2), ['file' => $this->code]);
    }

    public function downloads(){
        return $this->hasMany(ActivityDpwnload::class , 'file_id' , 'id');
    }
}
