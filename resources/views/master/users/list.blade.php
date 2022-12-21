@extends('layouts.master')

@section('titlebar', 'Users')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <button data-coreui-toggle="modal" data-coreui-target="#adduser" class="btn btn-success btn-sm"
                                type="button">add</button>
                            &nbsp; List Users
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0" id="table_comp">
                                    <thead class="table-light fw-semibold">
                                        <th>id</th>
                                        <th>nama group</th>
                                        <th>nama user</th>
                                        <th>action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->nm_group }}</td>
                                                <td>{{ $item->username }}</td>
                                                <td>
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

    <div class="modal fade" id="adduser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">form user</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formuser" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">Nama Group:</label>
                            <select name="id_group" id="id_group" class="form-control">
                                @foreach ($group as $item)
                                    <option value="{{ $item->id }}">{{ $item->nm_group }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Username:</label>
                            <input type="text" class="form-control" name="username" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Fullname:</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Email:</label>
                            <input type="email" class="form-control" name="email" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Password Confirm:</label>
                            <input type="password" class="form-control" name="password_confirmation" id="password-confirm" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="user-form-submit" type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $('#table_comp').DataTable();

        $("#user-form-submit").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('master.listuser.store') }}",
                data: $('#formuser').serialize(),
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
                    url: "{{ route('master.listuser.destroyUser') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id_comp: id
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

    </script>
@endsection
