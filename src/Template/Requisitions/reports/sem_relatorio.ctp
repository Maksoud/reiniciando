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

<?php 
    $this->layout = 'layout-clean';
?>

<div class="col-xs-12 main">
    <?= $this->element('report-header'); ?>
    
    <h4 class="page-header"><span class="text-bold"><?= __('Ops!') ?></span></h4>
    
    <div class="pull-4 bottom-20">
        <?=  '<h4 class="text-center">'.__('Não há relatório desenvolvido para o filtro selecionado.').'</h4>' ?>
    </div>
</div>