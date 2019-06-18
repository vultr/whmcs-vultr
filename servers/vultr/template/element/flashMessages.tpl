<link rel="stylesheet" href="{$WEB_ROOT}/modules/servers/vultr/assets/css/vultr.css">
<div class="row">
	{foreach from=$flashMessages item=message}
		<div class="alert alert-{$message['type']}" role="alert"><a href="#" class="close" data-dismiss="alert"
																	aria-label="close">&times;</a>{$message['message']}
		</div>
	{/foreach}
</div>