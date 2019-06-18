{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrBackupsContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<h4>{$_LANG.backups.index.panel_title}</h4>
				</div>
			</div>
		</div>
		<table class="table table-striped table-bordered">
			<tr>
				<th>{$_LANG.backups.index.name}</th>
				<th>{$_LANG.backups.index.status}</th>
				<th>{$_LANG.backups.index.size}</th>
				<th>{$_LANG.backups.index.desc}</th>
				<th>{$_LANG.backups.index.actions}</th>
			</tr>
			{foreach from=$backups item=backup}
				<tr>
					<td>{$backup['BACKUPID']}<br>{$backup['date_created']}</td>
					<td>{$backup['status']}</td>
					<td>{$backup['size']}</td>
					<td>{$backup['description']}</td>
					<td>
						<a onclick="return confirm('{$_LANG.backups.index.confirm}')" class="btn btn-danger"
						   type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Backups&cloudAction=restore&vultrID={$backup['BACKUPID']}">{$_LANG.backups.index.restore}</a>
					</td>
				</tr>
				{foreachelse}
				<tr>
					<td colspan="5">
						{$_LANG.backups.index.not_found}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
</div>