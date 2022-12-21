<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body>
    <div class="wrapper">

        <section class="invoice">

            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fas fa-globe"></i> AdminLTE, Inc.

                    </h2>
                </div>

            </div>

            <br>
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <address>
                        <strong>Admin, Inc.</strong><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br>
                        Phone: (804) 123-5432<br>
                    </address>
                </div>

                <div class="col-sm-4 invoice-col">
                    <address>
                        <b>Cycle : {{ $dt_mst->cycle }}</b><br>
                        <img src="https://chart.googleapis.com/chart?cht=qr&chl={{ $dt_ttd[0]->no_ttd }}&chs=80x80&chld=L|1" alt=""><br>
                        <b>{{ $dt_ttd[0]->no_ttd }}</b><br>
                    </address>
                </div>

                <div class="col-sm-4 invoice-col">

                </div>

            </div>


            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Qty AWB</th>
                                <th>Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dt_ttd as $item)
                                <tr>
                                    <td>{{ $item->jml_awb }}</td>
                                    <td>Produk</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row">

                <div class="col-6">
                    <b>Keterangan:</b>
                    <p class="text well well-sm shadow-none" style="margin-top: 10px;">
                        {{ $dt_ttd[0]->desc }}
                    </p>
                </div>

                <div class="col-6">

                </div>

            </div>

        </section>

    </div>
</body>

</html>
