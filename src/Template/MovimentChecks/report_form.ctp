<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentChecks */
/* File: src/Template/MovimentChecks/report_form.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('MovimentCheck', ['target' => '_blank']) ?>

<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script(['bootstrap-multiselect.min',
                         'maksoud-radiooptions.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 179px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('SELECIONE UM PERÍODO') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Campos necessários para identificação dos lançamentos.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data Inicial') ?>*
                        </label>
                        <?= $this->Form->control('dtinicial', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', ' class' => $input.' focus datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtinicial', 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data Final') ?>*
                        </label>
                        <?= $this->Form->control('dtfinal', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtfinal', 'required' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well" style="min-height: 179px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('ESPECÍFICOS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Estes campos podem ser usados para filtro do relatório.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Nº do Cheque') ?>
                        </label>
                        <?= $this->Form->control('cheque', ['label' => false, 'type' => 'number', 'class' => $input, 'required' => false]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Nominal à') ?>
                        </label>
                        <?= $this->Form->control('nominal', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => false]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $single ?> box">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('OPCIONAIS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Estes campos podem ser usados para filtro do relatório.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>" style="font-weight: normal">
                                    <?= __('Documento') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é opcional e pesquisa os dados que contém o dado informado.') ?>"></i>
                                </label>
                                <?= $this->Form->control('documento', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => false, 'maxlength' => '25']) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>" style="font-weight: normal">
                                    <?= __('Histórico') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é opcional e pesquisa os dados que contém o dado informado.') ?>"></i>
                                </label>
                                <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => false]) ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                        <div class="<?= $double ?>">
                            <div class="row">
                                <div class="<?= $single ?>">
                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            $('#providers').multiselect({
                                                enableFiltering: true,
                                                enableClickableOptGroups: true,
                                                enableCaseInsensitiveFiltering: true,
                                                inheritClass: true,
                                                buttonContainer: '<div />',
                                                maxHeight: 300,
                                                maxWidth: 317,
                                                dropUp: true
                                            });
                                        });
                                    </script>
                                    <label class="<?= $label ?>" style="font-weight: normal"><?= __('Fornecedor') ?></label>
                                    <?= $this->Form->control('providers_id', ['label' => false, 'type' => 'select', 'id' => 'providers', 'class' => $input, 'options' => $providers, 'title' => __('Fornecedores'), 'empty' => __('Todos')]) ?>
                                </div>
                            </div>
                        </div>
                    <?php }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) ?>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#banks').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 317,
                                    dropUp: true
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal"><?= __('Banco') ?></label>
                        <?= $this->Form->control('banks_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $banks, 'id' => 'banks', 'title' => __('Bancos'), 'empty' => __('Todos')]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                                    <?= __('Centro de Custos') ?>
                                </label>
                                <?= $this->Form->control('costs_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $costs, 'empty' => __('Todos')]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#account_plans_id').multiselect({
                                            enableFiltering: true,
                                            enableClickableOptGroups: true,
                                            enableCaseInsensitiveFiltering: true,
                                            inheritClass: true,
                                            buttonContainer: '<div />',
                                            maxHeight: 300,
                                            maxWidth: 300,
                                            dropUp: true
                                        });
                                    });
                                </script>
                                <label class="<?= $label ?>" style="font-weight: normal">
                                    <?= __('Plano de Contas') ?>
                                </label>
                                <?= $this->Form->control('account_plans_id', ['label' => false, 'type' => 'select', 'id' => 'account_plans_id', 'class' => $input, 'options' => $accountPlans, 'title' => __('Plano de Contas'), 'empty' => __('Todos')]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('FILTROS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Estes campos podem ser usados para filtro do relatório.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')], 'empty' => __('Todos')]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Ordem') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o campo que será utilizado para ordenar os itens do relatório.') ?>"></i>
                        </label>
                        <?= $this->Form->control('Ordem', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['ordem'             => __('Ordem'),
                                                                                                                                  'data'              => __('Data do Lançamento'),
                                                                                                                                  'vencimento'        => __('Data do Vencimento'),
                                                                                                                                  'dtbaixa'           => __('Data do Pagamento'),
                                                                                                                                  'historico'         => __('Histórico'),
                                                                                                                                  'document_types_id' => __('Tipos de Documento'),
                                                                                                                                  'event_types_id'    => __('Tipos de Evento'),
                                                                                                                                  'status'            => __('Status')
                                                                                                                                 ]
                                                              ]
                                                ); ?>
                    </div>
                    <div class="<?= $double ?>">
                        <?= $this->Form->radio('Tipo', ['movimentoCheque_cheque' => ''], 
                                                       ['label'       => false, 
                                                        'default'     => 'movimentoCheque_cheque', 
                                                        'hiddenField' => false,
                                                        'hidden'
                                                       ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gerar Relatório'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>