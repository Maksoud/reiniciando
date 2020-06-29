<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Knowledges */
/* File: src/Template/Knowledges/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('ID') ?></label><br>
            <?= str_pad($knowledge['id'], 6, '0', STR_PAD_LEFT) ?>
        </div>
        <div class="form-group">
            <label><?= __('Descrição') ?></label><br>
            <?= h($knowledge->title) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($knowledge->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($knowledge->modified) ?></span>
        </div>
    </div>
    
</div>