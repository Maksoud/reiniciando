<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Layout/layout-clean.ctp */
?>

<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
    </head>
    <body>
        <div class="bg_ajax hide">
            <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br><br>
            Carregando
        </div>
        <div id="container">
            <div id="content">
                <div class="col-xs-12 text-nowrap">
                    <?= $this->Flash->render() ?>
                </div>
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <footer>
            <div id="footer"><?= $this->element('footer') ?></div>
        </footer>
    </body>
</html>