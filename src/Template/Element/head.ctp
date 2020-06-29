<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

use Cake\Core\Configure;
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
    
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<?= $this->Html->css(['AdminLTE.min', //Theme style
                      'skins/skin-'. Configure::read('Theme.skin') .'.min', /* AdminLTE Skins. Choose a skin from the css/skins
                                                                            folder instead of downloading all of them to reduce the load. */
                      //Bootstrap
                      'bootstrap-tagsinput-typeahead',
                      'bootstrap.min',
                      'bootstrap-datepicker3.min',
                      'bootstrap-multiselect.min',
                      //Extras
                      //'dashboard.min',
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
<?= $this->Html->script(['analystics']) ?>

<!--Fonte utilizada no 'Você sabia?' e login-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet" type="text/css">

<title>
    <?= __('Reiniciando Sistemas') ?>
</title>

<!--<? $this->fetch('title') ?>-->

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->