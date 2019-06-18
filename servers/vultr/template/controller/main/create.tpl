{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrMAINContainer">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<h4>{$_LANG.main.create.panel_title}</h4>
				</div>
			</div>
		</div>
		<form class="form-horizontal" role="form"
			  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Main&cloudAction=create"
			  method="POST">
			<!--Select Label-->
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<label for="vultrLabel">{$_LANG.main.create.server_label}</label>
					<input value="{if isset($postData['vultrLabel'])}{$postData['vultrLabel']}{/if}"
						   class="form-control" type="text" id="vultrLabel" name="vultrLabel" maxlength="250"
						   placeholder="{$_LANG.main.create.server_label_placeholder}">
				</div>
			</div>
			<!--Select Label END-->
			<!--Select Hostname-->
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<label for="vultrHostname">{$_LANG.main.create.server_hostname}</label>
					<input value="{if isset($postData['vultrHostname'])}{$postData['vultrHostname']}{/if}"
						   class="form-control" type="text" id="vultrHostname" name="vultrHostname" maxlength="250"
						   placeholder="{$_LANG.main.create.server_hostname_placeholder}">
				</div>
			</div>
			<!--Select Hostname END-->
			<!--Select Region-->
			<div class="row">
				<div class="col-sm-5 col-sm-offset-1">
					<label for="vultrRegionDCID">{$_LANG.main.create.location}</label>
					<select class="form-control" id="vultrRegionDCID" name="vultrRegionDCID">
						{foreach from=$regions key=k item=v}
							<option value="{$v['DCID']}"
									{if isset($postData['vultrRegionDCID']) && $postData['vultrRegionDCID']==$v['DCID']}selected{/if}>{$v['name']}
								({$v['country']})
							</option>
						{/foreach}
					</select>
				</div>
				<!--Select Region END-->
				<!--Select OS-->
				<div class="col-sm-5">
					<label for="vultrOSID">{$_LANG.main.create.system}</label>
					<select disabled class="form-control" id="vultrOSID" name="vultrOSID">
						<option value="{$module['configoptions']['os_type']}"
								selected>{$oses[$module['configoptions']['os_type']]['name']}</option>
					</select>
				</div>
			</div>
			<!--Select OS END-->
			<!--Select Snapshot-->
			<!--/***If selected OS Type is Snapshot***/-->
			{if $module['configoptions']['os_type']==='164'}
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<label for="vultrSNAPSHOTID">{$_LANG.main.create.snapshot}</label>
						<select class="form-control" id="vultrSNAPSHOTID" name="vultrSNAPSHOTID">
							{foreach from=$snapshots key=k item=v}
								<option value="{$v['SNAPSHOTID']}"
										{if isset($postData['vultrSNAPSHOTID']) && $postData['vultrSNAPSHOTID']==$v['SNAPSHOTID']}selected{/if}>{$v['description']}</option>
							{/foreach}
						</select>
					</div>
				</div>
			{/if}
			<!--Select Snapshot END-->
			<!--/***If selected OS Type is Backup***/-->
			{if $module['configoptions']['os_type']==='180'}
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<label for="vultrBACKUPID">{$_LANG.main.create.backups}</label>
						<select class="form-control" id="vultrBACKUPID" name="vultrBACKUPID">
							{foreach from=$backups key=k item=v}
								<option value="{$v['BACKUPID']}"
										{if isset($postData['vultrBACKUPID']) && $postData['vultrBACKUPID']==$v['BACKUPID']}selected{/if}>{$v['description']}
									({$v['date_created']} - {$v['size']})
								</option>
							{/foreach}
						</select>
					</div>
				</div>
			{/if}
			<!--Select Backup END-->
			<!--/***If selected OS Type is Application***/-->
			{if $module['configoptions']['os_type']==='186'}
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<label for="vultrAppID">{$_LANG.main.create.app}</label>
						<select disabled class="form-control" id="vultrAppID" name="vultrAppID">
							<option value="{$module['configoptions']['application']}"
									selected>{$apps[$module['configoptions']['application']]['deploy_name']}</option>
						</select>
					</div>
				</div>
			{/if}
			<!--/***If selected OS Type is Custom***/-->
			{if $module['configoptions']['os_type']==='159'}
				<div class="row col-sm-10 col-sm-offset-1">
					<div class="row">
						<div class="col-sm-4">
							<label>
								<input type="radio" name="vultrISOType" id="cloudCustomType" value="ISO"
									   {if (isset($postData['vultrISOType']) && $postData['vultrISOType']=='ISO') || !isset($postData['vultrSCRIPTtype'])}checked{/if}>
								{$_LANG.main.create.iso}
							</label>
						</div>
						<div class="col-sm-8">
							<select class="form-control" id="vultrISOID" name="vultrISOID">
								{foreach from=$isos key=k item=v}
									<option value="{$v['ISOID']}"
											{if isset($postData['vultrSCRIPTtype']) && $postData['vultrSCRIPTtype']==$v['ISOID']}selected{/if}>{$v['filename']}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label>
								<input type="radio" name="vultrISOType" id="cloudCustomType" value="IPXECustom"
									   {if isset($postData['vultrISOType']) && $postData['vultrISOType']=='IPXECustom'}checked{/if}>
								{$_LANG.main.create.ipxe_url}
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text"
								   value="{if isset($postData['vultrIPXEUrl'])}{$postData['vultrIPXEUrl']}{/if}"
								   class="form-control" id="vultrIPXEUrl" name="vultrIPXEUrl">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label>
								<input type="radio" name="vultrISOType" id="cloudCustomType" value="IPXEScript"
									   {if isset($postData['vultrISOType']) && $postData['vultrISOType']=='IPXEScript'}checked{/if}>
								{$_LANG.main.create.ipxe} (<a
										href="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=Scripts">{$_LANG.main.create.manage}</a>)
							</label>
						</div>
						<div class="col-sm-8">
							<select class="form-control" id="vultrSCRIPTID" name="vultrSCRIPTID">
								{foreach from=$startupscript key=k item=v}
									{if $v['type']=='pxe'}
										<option value="{$v['SCRIPTID']}"
												{if isset($postData['vultrSCRIPTID']) && $postData['vultrSCRIPTID']==$v['SCRIPTID']}selected{/if}>{$v['name']}</option>
									{/if}
								{/foreach}
							</select>
						</div>
					</div>
				</div>
			{/if}
			<!--Select Snapshot END-->
			<!--/***If selected OS Type is OS withput Windows***/-->
			{if $module['configoptions']['os_type']!=='159' && $module['configoptions']['os_type']!=='164' && $module['configoptions']['os_type']!=='180' && $module['configoptions']['os_type']!=='186'}
				<!--Select Startup script-->
				<div class="row">
					<div class="col-sm-5 col-sm-offset-1">
						<label for="vultrSCRIPT">{$_LANG.main.create.script_install}</label>
						{if count($startupscript)>0}
							<select class="form-control" id="vultrSCRIPT" name="vultrSCRIPT">
								<option value="0"
										{if isset($postData['vultrSCRIPT']) && $postData['vultrSCRIPT']=='0'}selected{/if}selected>{$_LANG.main.create.no}</option>
								<option value="1"
										{if isset($postData['vultrSCRIPT']) && $postData['vultrSCRIPT']=='1'}selected{/if}>{$_LANG.main.create.yes}</option>
							</select>
						{else}
							<a class="btn btn-warning"
							   href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=Scripts"
							   role="button">{$_LANG.main.create.no_script_found}</a>
						{/if}
					</div>
					{if count($startupscript)>0}
						<div class="col-sm-5" id="selectStartupScriptDiv">
							<label for="vultrSCRIPTID">{$_LANG.main.create.script}</label>
							<select class="form-control" id="vultrSCRIPTID" name="vultrSCRIPTID">
								{foreach from=$startupscript key=k item=v}
									{if !isset($v['type']) || $v['type']=='boot'}
										<option value="{$v['SCRIPTID']}"
												{if isset($postData['vultrSCRIPTtype']) && $postData['vultrSCRIPTtype']==$v['SCRIPTID']}selected{/if}>{$v['name']}</option>
									{/if}
								{/foreach}
							</select>
						</div>
					{/if}
				</div>
				<!--Select Startup script END-->
			{/if}
			<!--IPv6-->
			<div class="row">
				<div class="col-sm-5 col-sm-offset-1">
					<label for="vultrIPv6">{$_LANG.main.create.ipv6}</label>
					<select class="form-control" id="vultrIPv6" name="vultrIPv6">
						<option value="0"
								{if isset($postData['vultrIPv6']) && $postData['vultrIPv6']=='0'}selected{/if}>{$_LANG.main.create.no}</option>
						<option value="1"
								{if isset($postData['vultrIPv6']) && $postData['vultrIPv6']=='1'}selected{/if}>{$_LANG.main.create.yes}</option>
					</select>
				</div>
				<!--IPv6 END-->
				<!--Priv network-->
				<div class="col-sm-5">
					<label for="vultrPrivNet">{$_LANG.main.create.priv_net}</label>
					<select class="form-control" id="vultrPrivNet" name="vultrPrivNet">
						<option value="0"
								{if isset($postData['vultrPrivNet']) && $postData['vultrPrivNet']=='0'}selected{/if}>{$_LANG.main.create.no}</option>
						<option value="1"
								{if isset($postData['vultrPrivNet']) && $postData['vultrPrivNet']=='1'}selected{/if}>{$_LANG.main.create.yes}</option>
					</select>
				</div>
			</div>
			<!--Priv network END-->
			<!--Select SSH-->
			{if $module['configoptions']['os_type']!=='124' && $module['configoptions']['os_type']!=='186'}
				<div class="row">
					<div class="col-sm-5 col-sm-offset-1">
						<label for="vultrSSH">{$_LANG.main.create.ssh_install}</label>
						{if count($sshkeys)>0}
							<select class="form-control" id="vultrSSH" name="vultrSSH">
								<option value="0"
										{if isset($postData['vultrSSH']) && $postData['vultrSSH']=='0'}selected{/if}>{$_LANG.main.create.no}</option>
								<option value="1"
										{if isset($postData['vultrSSH']) && $postData['vultrSSH']=='1'}selected{/if}>{$_LANG.main.create.yes}</option>
							</select>
						{else}
							<a class="btn btn-warning"
							   href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=SSHKeys"
							   role="button">{$_LANG.main.create.no_ssh_found}</a>
						{/if}
					</div>
					{if count($sshkeys)>0}
						<div class="col-sm-5" id="vultrSCRIPTIDDIV">
							<label for="vultrSSHKEYID">{$_LANG.main.create.ssh_cert}</label>
							<select class="form-control" id="vultrSSHKEYID" name="vultrSSHKEYID">
								{foreach from=$sshkeys key=k item=v}
									<option value="{$v['SSHKEYID']}"
											{if isset($postData['vultrSSHKEYID']) && $postData['vultrSSHKEYID']==$v['SSHKEYID']}selected{/if}>{$v['name']}</option>
								{/foreach}
							</select>
						</div>
					{/if}
				</div>
			{/if}
			<!--Select SSH END-->
			<!--Auto backups-->
			<div class="row">
				<div class="col-sm-5 col-sm-offset-1">
					<label for="vultrAutoBackups">{$_LANG.main.create.backups}</label>
					<select disabled class="form-control" id="vultrAutoBackups" name="vultrAutoBackups">
						<option value="{$module['configoptions']['auto_backups']}"
								selected>{if $module['configoptions']['auto_backups']}{$_LANG.main.create.yes}{else}{$_LANG.main.create.no}{/if}</option>
					</select>
				</div>
				<!--Auto backups END-->
			</div>
			<!--Submit-->
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<button type="submit" name="cloudCreateAction"
							class="btn btn-default">{$_LANG.main.create.create}</button>
				</div>
			</div>
			<!--Submit END-->
		</form>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function ()
	{
		$('input[name="vultrISOType"]').on('change', function ()
		{
			if ($(this).val() === 'ISO')
			{
				$('select#vultrISOID').removeAttr('disabled');
				$('input#vultrIPXEUrl').attr('disabled', 'disabled');
				$('select#vultrSCRIPTID').attr('disabled', 'disabled');
			}
			else if ($(this).val() === 'IPXECustom')
			{
				$('select#vultrISOID').attr('disabled', 'disabled');
				$('input#vultrIPXEUrl').removeAttr('disabled');
				$('select#vultrSCRIPTID').attr('disabled', 'disabled');
			}
			else
			{
				$('select#vultrISOID').attr('disabled', 'disabled');
				$('input#vultrIPXEUrl').attr('disabled', 'disabled');
				$('select#vultrSCRIPTID').removeAttr('disabled');
			}
		});
		$('input[name="vultrISOType"]:checked').trigger('change');
		//SCRIPT
		$('select#vultrSCRIPT').on('change', function ()
		{
			if ($(this).val() === '1')
			{
				$('div#selectStartupScriptDiv').show();
			}
			else
			{
				$('div#selectStartupScriptDiv').hide();
			}
		});
		$('select#vultrSCRIPT').trigger('change');
		//SSH
		$('select#vultrSSH').on('change', function ()
		{
			if ($(this).val() === '1')
			{
				$('div#vultrSCRIPTIDDIV').show();
			}
			else
			{
				$('div#vultrSCRIPTIDDIV').hide();
			}
		});
		$('select#vultrSSH').trigger('change');
	});
</script>