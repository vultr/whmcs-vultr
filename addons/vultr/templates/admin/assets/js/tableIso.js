/* 
 * DataTable MGFramework
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
jQuery(document).ready(function ()
{

	jQuery('#iso table').dataTable({
			processing: true,
			serverSide: false,
			searching: false,
			autoWidth: false,
			columns: [
				, null
				, null
				, null
				, null
				, {orderable: false}
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
	jQuery('#iso table').MGModalActions();

	jQuery(function ()
	{
		jQuery(".onoffswitch").on('change', function ()
		{
			var id = jQuery(this).find('input').attr('id');
			JSONParser.request('changeIsoSettings', {isoId: id});
		});

	});

});

