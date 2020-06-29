<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Users */
/* File: src/Template/Users/login2.ctp */
?>

<?php $this->layout = 'layout-clean'; ?>

<div class="main well col-xs-offset-2 col-xs-8 col-sm-offset-3 col-sm-5 col-md-offset-4 col-md-4 col-lg-3">
    <div class="text-center">
        <?= $this->Html->image("Reiniciando.png", ['style' => 'width: 200px; margin-bottom: 10px; margin-left:-15px;']) ?>
    </div>
    <?= $this->Session->flash() ?>
    <?= $this->Form->create('User') ?>
    <h4 class="text-nowrap"><?= __('Entrar no Sistema') ?></h4>
    <div class="form-group">
        <?= $this->Form->control('username', array('label' => false, 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Usuário ou E-mail', 'div' => ['class' => 'input-group'], 'after' => '<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>')) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->control('password', array('label' => false, 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Senha', 'div' => ['class' => 'input-group'], 'after' => '<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>')) ?>
    </div>
    <?= $this->Form->end(['label' => 'Entrar', 'class' => 'btn btn-default btn-block']) ?>
    <span class="font-12">
        <span class="pull-left"><?= $this->Html->link(__('Cadastre-se'), ['controller' => 'Parameters', 'action' => 'register'], [' class="btn_modal" data-loading-text="Carregando..." data-title=""']) ?></span>
        <span class="pull-right"><?= $this->Html->link(__('Recuperar Senha'), ['controller' => 'Users', 'action' => 'reenviaSenha'], [' class="btn_modal" data-loading-text="Carregando..." data-title=""']) ?></span>
    </span>
</div>
<?= $this->element('modal') ?>
