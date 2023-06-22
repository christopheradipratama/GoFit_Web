<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class MemberDepositKelas extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'member_deposit_kelas';
    protected $primaryKey = 'ID_MEMBER_DEPOSIT_KELAS';
    protected $guard = 'member_deposit_kelas';

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
        "ID_MEMBER",  
        "ID_KELAS",
        "SISA_DEPOSIT",
        "MASA_BERLAKU",
        "EXPIRED_RESET_KELAS",
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

    public function member()
    {
        return $this->belongsTo("App\Models\Member", "ID_MEMBER");
    }

    public function promo()
    {
        return $this->belongsTo('App\Models\Promo','ID_PROMO');
    }

    public function pegawai()
    {
        return $this->belongsTo("App\Models\Pegawai", "ID_PEGAWAI");
    }

    public function kelas()
    {
        return $this->belongsTo('App\Models\Kelas','ID_KELAS');
    }
}
