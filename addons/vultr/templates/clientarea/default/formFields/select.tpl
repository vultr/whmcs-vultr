{if $enableLabel}
	<label for="{$formName}_{$name}" class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}">
	<select class="form-control" {if $id} id="{$id}" {elseif $addIDs}id="{$addIDs}_{$name}"{/if}
			name="{$nameAttr}" {if $readonly||$disabled}disabled="disabled"{/if} {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>
		{foreach from=$options item=option key=opValue}
			<option value="{$opValue}" {if $opValue==$value}selected{/if}>
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
</div>