
        <h5>Input your Email</h5>
        <div class="container">
            <form method="POST" action="<?=base_url('proceedpayonline')?>" style="display: flex; flex-direction: column; align-items: center; width: 100%;">
                <div class="mb-3 row" style="align-items: center;">
                    <label for="inputName" class="col-sm-1-12 col-form-label">Email:</label>
                    <div class="col-sm-1-12">
                        <input type="email" class="form-control" name="email" id="email" placeholder="">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Pay ₦5000 + ₦100 (Charges)</button>
                    </div>
                </div>
            </form>
        </div>
