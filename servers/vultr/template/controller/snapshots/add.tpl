{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrSNAPSHOTContainer">
	<div class="panel panel-default">
		<div class="panel-heading ">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h4>{$_LANG.snapshots.add.panel_title}</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<p></p>
			<form action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Snapshots&cloudAction=add"
				  method="POST">
				<div class="form-group col-sm-10 col-sm-offset-1">
					<label for="vultrSNAPSHOTdesc">{$_LANG.snapshots.add.description}</label>
					<input type="text" class="form-control" id="vultrSNAPSHOTdesc" name="vultrSNAPSHOTdesc">
				</div>
				<div class="form-group col-sm-10 col-sm-offset-1">
					<button type="submit" name="vultrAddAction"
							class="btn btn-default">{$_LANG.snapshots.add.create}</button>
				</div>
			</form>
		</div>
	</div>
</div>