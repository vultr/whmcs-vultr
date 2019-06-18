$(document).ready(function ()
{
	$('form[name="packagefrm"] div.tab-content div#tab3 table:eq(1)').prepend('<tr><td class="fieldlabel">Configurable Options</td><td class="fieldarea"><a href="#" id="vultr_configurable_options">Generate default</a><td class="fieldlabel">Custom Fields</td><td class="fieldarea"><a href="#" id="vultr_custom_fields">Generate default</a></td></tr>');
	$('form[name="packagefrm"] div.tab-content div#tab3').on('click', 'a#vultr_configurable_options', function (e)
	{
		$.post("configproducts.php?action=edit&id=#id#&tab=3", {
			productID: '#id#',
			vultr_action: 'vultr_configurable_options'
		}, function (data)
		{
			alert(data.message);
			if (data.reload !== undefined)
			{
				location.reload();
			}
		});
		e.preventDefault();
	});
	$('form[name="packagefrm"] div.tab-content div#tab3').on('click', 'a#vultr_custom_fields', function (e)
	{
		$.post("configproducts.php?action=edit&id=#id#&tab=3", {
			productID: '#id#',
			vultr_action: 'vultr_custom_fields'
		}, function (data)
		{
			alert(data.message);
			if (data.reload !== undefined)
			{
				location.reload();
			}
		});
		e.preventDefault();
	});
});

