<!DOCTYPE html>
<html lang="en">
<head>
   <title>Laporan Kas Masjid</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        .cop {
            width:auto;
            padding: 0 0 15px 0;
        }
        .tengah {
            text-align: center;
            line-height: 5px;
        }
        .tengah-ttd {
            text-align: center;
            line-height: 20px;
        }
        .table {
            font-size: 12pt;
        }
        hr {
            background-color:white;
            margin:0 0 20px 0;
            border-width:0;
        }
        hr.s1 {
            height:2px;
            border-top:4px solid black;
            border-bottom:1px solid black;
        }
        .tables td, .tables th {
            font-size: 12pt;
        }
    </style>
</head>
<body>
    <div class="content p-4">
        <div class="cop">
            <table width="100%">
                <tr>
                    <td width="10px">
                        <img src="{{asset('vendor/adminlte/dist/img/logo.png')}}" width="120px">
                    </td>
                    <td class="tengah">
                        <h3 style="font-weight: 700">BADAN KEMAKMURAN MASJID (BKM)</h3>
                        <h3 style="font-weight: 900">AL-FURQAN</h3>
                        <h4 style="font-weight: 700">GAMPONG BEURAWE KEC. KUTA ALAM KOTA BANDA ACEH</h4>
                        <p>Sekretariat : Jl. K. Saman Gamping Beurawe Kode Pos : 23124 Contact Person : 08216111577</p>
                    </td>
                </tr>
            </table>
        </div>
        <hr class="s1">
        <center>
            <h4 style="line-height: 1ch">Laporan Rekapitulasi Kas Masjid</h2>
            <p>Periode {{date_indo($from_date)}} s/d {{date_indo($to_date)}}</p>
        </center>
        <div class="row">
            <div class="col-lg-12">
                <table width="100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Uraian</th>
                            <th>Pemasukan</th>
                            <th>Pengeluaran</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($result as $item)
                            <tr>
                                <td>{{$no}}</td>
                                <td>{{mediumdate_indo($item->tanggal_kas)}}</td>
                                <td>{{$item->keterangan}}</td>
                                <td>@if($item->arus_kas == "masuk") {{rupiah($item->masuk)}} @endif</td>
                                <td>@if($item->arus_kas == "keluar") {{rupiah($item->keluar)}} @endif</td>
                            </tr>
                            @php
                            $no++;
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="3"><strong>Total</strong></td>
                            <td colspan="1"><strong>{{rupiah($total_masuk)}}</strong></td>
                            <td><strong>{{rupiah($total_keluar)}}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Saldo Awal</strong></td>
                            <td colspan="2"><strong>{{rupiah($saldo_awal)}}</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3"><strong>Saldo Akhir</strong></td>
                            <td colspan="2"><strong>{{rupiah($saldo_akhir)}}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-12 mt-4">
                <table width="100%" class="tables">
                    <tr style="height: 25px;">
                        <td class="tengah"></td>
                        <td class="tengah">Banda Aceh, {{date_indo(date('Y-m-d'))}}</td>
                    </tr>
                    <tr>
                        <td class="tengah">Diperiksa Oleh</td>
                        <td class="tengah">Mengetahui,</td>
                    </tr>
                    <tr style="height: 190px;">
                        <td class="tengah-ttd"><span><u>{{ $bendahara_bkm }}</u></span><p><strong>Bendahara BKM</strong></p></td>
                        <td class="tengah-ttd"><span><u>{{ $ketua_bkm }}</u></span><p><strong>Ketua BKM</strong></p></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
<script>
    window.print();
</script>
</body>
</html>