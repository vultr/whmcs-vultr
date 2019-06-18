{if $enableLabel}
    <label class="col-sm-3 control-label"></label>
{/if}
    <div class="col-sm-{$colWidth} {$additinalClass}">
        <button {if $addIDs}id="{$addIDs}_{$name}"{/if} type="submit" name="{$nameAttr}" value="{$value}" class="btn btn-{$color}" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>{if $icon}<i class="glyphicon glyphicon-{$icon}"></i> {/if}{if $enableContent}{$MGLANG->T('label')}{/if}</button>
    </div>