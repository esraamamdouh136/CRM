	jQuery(document).ready(function ($) {
	
			
		

					$('.data-table').DataTable({
							"paging": true,
							"pagingType": "full_numbers",
							"info": true,
							"responsive": true,
							"aoColumnDefs": [{
								"bSortable": false,
								"aTargets": ["no-sort"],

							}],
							"bInfo": true
						});

						$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
							$('.data-table:visible').each(function (e) {
								//   alert('visible ' + $(this).attr('id'));
								$(this).DataTable().columns.adjust().responsive.recalc();
							});
						});
								$('table.table input[type=checkbox]').click(function () {
    $(this).closest('tr').toggleClass("highlight", this.checked);
});	


		});




