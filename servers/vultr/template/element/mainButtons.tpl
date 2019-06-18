<div class="row">
	<div class="btn-group btn-group-justified col-sm-12">
		<a href="clientarea.php?action=productdetails&id={$serviceid}"
		   class="btn btn-{if $controller=='Main' || $controller=='Graphs'}info{else}primary{/if}"
		   type="button">{$_LANG.elements.buttons.main_page}</a>
		<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=Snapshots"
		   class="btn btn-{if $controller=='Snapshots'}info{else}primary{/if}"
		   type="button">{$_LANG.elements.buttons.snapshots}</a>
		<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=Scripts"
		   class="btn btn-{if $controller=='Scripts'}info{else}primary{/if}"
		   type="button">{$_LANG.elements.buttons.scripts}</a>
		<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=SSHKeys"
		   class="btn btn-{if $controller=='SSHKeys'}info{else}primary{/if}"
		   type="button">{$_LANG.elements.buttons.ssh_keys}</a>
		<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=Dns"
		   class="btn btn-{if $controller=='Dns'}info{else}primary{/if}" type="button">{$_LANG.elements.buttons.dns}</a>
		<a href="clientarea.php?action=productdetails&id={$serviceid}&cloudController=Backups"
		   class="btn btn-{if $controller=='Backups'}info{else}primary{/if}"
		   type="button">{$_LANG.elements.buttons.backups}</a>
	</div>
</div>