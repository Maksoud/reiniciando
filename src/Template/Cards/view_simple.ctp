<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Cards */
/* File: src/Template/Cards/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Descrição') ?></label><br>
            <?= $card->title ?>
        </div>
        <div class="form-group">
            <label><?= __('Bandeira') ?></label><br>
            <?= $card->bandeira ?>
        </div>
        <div class="form-group">
            <label><?= __('Dia de Vencimento') ?></label><br>
            <?= $card->vencimento ?>
        </div>
        <div class="form-group">
            <label><?= __('Melhor dia de Compra') ?></label><br>
            <?= $card->melhor_dia ?>
        </div>
        <div class="form-group">
            <label><?= __('Limite de Crédito') ?></label><br>
            <?= $this->Number->precision($card->limite, 2) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Cards->status($card->status) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($card->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($card->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($card->username) ?></span>
        </div>
    </div>
    
</div>