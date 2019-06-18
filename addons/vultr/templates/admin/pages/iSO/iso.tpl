<div class="alert alert-info">{$MGLANG->T('isoInfo')}</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div id="iso">
			<table class="table  table-hover">
				<thead>
					<tr>
						<th>{$MGLANG->T('isoid')}</th>
						<th>{$MGLANG->T('date_created')}</th>
						<th>{$MGLANG->T('filename')}</th>
						<th>{$MGLANG->T('size')}</th>
						<th>{$MGLANG->T('status')}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$isoList item=e}
						<tr>
							<td>{$e['ISOID']}</td>
							<td>{$e['date_created']}</td>
							<td>{$e['filename']}</td>
							<td>{$e['size'] / 1024 / 1024 / 1024} GB</td>
							<td>{$e['status']}</td>
							<td>
								<div class="onoffswitch onoffswitch-{$e['ISOID']}">
									<input type="checkbox" name="{$e['ISOID']}" class="onoffswitch-checkbox"
										   id="{$e['ISOID']}" value="{$e['ISOID']}"
										   {if !empty($isoSettings[$e['ISOID']])}checked{/if}>
									<label class="onoffswitch-label" for="{$e['ISOID']}">
										<span class="onoffswitch-inner" data-before="{$MGLANG->T('enabled')}"
											  data-after="{$MGLANG->T('disabled')}"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>
<script src='../modules/addons/vultr/templates/admin/assets/js/tableIso.js' type='text/javascript'></script>
