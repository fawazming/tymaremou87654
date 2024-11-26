
        <h5>Input your pin</h5>
        <div class="container">
            <form method="GET" action="<?=base_url('pinstat')?>" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="mb-3 row" style="align-items: center;">
                    <label for="inputName" class="col-sm-1-12 col-form-label">Pin:</label>
                    <div class="col-sm-1-12">
                        <input type="text" class="form-control" name="pin" id="pin" placeholder="e.g iop0842">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Check Pin</button>
                    </div>
                </div>
            </form>
        </div>
