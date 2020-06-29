<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Layout/default.ctp */
?>

<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <div class="bg_ajax">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
            Carregando
        </div>
        <header>
            <div class="container-fluid aSemUnderline" id="header">
                <?= $this->element('navbar-up') ?>
            </div>
        </header>
        <div class="container-fluid">
            <div class="col-sm-offset-3 col-md-offset-2 text-nowrap">
                <?= $this->Flash->render() ?>
            </div>
            <?= $this->fetch('content') ?>
            <?= $this->element('modal') ?>
            <?= $this->element('chat') ?>
        </div>
        <footer>
            <div id="footer"><?= $this->element('footer') ?></div>
        </footer>
    </body>
</html>