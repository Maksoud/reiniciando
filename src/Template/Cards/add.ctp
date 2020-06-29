<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Cards */
/* File: src/Template/Cards/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('card', ['type' => 'file', 'class' => 'ajax_add', 'data-url' => 'cards/addjson']) ?>

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
                            <?= __('Título') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o título para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'class' => $input . ' focus', 'maxlength' => '100', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Bandeira') ?></label>
                        <?= $this->Form->control('bandeira', ['label'   => false, 
                                                              'class'   => $input, 
                                                              'type'    => 'select',
                                                              'options' => ['Master'   => __('MasterCard'),
                                                                            'Visa'     => __('Visa'),
                                                                            'Hiper'    => __('HiperCard'),
                                                                            'Elo'      => __('Cielo'),
                                                                            'Aura'     => __('Aura'),
                                                                            'American' => __('American Express'),
                                                                            'diners'   => __('Diners'),
                                                                            'Outros'   => __('Outros')
                                                                           ]
                                                             ]) ?>
                    </div>
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Limite de Crédito') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe qual é o limite do seu crédito.') ?>"></i>
                        </label>
                        <?= $this->Form->control('limite', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'placeholder' => __('0,00'), 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Dia de Vencimento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe qual é o dia do vencimento da fatura.') ?>"></i>
                        </label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Melhor dia de Compra') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe qual é o limite do seu crédito.') ?>"></i>
                        </label>
                        <?= $this->Form->control('melhor_dia', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
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