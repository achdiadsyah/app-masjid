@extends('adminlte::page')

@section('title', 'Jadwal Sholat Khusus')

@section('content_header')
    <h1>Jadwal Sholat Khusus</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-info">
                    <div class="card-title">Jadwal Sholat Khusus</div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3 pb-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button class="btn btn-primary btn-sm" onclick="showAddData();">Add New Data</button>
                                <button class="btn btn-success btn-sm" onclick="reloadTable();">Refresh Data</button>
                            </div>
                        </div>
                    </div>
                    <table id="dataTable" class="table table-bordered table-striped dataTable" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Jadwal Sholat</th>
                                <th>Muazin</th>
                                <th>Imam</th>
                                <th>Khatib</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
            </div>
            <form id="formAddData">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Waktu Sholat</label>
                        <input type="time" class="form-control" id="time" name="time" required>
                    </div>
                    <div class="form-group">
                        <label>Jadwal Sholat</label>
                        <select name="sholat" id="sholat" class="form-control" required>
                            <option value="">--Silahkan Pilih--</option>
                            <option value="tarawih">Tarawih</option>
                            <option value="idfitri">IED - Fitri</option>
                            <option value="idadha">IED - Adha</option>
                            <option value="khusuf">Khusuf</option>
                            <option value="istisqa">Istisqa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Muazin</label>
                        <input type="text" class="form-control" id="muazin" name="muazin" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Muazin</label>
                        <input type="text" class="form-control" id="keterangan_muazin" name="keterangan_muazin" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Imam</label>
                        <input type="text" class="form-control" id="imam" name="imam" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Imam</label>
                        <input type="text" class="form-control" id="keterangan_imam" name="keterangan_imam" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Khatib</label>
                        <input type="text" class="form-control" id="khatib" name="khatib">
                    </div>
                    <div class="form-group">
                        <label>Keterangan Khatib</label>
                        <input type="text" class="form-control" id="keterangan_khatib" name="keterangan_khatib">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="hideAddData();">Close</button>
                    <button type="submit" class="btn btn-primary">Save Data</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('plugins.Datatables', true)
@section('js')
<script src="{{asset('display')}}/js/custom.js"></script>
<script>
    $( document ).ready(function() {
        var table = $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url:  "{{route('jadwal.sholat-khusus')}}",
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'tanggal', name: 'tanggal' },
                { data: 'time', name: 'time' },
                { data: 'sholat', name: 'sholat' },
                { data: 'muazin', name: 'muazin' },
                { data: 'imam', name: 'imam' },
                { data: 'khatib', name: 'khatib' },
                { data: 'created_by', name: 'created_by', render: function(data, type, row){
                    return `${data}`;
                }},
                {render: function (data, type, row) {                    
                    return `<button type="button" onClick="deleteData('${row.id}')" class="btn btn-danger btn-sm">Delete</button>`;
                }},
            ]
        });

        $("#formAddData").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: "{{route('jadwal.sholat-khusus-add')}}",
                data: form.serialize(),
                success: function(data) {
                    hideAddData();
                    form[0].reset(),
                    alert("Success Add New Data");
                    reloadTable();
                },
                error: function (){
                    hideAddData();
                    alert("Error Add New Data");
                }
            });

        });
    });

    function showAddData() {
        $("#modalAdd").modal('show');
    }
    
    function hideAddData() {
        $("#modalAdd").modal('hide');
    }

    function reloadTable() {
        $('#dataTable').DataTable().ajax.reload();
    }

    function deleteData(id){
        if (confirm("Delete Data") == true) {
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax(
            {
                url: "{{route('jadwal.sholat-khusus-delete')}}",
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (){
                    alert("Success Delete Data");
                    reloadTable();
                },
                error: function (){
                    alert("Error Delete Data");
                }
            });
        }
    }
</script>
    
@stop