<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Layout/default-lte.ctp */

use Cake\Core\Configure;
?>

<!DOCTYPE html>
<html>

    <head>
        <?= $this->element('head') ?>
    </head>

    <body class="hold-transition skin-<?= Configure::read('Theme.skin'); ?> sidebar-mini" style="padding-top:0px;">

        <div class="bg_ajax">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
            Carregando
        </div>

        <!-- Site wrapper -->
        <div class="wrapper" style="background-color:#ecf0f5;">

            <header class="main-header">

                <!-- Logo -->
                <!--<a href="<?= $this->Url->build('/'); ?>" class="logo" style="background-color:#ecf0f5;">-->
                <span class="logo" style="background-color:#ecf0f5;">
                    <span class="logo-mini">
                        <?= $this->Html->link($this->Html->image("Reiniciando.png", ['alt'   => 'logomarca',
                                                                                     'style' => 'margin:-10px;width:138px;clip-path:inset(0px 108px 0px 0px); -webkit-clip-path: inset(0px 108px 0px 0px);'
                                                                                    ]), 
                                                                                    ['controller' => 'UsersParameters', 
                                                                                     'action'     => 'changeParameter'
                                                                                    ], 
                                                                                    ['class'             => 'btn btn_modal font-16', 
                                                                                     'data-size'         => 'sm', 
                                                                                     'data-loading-text' => '', 
                                                                                     'data-title'        => __('Mudar de Perfil'),
                                                                                     'escape'            => false
                                                                                    ]); ?>
                    </span>
                    <span class="logo-lg">
                        <?= $this->Html->link($this->Html->image("Reiniciando.png", ['alt'   => 'logomarca',
                                                                                     'style' => 'width:142px;margin-top:-13px;'
                                                                                    ]), 
                                                                                    ['controller' => 'UsersParameters', 
                                                                                     'action'     => 'changeParameter'
                                                                                    ], 
                                                                                    ['class'             => 'btn btn_modal font-16', 
                                                                                     'data-size'         => 'sm', 
                                                                                     'data-loading-text' => '', 
                                                                                     'data-title'        => __('Mudar de Perfil'),
                                                                                     'escape'            => false
                                                                                    ]); ?>
                    </span>
                </span>
                <span id="logo" data-url="<?= $this->Url->build('/', true)?>"></span>

                <!-- Header Navbar: style can be found in header.less -->
                <?= $this->element('nav-top') ?>

            </header>

            <!-- Left side column. contains the sidebar -->
            <?= $this->element('aside-main-sidebar'); ?>

            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <div class="text-nowrap">
                    <?= $this->Flash->render(); ?>
                    <?= $this->Flash->render('auth'); ?>
                </div>
                
                <?= $this->fetch('content'); ?>
                <?= $this->element('modal') ?>
                <?= $this->element('chat') ?>

            </div>
            
            <!-- /.content-wrapper -->

        </div>

        <!-- ./wrapper -->

        <footer>
            <div id="footer"><?= $this->element('footer') ?></div>
        </footer>

    </body>
</html>
