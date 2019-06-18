{**********************************************************************
* QuickBooksDesktop product developed. (2016-01-13)
* *
*
*  CREATED BY MODULESGARDEN       ->       http://modulesgarden.com
*  CONTACT                        ->       contact@modulesgarden.com
*
*
* This software is furnished under a license and may be used and copied
* only  in  accordance  with  the  terms  of such  license and with the
* inclusion of the above copyright notice.  This software  or any other
* copies thereof may not be provided or otherwise made available to any
* other person.  No title to and  ownership of the  software is  hereby
* transferred.
*
*
**********************************************************************}

{**
* @author Paweł Kopeć <pawelk@modulesgarden.com>
*}
{if $category.loginUrl}
<a href="{$category.loginUrl}" target="blank" data-toggle="tooltip"   data-toggle="tooltip" class="btn btn-sm btn-success buttonInGroup"
    title="{$MGLANG->T('actionButtons','Login In')}"> <i class="glyphicon glyphicon-upload"></i>     
</a>
{/if}
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-details" data-modal-target="{$id}"  data-toggle="tooltip" class="btn btn-sm btn-info buttonInGroup"
    title="{$MGLANG->T('actionButtons','details')}"> <i class="glyphicon glyphicon-file"></i>     
</button>
{if $isAdminPermission}
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-edit-entity" data-modal-target="{$id}"  data-toggle="tooltip" class="btn btn-sm btn-warning buttonInGroup"
    title="{$MGLANG->T('actionButtons','edit')}"> <i class="glyphicon glyphicon-pencil"></i>     
</button>
<button  data-toggle="tooltip" type="button"  data-modal-id="mg-modal-delete-entity" data-modal-target="{$id}" data-modal-title="{$title}"
        class="btn btn-sm btn-danger buttonInGroup" title="{$MGLANG->T('actionButtons','delete')}"><i class="glyphicon glyphicon-remove"></i>
</button>
{/if}