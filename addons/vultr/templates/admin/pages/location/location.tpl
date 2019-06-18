<div class="box light">

	<div class="row">
		<div class="col-lg-6">
			<div class="alert alert-info">{$MGLANG->T('serverLocationInfo')}</div>
			<div class="panel panel-default">
				<div class="panel-heading">{$MGLANG->T('serverLocation')}</div>
				<div class="panel-body">
					{foreach from=$locationArray item=e}
						<div class="form-group">
							<label for="{$e['DCID']}" class="col-sm-2 control-label">{$e['name']}</label>
							<div class="col-sm-10">

								<div class="onoffswitch onoffswitch-{$e['DCID']}">
									<input type="checkbox" name="{$e['DCID']}" class="onoffswitch-checkbox"
										   id="{$e['DCID']}" value="{$locationSettings[$e['DCID']]}"
										   {if !$locationSettings[$e['DCID']]}checked{/if}>
									<label class="onoffswitch-label" for="{$e['DCID']}">
										<span class="onoffswitch-inner" data-before="{$MGLANG->T('enabled')}"
											  data-after="{$MGLANG->T('disabled')}"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</div>
						</div>
					{/foreach}
				</div>
			</div>
		</div>
	</div>
</div>

<script src='../modules/addons/vultr/templates/admin/assets/js/locationController.js' type='text/javascript'></script>