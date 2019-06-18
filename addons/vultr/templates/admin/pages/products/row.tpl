<tr>
	<td>{$name}</td>
	<td>{$groupName}</td>
	<td>{$configoption2}</td>
	<td>{$paytype}</td>
	<td>
		<input type="hidden" value="{$id}" name="productId"/>
		<a data-toggle="tooltip" title="{$MGLANG->T('editProduct')}" class="btn btn-info"
		   href="configproducts.php?action=edit&id={$id}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
		<a data-toggle="tooltip" title="{$MGLANG->T('configurableOptions')}" class="btn btn-info"
		   href="configproductoptions.php?action=managegroup&id={$configurableID}"
		   {if empty($configurableID)}disabled{/if}><i class="fa fa-sliders" aria-hidden="true"></i></a>
		<a data-toggle="tooltip" title="{$MGLANG->T('deleteProduct')}" class="btn btn-danger removeProduct"><i
					class="fa fa-ban" aria-hidden="true"></i></a>
	</td>
</tr>