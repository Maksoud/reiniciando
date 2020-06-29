<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Banks */
/* File: src/Template/Banks/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Título') ?></label><br>
            <?= $bank->title ?>
        </div>
        <div class="form-group">
            <label><?= __('Tipo de Conta') ?></label><br>
            <?= $this->Banks->tipoconta($bank->tipoconta) ?>
        </div>
        <div class="form-group">
            <label><?= __('Emite Cheque') ?></label><br>
            <?= $bank->emitecheque == 'S' ? __('Sim') : __('Não'); ?>
        </div>
    </div>

    <div class="col-xs-12 box bg-info">
        <div class="bloco-cabecalho"><?= __('DADOS DA CONTA') ?></div>
        <div class="form-group">
            <label><?= __('Banco') ?></label><br>
            <?= $bank->numbanco.' - '.$bank->banco ?>
        </div>
        <div class="form-group">
            <label><?= __('Agência') ?></label><br>
            <?= $bank->agencia ?>
        </div>
        <div class="form-group">
            <label><?= $this->Banks->tipoconta($bank->tipoconta) ?></label><br>
            <?= $bank->conta ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Banks->status($bank->status) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($bank->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($bank->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($bank->username) ?></span>
        </div>
    </div>
    
</div>