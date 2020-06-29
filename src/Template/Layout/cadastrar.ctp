<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Layout/cadastrar.ctp */

use Cake\Core\Configure;
?>

<!DOCTYPE html>
<html>
    <head>
        <?= $this->element('head') ?>
        <?= $this->Html->css(['login.min']) ?>
    </head>
    <body>
        <div class="container-fluid bg_login">
            <?= $this->fetch('content') ?>
        </div>
        <footer>
            <?= $this->Html->script(['jquery-2.2.4.min',
                                     //Bootstrap
                                     'bootstrap.min',
                                     //AdminLTE
                                     'app.min',
                                    ]) ?>
        </footer>
    </body>
</html>