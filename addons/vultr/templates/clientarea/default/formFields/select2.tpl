{if $enableLabel}
	<label for="{$addIDs}_{$name}" class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}">
	<select {if $multiple}multiple="multiple"{/if} {if $id} id="{$id}" {elseif $addIDs}id="{$addIDs}_{$name}"{/if}
			name="{$nameAttr}{if $multiple}[]{/if}" {if $readonly||$disabled}disabled="disabled"{/if} {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>
		{foreach from=$options item=option key=opValue}
			<option value="{$opValue}"
					{if $multiple}{if in_array($opValue,$value)}selected{/if}{else}{if $opValue==$value}selected{/if}{/if}>
				{$option}
			</option>
		{/foreach}
	</select>
	{if $readonly}
		<input type="hidden" name="{$nameAttr}" value="{$value}"/>
	{/if}
	{if $enableDescription }
		<span class="help-block">{$MGLANG->T('description')}</span>
	{/if}
	<span class="help-block error-block" {if !$error}style="display:none;"{/if}>{$error}</span>
	{literal}
	<script type="text/javascript">
		$(document).ready(function ()
		{
			$("#{/literal}{if $id}{$id}{elseif $addIDs}{$addIDs}_{$name}{/if}{literal}").select2({
				containerCssClass: ' tpx-select2-container select2-grey',
				dropdownCssClass: ' tpx-select2-drop'
			});
		});
	</script>
	{/literal}
</div>