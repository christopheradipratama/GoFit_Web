<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class TransaksiAktivasi extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'ID_TRANSAKSI_AKTIVASI';
    protected $table = 'transaksi_aktivasi';
    protected $guard = 'transaksi_aktivasi';
    protected $keyType = 'string';

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
        "ID_TRANSAKSI_AKTIVASI",  
        "ID_MEMBER",
        "ID_PEGAWAI",
        "TANGGAL_TRANSAKSI_AKTIVASI",
        "EXPIRED_TRANSAKSI_AKTIVASI",
        "BIAYA_AKTIVASI",
        "STATUS_AKTIVASI",
        "KEMBALIAN",
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
        if (!is_null($this->attributes["update_at"])) {
            return Carbon::parse($this->attributes["update_at"])->format(
                "Y-m-d H:i:s"
            );
        }
    }

    public function member()
    {
        return $this->belongsTo("App\Models\Member", "ID_MEMBER");
    }

    public function pegawai()
    {
        return $this->belongsTo("App\Models\Pegawai", "ID_PEGAWAI");
    }
}