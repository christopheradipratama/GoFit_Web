<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Promo extends Model
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'ID_PROMO';
    protected $table = 'promo';
    protected $guard = 'promo';
    // protected $keyType = 'integer';

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
        "ID_PROMO",
        "NAMA_PROMO",
        "TANGGAL_MULAI_PROMO",
        "TANGGAL_BATAS_PROMO",
        "JENIS_PROMO",
        "KETERANGAN_PROMO",
        "MINIMAL_PEMBELIAN",  
        "BONUS",
    ];
}
