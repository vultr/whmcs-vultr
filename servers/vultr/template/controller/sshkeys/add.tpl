{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
<div class="row" id="vultrSSHContainer">
	<div class="panel panel-default">
		<div class="panel-heading ">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h4>{$_LANG.sshkeys.add.panel_title}</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<form id="addSSHKeyForm"
				  action="{$WEB_ROOT}/clientarea.php?action=productdetails&id={$serviceid}&cloudController=SSHKeys&cloudAction=add"
				  method="POST" class="col-sm-10 col-sm-offset-1">
				<div class="form-group col-sm-3">
					<label for="vultrSSHKEYname">{$_LANG.sshkeys.add.name}</label>
					<input type="text" class="form-control" id="vultrSSHKEYname" name="vultrSSHKEYname"
						   placeholder="{$_LANG.sshkeys.add.script_name}">
				</div>
				<div class="form-group col-sm-9">
					<label for="vultrSSHKEY">{$_LANG.sshkeys.add.ssh_key}</label>
					<textarea name="vultrSSHKEY" class="form-control" rows="5" id="vultrSSHKEY"></textarea>
				</div>

				<button type="submit" name="cloudAddAction" class="btn btn-default">{$_LANG.sshkeys.add.create}</button>
			</form>
		</div>
	</div>
</div>