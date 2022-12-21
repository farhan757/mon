@extends('layouts.master')

@section('titlebar', 'Use Component')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                        <button data-coreui-toggle="modal" data-coreui-target="#formfilter" class="btn btn-success btn-sm"
                                type="button">filter</button>
                            &nbsp;                             
                            List Use Component
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border mb-0" id="table_comp">
                                    <thead class="table-light fw-semibold">
                                        <th>id</th>
                                        <th>nama component</th>
                                        <th>use</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->id_material }}</td>
                                                <td>{{ $item->nm_component }}</td>
                                                <td>{{ $item->tt_qty }}</td>
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

    @include('include.formfilter')

@endsection

@section('js')
    <script>
        $('.cycle').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        })        
    </script>
@endsection
