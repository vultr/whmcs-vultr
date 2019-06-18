<div class="alert alert-info">{$MGLANG->T('snapshotsInfo')}</div>
<div class="panel panel-default">
	<div class="panel-body">
		<div id="snapshots">
			<table class="table  table-hover">
				<thead>
					<tr>
						<th>{$MGLANG->T('snapshotid')}</th>
						<th>{$MGLANG->T('client')}</th>
						<th>{$MGLANG->T('date_created')}</th>
						<th>{$MGLANG->T('description')}</th>
						<th>{$MGLANG->T('size')}</th>
						<th>{$MGLANG->T('status')}</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$snapshotList item=e}
						<tr>
							<td>{$e['SNAPSHOTID']}</td>
							<td>{if !empty($e['client'])}<a
									href="clientssummary.php?userid={$e['client']['clientid']}">{$e['client']['clientname']}</a> {/if}
							</td>
							<td>{$e['date_created']}</td>
							<td>{$e['description']}</td>
							<td>{$e['size'] / 1024 / 1024 / 1024} GB</td>
							<td>{$e['status']}</td>
							<td>
								<div class="onoffswitch onoffswitch-{$e['SNAPSHOTID']}">
									<input type="checkbox" name="{$e['SNAPSHOTID']}" class="onoffswitch-checkbox"
										   id="{$e['SNAPSHOTID']}" value="{$e['SNAPSHOTID']}"
										   {if !empty($allowSnapshots[$e['SNAPSHOTID']])}checked{/if}>
									<label class="onoffswitch-label" for="{$e['SNAPSHOTID']}">
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
<script src='../modules/addons/vultr/templates/admin/assets/js/tableSnapshots.js' type='text/javascript'></script>
