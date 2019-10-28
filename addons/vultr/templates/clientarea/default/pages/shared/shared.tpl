<div class="box light">
	<div class="row">
		<div class="col-lg-12" id="mg-categories-content">
			<table class="table dataTable no-footer" id="mg-data-list">
				<thead>
					<tr>
						<th>{$MGLANG->T('Name')}</th>
						<th>{$MGLANG->T('Username')}</th>
						<th>{$MGLANG->T('Password')}</th>
						<th>{$MGLANG->T('Shared By')}</th>
						<th>{$MGLANG->T('Category')}</th>
						<th style="width: 150px; text-align: center;">{$MGLANG->T('Actions')}</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			{if $isAdminPermission}
				<div class="well well-sm" style="margin-top:10px;">
					<button class="btn btn-success btn-inverse icon-left" type="button" data-toggle="modal"
							data-target="#mg-modal-add-new">
						<i class="glyphicon glyphicon-plus"></i>
						{$MGLANG->T('Add New')}
					</button>
				</div>
			{/if}
			<form data-toggle="validator" role="form" id="mg-form-add-new">
				<div class="modal fade bs-example-modal-lg" id="mg-modal-add-new" tabindex="-1" role="dialog"
					 aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
								<h4 class="modal-title">{$MGLANG->T('Add New Shared Password')} <strong></strong></h4>
							</div>
							<div class="modal-loader" style="display:none;"></div>

							<div class="modal-body">
								<input type="hidden" name="id" data-target="id" value="">
								<div class="modal-alerts">
									<div style="display:none;" data-prototype="error">
										<div class="note note-danger">
											<button type="button" class="close" data-dismiss="alert"><span
														aria-hidden="true">&times;</span><span class="sr-only"></span>
											</button>
											<strong></strong>
											<a style="display:none;" class="errorID" href=""></a>
										</div>
									</div>
									<div style="display:none;" data-prototype="success">
										<div class="note note-success">
											<button type="button" class="close" data-dismiss="alert"><span
														aria-hidden="true">&times;</span><span class="sr-only"></span>
											</button>
											<strong></strong>
										</div>
									</div>
								</div>
								{$formAdd}
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" data-modal-action="save"
										id="pm-modal-addip-button-add">{$MGLANG->T('modal','Add')}</button>
								<button type="button" class="btn btn-default"
										data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<form data-toggle="validator" role="form" id="mg-form-entity-edit">
				<div class="modal fade bs-example-modal-lg" id="mg-modal-edit-entity" data-modal-load="detail"
					 tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
											class="sr-only">Close</span></button>
								<h4 class="modal-title">{$MGLANG->T('Edit Shared Password')} <strong
											data-modal-var="username"></strong></h4>
							</div>
							<div class="modal-loader" style="display:none;"></div>

							<div class="modal-body">
								<input type="hidden" name="id" data-target="id" value="">
								<div class="modal-alerts">
									<div style="display:none;" data-prototype="error">
										<div class="note note-danger">
											<button type="button" class="close" data-dismiss="alert"><span
														aria-hidden="true">&times;</span><span class="sr-only"></span>
											</button>
											<strong></strong>
											<a style="display:none;" class="errorID" href=""></a>
										</div>
									</div>
									<div style="display:none;" data-prototype="success">
										<div class="note note-success">
											<button type="button" class="close" data-dismiss="alert"><span
														aria-hidden="true">&times;</span><span class="sr-only"></span>
											</button>
											<strong></strong>
										</div>
									</div>
								</div>
								{$formEdit}
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary" data-modal-action="save"
										id="pm-modal-addip-button-add">{$MGLANG->T('Save')}</button>
								<button type="button" class="btn btn-default"
										data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="modal fade bs-example-modal-lg" id="mg-modal-delete-entity" tabindex="-1" role="dialog"
				 aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span
										aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">{$MGLANG->T('modal','Delete Shared Password')} <strong
										data-modal-title=""></strong></h4>
						</div>
						<div class="modal-loader" style="display:none;"></div>

						<div class="modal-body">
							<input type="hidden" name="id" data-target="id" value="">
							<div class="modal-alerts">
								<div style="display:none;" data-prototype="error">
									<div class="note note-danger">
										<button type="button" class="close" data-dismiss="alert"><span
													aria-hidden="true">&times;</span><span class="sr-only"></span>
										</button>
										<strong></strong>
										<a style="display:none;" class="errorID" href=""></a>
									</div>
								</div>
								<div style="display:none;" data-prototype="success">
									<div class="note note-success">
										<button type="button" class="close" data-dismiss="alert"><span
													aria-hidden="true">&times;</span><span class="sr-only"></span>
										</button>
										<strong></strong>
									</div>
								</div>
							</div>
							<div style="margin: 30px; text-align: center;">

								<div>{$MGLANG->T('Are you sure you want to delete this entry from own passwords list?')} </div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-modal-action="delete"
									id="pm-modal-addip-button-add">{$MGLANG->T('modal','delete')}</button>
							<button type="button" class="btn btn-default"
									data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade bs-example-modal-lg" id="mg-modal-details" data-modal-load="note" tabindex="-1"
				 role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal"><span
										aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<h4 class="modal-title">{$MGLANG->T('Details')} <strong data-modal-var="name"></strong></h4>
						</div>
						<div class="modal-loader" style="display:none;"></div>
						<div class="modal-body">
							<input type="hidden" name="id" data-target="id" value="">
							<div class="modal-alerts">
								<div style="display:none;" data-prototype="error">
									<div class="note note-danger">
										<button type="button" class="close" data-dismiss="alert"><span
													aria-hidden="true">&times;</span><span class="sr-only"></span>
										</button>
										<strong></strong>
										<a style="display:none;" class="errorID" href=""></a>
									</div>
								</div>
								<div style="display:none;" data-prototype="success">
									<div class="note note-success">
										<button type="button" class="close" data-dismiss="alert"><span
													aria-hidden="true">&times;</span><span class="sr-only"></span>
										</button>
										<strong></strong>
									</div>
								</div>
							</div>
							<table class="table">
								<tbody>
									<tr>
										<td>{$MGLANG->T('Name')}</td>
										<td data-modal-var="name"></td>
									</tr>
									<tr>
										<td>{$MGLANG->T('Username')}</td>
										<td data-modal-var="username"></td>
									</tr>
									<tr>
										<td>{$MGLANG->T('Password')}</td>
										<td data-modal-var="password"></td>
									</tr>
									<tr>
										<td>{$MGLANG->T('Website URL')}</td>
										<td data-modal-var="websiteUrl"></td>
									</tr>
									<tr>
										<td>{$MGLANG->T('Login URL')}</td>
										<td data-modal-var="loginUrl"></td>
									</tr>
									<tr>
										<td>{$MGLANG->T('Shared By')}</td>
										<td data-modal-var="shared"></td>
									</tr>
									<tr>
										<td>{$MGLANG->T('Note')}</td>
										<td data-modal-var="note"></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default"
									data-dismiss="modal">{$MGLANG->T('close')}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{literal}
	<style>
		.mg-permission-disabled {
			display: inline-block;
			margin-top: 3px;
			width: 65px;
			padding: 4px;
			text-transform: none;
			opacity: 0.25;
		}
	</style>
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
					var filter = {
						//    serverID: $('#pm-filters-server').val(),
					};
					JSONParser.request(
						'list'
						, {
							filter: filter
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

			$('#mg-categories-content').MGModalActions();
			$('#mg-modal-delete-entity, #mg-form-add-new').on('hidden.bs.modal', function ()
			{
				var api = mgDataTable.api();
				api.ajax.reload(function ()
				{
				}, false);
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