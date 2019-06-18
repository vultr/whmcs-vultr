{**********************************************************************
* MGMF product developed. (2016-02-09)
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
<div class="box light">
    <div class="row">
        <div class="col-lg-12" id="mg-categories-content" >
            <table class="table table-hover" id="mg-data-list" >
                <thead>
                    <tr>
                        <th>{$MGLANG->T('Name')}</th>
                        <th>{$MGLANG->T('Description')}</th>
                        <th style="width: 150px; text-align: center;">{$MGLANG->T('Actions')}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody> 
            </table>
            <div class="well well-sm" style="margin-top:10px;">
                <button class="btn btn-success btn-inverse icon-left" type="button"  data-toggle="modal" data-target="#mg-modal-add-new">               
                    <i class="glyphicon glyphicon-plus"></i>
                    {$MGLANG->T('Add Category')}
                </button>
            </div>    
            {*Modal mg-modal-new-entity*}
            <form data-toggle="validator" role="form" id="mg-form-add-new">
                <div class="modal fade bs-example-modal-lg" id="mg-modal-add-new" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">{$MGLANG->T('Add New Category')} <strong></strong></h4>
                            </div>
                            <div class="modal-loader" style="display:none;"></div>

                            <div class="modal-body">
                                <input type="hidden" name="id" data-target="id" value="">
                                <div class="modal-alerts">
                                    <div style="display:none;" data-prototype="error">
                                        <div class="note note-danger">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                            <strong></strong>
                                            <a style="display:none;" class="errorID" href=""></a>
                                        </div>
                                    </div>
                                    <div style="display:none;" data-prototype="success">
                                        <div class="note note-success">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                            <strong></strong>
                                        </div>
                                    </div>
                                </div>
                                {$formCategory}
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" data-modal-action="save" id="pm-modal-addip-button-add">{$MGLANG->T('modal','Add')}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            {*Modal mg-modal-edit*}
            <form data-toggle="validator" role="form" id="mg-form-entity-edit">
                <div class="modal fade bs-example-modal-lg" id="mg-modal-edit-entity" data-modal-load="detail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title">{$MGLANG->T('Edit Category')} <strong data-modal-var="username"></strong></h4>
                            </div>
                            <div class="modal-loader" style="display:none;"></div>

                            <div class="modal-body">
                                <input type="hidden" name="id" data-target="id" value="">
                                <div class="modal-alerts">
                                    <div style="display:none;" data-prototype="error">
                                        <div class="note note-danger">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                            <strong></strong>
                                            <a style="display:none;" class="errorID" href=""></a>
                                        </div>
                                    </div>
                                    <div style="display:none;" data-prototype="success">
                                        <div class="note note-success">
                                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                            <strong></strong>
                                        </div>
                                    </div>
                                </div>
                                {$formCategoryEdit}
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" data-modal-action="save" id="pm-modal-addip-button-add">{$MGLANG->T('Save')}</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>      
            {*Modal mg-modal-delete-account*}
            <div class="modal fade bs-example-modal-lg" id="mg-modal-delete-entity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">{$MGLANG->T('modal','Delete Category')} <strong data-modal-title=""></strong></h4>
                        </div>
                        <div class="modal-loader" style="display:none;"></div>

                        <div class="modal-body">
                            <input type="hidden" name="id" data-target="id" value="">
                            <div class="modal-alerts">
                                <div style="display:none;" data-prototype="error">
                                    <div class="note note-danger">
                                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                        <strong></strong>
                                        <a style="display:none;" class="errorID" href=""></a>
                                    </div>
                                </div>
                                <div style="display:none;" data-prototype="success">
                                    <div class="note note-success">
                                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                                        <strong></strong>
                                    </div>
                                </div>
                            </div>
                            <div style="margin: 30px; text-align: center;">

                                <div>{$MGLANG->T('Are you sure you want to delete this entry from categories list?')} </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-modal-action="delete" id="pm-modal-addip-button-add">{$MGLANG->T('modal','delete')}</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{$MGLANG->T('modal','close')}</button>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var mgDataTable;

            jQuery(document).ready(function () {
                mgDataTable = $('#mg-data-list').dataTable({
                    processing: false,
                    searching: true,
                    autoWidth: false,
                    "serverSide": false,
                    "order": [[0, "desc"]],
                    ajax: function (data, callback, settings) {
                        JSONParser.request(
                                'list'
                                , {
                                    filter: {}
                                    , limit: data.length
                                    , offset: data.start
                                    , order: data.order
                                    , search: data.search
                                }
                        , function (data) {
                            callback(data);
                        }
                        );
                    },
                    'columns': [
                                , null
                                , {orderable: false}

                    ],
                    'aoColumnDefs': [{
                            'bSortable': false,
                            'aTargets': ['nosort']
                        }],
                    language: {
                        "zeroRecords": "{/literal}{$MGLANG->absoluteT('Nothing to display')}{literal}",
                        "infoEmpty": "",
                        "search": "{/literal}{$MGLANG->absoluteT('Search')}{literal}",
                        "paginate": {
                            "previous": "{/literal}{$MGLANG->absoluteT('Previous')}{literal}"
                            , "next": "{/literal}{$MGLANG->absoluteT('Next')}{literal}"
                        }
                    }
                });

                $('#mg-categories-content').MGModalActions();
                $('#mg-modal-delete-entity, #mg-form-add-new').on('hidden.bs.modal', function () {
                    var api = mgDataTable.api();
                    api.ajax.reload(function () {
                    }, false);
                });
            });
        });
    </script>

{/literal}