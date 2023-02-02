<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AzizRamdanLab\JadwalShalat\JadwalShalat;
use App\Models\Keuangan;
use App\Models\JadwalSholatUmum;
use App\Models\JadwalSholatKhusus;
use App\Models\JadwalPengajian;
use App\Models\AppSetting;
use App\Models\RunningText;

class DisplayController extends Controller
{
    public function displayTv(Request $request)
    {
        return view('display.index');
    }

    public function jadwalSholat(Request $request)
    {
        if($request->ajax()){
            $jadwalShalat = new JadwalShalat;
            $provinsi = $jadwalShalat->getProvinsi();
            foreach ($provinsi as $pro) {
                if($pro['text'] == "ACEH"){
                    $kabkot = $jadwalShalat->getKabupatenKota($pro['value']);
                    foreach ($kabkot as $kab) {
                        if($kab['text'] == "KOTA BANDA ACEH") {
                            $jadwal = $jadwalShalat->getJadwalShalat($pro['value'], $kab['value'], date('m'), date('Y'));
                            foreach ($jadwal['data'] as $key => $value) {
                                if($key == date('Y-m-d')) {
                                    return $jadwal['data'][$key];
                                }
                            }
                        }
                    }
                }
            }
        }
        abort(403, 'Unauthorized action.');
    }

    public function getSlideData(Request $request)
    {
        $AppSetting     = AppSetting::where('id', '1')->first();

        $conf_gallery   = $AppSetting->is_gallery == '1' ? true : false;
        $conf_ticker    = $AppSetting->is_ticker == '1' ? true : false;
        $conf_jumat     = date("D") == "Fri" ? true : false;

        $pnj_shubuh     = JadwalPengajian::where(['pengajian' => 'shubuh', 'tanggal' => date('Y-m-d')])->first();
        $pnj_magrib     = JadwalPengajian::where(['pengajian' => 'magrib', 'tanggal' => date('Y-m-d')])->first();
        $pnj_wanita     = JadwalPengajian::where(['pengajian' => 'wanita', 'tanggal' => date('Y-m-d')])->first();

        $jadwalSholaU   = JadwalSholatUmum::where('tanggal', date('Y-m-d'))->get();
        $jadwalSholaK   = JadwalSholatKhusus::where('tanggal', date('Y-m-d'))->get();

        $pengluaran     = Keuangan::where('arus_kas', 'keluar')->orderBy('id', 'desc')->get()->take(5);
        $pemasukan      = Keuangan::where('arus_kas', 'masuk')->orderBy('id', 'desc')->get()->take(5);
        $masuk          = Keuangan::where('arus_kas', 'masuk')->sum('masuk');
        $keluar         = Keuangan::where('arus_kas', 'keluar')->sum('keluar');
        $sisa_saldo     =  $masuk - $keluar;

        $return = [
            'revision_id'       => $AppSetting->revision_id,
            'date_active'       => date('Y-m-d'),
            'slide_interval'    => $AppSetting->interval * 1000,
            'is_jumat'          => $conf_jumat,
            'is_idfitri'        => $AppSetting->is_idfitri == '1' ? true : false, 
            'is_idadha'         => $AppSetting->is_idadha == '1' ? true : false, 
            'is_ramadhan'       => $AppSetting->is_ramadhan == '1' ? true : false,
            'is_gallery'        => $conf_gallery,
            'jadwal_sholat'     => $jadwalSholaU,
            'pengajian_shubuh'  => $pnj_shubuh ? $pnj_shubuh : false,
            'pengajian_magrib'  => $pnj_magrib ? $pnj_magrib : false,
            'pengajian_wanita'  => $pnj_wanita ? $pnj_wanita : false,
            'pengeluaran_kas'   => $pengluaran ? $pengluaran : false,
            'pemasukan_kas'     => $pemasukan ? $pemasukan : false,
            'sisa_saldo_kas'    => $sisa_saldo ? $sisa_saldo : false,
        ];

        // Hadist Slide
        if($conf_jumat){
            $return += [
                'khatib'            => JadwalSholatUmum::where(['tanggal' => date('Y-m-d'), 'sholat' => 'dzuhur'])->first()->khatib,
                'keterangan_khatib' => JadwalSholatUmum::where(['tanggal' => date('Y-m-d'), 'sholat' => 'dzuhur'])->first()->keterangan_khatib,
            ];
        }

        // Gallery Slide
        if($conf_gallery){
            $return += [
                'gallery_slide'   => [
                    [
                        'id'        => 1,
                        'alt'       => 'Foto 1',
                        'caption'   => 'Caption 123',
                    ],
                    [
                        'id'        => 2,
                        'alt'       => 'Foto 2',
                        'caption'   => 'Caption 123',
                    ],
                    [
                        'id'        => 3,
                        'alt'       => 'Foto 3',
                        'caption'   => 'Caption 123',
                    ],
                    [
                        'id'        => 4,
                        'alt'       => 'Foto 4',
                        'caption'   => 'Caption 123',
                    ],
                ]
            ];
        }

        // Ticker Running Text
        if($conf_ticker){
            $return += [
                'running_text' => RunningText::all()
            ];
        }

        return response()->json($return, 200);
    }
}
