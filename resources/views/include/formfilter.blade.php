<div class="modal fade" id="formfilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">form filter</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET">
                @csrf                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">cycle1:</label>
                        <input type="text" class="form-control cycle" id="cycle1" name="cycle1" value="{{ $cycle1 ?? '' }}">                        

                        <label class="col-form-label">cycle2:</label>
                        <input type="text" class="form-control cycle" id="cycle2" name="cycle2" value="{{ $cycle2 ?? '' }}">
                    </div>


                </div>
                <div class="modal-footer">
                    <input id="upd-form-submit" type="submit" class="btn btn-primary" value="filter">
                </div>
            </form>
        </div>
    </div>
</div>
