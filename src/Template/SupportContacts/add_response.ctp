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
/* File: src/Template/SupportContacts/add_response.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($supportContact) ?>

<?= $this->Html->script(['maksoud-text.min']) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $single ?> well">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Resposta') ?>
                        </label>
                        <?= $this->Form->textarea('resposta', ['label' => false, 'id' => 'text', 'maxlength' => '300', 'type' => 'textarea', 'class' => 'form-control form-group', 'required' => true]) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Status') ?>
                        </label>
                        <?= $this->Form->control('status', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['B' => 'Respondido', 
                                                                                                                                   'F' => 'Finalizado'
                                                                                                                                  ]]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
    <?= $this->Html->link(__(' Visualizar Chamado'), ['action' => 'view', $supportContact->id], ['class' => 'btn_modal2 box-shadow scroll-modal btn btn-warning btn-shortcut fa fa-eye ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>