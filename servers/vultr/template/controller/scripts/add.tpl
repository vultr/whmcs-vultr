{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrSCRIPTContainer">
	<div class="panel panel-default">
		<div class="panel-heading ">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h4>{$_LANG.scripts.add.panel_title}</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<p></p>
			<form action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Scripts&cloudAction=add"
				  method="POST">
				<div class="form-group col-sm-10 col-sm-offset-1">
					<label for="vultrSCRIPTname">{$_LANG.scripts.add.name}</label>
					<input type="text" class="form-control" id="vultrSCRIPTname"
						   value="{if isset($postData['vultrSCRIPTname'])}{$postData['vultrSCRIPTname']}{/if}"
						   name="vultrSCRIPTname" placeholder="Script name">
				</div>
				<div class="form-group col-sm-10 col-sm-offset-1">
					<label for="vultrSCRIPTtype">{$_LANG.scripts.add.type}</label>
					<select class="form-control" name="vultrSCRIPTtype" id="vultrSCRIPTtype">
						<option value="boot"
								{if isset($postData['vultrSCRIPTtype']) && $postData['vultrSCRIPTtype']=='boot'}selected{/if}>
							Boot
						</option>
						<option value="pxe"
								{if isset($postData['vultrSCRIPTtype']) && $postData['vultrSCRIPTtype']=='pxe'}selected{/if}>
							PXE
						</option>
					</select>
				</div>
				<div class="form-group col-sm-10 col-sm-offset-1">
					<label for="vultrSCRIPT">{$_LANG.scripts.add.script}</label>
					<textarea name="vultrSCRIPT" class="form-control" rows="5"
							  id="vultrSCRIPT">{if isset($postData['vultrSCRIPT'])}{$postData['vultrSCRIPT']}{/if}</textarea>
				</div>
				<div class="form-group col-sm-10 col-sm-offset-1">
					<button type="submit" name="vultrAddAction"
							class="btn btn-default">{$_LANG.scripts.add.create}</button>
				</div>
			</form>
		</div>
	</div>
</div>