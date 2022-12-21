<div class="modal fade" id="createttdkurir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">form create ttd kurir</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formttdkurir" method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Current Status:</label>
                        <label class="col-form-label" ><strong id="current_sts"></strong></label>
                    </div>
                    <div class="mb-3">
                        <label for="" class="col-form-label">Desc:</label>
                        <textarea name="desc" id="desc" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input id="ttd-form-submit" type="submit" class="btn btn-primary" value="create">
                </div>
            </form>
        </div>
    </div>
</div>
