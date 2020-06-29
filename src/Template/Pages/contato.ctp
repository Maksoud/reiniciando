<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Parameters */
/* File: src/Template/Parameters/contato.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Parameter') ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $single ?>">
                <div class="row">
                    <label class="<?= $label ?>"><?= __('Nome') ?>*</label>
                    <?= $this->Form->control('nome', ['label' => false, 'type' => 'text', 'class' => $class_input. ' focus', 'required' => true]) ?>
                </div>
                <div class="row">
                    <label class="<?= $label ?>"><?= __('E-mail') ?>*</label>
                    <?= $this->Form->control('email', ['label' => false, 'type' => 'text', 'class' => $class_input, 'required' => true]) ?>
                </div>
                <div class="row">
                    <label class="<?= $label ?>"><?= __('Assunto') ?>*</label>
                    <?= $this->Form->control('assunto', ['label' => false, 'type' => 'select', 'class' => $class_input, 'options' => ['Sugestões' => 'Sugestões',
                                                                                                                                      'Elogios'   => 'Elogios',
                                                                                                                                      'Dúvidas'   => 'Dúvidas',
                                                                                                                                      'Reparos'   => 'Reparos',
                                                                                                                                      'default'   => 'user'
                                                                                                                                     ]]); ?>
                </div>
            </div>
            <div class="<?= $single ?> well">
                <div class="row">
                    <label class="<?= $label ?>"><?= __('Mensagem') ?>*</label>
                    <?= $this->Form->textarea('mensagem', ['label' => false, 'type' => 'text', 'style' => 'height: 181px', 'class' => $class_input2, 'required' => true]) ?>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>