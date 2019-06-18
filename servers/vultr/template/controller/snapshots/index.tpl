{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrSnapshotsContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-2">
					{assign "find" array('%use%', '%available%')}
					{assign "repl" array($use,$available)}
					<h4>{$_LANG['snapshots']['index']['panel_title']|replace:$find:$repl}</h4>
				</div>
				<div class="col-sm-offset-2 col-sm-2">
					{if $use<$available}
						<a class="btn btn-success" type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Snapshots&cloudAction=add">{$_LANG['snapshots']['index']['create_new']}</a>
					{/if}
				</div>
			</div>
		</div>
		<table class="table table-striped table-bordered">
			<tr>
				<th>{$_LANG['snapshots']['index']['id']}</th>
				<th>{$_LANG['snapshots']['index']['description']}</th>
				<th>{$_LANG['snapshots']['index']['size']}</th>
				<th>{$_LANG['snapshots']['index']['status']}</th>
				<th>{$_LANG['snapshots']['index']['created']}</th>
				<th>{$_LANG['snapshots']['index']['actions']}</th>
			</tr>
			{foreach from=$snapshots item=script}
				<tr>
					<td>{$script['SNAPSHOTID']}</td>
					<td>{$script['description']}</td>
					<td>{$script['size']}</td>
					<td id="vultr_status">{$script['status']}</td>
					<td>{$script['date_created']}</td>
					<td>
						{if $script['status']=='pending'}
						{$_LANG.snapshots.index.pending}
						{else}
						<a onclick="return confirm('{$_LANG.snapshots.index.confirmrestore}')" class="btn btn-info"
						   type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Snapshots&cloudAction=restore&vultrID={$script['SNAPSHOTID']}">{$_LANG.snapshots.index.restore}</a>
						<a onclick="return confirm('{$_LANG.snapshots.index.confirm}')" class="btn btn-danger"
						   type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Snapshots&cloudAction=delete&vultrID={$script['SNAPSHOTID']}">{$_LANG.snapshots.index.delete}</a>
					</td>
					{/if}
				</tr>
				{foreachelse}
				<tr>
					<td colspan="6">
						{$_LANG.snapshots.index.not_found}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
</div>