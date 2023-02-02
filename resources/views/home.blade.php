@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h5 id="kas_masuk"></h5>
                    <p>Total Pemasukan Kas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
                <a href="{{route('kas.masuk')}}" class="small-box-footer">Selengkapnya
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h5 id="kas_keluar"></h5>
                    <p>Total Pengeluaran Kas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
                <a href="{{route('kas.keluar')}}" class="small-box-footer">Selengkapnya
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h5 id="sisa_saldo"></h5>
                    <p>Sisa Saldo Kas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bars"></i>
                </div>
                <a href="{{route('kas.laporan')}}" class="small-box-footer">Selengkapnya
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $( document ).ready(function() {
            $.ajax({
                type:'GET',
                url:"{{ route('home') }}",
                success:function(data){
                    $("#kas_masuk").html(rupiah(data.kas_masuk));
                    $("#kas_keluar").html(rupiah(data.kas_keluar));
                    $("#sisa_saldo").html(rupiah(data.sisa_saldo));
                },
                error: function() {
                    alert('Fail getting data from server');
                }
            });
        });
    </script>
@stop