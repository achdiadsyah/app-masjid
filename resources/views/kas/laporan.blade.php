@extends('adminlte::page')

@section('title', 'Kas Masuk')

@section('content_header')
    <h1>Laporan Arus Kas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-6 mx-auto">
            <div class="card">
                <div class="card-header bg-warning">
                    <div class="card-title">Laporan Kas</div>
                </div>
                <form action="{{route('kas.laporan-show')}}" method="POST">
                    <div class="card-body">
                        @csrf
                        <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Hingga Tanggal</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lihat Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
    
@stop