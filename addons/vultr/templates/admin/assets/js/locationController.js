/* 
 * Scripts for Location Controller
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */

jQuery(function ()
{
	jQuery(".onoffswitch").on('change', function ()
	{
		var id = jQuery(this).find('input').attr('id');
		JSONParser.request('changeLocationSettings', {locationId: id});
	});

});

