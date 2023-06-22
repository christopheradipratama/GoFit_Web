<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;

class Kelas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'kelas';
    protected $primaryKey = 'ID_KELAS';
    // protected $guard = 'kelas';

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
        "NAMA_KELAS",
        "TARIF",
        "KAPASITAS",
    ];
}