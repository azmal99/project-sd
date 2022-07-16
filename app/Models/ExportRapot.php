<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ExportRapot extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;
    // public $table = "rapot";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_siswa', 'nis', 'nisn', 'nama_mata_pelajaran',
        'np_ph1', 'np_ph2',
        'nk_ph1', 'nk_ph2',
        'nt_ph1', 'nt_ph2',
        'np_pts', 'nk_pts', 'nt_pts',
        'nama_ekskul', 'sakit', 'izin', 'tanpa_alasan',
        'sikap_spiritual', 'kerajinan', 'kerapihan',
        'kebersihan', 'cttn_walikelas'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // 'id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}