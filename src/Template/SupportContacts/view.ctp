<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* SupportContacts */
/* File: src/Template/SupportContacts/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">

    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Ordem') ?></label><br>
            <?= str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT) ?>
        </div>
        <div class="form-group">
            <label><?= __('E-mail para resposta') ?></label><br>
            <?= h($supportContact->mail) ?>
        </div>
        <div class="form-group">
            <label><?= __('Assunto') ?></label><br>
            <?= h($supportContact->title) ?>
        </div>
        <div class="form-group">
            <label><?= __('Descrição da Solicitação') ?></label><br>
            <?= h($supportContact->descricao) ?>
        </div>
    </div>

    <?php if ($supportContact->status != 'A') { ?>
    <div class="col-xs-12 panel-group box bg-info">
        <div class="form-group">
            <label><?= __('Resposta') ?></label><br>
            <?= h($supportContact->resposta) ?>
        </div>
    </div>
    <?php }//if ($supportContact->status != 'A') ?>
    
    <div class="col-xs-12 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->SupportContacts->status($supportContact->status) ?><br>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($supportContact->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($supportContact->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($supportContact->username) ?></span>
        </div>
    </div>
</div>