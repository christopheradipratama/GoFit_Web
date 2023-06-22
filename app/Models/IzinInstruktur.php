<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class IzinInstruktur extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'izin_instruktur';
    protected $primaryKey = 'ID_IZIN_INSTRUKTUR';
    protected $guard = 'izin_instruktur';

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
        "ID_INSTRUKTUR",
        "NAMA_INSTRUKTUR_PENGGANTI",
        "TANGGAL_IZIN_INSTRUKTUR",
        "KETERANGAN_IZIN",
        "TANGGAL_MELAKUKAN_IZIN",
        "STATUS_IZIN",
        "TANGGAL_KONFIRMASI_IZIN",
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

    public function instruktur()
    {
        return $this->belongsTo('App\Models\Instruktur','ID_INSTRUKTUR');
    }
}
