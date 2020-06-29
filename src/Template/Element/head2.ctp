<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<?= $this->Html->charset() ?>
<?= $this->Html->meta('icon', '/favicon.png') ?>
<?= $this->Html->meta('icon', '/favicon.png', ['rel'   => 'apple-touch-icon',
                                               'type'  => 'image/png',
                                               'sizes' => '192x192'
                                              ]) ?>
<?= $this->Html->css([
                      //Bootstrap,
                      'bootstrap-tagsinput-typeahead',
                      'bootstrap.min',
                      'bootstrap-datepicker3.min',
                      'bootstrap-multiselect.min',
                      //Extras
                      'dashboard.min',
                      'maksoud.min',
                      'jquery.dataTables.min',
                      'dataTables.bootstrap.min',
                      //Fonte utilizada no ícones
                      'font-awesome.min',
                      'bootstrap-treeview.min',
	                    'joyride-2.1'
                     ])
?>

<!-- Google -->
<?= $this->Html->script('analystics') ?>

<!--Fonte utilizada no 'Você sabia?' e login-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet" type="text/css">

<title>
    <?= __('Reiniciando - Sistemas Empresariais (R2 Financeiro)') ?>
</title>

<!--<? $this->fetch('title') ?>-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->