</div>

<!-- BEGIN: Page content-->
<div>
	<h2 class="text-center">
		General Registration Statistics
	</h2>
	<div class="row">
		<div class="col-lg-4  col-sm-12">
			<div class="card">
				<div class="card-body">
					<h5 class="box-title text-center">Total Delegates</h5>
					<div class="row">
						<div class="col text-center">
							<div class="easypie" data-percent="<?=(($total_del/1000)*100)?>" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?= ($total_del)?></span></div>
							<h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Overall</h6>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="card">
				<div class="card-body">
					<h5 class="box-title text-center">Total By Gender</h5>
					<div class="row">
						<div class="col text-center">
							<div class="easypie" data-percent="<?=(($male/400)*100)?>" data-bar-color="#00bcd4" data-size="110" data-line-width="8"><span class="easypie-data text-info" style="font-size:32px;"><?=($male)?></span></div>
							<h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Male</h6>
						</div>
						<div class="col text-center">
							<div class="easypie" data-percent="<?=(($male/600)*100)?>" data-bar-color="#2949ef" data-size="110" data-line-width="8"><span class="easypie-data text-primary" style="font-size:32px;"><?=($female)?></span></div>
							<h6 class="mb-0 mt-3 font-15 text-muted font-weight-normal">Female
							</h6>
						</div>
					</div>
				</div>
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
