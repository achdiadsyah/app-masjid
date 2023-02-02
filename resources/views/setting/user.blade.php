@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="card-title">User Management</div>
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
                                <th>Name</th>
                                <th>Email / Username</th>
                                <th>User Level</th>
                                @if(auth()->user()->user_level == "admin")
                                <th>Action</th>
                                @endif
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
                        <label>Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email / Username</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>User Level</label>
                        <select name="user_level" id="user_level" class="form-control" required>
                            <option value="">--Select Level--</option>
                            <option value="admin">Admin</option>
                            <option value="bendahara">Bendahara</option>
                        </select>
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
                url:  "{{route('setting.user')}}",
                type: 'GET',
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'user_level', name: 'user_level' },
                @if(auth()->user()->user_level == "admin")
                {render: function (data, type, row) {                    
                    return `<button type="button" onClick="deleteData('${row.id}')" class="btn btn-danger btn-sm">Delete</button>`;
                }},
                @endif
            ]
        });

        $("#formAddData").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: "POST",
                url: "{{route('setting.user-add')}}",
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
                url: "{{route('setting.user-delete')}}",
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