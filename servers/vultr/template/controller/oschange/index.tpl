{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
{if isset($apps)}
	<div class="row" id="vultrMAINContainer">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<h4>{$_LANG.oschange.index.panel_title_app} - {$info.label}</h4>
					</div>
				</div>
			</div>
			<form class="form-horizontal" role="form"
				  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=OSChange&cloudAction=index"
				  method="POST">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<label for="vultrOSID">{$_LANG.oschange.index.label_app}</label>
						<select class="form-control" id="vultrAPPID" name="vultrAPPID">
							{foreach from=$apps key=k item=v}
								<option value="{$v['APPID']}"
										{if isset($postData['vultrAPPID']) && $postData['vultrAPPID']==$v['APPID']}selected{/if}>{$v['deploy_name']}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<!--Submit-->
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<a style="margin-bottom: 20px;" class="btn btn-default"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}">{$_LANG.oschange.index.back}</a>
						<button type="submit" name="cloudCreateAction" class="btn btn-primary"
								onclick="if (confirm('{$_LANG.oschange.index.confirm_app}')){ return true; } else { return false; }">{$_LANG.oschange.index.change}</button>
					</div>
				</div>
				<!--Submit END-->
			</form>
		</div>
	</div>
{else}
	<div class="row" id="vultrMAINContainer">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<h4>{$_LANG.oschange.index.panel_title} - {$info.label}</h4>
					</div>
				</div>
			</div>
			<form class="form-horizontal" role="form"
				  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=OSChange&cloudAction=index"
				  method="POST">
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						<label for="vultrOSID">{$_LANG.oschange.index.label}</label>
						<select class="form-control" id="vultrOSID" name="vultrOSID">
							{foreach from=$oses key=k item=v}
								<option value="{$v['OSID']}"
										{if isset($postData['vultrOSID']) && $postData['vultrOSID']==$v['OSID']}selected{/if}>{$v['name']}</option>
							{/foreach}
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-3">
						{$_LANG.oschange.index.current} <strong>{$info.os}</strong>
					</div>
				</div>
				<!--Submit-->
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<a style="margin-bottom: 20px;" class="btn btn-default"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}">{$_LANG.oschange.index.back}</a>
						<button type="submit" name="cloudCreateAction" class="btn btn-primary"
								onclick="if (confirm('{$_LANG.oschange.index.confirm_os}')){ return true; } else { return false; }">{$_LANG.oschange.index.change}</button>
					</div>
				</div>
				<!--Submit END-->
			</form>
		</div>
	</div>
{/if}



