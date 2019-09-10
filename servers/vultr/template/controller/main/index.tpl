{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
{if isset($server.power_status)}
	<div class="row" id="vultrMAINContainer">
		<div class="col-sm-6 col-sm-offset-3">
			<h3 class="so_title">
				{$_LANG.main.index.control_panel}
			</h3>
		</div>
		<div class="col-sm-12">
			<p><br/></p>
			<h3 class="ajaxMessages">

			</h3>
			<div id="vultrAjaxLoader"
				 style="background: rgba(255, 255, 255, 0.8) url('{$WEB_ROOT}/modules/servers/vultr/assets/images/loader.gif') no-repeat scroll 50% 50%; display: none;">

		</div>
		<div class="so_buttons">
			<button class="btn" id="btn_boot">
				<img class="manage_img"
					 src="{$WEB_ROOT}/modules/servers/vultr/assets/images/reboot.png"/> {$_LANG.main.index.boot}
			</button>
			<button class="btn" id="btn_reboot">
				<img class="manage_img"
					 src="{$WEB_ROOT}/modules/servers/vultr/assets/images/repeat.png"/> {$_LANG.main.index.reboot}
			</button>
			<button class="btn" id="btn_stop">
				<img class="manage_img"
					 src="{$WEB_ROOT}/modules/servers/vultr/assets/images/stop.png"/> {$_LANG.main.index.stop}
			</button>
			<button class="btn" id="btn_reinstall">
				<img class="manage_img"
					 src="{$WEB_ROOT}/modules/servers/vultr/assets/images/package.png"/> {$_LANG.main.index.reinstall}
			</button>
			<button class="btn" id="btn_console"
					onclick="window.open('{$server.kvm_url}', '{addslashes($server.label)}', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,width=720,height=435');
							return false;">
				<img class="manage_img"
					 src="modules/servers/vultr/assets/images/console.png"/> {$_LANG.main.index.console}
			</button>
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h3 class="so_title">
				{$_LANG.main.index.details}
			</h3>
		</div>
		<div class="col-sm-12">
			<table class="table table-bordered table-striped" style="width:100%;">
				<tr>
					<td>{$_LANG.main.index.vm_status}</td>
					<td>
                        <span id="vultr_vm_status">
                            <strong>{$server.status}</strong>
                        </span>
					</td>
				</tr>
				<tr>
					<td>{$_LANG.main.index.power_status}</td>
					<td>
                        <span id="vultr_power_status">
                            {if $server.power_status == "running"}
								<strong style="color:green;">{$server.power_status}</strong>



{else}



								<strong style="color:red;">{$server.power_status}</strong>
							{/if}
                        </span>
						<a id="checkStatus" href="">
							<span id="serverstatus" style="display: none;"><img
										src="{$WEB_ROOT}/modules/servers/vultr/assets/images/ajax-loader.gif"></span>
							<img id="refresh-loader" src="{$WEB_ROOT}/modules/servers/vultr/assets/images/refresh.gif"
								 style="display: inline-block;" class="">
						</a>
					</td>
				</tr>
				{if isset($server.server_state)}
					<tr>
						<td>{$_LANG.main.index.server_status}</td>
						<td>
                            <span id="vultr_server_state">
                                <strong>{$server.server_state}</strong>
                            </span>
						</td>
					</tr>
				{/if}

				<tr>
					<td>{$_LANG.main.index.vps_name}</td>
					<td>
                        <span class="" id="vultr_label">
                            {$server.label} 
                        </span>
						<button class="btn btn-default" id="vultr_label_change" onclick="
                                $('#vultr_label').addClass('hide');
                                $('#vultr_label_form').removeClass('hide');
                                $(this).addClass('hide');">
							{$_LANG.main.index.label_change}
						</button>
						<form id="vultr_label_form" class="form-horizontal hide" role="form"
							  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}" method="POST">
							<input class="form-control" maxlength="250" type="text" value="{$server.label}"
								   name="vultrLabel"/>
							<button type="submit" name="vultrLabelAction"
									class="btn btn-primary">{$_LANG.main.index.save}</button>
							<button class="btn" id="btn_boot" onclick="$('#vultr_label,.change_label,#vultr_label_change').removeClass('hide');
                                    $('#vultr_label_form').addClass('hide');
                                    return false;">
								{$_LANG.main.index.label_change_cancel}
							</button>
						</form>
					</td>
				</tr>

				<tr>
					<td>{$_LANG.main.index.cpus}</td>
					<td>{$server.vcpu_count}</td>
				</tr>
				<tr>
					<td>{$_LANG.main.index.memory}</td>
					<td>{$server.ram}</td>
				</tr>
				<tr>
					<td>{$_LANG.main.index.hdd}</td>
					<td>{$server.disk}</td>
				</tr>
				<tr>
					<td>{$_LANG.main.index.template}</td>
					<td>
						{if $isSnapshot}Snapshot
						{else}
							{$server.os}
						{/if}
						<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=OSChange"
						   class="btn btn-default"
						   type="button">{if $server.os|truncate == 'Application '}{$_LANG.main.index.change_app}{else}{$_LANG.main.index.change_os}{/if}</a>
					</td>
				</tr>

				<tr>
					<td>{$_LANG.main.index.templateISO}</td>
					<td>{$isoName}
						{if $availableIsos}
							<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=ISOChange"
							   class="btn btn-default" type="button">{$_LANG.main.index.change_iso}</a>
						{else}{$_LANG.isochange.index.no_available_isos}
						{/if}
						{if $isoName != ''}
							<form method="post" style="display: inline;">
								<button class="btn btn-default" name="detachIso"
										type="submit">{$_LANG.main.index.detach_iso}</button>
							</form>
						{/if}
					</td>
				</tr>

				<tr>
					<td>{$_LANG.main.index.ipaddress}</td>
					<td>
						{$_LANG.main.index.main_ip} {$server.main_ip}
						{if !empty($server.internal_ip)}
							<br>
							{$_LANG.main.index.internal_ip} {$server.internal_ip}
						{/if}
					</td>
				</tr>
				<tr>
					<td>{$_LANG.main.index.root_password}</td>
					<td>
						{if $module.configoptions.os_type=='164'}
							{$_LANG.main.index.pass_undefined}
						{else}
							<button class="btn show_pass btn-default" id="btn_boot" onclick="$('.root_pass_show').removeClass('hide');
                                    $('button.hide_pass').removeClass('hide');
                                    $(this).addClass('hide');">
								{$_LANG.main.index.root_pass_show}
							</button>
							<span class="root_pass_show hide">
                                {$server.default_password}                                
                            </span>
							<br>
							<button class="btn hide_pass hide btn-default" id="btn_boot" onclick="$('.root_pass_show').addClass('hide');
                                    $('button.show_pass').removeClass('hide');
                                    $(this).addClass('hide');">
								{$_LANG.main.index.root_pass_hide}
							</button>
						{/if}

					</td>
				</tr>
			</table>
		</div>
	</div>
	{if isset($appInfo)}
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<h3 class="so_title">
					{$_LANG.main.index.app_info}
				</h3>
			</div>
			<div class="col-sm-12 app_content text-left">
				{$appInfo|nl2br}
			</div>
		</div>
	{/if}
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h3 class="so_title">
				{$_LANG.main.index.networks}
			</h3>
		</div>
		<div class="col-sm-12">
			<div>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#ipv4tab" aria-controls="ipv4tab" role="tab"
															  data-toggle="tab">IPv4</a></li>
					{if !empty($ipv6)}
						<li role="presentation"><a href="#ipv6tab" aria-controls="ipv6tab" role="tab" data-toggle="tab">IPv6</a>
						</li>
					{/if}
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="ipv4tab">
						<table class="table table-bordered table-striped" style="width:100%;">
							<tr>
								<th>{$_LANG.main.index.address}</th>
								<th>{$_LANG.main.index.netmask}</th>
								<th>{$_LANG.main.index.gateway}</th>
								<th>{$_LANG.main.index.reverse_dns}</th>
								<th></th>
							</tr>
							{foreach from=$ipv4 item=ip}
								<tr>
									<td>{$ip.ip}</td>
									<td>{$ip.netmask}</td>
									<td>{$ip.gateway}</td>
									<td>
										{if $ip.type!='private'}
											<form id="rev_{$ip.ip|replace:'.':'_'}" class="hide"
												  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}"
												  method="POST">
												<input type="hidden" value="{$ip.ip}" name="vultrIP">
												<input value="{$ip.reverse}" name="vultrREVDNS"
													   style="margin-bottom: 5px;"/>
												<button class="btn btn-primary" type="submit">{$_LANG.main.index.update}</button>
												<button class="btn"
														onclick="$('form#rev_{$ip.ip|replace:'.':'_'}').addClass('hide');
																$('span#rev_{$ip.ip|replace:'.':'_'}').removeClass('hide');
																return false;">
													{$_LANG.main.index.label_change_cancel}
												</button>
											</form>
											<span class="change_rev" id="rev_{$ip.ip|replace:'.':'_'}">
                                                {$ip.reverse}
                                                <button class="btn btn-default" type="button">{$_LANG.main.index.change}</button>
                                            </span>
										{/if}
									</td>
									<td>{$ip.type|replace:'_':' '}</td>
								</tr>
							{/foreach}
						</table>
					</div>
					{if !empty($ipv6)}
						<div role="tabpanel" class="tab-pane" id="ipv6tab">
							<table class="table table-bordered table-striped" style="width:100%;">
								<tr>
									<th>{$_LANG.main.index.default_ip}</th>
									<th>{$_LANG.main.index.network}</th>
									<th>{$_LANG.main.index.cidr}</th>
									<th></th>
								</tr>
								{foreach from=$ipv6 item=ip}
									<tr>
										<td>{$ip.ip}</td>
										<td>{$ip.network}</td>
										<td>{$ip.network_size}</td>
										<td>{$ip.type|replace:'_':' '}</td>
									</tr>
								{/foreach}
							</table>
							<h4 class="pull-left">{$_LANG.main.index.reverse_dns}</h4>
							<form class="form-horizontal" role="form"
								  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}"
								  method="POST">
								<table class="table table-bordered table-striped" style="width:100%;">
									<tr>
										<th>{$_LANG.main.index.ip}</th>
										<th>{$_LANG.main.index.reverse}</th>
										<th>{$_LANG.main.index.actions}</th>
									</tr>
									{foreach from=$ipv6rev item=ip}
										<tr>
											<td>{$ip.ip}</td>
											<td>{$ip.reverse}</td>
											<td>
												<button attr-ip="{$ip.ip}" attr-rev="{$ip.reverse}"
														style="margin-bottom: 5px;" class="btn btn-primary edit-rev-dns"
														id="{$ip.ip|replace:':':''}">{$_LANG.main.index.edit}</button>
												<a onclick="return confirm('{$_LANG.main.index.confirm}')"
												   class="btn btn-danger" type="button"
												   href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Main&cloudAction=delete&vultrID={$ip.ip}">{$_LANG.main.index.delete}</a>
											</td>
										</tr>
									{/foreach}
									<tr>
										<td><input class="form-control" type="text" name="ipv6revip"/></td>
										<td><input class="form-control" type="text" name="ipv6revrev"/></td>
										<td>
											<button type="submit" name="ipv6revAdd"
													class="btn btn-primary">{$_LANG.main.index.add}</button>
										</td>
									</tr>
								</table>
							</form>
						</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6 col-sm-offset-3">
			<h3 class="so_title">
				{$_LANG.main.index.stats}
			</h3>
		</div>
		<div class="col-sm-12">
			<table class="table table-bordered table-striped" style="width:100%;">
				<tr>
					<td class="col-sm-2">{$_LANG.main.index.bandwidth}</td>
					<td class="col-sm-10">
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="{$server.bandwidth}"
								 aria-valuemin="0" aria-valuemax="100"
								 style="min-width: 0em; width:{$server.bandwidth}%;">
								<span class="progress-value"
									  style="position:absolute;right:0;left:0;font-size: 16px;color: #333333;">{$server.current_bandwidth_gb} GB / {$server.allowed_bandwidth_gb} GB</span>
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><a
								href="clientarea.php?action=productdetails&id={$module['serviceid']}&cloudController=Graphs"
								class="btn btn-default" type="button">{$_LANG.main.index.usage_graphs}</a></td>
				</tr>
			</table>
		</div>
	</div>
{literal}
	<style type="text/css">
		.so_buttons {
			margin-bottom: 20px;
		}

		.so_buttons a, .so_buttons form {
			display: block;
			float: left;
			overflow: hidden;
			margin: 3px;
		}

		.so_title {
			margin-bottom: 20px;
		}

		.so_progress {
			width: 58%;
			height: 20px;
		}

		.so_progress-wrap {
			background: green;
			overflow: hidden;
			position: relative;
			float: left;
			line-height: 20px;
		}

		.so_progress-bar {
			background: #ddd;
			position: absolute;
			top: 0;
			width: 100%;
			padding-left: 5px;
		}

		.so_progress-total {
			float: right;
			width: 40%;
			line-height: 20px;
		}

		#so_root_pass, #so_hostname {
			margin: 0;
			padding: 0;
		}

		#so_root, #so_root_pass, #so_root_change_act, #so_hostname, #btn_change_hostname {
			display: none;
		}

		#so_alerts .box-success, #so_alerts .box-error {
			padding: 5px;
			margin-bottom: 20px;
		}

		#so_alerts .box-success {
			background-color: #DFF0D8;
		}

		#so_alerts .box-error {
			background-color: #F2DEDE;
		}

		.bs-docs-example:after {
			background-color: #F5F5F5;
			border: 1px solid #DDDDDD;
			border-radius: 4px 0 4px 0;
			color: #9DA0A4;
			font-size: 12px;
			font-weight: bold;
			left: -1px;
			padding: 3px 7px;
			position: absolute;
			top: -1px;
		}

		.bs-docs-example {
			background-color: #FFFFFF;
			border: 1px solid #DDDDDD;
			border-radius: 4px 4px 4px 4px;
			margin: 15px 0;
			padding: 39px 19px 14px;
			position: relative;
		}

		.bs-docs-example img {
			width: 700px;
			margin: 0 auto;
			display: block;
		}

		.so_buttons {
			margin-bottom: 20px;
			text-align: left
		}

		.so_buttons button {
			width: 24%;
			margin-bottom: 5px;
		}

		.green {
			font-weight: bold;
			color: green;
		}

		.red {
			font-weight: bold;
			color: red
		}

		.app_content {
			font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
			display: block;
			word-break: break-all;
			word-wrap: break-word;
			font-size: 13px;
			line-height: 1.25em;
			background-color: #f9f2f4;
			color: #c7254e;
			border-radius: 3px;
			padding: 6px 10px;
			overflow: auto;
		}
	</style>
	<script type="text/javascript">
		var closeAlertButton = '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>';
		$(document).ready(function ()
		{
			$(document).on({
				ajaxStart: function ()
				{
					$('div#vultrAjaxLoader').show();
				},
				ajaxStop: function ()
				{
					$('div#vultrAjaxLoader').hide();
				}
			});
			$('.edit-rev-dns').on('click', function (e)
			{
				$('input[name="ipv6revip"]').val($(this).attr('attr-ip'));
				$('input[name="ipv6revrev"]').val($(this).attr('attr-rev'));
				e.preventDefault();
			});
			var urlTabCookie = readCookie('tabsUrl');
			if (urlTabCookie !== null)
			{
				$('.nav-tabs a[href=' + urlTabCookie + ']').trigger('click');
			}
			$('.nav-tabs a').on('shown.bs.tab', function (e)
			{
				createCookie('tabsUrl', e.target.hash, 5);
			});
			$('.change_rev').on('click', function ()
			{
				$(this).addClass('hide');
				$('form#' + $(this).attr('id')).removeClass('hide');
			});
			$('#btn_boot').click(function (e)
			{
				$.ajax({
					type: "POST",
					dataType: 'json',
					data: {
						VultrAction: 'start'
					},
					success: function (msg)
					{
						$('a#checkStatus').trigger('click');
						vultrParseAjax(msg);
					}
				});
				e.preventDefault();
			});
			$('#btn_reboot').click(function (e)
			{
				$.ajax({
					type: "POST",
					dataType: 'json',
					data: {
						VultrAction: 'reboot'
					},
					success: function (msg)
					{
						$('a#checkStatus').trigger('click');
						vultrParseAjax(msg);
					}
				});
				e.preventDefault();
			});
			$('#btn_stop').click(function (e)
			{
				$.ajax({
					type: "POST",
					dataType: 'json',
					data: {
						VultrAction: 'stop'
					},
					success: function (msg)
					{
						$('a#checkStatus').trigger('click');
						vultrParseAjax(msg);
					}
				});
				e.preventDefault();
			});
			$('#btn_reinstall').click(function (e)
			{
				if (confirm('{/literal}{$_LANG.main.index.confirm_reinstall}{literal}'))
				{
					$.ajax({
						type: "POST",
						dataType: 'json',
						data: {
							VultrAction: 'reinstall'
						},
						success: function (msg)
						{
							$('a#checkStatus').trigger('click');
							vultrParseAjax(msg);
						}
					});
				}
				e.preventDefault();
			});
			/******************************************************************/
			var ajaxEnd = true;
			setInterval(function ()
			{
				if (ajaxEnd)
				{
					ajaxEnd = false;
					$('#refresh-loader').addClass('refresh-loader');
					$.ajax({
						type: "POST",
						dataType: 'json',
						global: false,
						data: {
							VultrAction: 'checkStatus'
						},
						success: function (msg)
						{
							if (msg.status)
							{
								$('span#vultr_power_status strong').text(msg.power_status);
								if (msg.power_status === 'stopped')
								{
									$('span#vultr_power_status strong').css('color', 'red');
								}
								else
								{
									$('span#vultr_power_status strong').css('color', 'green');
								}
							}
							if (msg.server_state != undefined)
							{
								$('span#vultr_server_state strong').html(msg.server_state);
							}
							if (msg.vm_status != undefined)
							{
								$('span#vultr_vm_status strong').html(msg.vm_status);
							}
						},
						complete: function ()
						{
							ajaxEnd = true;
							$('#refresh-loader').removeClass('refresh-loader');
						}
					});
				}
			}, 60000);
			/********************************************************************/
			$('a#checkStatus').click(function (e)
			{
				$.ajax({
					type: "POST",
					dataType: 'json',
					data: {
						VultrAction: 'checkStatus'
					},
					success: function (msg)
					{
						var message = '';
						if (msg.status)
						{
							$('span#vultr_power_status strong').text(msg.power_status);
							if (msg.power_status === 'stopped')
							{
								$('span#vultr_power_status strong').css('color', 'red');
							}
							else
							{
								$('span#vultr_power_status strong').css('color', 'green');
							}
							message = '<div class="alert alert-success" role="alert">' + closeAlertButton + msg.message + '</div>';
						}
						else
						{
							if (msg.message !== undefined)
							{
								message = '<div class="alert alert-warning" role="alert">' + closeAlertButton + msg.message + '</div>';
							}
							else
							{
								message = '<div class="alert alert-warning" role="alert">' + closeAlertButton + '{/literal}{$_LANG.vps_ajax.unknown}{literal}</div>';
							}
						}
						if (msg.server_state != undefined)
						{
							$('span#vultr_server_state strong').html(msg.server_state);
						}
						if (msg.vm_status != undefined)
						{
							$('span#vultr_vm_status strong').html(msg.vm_status);
						}
					}
				});
				e.preventDefault();
			});
		});

		function vultrParseAjax(msg)
		{
			if (msg.status)
			{
				$('h3.ajaxMessages').html('<div class="alert alert-success" role="alert">' + closeAlertButton + msg.message + '</div>');
			}
			else
			{
				if (msg.message != undefined)
				{
					$('h3.ajaxMessages').html('<div class="alert alert-warning" role="alert">' + closeAlertButton + msg.message + '</div>');
				}
				else
				{
					$('h3.ajaxMessages').html('<div class="alert alert-warning" role="alert">' + closeAlertButton + '{/literal}{$_LANG.vps_ajax.unknown}{literal}</div>');
				}
			}
		}

		function createCookie(name, value, min)
		{
			if (min)
			{
				var date = new Date();
				date.setTime(date.getTime() + (min * 60 * 1000));
				var expires = "; expires=" + date.toGMTString();
			}
			else
			{
				var expires = "";
			}
			document.cookie = name + "=" + value + expires + "; path=/";
		}

		function readCookie(name)
		{
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++)
			{
				var c = ca[i];
				while (c.charAt(0) == ' ')
					c = c.substring(1, c.length);
				if (c.indexOf(nameEQ) == 0)
				{
					return c.substring(nameEQ.length, c.length);
				}
			}
			return null;
		}

		function eraseCookie(name)
		{
			createCookie(name, "", -1);
		}
	</script>
{/literal}
{else}
{literal}
	<script type="text/javascript">
		var ajaxEnd = true;
		var reload = false;
		$(document).ready(function ()
		{
			setInterval(function ()
			{
				if (ajaxEnd)
				{
					ajaxEnd = false;
					$.ajax({
						type: "POST",
						dataType: 'json',
						data: {
							VultrAction: 'checkVMStatus'
						},
						success: function (msg)
						{
							if (msg.reload)
							{
								reload = true;
							}
						},
						complete: function ()
						{
							if (reload)
							{
								location.reload();
							}
							else
							{
								ajaxEnd = true;
							}
						}
					});
				}
			}, 5000);
		});
	</script>
{/literal}
{/if}