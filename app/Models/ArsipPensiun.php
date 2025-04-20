<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArsipPensiun extends Model
{
    use HasFactory;
    protected $table = 'arsip_pensiun';
    protected $fillable = [
        'nama',
        'nomor_sk',
        'nomor_pegawai',
        'unit_kerja',
        'tanggal_surat',
        'tanggal_diterima',
        'dokumen1',
        'dokumen2',
    ];
}
