@extends('adminlte::page')

@section('title', 'Kas Masuk')

@section('content_header')
    <h1>Kas Masuk</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-success">
                    <div class="card-title">Data Kas Masuk</div>
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
                                <th>Tanggal Kas</th>
                                <th>Keterangan</th>
                                <th>Nominal</th>
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
                        <label>Tanggal Kas</label>
                        <input type="date" class="form-control" id="tanggal_kas" name="tanggal_kas" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan Kas</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" required>
                        <small class="text-muted">Tanpa koma atau desimal</small>
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
<script>
    $( document ).ready(function() {
        var table = $('#dataTable').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url:  "{{route('kas.masuk')}}",
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'tanggal_kas', name: 'tanggal_kas' },
                { data: 'keterangan', name: 'keterangan' },
                { data: 'masuk', name: 'masuk', render: function(data, type, row){
                    return rupiah(data);
                }},
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
                url: "{{route('kas.masuk-add')}}",
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
                url: "{{route('kas.kas-delete')}}",
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