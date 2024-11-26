</div>
<div>
	<link href="<?= base_url('assets/admin/vendors/sweetalert2/dist/sweetalert2.min.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/summernote/dist/summernote-bs4.css') ?>" rel="stylesheet" />

     <div class="container">
                <form method="get" action="manual1">
                    <div class="mb-3 row">
                        <label for="inputName" class="col-sm-1-12 col-form-label">Zone</label>
                        <div class="col-sm-1-12">
                            <select name="zone" id="zone" required="" class="form-control">
                                <option  >Select a Zone</option>
                                <option value="Ijebu">Ijebu</option>
                                <option value="Egba">Egba</option>
                                <option value="Remo">Remo</option>
                                <option value="Adoodo">Adoodo</option>
                            </select>
                        </div>&nbsp; &nbsp; &nbsp; &nbsp; 
						<label for="inputName" class="col-sm-1-12 col-form-label">Gender</label>
                        <div class="col-sm-1-12">
                            <select name="gender" id="gender" required="" class="form-control">
                                <option  >Select a Gender</option>
                                <option value="male">male</option>
                                <option value="female">female</option>
                            </select>
                        </div>
						&nbsp; &nbsp; &nbsp; &nbsp; 
						<label for="inputName" class="col-sm-1-12 col-form-label">Category</label>
                        <div class="col-sm-1-12">
                            <select name="category" id="category" required="" class="form-control">
                                <option  >Select a Category</option>
                                <option value="primary">Primary</option>
                                <option value="jsec">Junior Secondary</option>
                                <option value="ssec">Senior Secondary</option>
                                <option value="sch_leaver">School Leaver</option>
                                <option value="hi">Higher Institution</option>
                                <option value="Workers">Workers</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">Proceed</button>
                        </div>
                    </div>
                </form>
            </div>


</div><!-- END: Page content-->
<script src="<?= base_url('assets/admin/vendors/DataTables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendors/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/admin/vendors/summernote/dist/summernote-bs4.min.js') ?>"></script>

<script>
	$('.alert_6').click(function() {
		var name = $(this).data("prodname");
		var id = $(this).data("prodid");
		swal({
			title: 'Are you sure?',
			text: 'You want to delete' + name + 'NB: All images attached to this product MUST first be deleted!',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			showLoaderOnConfirm: true,
			preConfirm: () => {
				return fetch('<?= base_url() ?>admin/del_product?id=' + id)
					.then(response => {
						if (!response.ok) {
							throw new Error(response.statusText)
						}
						console.log(response)
						return response.json()
					})
					.catch(error => {
						swal.showValidationError(
							`
							Request failed: $ {
								error
							}
							`
						)
					})
			},
			allowOutsideClick: () => !swal.isLoading()
		}).then((result) => {
			if (result.value) {
				swal(
					'Deleted!',
					'Your file has been deleted.',
					'success'
				)
			}
			document.location.reload();
		})
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
