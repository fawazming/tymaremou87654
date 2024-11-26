        </div>
        <!-- BEGIN: Page content-->
        <div>
        	<div class="card">
        		<div class="card-body">
        			<h5 class="box-title text-primary">Upload Manually</h5>
        			<?= form_open_multipart(base_url('admin/new_dels'), array()) ?>

        			<div class="row">
        				<div class="col-md-12">
        					<div class="form-group mb-4"><label>Delegates *</label>
        						<input class="form-control" type="file" name="dels" required>
        						<small class="form-text text-muted"> </small>
        					</div>
        				</div>
        			</div>
        			<div class="form-group">
        				<input type="submit" value="Import" name="import" class="btn btn-primary mr-2">
        				<button class="btn btn-primary mr-2" name="import" type="submit">Import</button><button class="btn btn-light" type="reset">Clear</button></div>
        			</form>
        		</div>
        	</div>
        </div>
        <!-- END: Page content-->
