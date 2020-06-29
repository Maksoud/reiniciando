<?php use Cake\Core\Configure; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo Configure::read('Theme.title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('AdminLTE./bootstrap/css/bootstrap.min'); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?php echo $this->Html->css('AdminLTE.AdminLTE.min'); ?>
    <?php echo $this->Html->css('AdminLTE.skins/skin-'. Configure::read('Theme.skin') .'.min'); ?>
    <?php echo $this->Html->css('AdminLTE.documentation'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-<?php echo Configure::read('Theme.skin'); ?> fixed" data-spy="scroll" data-target="#scrollspy">
    <div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <!-- Logo -->
        <a href="<?php echo $this->Url->build('/'); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><?php echo Configure::read('Theme.logo.mini'); ?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><?php echo Configure::read('Theme.logo.large'); ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li><a href="http://almsaeedstudio.com">Almsaeed Studio</a></li>
              <li><a href="http://almsaeedstudio.com/premium">Premium Templates</a></li>
            </ul>
          </div>
        </nav>
    </header>
      <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <div class="sidebar" id="scrollspy">

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="nav sidebar-menu">
            <li class="header">TABLE OF CONTENTS</li>
            <li class="active"><a href="#introduction"><i class="fa fa-circle-o"></i> Introduction</a></li>
            <li><a href="#download"><i class="fa fa-circle-o"></i> Download</a></li>
            <li><a href="#dependencies"><i class="fa fa-circle-o"></i> Dependencies</a></li>
            <li><a href="#advice"><i class="fa fa-circle-o"></i> Advice</a></li>
            <li><a href="#layout"><i class="fa fa-circle-o"></i> Layout</a></li>
            <li><a href="#adminlte-options"><i class="fa fa-circle-o"></i> Javascript Options</a></li>
            <li class="treeview" id="scrollspy-components">
              <a href="javascript:void(0)"><i class="fa fa-circle-o"></i> Components</a>
              <ul class="nav treeview-menu">
                <li><a href="#component-main-header">Main Header</a></li>
                <li><a href="#component-sidebar">Sidebar</a></li>
                <li><a href="#component-control-sidebar">Control Sidebar</a></li>
                <li><a href="#component-info-box">Info Box</a></li>
                <li><a href="#component-box">Boxes</a></li>
                <li><a href="#component-direct-chat">Direct Chat</a></li>
              </ul>
            </li>
            <li><a href="#plugins"><i class="fa fa-circle-o"></i> Plugins</a></li>
            <li><a href="#browsers"><i class="fa fa-circle-o"></i> Browser Support</a></li>
            <li><a href="#upgrade"><i class="fa fa-circle-o"></i> Upgrade Guide</a></li>
            <li><a href="#implementations"><i class="fa fa-circle-o"></i> Implementations</a></li>
            <li><a href="#faq"><i class="fa fa-circle-o"></i> FAQ</a></li>
            <li><a href="#license"><i class="fa fa-circle-o"></i> License</a></li>
          </ul>
        </div>
        <!-- /.sidebar -->
    </aside>

      <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <h1>
            AdminLTE Documentation
            <small>Version 2.3</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Documentation</li>
          </ol>
        </div>

        <!-- Main content -->
        <div class="content body">

            <?php echo $this->fetch('content'); ?>

        </div><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <?php echo $this->element('footer'); ?>

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <div class="pad">
          This is an example of the control sidebar.
        </div>
      </aside><!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <?php echo $this->Html->script('AdminLTE./plugins/jQuery/jquery-2.2.3.min'); ?>
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->script('AdminLTE./bootstrap/js/bootstrap'); ?>
    <!-- SlimScroll -->
    <?php echo $this->Html->script('AdminLTE./plugins/slimScroll/jquery.slimscroll.min'); ?>
    <!-- FastClick -->
    <?php echo $this->Html->script('AdminLTE./plugins/fastclick/fastclick'); ?>
    <!-- AdminLTE App -->
    <?php echo $this->Html->script('AdminLTE./js/app.min'); ?>
    <!-- AdminLTE for demo purposes -->
    <?php echo $this->fetch('script'); ?>
    <?php echo $this->fetch('scriptBottom'); ?>
    <?php echo $this->Html->script('https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js'); ?>
    <?php echo $this->Html->script('AdminLTE.documentation'); ?>
  </body>
</html>
