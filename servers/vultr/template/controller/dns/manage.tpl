{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrDNSContainer">
	<div class="panel panel-default col-sm-12">
		<form action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns&cloudAction=manage&vultrID={$domain}"
			  method="POST">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h4>{$_LANG.dns.manage.panel_title} - {$domain}</h4>
					</div>
				</div>
			</div>
			<table class="table table-striped table-bordered">
				<tr>
					<th>{$_LANG.dns.manage.record}</th>
					<th>{$_LANG.dns.manage.delete}</th>
					<th>{$_LANG.dns.manage.type}</th>
					<th>{$_LANG.dns.manage.name}</th>
					<th>{$_LANG.dns.manage.data}</th>
					<th style="width: 50px;">{$_LANG.dns.manage.ttl}</th>
					<th>{$_LANG.dns.manage.priority}</th>
				</tr>
				{foreach from=$records item=record}
					<tr>
						<td>{$record['RECORDID']}</td>
						<td><input type="checkbox" name="record[{$record['RECORDID']}][delete]"></td>
						<td>{$record['type']}</td>
						<td><input style="width: 190px;" name="record[{$record['RECORDID']}][name]"
								   value="{$record['name']|escape:html}"></td>
						<td><input style="width: 190px;" name="record[{$record['RECORDID']}][data]"
								   value="{$record['data']|escape:html}"></td>
						<td><input style="width: 50px;" name="record[{$record['RECORDID']}][ttl]"
								   value="{$record['ttl']}"></td>
						<td>{if $record['type']=='MX' || $record['type']=='SRV'}<input style="width: 50px;"
																					   name="record[{$record['RECORDID']}][priority]"
																					   value="{$record['priority']|escape:html}">{/if}
						</td>
					</tr>
					{foreachelse}
					<tr>
						<td colspan="5">
							{$_LANG.dns.manage.not_found}
						</td>
					</tr>
				{/foreach}
			</table>
			<button type="submit" name="vultrUpdateAction" class="btn btn-default">{$_LANG.dns.manage.update}</button>
		</form>
	</div>
</div>
<div class="row">
	<div class="panel panel-default col-sm-12">
		<form action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns&cloudAction=manage&vultrID={$domain}"
			  method="POST">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h4>{$_LANG.dns.manage.add_new}</h4>
					</div>
				</div>
			</div>
			<table class="table table-striped table-bordered">
				<tr class="something">
					<th>{$_LANG.dns.manage.type}</th>
					<th>{$_LANG.dns.manage.name}</th>
					<th>{$_LANG.dns.manage.data}</th>
					<th>{$_LANG.dns.manage.ttl}</th>
					<th>{$_LANG.dns.manage.priority}</th>
					<th></th>
				</tr>
				<tr class="addRecord">
					<td>
						<select name="type" tabindex="">
							<option value="A" selected="">A</option>
							<option value="AAAA">AAAA</option>
							<option value="CNAME">CNAME</option>
							<option value="NS">NS</option>
							<option value="MX">MX</option>
							<option value="SRV">SRV</option>
							<option value="TXT">TXT</option>
						</select>
					</td>
					<td><input name="name" placeholder="{$_LANG.dns.manage.example} www"></td>
					<td><input name="data" placeholder="{$_LANG.dns.manage.example} mx.example.com"></td>
					<td><input style="width: 50px;" name="ttl" placeholder="900"></td>
					<td><input style="width: 50px;" name="priority"></td>
					<td>
						<button style="width: 50px;" type="submit" name="vultrAddAction"
								class="btn btn-default">{$_LANG.dns.manage.add}</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('.addRecord select[name="type"]').on('change', function ()
		{
			if ($(this).val() == 'SRV' || $(this).val() == 'MX')
			{
				$('.addRecord input[name="priority"]').show();
			}
			else
			{
				$('.addRecord input[name="priority"]').hide();
			}
		});
		$('.addRecord select[name="type"]').trigger('change');
	});
</script>