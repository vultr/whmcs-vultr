{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrSSHContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-3 col-sm-offset-5">
					<h4>{$_LANG.sshkeys.index.panel_title}</h4>
				</div>
				<div class="col-sm-offset-2 col-sm-2">
					<a class="btn btn-success" type="button"
					   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=SSHKeys&cloudAction=add">{$_LANG.sshkeys.index.add}</a>
				</div>
			</div>
		</div>
		<table class="table table-striped table-bordered">
			<tr>
				<th>{$_LANG.sshkeys.index.id}</th>
				<th>{$_LANG.sshkeys.index.name}</th>
				<th>{$_LANG.sshkeys.index.created}</th>
				<th>{$_LANG.sshkeys.index.actions}</th>
			</tr>
			{foreach from=$keys item=script}
				<tr>
					<td>{$script['SSHKEYID']}</td>
					<td>{$script['name']}</td>
					<td>{$script['date_created']}</td>
					<td><a onclick="return confirm('{$_LANG.sshkeys.index.confirm}')" class="btn btn-danger"
						   type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=SSHKeys&cloudAction=delete&vultrID={$script['SSHKEYID']}">{$_LANG.sshkeys.index.delete}</a>
					</td>
				</tr>
				{foreachelse}
				<tr>
					<td colspan="4">
						{$_LANG.sshkeys.index.not_found}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
</div>