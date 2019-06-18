{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrDNSContainer">
	<div class="panel panel-default col-sm-12">
		<form action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns&cloudAction=create"
			  method="POST">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h4>{$_LANG.dns.create.panel_title}</h4>
					</div>
				</div>
			</div>
			<div class="row">
				{if count($domains)>0}
					<div class="form-group col-sm-5">
						<label for="vultrDNSdomainID">{$_LANG.dns.create.select_domain}</label>
						<select class="form-control" name="vultrDNSdomainID">
							{foreach from=$domains item=domain}
								<option value="{$domain->domain}">{$domain->domain}</option>
							{/foreach}
						</select>
					</div>
					<div class="form-group col-sm-4">
						<label for="vultrDNSdomainName">{$_LANG.dns.create.input_domain}</label>
						<input type="text" class="form-control" id="vultrDNSdomainName" name="vultrDNSdomainName"
							   value="{if isset($postData.vultrDNSdomainName)}{$postData.vultrDNSdomainName}{/if}"
							   placeholder="example.com">
					</div>
				{else}
					<div class="form-group col-sm-9">
						<label for="vultrDNSdomainName">{$_LANG.dns.create.input_domain2}</label>
						<input type="text" class="form-control" id="vultrDNSdomainName" name="vultrDNSdomainName"
							   value="{if isset($postData.vultrDNSdomainName)}{$postData.vultrDNSdomainName}{/if}"
							   placeholder="example.com">
					</div>
				{/if}
				<div class="form-group col-sm-3">
					<label for="vultrDNSserverIP">{$_LANG.dns.create.ip}</label>
					<input type="text" class="form-control text-center" id="vultrDNSserverIP" name="vultrDNSserverIP"
						   value="{if isset($postData.vultrDNSserverIP)}{$postData.vultrDNSserverIP}{else}{$ip}{/if}">
				</div>
			</div>
			<button type="submit" name="cloudCreateAction" class="btn btn-default">{$_LANG.dns.create.create}</button>
		</form>
	</div>
</div>





