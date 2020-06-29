<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Backups */
/* File: src/Template/Backup/backup.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Backup', ['type' => 'file']) ?>
<?= $this->Html->script('validaCpfCnpj.min') ?>

<?php 
    $double = 'col-xs-6 width-155';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control form-group width-x317';
    $input_double = 'form-control form-group double-input';
?>

    <div class="container-fluid">
        <div class="col-xs-12 main">
            <div class="col-xs-12 col-sm-6">
                <h4 class="text-center"><?= __('CADASTROS') ?></h4>
                <div class="well">
                    <div class="form-group">
                        <?= $this->Form->checkbox('providers', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Fornecedores</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('customers', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Clientes</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('transporters', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Transportadoras</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('banks', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Bancos</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('boxes', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Caixas</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('cards', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Cartões</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('coins', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Moedas</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('account_plans', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Planos de Contas</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('costs', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Centros de Custos</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('document_types', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Tipos de Documentos</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('event_types', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Tipos de Eventos</label></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <h4 class="text-center"><?= __('MOVIMENTOS') ?></h4>
                <div class="well">
                    <div class="form-group">
                        <?= $this->Form->checkbox('moviments', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Contas a Pagar/Receber</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('moviment_boxes', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Movimentos de Caixa</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('moviment_banks', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Movimentos de Banco</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('moviment_checks', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Movimentos de Cheque</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('moviment_cards', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Movimentos de Cartão</label></span>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->checkbox('transfers', ['hiddenField' => false])?>
                        <span class="text-bold"><label>Transferências</label></span>
                    </div>
                </div>
                <br/>
                <h4 class="text-center"><?= __('TIPO DE ARQUIVO EXPORTADO') ?></h4>
                <div class="well">
                    <div class="form-group text-center">
                        <div class="radio-inline btn btn-link">
                            <?= $this->Form->radio('radio', ['sql' => 'SQL', 'csv' => 'CSV'], 
                                                            ['legend'      => false, 
                                                             'default'     => 'csv', 
                                                             'hiddenField' => false,
                                                             'separator'   => '</div><div class="radio-inline">'
                                                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
    <?= $this->Form->end(['label' => 'Gerar', 'class' => 'btn btn-primary', 'div' => false]) ?>
</div>