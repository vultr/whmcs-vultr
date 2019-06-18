{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrDNSContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-sm-3 col-sm-offset-5">
					<h4>{$_LANG.dns.index.panel_title}</h4>
				</div>
				<div class="col-sm-offset-2 col-sm-2">
					<a class="btn btn-success" type="button"
					   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns&cloudAction=create">{$_LANG.dns.index.add}</a>
				</div>
			</div>
		</div>
		<table class="table table-striped table-bordered">
			<tr>
				<th>{$_LANG.dns.index.domain}</th>
				<th>{$_LANG.dns.index.created}</th>
				<th>{$_LANG.dns.index.actions}</th>
			</tr>
			{foreach from=$domains item=domain}
				<tr>
					<td class="col-sm-4">{$domain['domain']}</td>
					<td class="col-sm-4">{$domain['date_created']}</td>
					<td class="col-sm-4">
						<a class="btn btn-info" type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns&cloudAction=manage&vultrID={$domain['domain']}">{$_LANG.dns.index.manage}</a>
						<a onclick="return confirm('{$_LANG.dns.index.confirm}')" class="btn btn-danger" type="button"
						   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns&cloudAction=delete&vultrID={$domain['domain']}">{$_LANG.dns.index.delete}</a>
					</td>
				</tr>
				{foreachelse}
				<tr>
					<td colspan="3">
						{$_LANG.dns.index.not_found}
					</td>
				</tr>
			{/foreach}
		</table>
	</div>
	<div class="pull-left" style="margin-left: 20px;">
		<p>
			<strong>{$_LANG.dns.index.dns_title}</strong>
		</p>
		<p>
			{$ns['ns1']}
		</p>
		<p>
			{$ns['ns2']}
		</p>
	</div>
</div>



