<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'member';
    protected $primaryKey = 'ID_MEMBER';
    protected $guard = 'member';
    protected $keyType = "string";

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
        "NAMA_MEMBER",
        "ALAMAT_MEMBER",
        "EMAIL_MEMBER",
        "NOTELP_MEMBER",
        "TANGGAL_LAHIR_MEMBER",
        "JENIS_KELAMIN_MEMBER",
        "MASA_AKTIVASI",
        "SISA_DEPOSIT_KELAS",
        "SISA_DEPOSIT_UANG",
        "MASA_EXPIRED_MEMBER",
        "password",
        "TANGGAL_DEACITVE_MEMBER",
        "TANGGAL_RESET_KELAS",
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
