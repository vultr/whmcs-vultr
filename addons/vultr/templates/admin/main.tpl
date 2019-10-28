<div class="mg-wrapper body" data-target=".body" data-spy="scroll" data-twttr-rendered="true">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=all" rel="stylesheet"
		  type="text/css"/>
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/font-awesome.css"/>
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/simple-line-icons.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/uniform.default.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/components-rounded.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/jquery.dataTables.css"/>
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/select2.min.css"/>
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/onoffswitch.css"/>
	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/jquery-ui.min.css"/>

	<link rel="stylesheet" type="text/css" href="{$assetsURL}/css/mg-style.css" rel="stylesheet">
	<script type="text/javascript" src="{$assetsURL}/js/mgLibs.js"></script>
	{if !$isWHMCS6}
		<script type="text/javascript" src="{$assetsURL}/js/bootstrap.js"></script>
	{/if}
	<script type="text/javascript" src="{$assetsURL}/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="{$assetsURL}/js/dataTables.bootstrap.js"></script>
	<script type="text/javascript" src="{$assetsURL}/js/select2.full.min.js"></script>
	<script type="text/javascript" src="{$assetsURL}/js/bootstrap-hover-dropdown.min.js"></script>
	<script type="text/javascript" src="{$assetsURL}/js/jquery-ui.min.js"></script>
	<script src="{$assetsURL}/js/validator.js" type="text/javascript"></script>
	<script type="text/javascript">
		JSONParser.create('{$JSONCurrentUrl}');
		{literal}
		jQuery(document).ready(function ()
		{
			$("input[data-datepicker]").datepicker({
				dateFormat: 'yy-mm-dd'
			});

			//used to change positioning inside of module navbar
			var navbar_in_two_lines = false;
			var navbar_width_hide_names = 0;
			var resized_logo = false;
			var mg_logo = jQuery('.logo-default').attr("src");
			var mg_logo_cog = mg_logo.replace("mg-logo.png", "mg-logo-cog.png");

			function NavigationSet()
			{
				var navbar_height = jQuery('.page-header').height();

				if (jQuery('.page-header').width() <= (jQuery('.nav-menu').width() + jQuery('.modulename-logo').width() + jQuery('.modulename > a').width() + 40) && !navbar_in_two_lines)
				{
					jQuery('.page-container').addClass('centered');
					navbar_in_two_lines = true;
				}
				else if (jQuery('.page-header').width() > (jQuery('.nav-menu').width() + jQuery('.modulename-logo').width() + jQuery('.modulename > a').width() + 40) && navbar_in_two_lines && !navbar_width_hide_names && !resized_logo)
				{
					jQuery('.page-container').removeClass('centered');
					navbar_in_two_lines = false;
				}

				//check if short logo should be shown
				if (jQuery('.line-separator').width() <= (jQuery('.nav-menu').width() + jQuery('.modulename-logo').width()) && !resized_logo && !navbar_width_hide_names)
				{
					jQuery('.logo-default').attr("src", mg_logo_cog);
					resized_logo = true;
					//switch back logo to its full form
				}
				else if (jQuery('.line-separator').width() > (jQuery('.nav-menu').width() + 159) && resized_logo && !navbar_width_hide_names)
				{
					jQuery('.logo-default').attr("src", mg_logo);
					resized_logo = false;
				}

				//  hide page names from navigation bar
				if (jQuery('.line-separator').width() <= (jQuery('.nav-menu').width() + jQuery('.modulename-logo').width()) && resized_logo)
				{
					navbar_width_hide_names = jQuery('.page-header').width();
					jQuery('.navbar-nav').addClass('short');
					//  show page names from navigation bar
				}
				else if (navbar_width_hide_names < jQuery('.page-header').width() && navbar_width_hide_names != 0)
				{
					jQuery('.navbar-nav').removeClass('short');
					navbar_width_hide_names = 0;
				}
			}

			$(document).ready(NavigationSet);
			$(window).resize(NavigationSet);
		});




		{/literal}
	</script>

	<div class="full-screen-module-container">
		<div class="page-header">
			<div class="top-menu">
				<div class="page-container">
					<div class="modulename">
						<a href="{$mainURL}">{$mainName}</a>
					</div>
					<div class="line-separator"></div>
					<div class="nav-menu">
						<ul class="nav navbar-nav">
							{foreach from=$menu key=catName item=category}
								{if $category.submenu}
									<li class="menu-dropdown">
										{if $category.disableLink}
											<a href="#" data-hover="dropdown" data-close-others="true">
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
															{if $subCategory.icon}<i
																class="{$subCategory.icon}"></i>{/if}
															{if $subCategory.label}
																{$subCategory.label}
															{else}
																{$MGLANG->T('pagesLabels',$catName,$subCatName)}
															{/if}
														</a>
													{else}
														<a href="{$subCategory.url}">
															{if $subCategory.icon}<i
																class="{$subCategory.icon}"></i>{/if}
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
										<a href="{if $category.externalUrl}{$category.externalUrl}{else}{$category.url}{/if}"
										   {if $category.externalUrl}target="_blank"{/if}>
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

					<div class="modulename-logo">
						<a href="https://www.vultr.com" target="_blank"><img
									src="{$assetsURL}/img/logo_vultrondark.svg" alt="logo" class="logo-default"></a>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="page-container">
			<div class="row-fluid" id="MGAlerts">
				{if $error}
					<div class="note note-danger">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
									class="sr-only"></span></button>
						<p><strong>{$error}</strong></p>
					</div>
				{/if}
				{if $success}
					<div class="note note-success">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
									class="sr-only"></span></button>
						<p><strong>{$success}</strong></p>
					</div>
				{/if}
				<div style="display:none;" data-prototype="error">
					<div class="note note-danger">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
									class="sr-only"></span></button>
						<strong></strong>
						<a style="display:none;" class="errorID" href=""></a>
					</div>
				</div>
				<div style="display:none;" data-prototype="success">
					<div class="note note-success">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
									class="sr-only"></span></button>
						<strong></strong>
					</div>
				</div>
			</div>
			<div class="page-content" id="MGPage{$currentPageName}">
				<div class="container-fluid">
					<ul class="breadcrumb">
						<li>
							<a href="{$mainURL}"><i class="fa fa-home"></i></a>
						</li>
						{if $breadcrumbs[0]}
							<li>
								<a href="{$breadcrumbs[0].url}">{$MGLANG->T('pagesLabels','label', $breadcrumbs[0].name)}</a>
							</li>
						{/if}
						{if $breadcrumbs[1]}
							<li>
								<a href="{$breadcrumbs[1].url}">{$MGLANG->T('pagesLabels',$breadcrumbs[0].name,$breadcrumbs[1].name)}</a>
							</li>
						{/if}
					</ul>

					{$content}
				</div>
			</div>
		</div>
	</div>
	<div id="MGLoader" style="display:none;">
		<div>
			<img src="{$assetsURL}/img/ajax-loader.gif" alt="Loading ..."/>
		</div>
	</div>
</div>