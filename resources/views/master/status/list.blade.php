@extends('layouts.master')

@section('titlebar', 'Status')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <button data-coreui-toggle="modal" data-coreui-target="#addcompo" class="btn btn-success btn-sm"
                                type="button">add</button>
                            &nbsp; List Status
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0" id="table_comp">
                                    <thead class="table-light fw-semibold">
                                        <th>id</th>
                                        <th>icon</th>
                                        <th>nama status</th>
                                        <th>action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->icon }}</td>
                                                <td>{{ $item->nama_status }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-ghost-info btn-sm"
                                                        onclick="showEdit({{ $item->id }})">Edit</button>
                                                    <button type="button"
                                                        class="btn btn-ghost-danger btn-sm" onclick="delComp({{ $item->id }})">Delete</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>

    <div class="modal fade" id="addcompo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">form status</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formstat" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">icon:</label>
                            <input type="text" class="form-control" name="icon" id="icon">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Nama Status:</label>
                            <input type="text" class="form-control" name="nama_status" id="nama_status">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">desc status:</label>
                            <input type="text" class="form-control" name="desc_status" id="desc_status">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input id="stat-form-submit" type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editcompo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">form status</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formcompe" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="id" >

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">icon:</label>
                            <input type="text" class="form-control" name="icone" id="icone">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Nama Status:</label>
                            <input type="text" class="form-control" name="nama_statuse" id="nama_statuse">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">desc status:</label>
                            <input type="text" class="form-control" name="desc_statuse" id="desc_statuse">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input id="edit-form-submit" type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $('#table_comp').DataTable();

        $("#stat-form-submit").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('master.status.store') }}",
                data: $('#formstat').serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'success!',
                        text: response.message,
                        showCancelButton: false,
                        showConfirmButton: true
                    }).then(function() {
                        window.location.reload();
                    })
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'error!',
                        text: response.responseJSON.message,
                        showCancelButton: false,
                        showConfirmButton: true
                    }).then(function() {
                        window.location.reload();
                    })
                }
            });
            return false;
        })

        $("#edit-form-submit").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('master.status.saveAllEdit') }}",
                data: $('#formcompe').serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'success!',
                        text: response.message,
                        showCancelButton: false,
                        showConfirmButton: true
                    }).then(function() {
                        window.location.reload();
                    })
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'error!',
                        text: response.responseJSON.message,
                        showCancelButton: false,
                        showConfirmButton: true
                    }).then(function() {
                        window.location.reload();
                    })
                }
            });
            return false;
        })

        function delComp(id) {
            var cek = confirm('Are you sure delete data ?');
            if (cek) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('master.status.destroy') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    },
                    success: function(response) {
                        alert(response.message);
                        window.location.reload();
                    },
                    error: function(response) {

                        alert(response.responseJSON.message);
                        window.location.reload();
                    }
                });
            }
        }

        function showEdit(id){
            $.ajax({
                    type: "GET",
                    url: "{{ route('master.status.editByid') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        $('#icone').val(response.icon);
                        $('#nama_statuse').val(response.nama_status);
                        $('#desc_statuse').val(response.desc_status);
                        $('#id').val(response.id);
                        $('#editcompo').modal('show');
                    },
                    error: function(response) {

                        alert(response.responseJSON.message);

                    }
            });
        }


    </script>
@endsection
