{if $enableLabel}
	<label for="{$formName}_{$name}" class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}" {if $id} id="{$id}" {elseif $addIDs}id="{$addIDs}_{$name}"{/if}>
	{foreach from=$options item=option key=opValue}
		<div class="radio">
			<label>
				<input type="radio" {if $value == $opValue}checked="checked"{/if} name="{$nameAttr}"
					   value="{$opValue}" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}/>
				{$option}
			</label>
		</div>
	{/foreach}
	<span class="help-block error-block" {if !$error}style="display:none;"{/if}>{$error}</span>
</div>