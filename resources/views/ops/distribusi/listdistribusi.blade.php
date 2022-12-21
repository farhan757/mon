@extends('layouts.master')

@section('titlebar', 'Distribusi')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            List Distribusi
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0" id="table_comp">
                                    <thead class="table-light fw-semibold">
                                        <th>id</th>
                                        <th>No TTD</th>
                                        <th>cycle</th>
                                        <th>status</th>
                                        <th>jml awb</th>
                                        <th>action</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->no_ttd }}</td>
                                                <td>{{ $item->cycle }}</td>
                                                <td>{{ $item->nama_status }}</td>
                                                <td>{{ $item->jml_awb }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-ghost-primary btn-sm"
                                                        onclick="showDetail({{ $item->id }})">Detail</button>
                                                    @if ($item->id_status_last == 4)
                                                        <button type="button" class="btn btn-ghost-success btn-sm"
                                                            onclick="showFormupdt({{ $item->id }})">Create TTD Kurir</button>
                                                    @endif

                                                    @if ($item->id_status_last == 5)
                                                        <a href="{{ route('ops.distribusi.print',['id'=>$item->id]) }}" target="_blank" class="btn btn-ghost-secondary btn-sm"
                                                            >Print TTD</a>
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

    @include('include.formttdtokurir')
    @include('include.formdetailmaster')

@endsection

@section('js')
    <script>

        $('#table_comp').DataTable();
        $('#cycle').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })

        function showFormupdt(id){
            $.ajax({
                url: "{{ route('getCurrentsts') }}",
                type: "GET",
                data: {id:id},
                success: function(rsp){
                    $('#createttdkurir').modal('show');
                    $('#id').val(id);
                    $('#current_sts').text(rsp.nama_status);
                }
            });
        }

        $("#formttdkurir").on('submit', function(e) {
            e.preventDefault();
            var fd = new FormData($(this)[0]);
            console.log(fd);
            $.ajax({
                type: "POST",
                url: "{{ route('ops.distribusi.storeTtdKurir') }}",
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
