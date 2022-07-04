<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pembelajaran extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;
    public $table = "pembelajaran";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'kelas_id',
        'siswa_id',
        'mata_pelajaran_id',
        'kd_nilai_pengetahuan',
        'kd_nilai_keterampilan',
        'kd_nilai_tugas',
        'jumlah_nilai',
        'tahun_ajar_id',
        'cttn_walikelas'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id'
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