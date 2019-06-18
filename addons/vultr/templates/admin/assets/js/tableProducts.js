/* 
 * DataTable MGFramework
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
jQuery(document).ready(function ()
{

	jQuery('#productTable table').dataTable({
			processing: true,
			serverSide: true,
			searching: false,
			autoWidth: false,
			ajax: function (data, callback, settings)
			{
				var filter = {};
				JSONParser.request(
					'getProductList'
					, {
						filter: filter

						, order: data.order[0]
						, limit: data.length
						, offset: data.start
					}
					, function (data)
					{
						callback(data);
						jQuery('[data-toggle="tooltip"]').tooltip();
					}
				);
			},
			columns: [
				null
				, null
				, null
				, null
				, {orderable: false, targets: 0}
			],
			pagingType: "simple_numbers",
			aLengthMenu: [
				[10, 25, 50, 75, 100],
				[10, 25, 50, 75, 100]
			],
			iDisplayLength: 10,
			sDom: 't<"table-bottom"<"row"<"col-sm-6"p><"col-sm-6"L>>>',
			"zeroRecords": "{/literal}{$MGLANG->absoluteT('addonAA','datatables','zeroRecords')}{literal}",
			"infoEmpty": "{/literal}{$MGLANG->absoluteT('addonAA','datatables','zeroRecords')}{literal}",
			"paginate": {
				"previous": "{/literal}{$MGLANG->absoluteT('addonAA','datatables','previous')}{literal}"
				, "next": "{/literal}{$MGLANG->absoluteT('addonAA','datatables','next')}{literal}"
			}
		}
	);
	jQuery('#productTable').MGModalActions();


	jQuery(document).on('click', '.removeProduct', function ()
	{

		var productId = jQuery(this).closest('td').find('input[name="productId"]').val();
		jQuery('input[name="ModalProductId"').val(productId);
		$("#MGRemoveItem").modal();
	});

	jQuery(document).on('click', '#removeProductButton', function ()
	{
		var productId = jQuery('input[name="ModalProductId"').val();
		JSONParser.request('removeProduct', {productId: productId}, function (data)
		{
			if (data.success)
			{
				jQuery('#productTable table').DataTable().ajax.reload();
			}
		}, false);

	});


});

