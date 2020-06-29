<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Costs */
/* File: src/Template/Costs/view.ctp */
?>

<!-- File: src/Template/Costs/.ctp -->
<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Título') ?></label><br>
            <?= $cost->title ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Cards->status($cost->status) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($cost->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($cost->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($cost->username) ?></span>
        </div>
    </div>
    
</div>