<div class="modal fade" id="updatestat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">form update status</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formupdtsts" method="POST">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="col-form-label">Status:</label>
                        <select name="id_status" id="id_status" class="form-control">
                            @foreach ($liststs as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_status }}</option>
                            @endforeach
                        </select>

                        <label class="col-form-label">Current Status:</label>
                        <label class="col-form-label" id="current_sts"></label>
                    </div>


                </div>
                <div class="modal-footer">
                    <input id="upd-form-submit" type="submit" class="btn btn-primary" value="Save">
                </div>
            </form>
        </div>
    </div>
</div>
