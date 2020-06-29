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
/* File: src/Template/Parameters/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('parameter', ['type' => 'file']) ?>

<?= $this->Html->script(['validaCpfCnpj']) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> box" style="height:313px;">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('Tipo') ?>*</label>
                        <?= $this->Form->control('tipo', ['label' => false, 'type' => 'select', 'class' => $input.' tipocpfcnpj', 'required' => true, 'options' => ['J' => 'Jurídica', 
                                                                                                                                                                    'F' => 'Física'
                                                                                                                                                                   ]]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('CPF/CNPJ') ?>*</label>
                        <?= $this->Form->control('cpfcnpj', ['label' => false, 'type' => 'text', 'class' => $input.' focus cpfcnpjmask validacpfcnpj', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Nome/Razão Social') ?>*</label>
                        <?= $this->Form->control('razao', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('Identidade/I.E.') ?></label>
                        <?= $this->Form->control('ie', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => false]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('Data de Nasc./Fundação') ?></label>
                        <?= $this->Form->control('fundacao', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => 'Ex. 01/01/2020']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('E-mail de Cobrança') ?>*</label>
                        <?= $this->Form->control('email_cobranca', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well" style="height:313px;">
                <div class="row bottom-10">
                    <label class="file"><?= __('Logotipo') ?> (120x27)</label>
                    <?= $this->Form->file('logomarca', ['label' => ['label' => false, 'text' => 'Logotipo', 'class' => $label.' file-custom', 'type' => 'image']]) ?>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>"><?= __('Cidade') ?>*</label>
                                <?= $this->Form->control('cidade', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>"><?= __('Estado') ?>*</label>
                                <?= $this->Form->control('estado', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['AC' => 'AC', 'AL' => 'AL', 
                                                                                                                                            'AP' => 'AP', 'AM' => 'AM', 
                                                                                                                                            'BA' => 'BA', 'BH' => 'BH', 
                                                                                                                                            'CE' => 'CE', 'DF' => 'DF', 
                                                                                                                                            'ES' => 'ES', 'GO' => 'GO', 
                                                                                                                                            'MA' => 'MA', 'MT' => 'MT', 
                                                                                                                                            'MS' => 'MS', 'MG' => 'MG', 
                                                                                                                                            'PA' => 'PA', 'PB' => 'PB', 
                                                                                                                                            'PR' => 'PR', 'PE' => 'PE', 
                                                                                                                                            'PI' => 'PI', 'RJ' => 'RJ', 
                                                                                                                                            'RN' => 'RN', 'RS' => 'RS', 
                                                                                                                                            'RO' => 'RO', 'RR' => 'RR', 
                                                                                                                                            'SC' => 'SC', 'SP' => 'SP', 
                                                                                                                                            'SE' => 'SE', 'TO' => 'TO', 
                                                                                                                                            'EX' => 'EX'
                                                                                                                                            ]]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>"><?= __('CEP') ?>*</label>
                                <?= $this->Form->control('cep', ['label' => false, 'type' => 'text', 'class' => $input.' cepmask', 'required' => true]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>"><?= __('Telefone') ?>*</label>
                                <?= $this->Form->control('telefone', ['label' => false, 'type' => 'text', 'class' => $input . ' phonemask', 'required' => true]) ?>
                            </div>
                        </div>
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