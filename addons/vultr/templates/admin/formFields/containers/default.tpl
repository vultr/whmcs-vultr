<form class="form-horizontal normal-form" action="{$url}" method="post">
    <div class="form-group">
        <div class="col-lg-12">
            <legend>{$MGLANG->T('header')}</legend>
        </div>
    </div>
    {foreach from=$hidden item=field}
        {$field->html}
    {/foreach}
    {foreach from=$fields item=field}
            {if $field->opentag}
                <div class="form-group {if $field->error}has-error{/if}">
            {/if}
              {$field->html}
            {if $field->closetag}
                </div>
            {/if}
    {/foreach}
</form>