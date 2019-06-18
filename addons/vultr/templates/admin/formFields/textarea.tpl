{if $enableLabel}
	<label for="{$formName}_{$name}" class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}">
	<textarea {if $id} id="{$id}" {elseif $addIDs}id="{$addIDs}_{$name}"{/if} name="{$nameAttr}" class="form-control"
																			  placeholder="{if $enablePlaceholder}{$MGLANG->T('placeholder')}{/if}" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>{$value}</textarea>
	{if $enableDescription}
		<span class="help-block">{$MGLANG->T('description')}</span>
	{/if}
	<span class="help-block error-block" {if !$error}style="display:none;"{/if}>{$error}</span>
</div>