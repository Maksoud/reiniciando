<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Balances */
/* File: src/Template/Balances/super_add_balance.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Balance') ?>
<?= $this->Html->script('maksoud-radiooptions.min') ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-3 <?= $double ?>">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">Data do Lançamento*</label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">Crédito/Débito</label>
                        <?= $this->Form->control('creditodebito', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['C' => 'Crédito', 'D' => 'Débito']]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">Valor*</label>
                        <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'placeholder' => __('0,00'), 'required' => true]) ?>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="<?= $single ?>">
                        <div class="row text-center" style="margin-bottom: -5px;">
                            <div class="radio-inline btn btn-link">
                                <?= $this->Form->radio('radio', ['caixa'        => __('Caixa'), 
                                                                 'banco'        => __('Banco'), 
                                                                 'cartao'       => 'Cartão', 
                                                                 'planejamento' => 'Planejamento'
                                                                ], 
                                                                ['legend'      => false, 
                                                                 'default'     => 'caixa', 
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]
                                                      ) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <div class="caixa">
                            <label class="<?= $label ?> caixa">Caixa*</label>
                            <?= $this->Form->control('boxes_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $boxes]) ?>
                        </div>
                        <div class="banco hidden">
                            <label class="<?= $label ?>">Banco*</label>
                            <?= $this->Form->control('banks_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $banks]) ?>
                        </div>
                        <div class="cartao hidden">
                            <label class="<?= $label ?>">Cartão*</label>
                            <?= $this->Form->control('cards_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $cards]) ?>
                        </div>
                        <div class="planejamento hidden">
                            <label class="<?= $label ?>">Planejamentos & Metas*</label>
                            <?= $this->Form->control('plannings_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $plannings]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Atualizar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>