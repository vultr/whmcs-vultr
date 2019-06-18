{if $enableLabel}
    <label {if $id}for="{$id}" {elseif $addIDs}for="{$addIDs}_{$name}"{/if} class="col-sm-{$labelcolWidth} control-label">{$MGLANG->T('label')}</label>
{/if}
<div class="col-sm-{$colWidth}">
    <input name="{$nameAttr}" {if $id} id="{$id}" {elseif $addIDs}id="{$addIDs}_{$name}"{/if} type="password" value="{$value}" class="form-control" {foreach from=$dataAttr key=dataKey item=dataValue}data-{$dataKey}="{$dataValue}"{/foreach} {if $addIDs}id="{$addIDs}_{$name}"{/if} placeholder="{if $enablePlaceholder}{$MGLANG->T('placeholder')}{/if}" {if $required}required{/if}>
    <div class="help-block with-errors">{$error}</div>
    {if $enableDescription }
      <span class="help-block">{$MGLANG->T('description')}</span>
    {/if}
</div>
{if $showPassword}
    <div class="col-sm-1" style="padding-left:0px; margin-top:6px;">
        <a href="#" ><i class="glyphicon glyphicon-search mgfw-button-show-password"></i></a>
    </div>
    {literal}
        <script type="text/javascript">
             jQuery(document).ready(function (){
                  $(".mgfw-button-show-password").click(function(e){
                      e.preventDefault();
                      $("#{/literal}{$id}{literal}").prop("type")=="password" ?   $("#{/literal}{$id}{literal}").prop("type", 'text') :  $("#{/literal}{$id}{literal}").prop("type", 'password')
                  });
             });
        </script>
    {/literal}
   
{/if}