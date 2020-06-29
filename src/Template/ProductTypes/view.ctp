<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* ProductTypes */
/* File: src/Template/ProductTypes/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Código') ?></label><br>
            <?= str_pad($productType->code, 6, '0', STR_PAD_LEFT) ?>
        </div>
        <div class="form-group">
            <label><?= __('Título') ?></label><br>
            <?= $productType->title ?>
        </div>
        <div class="form-group">
            <label><?= __('Calcula Custo do Estoque') ?></label><br>
            <?= $this->ProductTypes->calc_cost($productType->calc_cost) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($productType->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($productType->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($productType->username) ?></span>
        </div>
    </div>
    
</div>