
        <h5>Input your pin to proceed</h5>
        <div class="container">
            <form method="GET" action="<?=base_url('pin')?>" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="mb-3 row" style="align-items: center;">
                    <label for="inputName" class="col-sm-1-12 col-form-label">Pin:</label>
                    <div class="col-sm-1-12">
                        <input type="text" class="form-control" style="width: 200px;" name="pin" id="pin" placeholder="e.g VYT62NBK" required value="<?=$pin?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Begin Registeration</button>
                    </div>
                </div>
            </form>
        </div>
