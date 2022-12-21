@extends('layouts.master')

@section('titlebar', 'Component')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <button data-coreui-toggle="modal" data-coreui-target="#addcompo" class="btn btn-success btn-sm"
                                type="button">add</button>
                            &nbsp; List Component
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0" id="table_comp">
                                    <thead class="table-light fw-semibold">
                                        <th>id</th>
                                        <th>key group</th>
                                        <th>nama component</th>
                                        <th>action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->key_group }}</td>
                                                <td>{{ $item->nm_component }}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">form component</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formcomp" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">Key Group:</label>
                            <select name="key_group" id="key_group" class="form-control">
                                <option value="material">Material</option>
                                <option value="jasa">Jasa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Name Component:</label>
                            <input type="text" class="form-control" name="nm_component" id="nm_component">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">stok:</label>
                            <input type="number" class="form-control" name="stok" id="stok">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">price:</label>
                            <input type="number" class="form-control" name="price" id="price">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input id="comp-form-submit" type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editcompo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">form component</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formcompe" method="POST">
                    @csrf

                    <input type="hidden" name="id" id="id" >

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="col-form-label">Key Group:</label>
                            <select name="key_groupe" id="key_groupe" class="form-control">

                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Name Component:</label>
                            <input type="text" class="form-control" name="nm_componente" id="nm_componente">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">stok:</label>
                            <input type="number" class="form-control" name="stoke" id="stoke">
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">price:</label>
                            <input type="number" class="form-control" name="pricee" id="pricee">
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

        $("#comp-form-submit").on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('master.component.store') }}",
                data: $('#formcomp').serialize(),
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
                url: "{{ route('master.component.put') }}",
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

        $("#edit-form-submit").html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...');
        $("#edit-form-submit").prop('disabled', false);

        function delComp(id) {
            var cek = confirm('Are you sure delete data ?');
            if (cek) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('master.component.destroy') }}",
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

        function showEdit(id){
            $.ajax({
                    type: "GET",
                    url: "{{ route('master.component.gebyid') }}",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var mat = "";
                        var jas = "";
                        if(response.key_group == "material"){
                            mat = "selected";
                        }
                        if(response.key_group == "jasa"){
                            jas = "selected";
                        }
                        $('#editcompo').modal('show');
                        var dropdown = '<option value="material" '+mat+'>Material</option>';
                        dropdown += '<option value="jasa" '+jas+'>Jasa</option>';
                        $('#stoke').val(response.stok);
                        $('#pricee').val(response.price);
                        $('#nm_componente').val(response.nm_component);
                        $('#id').val(response.id);
                        $('#key_groupe').html(dropdown);
                    },
                    error: function(response) {

                        alert(response.responseJSON.message);

                    }
            });
        }


    </script>
@endsection
