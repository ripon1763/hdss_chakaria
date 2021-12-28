<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<meta name="Developed by" content="Md.Fahad Khan">
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
	 <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/autocomplite/') ?>jquery.auto-complete.css">


   <!-- SELECT2 CSS -->
   <link href="<?php echo base_url(); ?>assets/plugins/select2/v3.5.1/select2-concat.min.css" rel="stylesheet" type="text/css" />

   <!-- GLOBAL STYLE CSS -->
   <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
   
   <link href="<?php echo base_url(); ?>assets/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />


    <style>
      .error{
        color:red;
        font-weight: normal;
      }
    </style>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  <script src="<?php echo base_url();?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>

   <!-- SELECT2 JS -->
  <script src="<?php echo base_url();?>assets/plugins/select2/v3.5.1/select2.min.js"></script>

   <!-- GLOBAL JS -->
  <script src="<?php echo base_url();?>assets/js/global.js"></script>

    <script>
        var baseURL = "<?php echo base_url(); ?>";
		
		$(document).on('pjax:complete', function() {
   $(".sidebar-menu a").each(function () {
        //if (($(this).attr('href')) && (window.location.pathname.toUpperCase() === $(this).attr('href').toUpperCase())) {
        if (($(this).attr('href')) && (window.location.pathname.toUpperCase().match("^" + $(this).attr('href').toUpperCase()))) {
            $(this).parents('li').addClass('active');
            $(this).parents('ul').not('.sidebar-menu').addClass('menu-open').css({ display: 'block' });
        }
    });
})
    $(document).ready(function() {
        var url = window.location; 
        var element = $('ul.sidebar-menu a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0; }).parent().addClass('active');
        if (element.is('li')) { 
             element.addClass('active').parent().parent('li').addClass('active')
         }
    });
		
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url().'dashboard?baseID=1'; ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?php echo $this->config->item('prefix');?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?php //echo $this->config->item('prefix');?><img height="50px" style="margin-left:-40px; margin-top:-10px" src="<?php echo base_url()?>assets/images/logo_new.png"></b></span>
        </a> 
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
		 
          <div class="navbar-custom-menu">
		   <h3 class="site_name"><?php echo $this->config->item('application_name');?></h3>
            <ul class="nav navbar-nav" style="float:right">
              <!-- User Account: style can be found in dropdown.less -->
			 
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo base_url(); ?>assets/dist/img/avatar.png" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer" style="background:#47A3AD">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>user/loadChangePass?baseID=1" class="btn btn-default btn-flat">Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>dashboard/logout?baseID=1" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php 
			
			 //echo $url = $_SERVER['REQUEST_URI'];
			
			function create_list( $arr ,$urutan)
			{
				if($urutan==0){
					 $html = "\n<ul class='sidebar-menu'>\n";
				}else
				{
					 $html = "\n<ul class='treeview-menu'>\n";
				}
				foreach ($arr as $key=>$v)
				{
					if (array_key_exists('children', $v))
					{
						$html .= "<li class='treeview'>\n";
						$html .= '<a href="#">
										<i class="'.$v['icon'].'"></i>
										<span>'.$v['menu_item_name'].'</span>
										<i class="fa fa-angle-left pull-right"></i>
									</a>';
		 
						$html .= create_list($v['children'],1);
						$html .= "</li>\n";
					}
					else{
							$html .= '<li><a href= "'. base_url().$v['url'].'?baseID='.$v['menu_item_id'].'">';
							if($urutan==0)
							{
								$html .=    '<i class="'.$v['icon'].'"></i>';
							}
							if($urutan==1)
							{
								$html .=    '<i class="fa fa-angle-double-right"></i>';
							}
							$html .= $v['menu_item_name']."</a></li>\n";}
				}
				$html .= "</ul>\n";
				return $html;
			}
	   ?>
	    <?php echo create_list($menu, 0) ?>
        </section>
        <!-- /.sidebar -->
      </aside>
	  <style>
	   .main-header .navbar-custom-menu, .main-header .navbar-right {float:none}
	   .site_name {float:left; margin-bottom:0px; margin-top:12px; color:#fff; text-align:center; font-family:FSLolaWeb}
	   
	   @media only screen and (max-width: 550px) {
			.site_name {display:none}
		}
	  </style>