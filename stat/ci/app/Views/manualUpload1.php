</div>
<div>
	<link href="<?= base_url('assets/admin/vendors/sweetalert2/dist/sweetalert2.min.css') ?>" rel="stylesheet" />
	<link href="<?= base_url('assets/admin/vendors/summernote/dist/summernote-bs4.css') ?>" rel="stylesheet" />

	<a href="<?=base_url('manual')?>">Go Back Home</a>
     <div class="container">
                <form method="post" action="manual2">
                    <input type="hidden" name="lb" value="<?=$zone?>">
                    <input type="hidden" name="gender" value="<?=$gender?>">
                    <input type="hidden" name="category" value="<?=$category?>">
                    <p><?=$zone.' '.$gender.' '.$category?></p>
                    <div class="mb-3 row">
                        <div class="mb-3">
                          <label for="tag" class="form-label">Tag</label>
                          <input type="tel" class="form-control" name="tag" id="tag" aria-describedby="" placeholder="Tag no">
                        </div>
                        <div class="mb-3">
                          <label for="fname" class="form-label">First Name</label>
                          <input type="text" class="form-control" name="fname" id="fname" aria-describedby="" placeholder="">
                        </div>
                        <div class="mb-3">
                          <label for="lname" class="form-label">Last Name</label>
                          <input type="text" class="form-control" name="lname" id="lname" aria-describedby="" placeholder="">
                        </div>
                        <div class="mb-3">
                          <label for="school" class="form-label">School/Course/Profession</label>
                          <input type="text" class="form-control" name="school" id="school" aria-describedby="" placeholder="">
                        </div>
                        <div class="mb-3">
                          <label for="phone" class="form-label">Phone Number</label>
                          <input type="tel" class="form-control" name="phone" id="phone" aria-describedby="" placeholder="">
                        </div>
                        &nbsp; &nbsp; &nbsp; &nbsp;
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
