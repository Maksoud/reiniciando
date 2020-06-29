<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* UsersParameters */
/* File: src/Template/UsersParameters/change_parameters.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('UsersParameters') ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <label class="control-label text-nowrap">
                    <?= __('Selecione um perfil') ?>
                </label>
                <?= $this->Form->control('parameters_id', ['label' => false, 'type' => 'select', 'options' => $parameters, 'class' => 'form-control form-group']) ?>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Mudar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>