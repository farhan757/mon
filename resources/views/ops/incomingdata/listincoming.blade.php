@extends('layouts.master')

@section('titlebar', 'Data')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            @if(Auth::user()->id_group == 1)
                            <button data-coreui-toggle="modal" data-coreui-target="#addcompo" class="btn btn-success btn-sm"
                                type="button">add</button>
                            &nbsp; 
                            @endif
                            List Data
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0" id="table_comp">
                                    <thead class="table-light fw-semibold">
                                        <th>id</th>
                                        <th>cycle</th>
                                        <th>status</th>
                                        <th>action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->cycle }}</td>
                                                <td>{{ $item->nama_status }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-ghost-primary btn-sm"
                                                        onclick="showDetail({{ $item->id }})">Detail</button>
                                                    @if(in_array($item->id_status_last,array(1,2,3)) && Auth::user()->id_group == 1)
                                                        <button type="button" class="btn btn-ghost-success btn-sm"
                                                            onclick="showFormupdt({{ $item->id }})">Update Status</button>                                                    
                                                    @endif

                                                    @if(Auth::user()->id_group == 1)
                                                        <button type="button" class="btn btn-ghost-danger btn-sm"
                                                            onclick="delInc({{ $item->id }})">Delete</button>                                                    
                                                    @endif
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

    <div class="modal fade" id="addcompo" tabindex="-1" data-coreui-backdrop="static" data-coreui-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">form create</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-inco" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="row">
                                    <div class="row">
                                        <div class="col-8 col-sm-6">
                                            <label class="form-label" for="softcopy1">Softcopy 1</label>
                                            <input class="form-control" id="softcopy1" name="softcopy1" type="file" required>
                                        </div>
                                        <div class="col-8 col-sm-6">
                                            <label class="form-label" for="softcopy2">Softcopy 2</label>
                                            <input class="form-control" id="softcopy2" name="softcopy2" type="file" required>
                                        </div>
                                    </div>
                                    <br><br><br><br>
                                    <div class="row">
                                        <div class="col-8 col-sm-3">
                                            <label class="form-label" for="softcopy1">Cycle</label>
                                            <input class="form-control" id="cycle" name="cycle" type="text" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <br><br><br><br>
                                    <div id="dynamicAddRemove">
                                        <div class="row mb-7">
                                            <label class="form-label">Detail</label>
                                            <div class="col-md-5">
                                                <select name="id_comp[0]" id="id_comp[0]" class="form-select selectcomp">
                                                    @foreach ($listcomp as $item)
                                                        <option value="{{ $item->id }}">{{ $item->key_group }}-{{ $item->nm_component }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <input class="form-control" id="qty[0]" name="qty[0]" type="text" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" name="add" id="dynamic-ar"
                                            class="btn btn-outline-primary btn-md">Add</button>
                                            </div>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="inc-form-submit" type="submit" class="btn btn-primary" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('include.formupdatests')
    @include('include.formdetailmaster')

@endsection

@section('js')
    <script>

        $('#table_comp').DataTable();
        $('#cycle').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })
        var i = 0;
        $("#dynamic-ar").click(function() {
            var lcomp = @json($listcomp);
            var xhtml = "";
            for(ii=0;ii<lcomp.length;ii++){
                xhtml += '<option value="'+lcomp[ii].id+'">'+lcomp[ii].key_group+'-'+lcomp[ii].nm_component+'</option>';
            }
            ++i;
            $("#dynamicAddRemove").append(
                '<div class="row mb-7" id="'+i+'">'+
                '  <div class="col-md-5">'+
                '<select name="id_comp['+i+']" id="id_comp['+i+']" class="form-select selectcomp">'+
                ''+xhtml+''+
                ' </select>'+
                '</div>'+
                '<div class="col-md-5">'+
                '<input type="number" class="form-control"'+
                'name="qty['+i+']" id="qty['+i+']" required autocomplete="off" autofocus>'+
                '</div>'+
                '<div class="col-md-2">'+
                '<button type="button" id="dynamic-ar"'+
                'class="btn btn-outline-danger remove-input-field" onclick="hapus('+i+')">Remove</button>'+
                '</div>'+
                '<br><br>'
            );
        });

        function hapus(i){
            $("#"+i+"").remove();
        }

        $("#form-inco").on('submit', function(e) {
            e.preventDefault();
            var fd = new FormData($(this)[0]);
            console.log(fd);
            $.ajax({
                type: "POST",
                url: "{{ route('ops.incdata.storeData') }}",
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
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

        function delInc(id) {
            var cek = confirm('Are you sure delete data ?');
            if (cek) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('ops.incdata.destroyData') }}",
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

        function showFormupdt(id){
            $.ajax({
                url: "{{ route('getCurrentsts') }}",
                type: "GET",
                data: {id:id},
                success: function(rsp){
                    $('#updatestat').modal('show');
                    $('#id').val(id);
                    $('#current_sts').text(rsp.nama_status);
                }
            });
        }

        $("#formupdtsts").on('submit', function(e) {
            e.preventDefault();
            var fd = new FormData($(this)[0]);
            console.log(fd);
            $.ajax({
                type: "POST",
                url: "{{ route('ops.incdata.UpdateSts') }}",
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
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

        function showDetail(id){
            $.ajax({
                url: "{{ route('ops.incdata.detailMaster') }}",
                type: "GET",
                data: {id:id},
                success: function(rsp){
                    $('#detailmst').modal('show'); 
                    var tcom = "";
                    for(i=0;i<rsp.component.length;i++){
                        tcom += '<tr>'+
                                    '<td><strong>'+rsp.component[i].nm_component+'</strong></td>'+
                                    '<td><strong>'+rsp.component[i].qty+'</strong></td>'+
                                '</tr>';
                    }
                    $('#tcomp').html(tcom);
                    
                    var tl = "";
                    for(i=0;i<rsp.liststatus.length;i++){
                        tl += '<li class="event" data-date="'+rsp.liststatus[i].created_at+'">'+
                                    '<h3>'+rsp.liststatus[i].nama_status+'</h3>'+
                                    '<p>'+rsp.liststatus[i].desc_status+'</p>'+
                               '</li>';
                    }                 
                    $('#timeline').html(tl);  
                }
            });
        }

    </script>
@endsection
