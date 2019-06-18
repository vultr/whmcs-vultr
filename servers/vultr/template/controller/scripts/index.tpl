{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrSCRIPTContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<h4>{$_LANG.scripts.index.panel_title}</h4>
				</div>
				<div class="col-sm-offset-2 col-sm-2">
					<a class="btn btn-success" type="button"
					   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Scripts&cloudAction=add">{$_LANG.scripts.index.add}</a>
				</div>
			</div>
		</div>
		<table class="table">
			<tr>
				<th>{$_LANG.scripts.index.id}</th>
				<th>{$_LANG.scripts.index.name}</th>
				<th>{$_LANG.scripts.index.type}</th>
				<th>{$_LANG.scripts.index.created}</th>
				<th>{$_LANG.scripts.index.actions}</th>
			</tr>
			{foreach from=$scripts item=script}
				<tr>
					<td>{$script['SCRIPTID']}</td>
					<td>{$script['name']}</td>
					<td>{if isset($script['type'])}{$script['type']}{else}{$_LANG.scripts.index.undefined}{/if}</td>
					<td>{$script['date_created']}</td>
					<td>
						<button scriptID="{$script['SCRIPTID']}" type="button"
								class="btn btn-info showScript">{$_LANG.scripts.index.show}</button>
						<a onclick="return confirm('{$_LANG.scripts.index.confirm}')" class="btn btn-danger"
						   type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Scripts&cloudAction=delete&vultrID={$script['SCRIPTID']}">{$_LANG.scripts.index.delete}</a>
					</td>
				</tr>
				<tr class="hide" scriptID='{$script['SCRIPTID']}'>
					<td colspan="5">
						<div class="col-sm-12 text-left">
							<pre>{$script['script']}</pre>
						</div>
					</td>
				</tr>
				{foreachelse}
				<tr>
					<td colspan="5">
						{$_LANG.scripts.index.not_found}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('button.showScript').on('click', function ()
		{
			var scriptID = $(this).attr('scriptID');
			if ($('tr[scriptID="' + scriptID + '"]').hasClass('hide'))
			{
				$('tr[scriptID="' + scriptID + '"]').removeClass('hide');
				$(this).text("{$_LANG.scripts.index.hide}");
			}
			else
			{
				$('tr[scriptID="' + scriptID + '"]').addClass('hide');
				$(this).text("{$_LANG.scripts.index.show}");
			}
		});
	});
</script>