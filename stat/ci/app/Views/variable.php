<div class="subheader_daterange"><span class="subheader-daterange-label" data-toggle="modal" data-target="#form" id=""><i class="ti-plus"></i> Add Variable</span><button class="btn btn-floating btn-sm rounded-0" data-toggle="modal" data-target="#form" type="button"><i class="ti-plus"></i></button></div>
</div>
<div>
	<!--BEGIN:: Form Modal -->

	<div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header border-bottom-0">
					<h5 class="modal-title" id="exampleModalLabel">Add Variable</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<?= form_open_multipart(base_url('admin/new_var'), array()) ?>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Variable Name</label>
						<input type="text" class="form-control" name="cat_name">
					</div>
					<div class="form-group">
						<label for="Variable">Variable Details</label>
						<textarea class="form-control" name="cat_details" placeholder="Details"></textarea>
					</div>

				</div>
				<div class="modal-footer border-top-0 d-flex justify-content-center">
					<button type="submit" class="btn btn-success">Submit</button>
				</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Form Modal Ended -->


	<div class="card">
		<div class="card-body">
			<h5 class="box-title">All Variable {info}</h5>
			<div class="flexbox mb-4">
				<div class="flexbox"><label class="mb-0 mr-2">Type:</label><select class="selectpicker form-control show-tick" id="type-filter" title="Please select" data-width="150px">
						<option value="">All</option>
					</select></div>
				<div class="input-group-icon input-group-icon-right mr-3"><span class="input-icon input-icon-right font-16"><i class="ti-search"></i></span><input class="form-control form-control-rounded" id="key-search" type="text" placeholder="Search ..."></div>
			</div>
			<div class="table-responsive">
				<table class="table table-bordered w-100" id="dt-filter">
					<thead class="thead-light">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th class="no-sort">Value</th>
							<th>Active</th>
							<th class="no-sort"></th>
						</tr>
					</thead>
					<tbody>
						{variables}
						<tr>
							<td>{id}</td>
							<td><a href="javascript:;">{name}</a></td>
							<td>{value}</td>
							<td>{active}</td>
							<td>
								<!-- <a class="text-muted font-16 alert_6" id="alert_6" data-varname="{name}" data-varid="{id}" href="javascript:;"><i class="ti-trash"></i></a> -->
								<a class="update text-muted font-16" data-var="{id}" href="javascript:;"><i class="ti-pencil"></i></a>
							</td>
						</tr>
						{/variables}
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<!--BEGIN:: Update Modal -->

	<div class="modal fade" id="updated" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header border-bottom-0">
					<h5 class="modal-title" id="exampleModalLabel">Edit Variable</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<?= form_open(base_url('admin/edt_var'), array()) ?>

				<span id="var_id"></span>
				<div class="form-group mb-4"><label>Name</label>
					<span id="name"></span>
				</div>

				<div class="form-group mb-4"><label>Value</label>
					<span id="value"></span>
				</div>
				<div class="form-group"><button class="btn btn-primary mr-2" type="submit">Submit</button><button class="btn btn-light" type="reset">Clear</button></div>
				</form>
			</div>
		</div>
	</div>

	<!-- Update Modal Ended -->
</div><!-- END: Page content-->
<script src="<?= base_url('assets/admin/vendors/DataTables/datatables.min.js') ?>"></script>
<!-- <script src="<?= base_url('assets/admin/vendors/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script> -->
<script>
	$(document).ready(function() {

		$('.update').click(function(e) {
			e.preventDefault();
			var varid = Number($(this).data("var")); //get the attribute value

			$.ajax({
				url: "http://josiefones.com/store/get_variable_data",
				data: {
					id: varid
				},
				method: 'GET',
				dataType: 'json',
				success: function(response) {
					$('#name').html(`<input class="form-control" type="text" name="name" value="${response.name}">`); //hold the response in id and show on popup
					$('#var_id').html(`<input type="hidden" name="var_id" value="${varid}">`);
					$('#value').html(`<textarea class="form-control" name="value">${response.value}</textarea>`);
					$('#updated').modal({
						backdrop: 'static',
						keyboard: true,
						show: true
					});
				}
			});
		});
	});

	$(function() {
		// Ajax sourced data
		$('#dt-ajax-data').DataTable({
			ajax: 'assets/demo/data/datatable-data.json',
			responsive: true,
		});
		// Filter & custom search field
		$(function() {
			var table = $('#dt-filter').DataTable({
				responsive: true,
				"sDom": 'Brtip',
				buttons: [
					'copy', 'excel', 'pdf', 'csv', 'print'
				],
				columnDefs: [{
					targets: 'no-sort',
					orderable: false
				}]
			});
			$('#key-search').on('keyup', function() {
				table.search(this.value).draw();
			});
			$('#type-filter').on('change', function() {
				table.column(3).search($(this).val()).draw();
			});
		});
	});
</script>
