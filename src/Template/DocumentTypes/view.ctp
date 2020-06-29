<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* DocumentTypes */
/* File: src/Template/DocumentTypes/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Tipo de Documento') ?></label><br>
            <?= $documentType->title ?>
        </div>
        <div class="form-group">
            <label><?= __('Agrupa Pagamentos') ?></label><br>
            <?= $documentType->vinculapgto == 'S' ? __('Sim') : __('Não'); ?>
        </div>
        <div class="form-group">
            <label><?= __('Duplica Documento') ?></label><br>
            <?= $documentType->duplicadoc == 'S' ? __('Sim') : __('Não'); ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Cards->status($documentType->status) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($documentType->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($documentType->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($documentType->username) ?></span>
        </div>
    </div>
    
</div>