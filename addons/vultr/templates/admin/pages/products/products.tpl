<div class="alert alert-info">{$MGLANG->T('productInfo')}</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div id="productTable">
			<table class="table table-stripe">
				<thead>
					<tr>
						<th>{$MGLANG->T('name')}</th>
						<th>{$MGLANG->T('group')}</th>
						<th>{$MGLANG->T('plan')}</th>
						<th>{$MGLANG->T('paytype')}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade bs-example-modal-lg" id="MGRemoveItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">{$MGLANG->T('modal','removeProduct')}</h4>
			</div>
			<div class="modal-body">
				<input type='hidden' name='ModalProductId'/>
				<h4 class="text-center">{$MGLANG->T('modal','removeInfo')}</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" id="removeProductButton"
						data-dismiss="modal">{$MGLANG->T('modal','remove')}</button>
				<button type="button" class="btn btn-default"
						data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
			</div>
		</div>
	</div>
</div>


<script src='../modules/addons/vultr/templates/admin/assets/js/tableProducts.js' type='text/javascript'></script>