{if $enableLabel}
    <label class="col-sm-3 control-label">
        {if $textLabel}{$MGLANG->T('label')}{/if}
    </label>
{/if}
    <div class="col-sm-{$colWidth} {$additinalClass}">
        <button type="button" name="{$nameAttr}" value="{$name}" class="btn btn-{$color}" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach}>{if $icon}<i class="glyphicon glyphicon-{$icon}"></i> {/if}{if $enableContent}{$MGLANG->T('content')}{/if}</button>
    </div>