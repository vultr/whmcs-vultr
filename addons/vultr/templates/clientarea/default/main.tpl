<div class="mg-wrapper body" data-target=".body" data-spy="scroll" data-twttr-rendered="true">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=all" rel="stylesheet" type="text/css"/> 
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/font-awesome.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/simple-line-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/uniform.default.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/select2.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/onoffswitch.css" />
    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/jquery-ui.min.css" />

    <link rel="stylesheet" type="text/css" href="{$assetsURL}/css/mg-style.css" rel="stylesheet">    
    <script type="text/javascript" src="{$assetsURL}/js/mgLibs.js"></script>
    {if !$isWHMCS6}
    <script type="text/javascript" src="{$assetsURL}/js/bootstrap.js"></script>
    {/if}
    <script type="text/javascript" src="{$assetsURL}/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/select2.min.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/bootstrap-hover-dropdown.min.js"></script>
    <script type="text/javascript" src="{$assetsURL}/js/jquery-ui.min.js"></script>
    <script src="{$assetsURL}/js/validator.js" type="text/javascript"></script>
    <script type="text/javascript">
        JSONParser.create('{$JSONCurrentUrl}');
    </script>

    <div class="full-screen-module-container">
        <div class="">  
            <div class="top-menu">
                <div class="page-container" >
                    <div class="nav-menu">
                        <ul class="nav navbar-nav">
                            {foreach from=$menu key=catName item=category}
                                {if $category.submenu}
                                    <li class="menu-dropdown">
                                        {if $category.disableLink}
                                            <a href="#"  data-hover="dropdown" data-close-others="true" >
                                            {if $category.icon}<i class="{$category.icon}"></i>{/if}
                                            {if $category.label}
                                                {$subpage.label} 
                                            {else}
                                                <span class="mg-pages-label">{$MGLANG->T('pagesLabels','label' , $catName)}</span>
                                            {/if}
                                            <i class="fa fa-angle-down dropdown-angle"></i>
                                            </a>
                                        {else}   
                                            <a href="{$category.url}" data-hover="dropdown" data-close-others="true">
                                            {if $category.icon}<i class="{$category.icon}"></i>{/if}
                                            {if $category.label}
                                                {$subpage.label}
                                            {else}
                                                <span class="mg-pages-label">{$MGLANG->T('pagesLabels','label', $catName)}</span>
                                            {/if}
                                            <i class="fa fa-angle-down dropdown-angle"></i>
                                            </a>
                                        {/if}
                                        <ul class="dropdown-menu pull-left">
                                            {foreach from=$category.submenu key=subCatName item=subCategory}
                                                <li>
                                                    {if $subCategory.externalUrl}
                                                        <a href="{$subCategory.externalUrl}" target="_blank">
                                                        {if $subCategory.icon}<i class="{$subCategory.icon}"></i>{/if} 
                                                        {if $subCategory.label}
                                                            {$subCategory.label}
                                                        {else}
                                                            {$MGLANG->T('pagesLabels',$catName,$subCatName)}
                                                        {/if}
                                                        </a>
                                                    {else}
                                                        <a href="{$subCategory.url}">
                                                        {if $subCategory.icon}<i class="{$subCategory.icon}"></i>{/if} 
                                                        {if $subCategory.label}
                                                            {$subCategory.label}
                                                        {else}
                                                            {$MGLANG->T('pagesLabels',$catName,$subCatName)}
                                                        {/if}
                                                    </a>
                                                    {/if}
                                                </li>
                                            {/foreach}
                                        </ul>
                                    </li>
                                {else}
                                    <li>
                                        <a href="{if $category.externalUrl}{$category.externalUrl}{else}{$category.url}{/if}" {if $catName ==$currentPageName}class="active"{/if} {if $category.externalUrl}target="_blank"{/if}>
                                            {if $category.icon}<i class="{$category.icon}"></i>{/if} 
                                            {if $category.label}
                                                <span>{$subpage.label}</span>
                                            {else}
                                                <span>{$MGLANG->T('pagesLabels', 'label', $catName)}</span>
                                            {/if}
                                        </a>
                                    </li>
                                {/if}
                            {/foreach}
                        </ul>
                    </div> 
                </div>
            </div>
        </div>
        <div class="clearfix"></div>              
        <div class="page-container">
            <div class="row-fluid" id="MGAlerts">
                {if $error}
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                        <p><strong>{$error}</strong></p>
                    </div>
                {/if}
                {if $success}
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                        <p><strong>{$success}</strong></p>
                    </div>
                {/if}
                <div style="display:none;" data-prototype="error">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                        <strong></strong>
                        <a style="display:none;" class="errorID" href=""></a>
                    </div>
                </div>
                <div style="display:none;" data-prototype="success">
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
                        <strong></strong>
                    </div>
                </div>
            </div>
            <div class="page-content" id="MGPage{$currentPageName}">
                <div class="container-fluid">
                    
                    {$content}
                </div>
            </div>
        </div>
    </div>
    <div id="MGLoader" style="display:none;" >
        <div>
            <img src="{$assetsURL}/img/ajax-loader.gif" alt="Loading ..." />
        </div>
    </div>   
</div>