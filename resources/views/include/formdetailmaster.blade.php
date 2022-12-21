<!-- Scrollable modal -->

<div class="modal fade" id="detailmst" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Component</h6>
                            <div id="content">
                                <table class="table">
                                    <thead>
                                        <th>Nama Component</th>
                                        <th>Qty</th>
                                    </thead>
                                    <tbody id="tcomp">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Timeline</h6>
                            <div id="content">
                                <ul class="timeline" id="timeline">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input data-coreui-dismiss="modal" class="btn btn-primary" value="Close">
            </div>
        </div>
    </div>
</div>
