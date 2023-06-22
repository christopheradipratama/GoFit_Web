<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class TransaksiDepositUang extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'ID_TRANSAKSI_DEPOSIT_UANG';
    protected $table = 'transaksi_deposit_uang';
    protected $guard = 'transaksi_deposit_uang';
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
        "ID_TRANSAKSI_DEPOSIT_UANG",  
        "ID_PROMO",
        "ID_MEMBER",
        "ID_PEGAWAI",
        "JUMLAH_DEPOSIT_UANG",
        "BONUS_DEPOSIT_UANG",
        "SISA_DEPOSIT",
        "TOTAL_DEPOSIT_UANG",
        "TANGGAL_DEPOSIT_UANG",
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
}
