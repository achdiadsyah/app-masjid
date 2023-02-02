@extends('adminlte::page')

@section('title', 'Setting App')

@section('content_header')
    <h1>Setting App</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title">Setting Display LED</div>
                </div>
                <div class="card-body">
                    <form action="{{route('setting.app-update')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$result->id}}" required>
                        <div class="form-group">
                            <label>Interval Slideshow</label>
                            <div class="input-group mb-3">
                                <input type="number" name="interval" id="interval" class="form-control" min="5" max="30" value="{{$result->interval}}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">detik</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Show Ticker / Running Text</label>
                            <select name="is_ticker" id="is_ticker" class="form-control" required>
                                <option value="1" @if($result->is_ticker == "1") selected @endif>Show</option>
                                <option value="0" @if($result->is_ticker == "0") selected @endif>Hide</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Show Gallery / Foto Kegiatan</label>
                            <select name="is_gallery" id="is_gallery" class="form-control" required>
                                <option value="1" @if($result->is_gallery == "1") selected @endif>Show</option>
                                <option value="0" @if($result->is_gallery == "0") selected @endif>Hide</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Show Atribut IED - Fitri</label>
                            <select name="is_idfitri" id="is_idfitri" class="form-control" required>
                                <option value="1" @if($result->is_idfitri == "1") selected @endif>Show</option>
                                <option value="0" @if($result->is_idfitri == "0") selected @endif>Hide</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Show Atribut IED - Adha</label>
                            <select name="is_idadha" id="is_idadha" class="form-control" required>
                                <option value="1" @if($result->is_idadha == "1") selected @endif>Show</option>
                                <option value="0" @if($result->is_idadha == "0") selected @endif>Hide</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Show Atribut Ramadhan / Tarawih</label>
                            <select name="is_ramadhan" id="is_ramadhan" class="form-control" required>
                                <option value="1" @if($result->is_ramadhan == "1") selected @endif>Show</option>
                                <option value="0" @if($result->is_ramadhan == "0") selected @endif>Hide</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-secondary">
                    <div class="card-title">Setting Aplikasi</div>
                </div>
                <div class="card-body">
                    <form action="{{route('setting.app-update')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$result->id}}" required>
                        <div class="form-group">
                            <label>Ketua BKM</label>
                            <input type="text" name="ketua_bkm" id="ketua_bkm" class="form-control" value="{{$result->ketua_bkm}}" required>
                        </div>
                        <div class="form-group">
                            <label>Bendahara BKM</label>
                            <input type="text" name="bendahara_bkm" id="bendahara_bkm" class="form-control" value="{{$result->bendahara_bkm }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
@if(session()->has('msg'))
<script>
    alert("{{ session()->get('msg') }}");
</script>
@endif 
@stop