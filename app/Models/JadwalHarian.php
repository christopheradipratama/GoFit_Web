<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class JadwalHarian extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $primaryKey = 'TANGGAL_JADWAL_HARIAN';
    protected $table = 'jadwal_harian';
    protected $guard = 'jadwal_harian';
    protected $keyType = 'datetime';

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ["remember_token"];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        "email_verified_at" => "datetime",
    ];

    protected $fillable = [
        "TANGGAL_JADWAL_HARIAN",
        "ID_INSTRUKTUR",
        "ID_JADWAL_UMUM",
        "KETERANGAN_JADWAL_HARIAN",
        "expired_at",
    ];

    public function getCreatedAtAttribute()
    {
        if (!is_null($this->attributes["created_at"])) {
            return Carbon::parse($this->attributes["created_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function getUpdatedAtAttribute()
    {
        if (!is_null($this->attributes["updated_at"])) {
            return Carbon::parse($this->attributes["updated_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    protected function serializeDate(\DateTimeInterface $date){
        return $date->format('Y-m-d H:i:s');
    }
    
    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }

    public function jadwalUmum()
    {
        return $this->belongsTo('App\Models\JadwalUmum','ID_JADWAL_UMUM');
    }
}
