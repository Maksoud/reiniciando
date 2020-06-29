<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* ProductTypes */
/* File: src/Template/ProductTypes/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($productType) ?>

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
                            <?= __('Código') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Código única com 6 dígitos para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('code', ['label' => false, 'type' => 'text', 'id' => 'text', 'maxlength' => '6', 'class' => $input . ' focus', 'required' => true]) ?>
                    </div>
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Título') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o título para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'id' => 'text', 'maxlength' => '60', 'class' => $input . ' focus', 'required' => true]) ?>
                    </div>
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Calcula Custo do Estoque') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Atualiza o valor de custo do produto na compra.') ?>"></i>
                        </label>
                        <?= $this->Form->control('calc_cost', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => 'Sim', 'N' => 'Não'], 'required' => true]) ?>
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