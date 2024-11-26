</div>

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="row">
                        <a class="btn btn-secondary" href="<?=base_url('vendor/calibrate')?>" role="button">Calibrate Pin</a>
                    </div> -->
                    <div class="row">
                        <div class="col text-center">
                            <div class="easypie" data-percent="100" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?=($tdel) ?></span></div>
                            <h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Total Delegates</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <h6>Print Delegate tags</h6>
            <div class="container">
                <form action="<?=base_url('printtag')?>" method="post">
                    <div class="mb-3 row">
                        <label for="range" class="col-sm-1-12 col-form-label">Range</label>
                        <div class="col-sm-1-12">
                            <input type="text" class="form-control" name="range" id="range" placeholder="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Print</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

</div>
<!-- END: Page content-->

<!-- BEGIN: Page backdrops-->
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div><!-- END: Page backdrops-->
