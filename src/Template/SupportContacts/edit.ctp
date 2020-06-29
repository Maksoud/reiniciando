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
/* File: src/Template/SupportContacts/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($supportContact) ?>

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
                            <?= __('Assunto') ?>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'maxlength' => '120', 'class' => $input.' focus', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Solicitação') ?>
                        </label>
                        <?= $this->Form->textarea('descricao', ['label' => false, 'id' => 'text', 'maxlength' => '300', 'type' => 'textarea', 'class' => 'form-control form-group', 'required' => true]) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                    </div>
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