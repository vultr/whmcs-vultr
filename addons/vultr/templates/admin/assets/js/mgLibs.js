var JSONParser = {
	url: false,
	type: 'post',
	startString: '<JSONRESPONSE#',
	stopString: '#ENDJSONRESPONSE>',
	currentPage: false,
	requestCounter: 0,

	create: function (url, type)
	{
		this.url = url;
		if (type !== undefined)
		{
			this.type = type;
		}
	},
	getJSON: function (json, disableError)
	{
		this.requestCounter--;
		if (this.requestCounter == 0)
		{
			jQuery('#MGLoader').loader('hide');
		}

		var start = json.indexOf(this.startString);
		json = json.substr(start + this.startString.length, json.indexOf(this.stopString) - start - this.startString.length);

		try
		{
			return jQuery.parseJSON(json);
		} catch (e)
		{
			console.log(e);
			jQuery('#MGAlerts').alerts('error', "Error: " + e.toString());
			jQuery('.modal.in').modal('hide');
			return false;
		}
	},
	request: function (action, data, callback, loader, disableErrors)
	{
		var details = {};
		var that = this;

		if (data === undefined)
		{
			data = {};
		}

		if (typeof data === "object")
		{
			data['mg-action'] = action;
			if (this.currentPage)
			{
				data['mg-page'] = this.currentPage;
			}
		}
		else if (typeof data === "string")
		{
			data += "&mg-action=" + action;
			if (this.currentPage)
			{
				data += "&mg-page=" + this.currentPage;
			}
		}

		if (loader === undefined)
		{
			jQuery('#MGLoader').loader();
		}
		else if (loader != "off")
		{
			jQuery(loader).loader();
		}

		this.requestCounter++;

		switch (this.type)
		{
			default:
				jQuery.post(this.url, data, function (response)
				{
					parsed = that.getJSON(response, disableErrors);
					if (parsed)
					{
						if (parsed.success)
						{
							jQuery('#MGAlerts').alerts('success', parsed.success);
						}

						if (parsed.error)
						{
							jQuery('#MGAlerts').alerts('error', parsed.error);
							jQuery('.modal.in').modal('hide');
						}

						if (parsed.data)
						{
							callback(parsed.data);
						}
					}
					else
					{
						jQuery('#MGAlerts').alerts('error', "Somethings Goes Wrong, check logs, contact admin");
						jQuery('.modal.in').modal('hide');
					}
				}).fail(function (response)
				{
					if (response.responseText)
					{
						jQuery('#MGAlerts').alerts('error', response.responseText);
						jQuery('#MGLoader').loader('hide');
					}
				});
		}
	}
};


function ucfirst(string)
{
	return string.charAt(0).toUpperCase() + string.slice(1);
}

jQuery.fn.alerts = function (type, message, configs)
{
	configs = jQuery.extend({
		items: null
		, confirmCallback: null
		, link: null
	}, configs);

	items = configs.items;
	confirmCallback = configs.confirmCallback;

	var container = this;

	var now = new Date().getTime();

	var current = new Array();

	var count = 0;

	var max = 2;

	jQuery(container).children('div[data-time]').each(function ()
	{
		var time = new String(jQuery(this).attr('data-time'));
		current[time] = 1;
		count++;
	});

	current.sort();

	if (count > max)
	{
		for (x in current)
		{
			var set = parseInt(x);
			if (set > 0)
			{
				if (now - set > 10 && count - max > 0)
				{
					jQuery(container).find('div[data-time="' + set + '"]').remove();
					count--;
				}
			}
		}
	}

	if (type === 'clear')
	{
		jQuery(container).find('div[data-time]').remove();
		return;
	}

	var prototype = jQuery(container).find('div[data-prototype="' + type + '"]').clone();

	prototype.find('strong').append(message);

	if (items != undefined)
	{
		var html = '<ul>';
		for (x in items)
		{
			html += '<li>' + items[x] + '</li>';
		}
		html += '</ul>';
		prototype.append(html);
	}

	prototype.find('.close').click(function ()
	{
		jQuery(this).parent().remove();
	});

	prototype.attr('data-time', now);

	if (configs.link)
	{
		prototype.append('<a href="' + configs.link.url + '">' + configs.link.name + '</a>');
	}

	prototype.removeAttr('data-prototype');
	prototype.show();

	jQuery(container).append(prototype);
};

jQuery.fn.loader = function (action)
{
	if (action === undefined || action == 'show')
	{
		jQuery('body').css('position', 'relative');
		jQuery(this).show();
	}
	else
	{
		jQuery(this).hide();
	}
}

jQuery.fn.MGGetForms = function (action)
{
	var that = this;
	var data = {};
	jQuery(this).find('input,select,textarea').each(function ()
	{
		if (!jQuery(this).is(':disabled'))
		{
			var name = jQuery(this).attr('name');

			var value = null;

			if (name !== undefined)
			{
				var type = jQuery(this).attr('type');

				var regExp = /([a-zA-Z_0-9]+)\[([a-zA-Z_0-9]+)\]/g;

				if (type == 'checkbox')
				{
					var value = [];
					jQuery(that).find('input[name="' + name + '"]').each(function ()
					{
						if (jQuery(this).is(':checked'))
						{
							value.push(jQuery(this).val());
						}
					});
				}
				else if (type == 'radio')
				{
					if (jQuery(this).is(':checked'))
					{
						var value = jQuery(this).val();
					}
				}
				else
				{
					var value = jQuery(this).val();
				}

				if (value !== null)
				{
					if (result = regExp.exec(name))
					{
						if (data[result[1]] === undefined)
						{
							data[result[1]] = {}
						}

						data[result[1]][result[2]] = value;
					}
					else
					{
						data[name] = value;
					}
				}
			}
		}
	});
	return data;
}

jQuery.fn.MGModalActions = function ()
{
	var that = this;
	var rowUpdateFunction;

	this.putField = function (modal, name, value)
	{
		var element = modal.find('*[name="' + name + '"]');
		if (element.length > 0)
		{
			switch (element.prop('tagName').toLowerCase())
			{
				case 'input':

					if (element.attr('type') == 'checkbox')
					{
						if (typeof value == 'object')
						{
							for (x in value)
							{
								modal.find('input[type=checkbox][name="' + name + '"][value="' + value[x] + '"]').attr('checked', 'checked');
							}
						}
						else
						{
							if (value == 1)
							{
								element.prop('checked', true);
							}
							else
							{
								element.prop('checked', false);
							}
						}
					}
					else if (element.attr('type') == 'radio')
					{
						element.filter('*[value="' + value + '"]').attr('checked', 'checked');
					}
					else
					{
						element.val(value);
					}
					break;
				case 'select':
					element.val(value);
					break;
				case 'textarea':
					element.text(value);
					break;
			}

			element.change();
		}

		var element = modal.find('*[name="' + name + '[]"]');


		if (element.length > 0)
		{
			switch (element.prop('tagName').toLowerCase())
			{
				case 'select':
					if (element.attr('multiple'))
					{
						element.find('option').removeAttr('selected');
						for (x in value)
						{
							element.find('option[value="' + value[x] + '"]').attr('selected', 'selected');
						}
					}
					break;
				case 'input':
					if (element.attr('type') == 'checkbox')
					{
						modal.find('input[type=checkbox][name="' + name + '[]"]').removeAttr('checked');
						for (x in value)
						{
							modal.find('input[type=checkbox][name="' + name + '[]"][value="' + value[x] + '"]').attr('checked', 'checked');
						}
					}
					break;
			}
			element.change();
		}
	}

	this.putFieldOptions = function (modal, name, newOptions)
	{
		var element = modal.find('*[name="' + name + '"]');
		if (element.length > 0)
		{
			switch (element.prop('tagName').toLowerCase())
			{

				case 'select':
					$('option', element).remove();
					$.each(newOptions, function (text, key)
					{
						var option = new Option(key, text);
						element.append($(option));
					});
					break;
					break;
			}

			element.change();
		}
	}

	this.addErrorField = function (modal, name, error)
	{
		var element = modal.find('*[name="' + name + '"]');

		if (element.length == 0)
		{
			var element = modal.find('*[name="' + name + '[]"]');
		}

		var contener = element.closest('div.form-group');

		contener.addClass('has-error');

		contener.find('.error-block').text(error).show();
	}

	this.clearModalError = function (modal)
	{
		modal.find('.form-group.has-error').removeClass('has-error');
		modal.find('.error-block').text('').hide();
		modal.find('.modal-alerts').alerts('clear');
	}

	this.setRowUpdateFunction = function (updatefunction)
	{
		this.rowUpdateFunction = updatefunction;
	}

	this.on('click', '*[data-modal-id]', function (event)
	{
		event.preventDefault();

		var target = jQuery(event.currentTarget).attr('data-modal-target');

		if (!target)
		{
			throw "Define target ID (data-modal-target)";
		}

		var modal = jQuery(event.currentTarget).attr('data-modal-id');

		if (!modal)
		{
			throw "Define modal id (data-modal-id)";
		}

		var action = jQuery('#' + modal).attr('data-modal-load');

		var functionName = jQuery('#' + modal).attr('data-modal-on-load');

		var onload = window[functionName];

		jQuery('#' + modal).find('[data-target]').val(target);
		jQuery('#' + modal).find('[data-modal-title]').text(target);

		that.clearModalError(jQuery('#' + modal));

		if (action)
		{

			jQuery('#' + modal).find('.modal-body').hide();
			jQuery('#' + modal).find('.modal-loader').show();

			JSONParser.request(
				action
				, {
					id: target
				}
				, function (data)
				{

					if (typeof onload === 'function')
					{
						data = onload(data);
					}

					if (data.formOptions)
					{
						for (x in data.formOptions)
						{
							that.putFieldOptions(jQuery('#' + modal), x, data.formOptions[x]);
						}
					}
					if (data.form)
					{
						for (x in data.form)
						{
							that.putField(jQuery('#' + modal), x, data.form[x]);
						}
					}

					if (data.error)
					{
						jQuery('#MGAlerts').alerts('success', data.error);
						jQuery('#' + modal).find('*[data-modal-action]').attr('disabled', 'disabled');
					}
					else
					{
						jQuery('#' + modal).find('*[data-modal-action]').removeAttr('disabled');
					}

					if (data.vars)
					{
						jQuery('#' + modal).find('*[data-modal-var]').each(function ()
						{
							var name = jQuery(this).attr('data-modal-var');
							if (data.vars[name] && name == "html")
							{
								jQuery(this).html(data.vars[name]);
							}
							else if (data.vars[name])
							{
								jQuery(this).text(data.vars[name]);
							}
							else
							{
								jQuery(this).text();
							}
						});
					}

					jQuery('#' + modal).find('.modal-body').show();
					jQuery('#' + modal).find('.modal-loader').hide();
				}
			);
		}
		else
		{
			jQuery('#' + modal).find('.modal-body').show();
			jQuery('#' + modal).find('.modal-loader').hide();
		}

		jQuery('#' + modal).modal();
	});

	this.updateRow = function (rowData)
	{
		for (var x in rowData)
		{
			if (x == 'DT_RowData')
			{
				var selector = 'tr';
				for (var z in rowData['DT_RowData'])
				{
					selector += '[data-' + z + '="' + rowData['DT_RowData'][z] + '"]';
				}
				var row = that.find(selector);
			}
		}
		if (row)
		{
			for (var x in rowData)
			{
				if (x == 'DT_RowClass')
				{
					jQuery(row).attr('class', '');
					jQuery(row).addClass(rowData[x]);
				}
				else if (x != 'DT_RowData')
				{
					jQuery(row).find('td:eq(' + x + ')').html(rowData[x]);
				}
			}
		}
		row = null;
	}

	this.modalAction = function (action, target, data)
	{
		if (target)
		{
			data['id'] = target;
		}

		JSONParser.request(
			action
			, data
			, function (data)
			{
				if (data.saved)
				{
					if (typeof that.rowUpdateFunction === 'function')
					{
						data = that.rowUpdateFunction(data);
					}

					that.updateRow(data.saved);
				}

				if (data.deleted)
				{
					if (typeof that.rowUpdateFunction === 'function')
					{
						data.deleted = that.rowUpdateFunction(data.deleted);
					}

					for (var x in data.deleted)
					{
						if (x == 'DT_RowData')
						{
							var selector = 'tr';
							for (var z in data.deleted['DT_RowData'])
							{
								selector += '[data-' + z + '="' + data.deleted['DT_RowData'][z] + '"]';
							}
							var row = that.find(selector);
						}
					}
					if (row)
					{
						if (data.deletedRowMessage)
						{
							row.html('<td colspan="' + row.find('td').length + '">' + data.deletedRowMessage + '</td>');
						}
						else
						{
							row.remove();
						}
					}
					row = null;
				}

				if (data.modalError || data.modalSuccess)
				{
					if (data.modalError)
					{
						jQuery('.modal.in .modal-alerts').alerts('error', data.modalError);
					}

					if (parsed.modalSuccess)
					{
						jQuery('.modal.in .modal-alerts').alerts('success', data.modalSuccess);
					}
				}
				else
				{
					jQuery('.modal.in').modal('hide');
				}

				if (data.modalFieldsErrors)
				{
					for (x in data.modalFieldsErrors)
					{
						if (data.modalFieldsErrors[x])
						{
							that.addErrorField(jQuery('.modal.in'), x, data.modalFieldsErrors[x]);
						}
					}
				}
			}
		);
	}

	this.on('click', '*[data-modal-action]', function (event)
	{
		event.preventDefault();

		if (jQuery(this).hasClass('disabled'))
		{
			return false;
		}

		var action = jQuery(this).attr('data-modal-action');

		var target = jQuery(this).attr('data-modal-target');

		var data = jQuery(this).closest('.modal').MGGetForms();

		that.modalAction(action, target, data);
	});

	return this;
}

jQuery.fn.MGresetInputData = function ()
{

	jQuery(this).find('input,select,textarea').each(function ()
	{

		if (!jQuery(this).is(':disabled') && jQuery(this).attr('name') !== undefined && jQuery(this).attr('name') !== false)
		{

			var name = jQuery(this).attr('name');
			name = name.replace("[]", "");

			if (jQuery(this).attr('type') == 'checkbox')
			{
				$(this).prop('checked', false);
			}
			else
			{

				$(this).val('');
			}

		}


	});
}  