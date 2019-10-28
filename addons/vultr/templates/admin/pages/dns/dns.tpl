<div class="box light">

	<div class="row">
		<div class="col-lg-6">
			<div class="alert alert-info">{$MGLANG->T('DNSInfo')}</div>
			<div class="panel panel-default">
				<div class="panel-heading">{$MGLANG->T('vanityDNS')}</div>
				<div class="panel-body">
					<form action="" method="post" class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-sm-2">{$MGLANG->T('ns1')}</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="ns1" value="{(!empty($nameServer['ns1']))? {$nameServer['ns1']}: ''}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">{$MGLANG->T('ns2')}</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="ns2"
									   value="{(!empty($nameServer['ns2']))? {$nameServer['ns2']}: ''}"/>
							</div>
						</div>
						<input type="submit" name="changeNS" class="btn btn-success"
							   value="{$MGLANG->T('changeNameServer')}"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>