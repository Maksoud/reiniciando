<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* ProductGroups */
/* File: src/Template/ProductGroups/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Código') ?></label><br>
            <?= str_pad($productGroup->code, 6, '0', STR_PAD_LEFT) ?>
        </div>
        <div class="form-group">
            <label><?= __('Título') ?></label><br>
            <?= $productGroup->title ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($productGroup->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($productGroup->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($productGroup->username) ?></span>
        </div>
    </div>
    
</div>