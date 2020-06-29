<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Providers */
/* File: src/Template/Providers/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($provider) ?>

<?= $this->Html->script(['add-providers.min',
                         'validaCpfCnpj.min',
                         'maksoud-text.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            
            <div class="<?= $single ?> box">
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Tipo') ?></label>
                            <?= $this->Form->control('tipo', ['label' => false, 'type' => 'select', 'class' => $input.' tipocpfcnpj', 'options' => ['J' => __('Pessoa Jurídica'), 'F' => __('Pessoa Física')]]) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('CPF/CNPJ') ?></label>
                            <?= $this->Form->control('cpfcnpj', ['label' => false, 'type' => 'text', 'class' => $input.' focus cpfcnpjmask validacpfcnpj', 'maxlength' => '25', 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('RG/Insc. Estadual') ?></label>
                            <?= $this->Form->control('ie', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input]) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $double ?>">
                    <label class="<?= $label ?>"><?= __('Status') ?></label>
                    <?= $this->Form->control('status', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['A' => __('Ativo'), 'I' => __('Inativo')], 'default' => 'A']) ?>
                </div>
                <div class="<?= $double ?>">
                    <label class="<?= $label ?>"><?= __('E-mail') ?></label>
                    <?= $this->Form->control('email', ['label' => false, 'class' => $input, 'maxlength' => '100', 'required' => false]) ?>
                </div>
            </div>
            
            <div class="<?= $single ?> well">
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('Nome/Razão Social') ?></label>
                            <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '255', 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('Nome Fantasia') ?></label>
                            <?= $this->Form->control('fantasia', ['label' => false, 'type' => 'text', 'maxlength' => '255', 'class' => $input]) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('Banco') ?></label>
                            <?= $this->Form->control('banco', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Agência') ?></label>
                            <?= $this->Form->control('agencia', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input]) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Conta') ?></label>
                            <?= $this->Form->control('conta', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input]) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $single ?> box">
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('Logradouro') ?></label>
                            <?= $this->Form->control('endereco', ['label' => false, 'type' => 'text', 'maxlength' => '255', 'class' => $input]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('Cidade') ?></label>
                            <?= $this->Form->control('cidade', ['label' => false, 'type' => 'text', 'maxlength' => '100', 'class' => $input]) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>"><?= __('Bairro') ?></label>
                            <?= $this->Form->control('bairro', ['label' => false, 'type' => 'text', 'maxlength' => '100', 'class' => $input]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Estado') ?></label>
                            <?= $this->Form->control('estado', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['AC' => 'AC','AL' => 'AL','AP' => 'AP','AM' => 'AM','BA' => 'BA','BH' => 'BH','CE' => 'CE','DF' => 'DF','ES' => 'ES','GO' => 'GO','MA' => 'MA','MT' => 'MT','MS' => 'MS','MG' => 'MG','PA' => 'PA','PB' => 'PB','PR' => 'PR','PE' => 'PE','PI' => 'PI','RJ' => 'RJ','RN' => 'RN','RS' => 'RS','RO' => 'RO','RR' => 'RR','SC' => 'SC','SP' => 'SP','SE' => 'SE','TO' => 'TO','EX' => 'EX']]) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('CEP') ?></label>
                            <?= $this->Form->control('cep', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input.' cepmask']) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $single ?> well">
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Telefone 1') ?></label>
                            <?= $this->Form->control('telefone1', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input.' phonemask']) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Telefone 2') ?></label>
                            <?= $this->Form->control('telefone2', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input.' phonemask']) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $double ?>">
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Telefone 3') ?></label>
                            <?= $this->Form->control('telefone3', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input.' phonemask']) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>"><?= __('Telefone 4') ?></label>
                            <?= $this->Form->control('telefone4', ['label' => false, 'type' => 'text', 'maxlength' => '25', 'class' => $input.' phonemask']) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $single ?> box">
                <div class="<?= $single ?>">
                    <label class="<?= $label ?>"><?= __('Observações') ?></label>
                    <?= $this->Form->textarea('obs', ['label' => false, 'id' => 'text', 'maxlength' => '300', 'type' => 'textarea', 'class' => 'form-control form-group']) ?>
                    <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
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