{if $enableLabel}
    <label for="{$addIDs}_{$name}" class="col-sm-3 control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}" >
    <div class="onoffswitch onoffswitch-{$addIDs}_{$name}">
        <input type="checkbox" name="{$nameAttr}" class="onoffswitch-checkbox" id="{$addIDs}_{$name}" value="true" {if $value}checked{/if}>
        <label class="onoffswitch-label" for="{$addIDs}_{$name}">
            <span class="onoffswitch-inner" data-before="{$MGLANG->T('enabled')}" data-after="{$MGLANG->T('disabled')}"></span>
            <span class="onoffswitch-switch"></span>
        </label>
    </div>
  {if $enableDescription}
    <span class="help-block">{$MGLANG->T('description')}</span>
  {/if}
    <span class="help-block error-block"{if !$error}style="display:none;"{/if}>{$error}</span>
</div>