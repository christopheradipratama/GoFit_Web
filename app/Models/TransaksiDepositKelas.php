<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class TransaksiDepositKelas extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'ID_TRANSAKSI_DEPOSIT_KELAS';
    protected $table = 'transaksi_deposit_kelas';
    protected $guard = 'transaksi_deposit_kelas';
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
        "ID_TRANSAKSI_DEPOSIT_KELAS",  
        "ID_MEMBER",
        "ID_PROMO",
        "ID_PEGAWAI",
        "ID_KELAS",
        "JUMLAH_DEPOSIT_KELAS",
        "TANGGAL_DEPOSIT_KELAS",
        "MASA_BERLAKU_KELAS",
        "BONUS_DEPOSIT_KELAS",
        "TOTAL_DEPOSIT_KELAS",
        "JUMLAH_PEMBAYARAN",
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
