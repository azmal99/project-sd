<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/guru/*',
        '/users/*',
        '/siswa/*',
        '/kelas/*',
        '/mata-pelajaran/*',
        '/tahun-ajaran/*',
        '/absensi/*',
        '/pembelajaran/*',
        '/rapot/*',
        '/kepribadian/*',
        '/anggota-ekskul/*',
        '/ekstra-kulikuler/*',
        '/nilai-pengetahuan/*',
        '/nilai-keterampilan/*',
        '/nilai-tugas/*',
        '/login/*',
        '/logout/*'


    ];
}
