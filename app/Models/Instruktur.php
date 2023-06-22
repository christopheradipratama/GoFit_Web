<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Instruktur extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'instruktur';
    protected $primaryKey = 'ID_INSTRUKTUR';
    protected $guard = 'instruktur';

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
        "NAMA_INSTRUKTUR",
        "ALAMAT_INSTRUKTUR",
        "EMAIL_INSTRUKTUR",
        "NOTELP_INSTRUKTUR",
        "TANGGAL_LAHIR_INSTRUKTUR",
        "JENIS_KELAMIN_INSTRUKTUR",
        "password",
        "JUMLAH_TERLAMBAT",
        "TANGGAL_EXPIRED_TERLAMBAT",
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
}