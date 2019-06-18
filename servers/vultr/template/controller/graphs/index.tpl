{include file="modules/servers/vultr/template/element/flashMessages.tpl"}
{include file="modules/servers/vultr/template/element/mainButtons.tpl"}
{if !isset($emptyData)}
	<link rel="stylesheet" href="{$WEB_ROOT}/modules/servers/vultr/assets/css/morris.css">
	<script src="{$WEB_ROOT}/modules/servers/vultr/assets/js/morris.min.js"></script>
	<script src="{$WEB_ROOT}/modules/servers/vultr/assets/js/raphael-min.js"></script>
	<div class="row" id="vultrCHARTSContainer">
		<div class="panel panel-default">
			<div class="panel-heading ">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h4>{$_LANG.graphs.index.panel_title_incoming}</h4>
					</div>
				</div>
			</div>
			<div class="row col-md-10 col-md-offset-1">
				<div id="vultrIncomingChart"></div>
			</div>
		</div>
	</div>
	<div class="row" id="vultrCHARTSContainer">
		<div class="panel panel-default">
			<div class="panel-heading ">
				<div class="row">
					<div class="col-md-6 col-md-offset-3">
						<h4>{$_LANG.graphs.index.panel_title_outgoing}</h4>
					</div>
				</div>
			</div>
			<div class="row col-md-10 col-md-offset-1">
				<div id="vultrOutgoingChart" style="height: 400px;"></div>
			</div>
		</div>
	</div>
{literal}
	<script type="text/javascript">
		$(document).ready(function ()
		{
			$('html,body').animate({scrollTop: $("#domain").offset().top}, 0.1);
		});
		Morris.Bar({
			element: 'vultrIncomingChart',
			data: {/literal}{$incoming}{literal},
			xkey: 'date',
			ykeys: ['incoming'],
			labels: ['Incoming'],
			barRatio: 0.4,
			xLabelAngle: 35,
			hideHover: 'auto',
			resize: true,
			pointSize: 1,
			hoverCallback: function (index, options, content, row)
			{
				return formatBytes(row.incoming, 2);
			},
			yLabelFormat: function (y)
			{
				return formatBytes(y.toString());
			}
		});
		Morris.Bar({
			element: 'vultrOutgoingChart',
			data: {/literal}{$outgoing}{literal},
			xkey: 'date',
			ykeys: ['outgoing'],
			labels: ['outgoing'],
			barRatio: 0.4,
			xLabelAngle: 35,
			hideHover: 'auto',
			resize: true,
			pointSize: 1,
			hoverCallback: function (index, options, content, row)
			{
				return formatBytes(row.outgoing, 2);
			},
			yLabelFormat: function (y)
			{
				return formatBytes(y.toString());
			}
		});

		function formatBytes(bytes, decimals)
		{
			if (bytes == 0)
			{
				return '0 Byte';
			}
			var k = 1024;
			var dm = decimals + 1 || 3;
			var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

			var i = Math.floor(Math.log(bytes) / Math.log(k));
			if (i >= 0)
			{
				return (bytes / Math.pow(k, i)).toPrecision(dm) + ' ' + sizes[i];
			}
			else
			{
				return (bytes / Math.pow(k, i)).toPrecision(dm);
			}
		}

	</script>
{/literal}
{/if}