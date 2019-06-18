{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrMAINContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<h4>{$_LANG.isochange.index.panel_title}</h4>
				</div>
			</div>
		</div>
		<form class="form-horizontal" role="form"
			  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=ISOChange&cloudAction=index"
			  method="POST">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<label for="vultrISOID">{$_LANG.isochange.index.label}</label>
					<select class="form-control" id="vultrISOID" name="vultrISOID">
						<option value=""></option>
						{foreach from=$isos key=k item=v}
							<option value="{$v["ISOID"]}"
									{if $v["ISOID"] == $mountedIsoId}selected{/if}>{$v['filename']}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					{if $mountedIsoName}{$_LANG.isochange.index.current} <strong>{$mountedIsoName}</strong>{/if}
				</div>
			</div>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<a style="margin-bottom: 20px;" class="btn btn-default"
					   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}">{$_LANG.oschange.index.back}</a>
					<button type="submit" name="cloudCreateAction" class="btn btn-primary"
							onclick="if (confirm('{$_LANG.oschange.index.confirm_os}')){ return true; } else { return false; }">{$_LANG.oschange.index.change}</button>
				</div>
			</div>
		</form>
	</div>
</div>