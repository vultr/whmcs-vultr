<div class="box light">
	<div class="row">
		<div class="col-lg-12" id="mg-categories-content">
			<table class="table table-hover" id="mg-data-list">
				<thead>
					<tr>
						<th>{$MGLANG->T('Product/Service')}</th>
						<th>{$MGLANG->T('Username')}</th>
						<th>{$MGLANG->T('Password')}</th>
						<th>{$MGLANG->T('Billing Cycle')}</th>
						<th>{$MGLANG->T('Next Due Date')}</th>
						<th>{$MGLANG->T('IP Address')}</th>
						<th>{$MGLANG->T('Status')}</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
{literal}
<script type="text/javascript">
	jQuery(document).ready(function ()
	{
		var mgDataTable;

		jQuery(document).ready(function ()
		{
			mgDataTable = $('#mg-data-list').dataTable({
				processing: false,
				searching: true,
				autoWidth: false,
				"serverSide": false,
				"order": [[0, "desc"]],
				ajax: function (data, callback, settings)
				{
					JSONParser.request(
						'list'
						, {
							filter: {}
							, limit: data.length
							, offset: data.start
							, order: data.order
							, search: data.search
						}
						, function (data)
						{
							callback(data);
						}
					);
				},
				'columns': [
					, null
					, null
					, null
					, null
					, null
					, {orderable: false}

				],
				'aoColumnDefs': [{
					'bSortable': false,
					'aTargets': ['nosort']
				}],
				language: {
					"zeroRecords": "{/literal}{$MGLANG->absoluteT('Nothing to display')}{literal}",
					"infoEmpty": "",
					"search": "{/literal}{$MGLANG->absoluteT('Search')}{literal}",
					"paginate": {
						"previous": "{/literal}{$MGLANG->absoluteT('Previous')}{literal}"
						, "next": "{/literal}{$MGLANG->absoluteT('Next')}{literal}"
					}
				}
			});

		});

		//show password
		$("#mg-categories-content").on("click", ".mg-show-password", function (e)
		{
			e.preventDefault();
			var inputPassword = $(this).closest("div").find(".form-control");
			JSONParser.request(
				'getPassword'
				, {id: $(this).attr('data-target')}
				, function (data)
				{
					inputPassword.val(data);
				});
		});
	});
</script>
{/literal}