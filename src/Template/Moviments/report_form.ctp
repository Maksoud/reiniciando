<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Moviments */
/* File: src/Template/Moviments/report_form.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Moviment', ['target' => '_blank']) ?>

<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script('bootstrap-multiselect.min') ?>
<?= $this->Html->script(['maksoud-radiooptions.min']) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 165px;">
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
                        <?= $this->Form->control('dtinicial', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' focus datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtinicial', 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data Final') ?>*
                        </label>
                        <?= $this->Form->control('dtfinal', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtfinal', 'required' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well" style="min-height: 165px;">
                <div class="row text-center">
                    <div class="radio-inline btn btn-link">
                        <?= $this->Form->radio('creditodebito', ['A' => __('Todos'),
                                                                 'C' => __('Receita'), 
                                                                 'D' => __('Despesa')
                                                                ], 
                                                                ['legend'      => false, 
                                                                 'default'     => 'A', 
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]
                                              ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <div class="report D hidden">
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#providers').multiselect({
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
                                <?= __('Fornecedor') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os fornecedores da despesa.') ?>"></i>
                            </label>
                            <?= $this->Form->control('providers_id', ['label' => false, 'type' => 'select', 'id' => 'providers', 'class' => $input, 'options' => $providers, 'empty' => 'Todos']) ?>
                        </div>
                        <div class="report C hidden">
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#customers').multiselect({
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
                                <?= __('Cliente') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os clientes da receita.') ?>"></i>
                            </label>
                            <?= $this->Form->control('customers_id', ['label' => false, 'type' => 'select', 'id' => 'customers', 'class' => $input, 'options' => $customers, 'empty' => 'Todos']) ?>
                        </div>
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
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>" style="font-weight: normal">
                                    <?= __('Tipo de Documento') ?>
                                </label>
                                <?= $this->Form->control('document_types_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $documentTypes, 'empty' => __('Todos')]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>" style="font-weight: normal">
                                    <?= __('Tipo de Evento') ?>
                                </label>
                                <?= $this->Form->control('event_types_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $eventTypes, 'empty' => __('Todos')]) ?>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <?= $this->Form->control('account_plans_id', ['label'   => false, 
                                                                      'id'      => 'account_plans_id',
                                                                      'class'   => $input,
                                                                      'options' => $accountPlans,
                                                                      'type'    => 'select',
                                                                      'empty'   => __('Todos'),
                                                                      'title'   => __('Plano de Contas')
                                                                     ]
                                               ) ?>
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
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Situação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o títulos já pagos/recebidos ou em aberto.') ?>"></i>
                        </label>
                        <?= $this->Form->control(__('Situação'), ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['todos'   => __('Todos'),
                                                                                                                     'aberto'  => __('Aberto'),
                                                                                                                     'baixado' => __('Baixado')
                                                                                                                    ]
                                                             ]
                                                ); ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Detalhamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o nível do detalhamento: Analítico ou Sintético.') ?>"></i>
                        </label>
                        <?= $this->Form->control(__('Detalhamento'), ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['analitico' => __('Analítico'),
                                                                                                                                             'sintetico' => __('Sintético')
                                                                                                                                            ]
                                                                     ]
                                                ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Tipo') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o modelo do relatório.') ?>"></i>
                        </label>
                        <?= $this->Form->control('Tipo', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['default'       => __('Padrão'),
                                                                                                                                 'planodecontas' => __('Plano de Contas'),
                                                                                                                                 'fluxo'         => __('Fluxo Diário')
                                                                                                                                ]
                                                         ]
                                                ); ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-left: 24px; margin-top: 17px; font-weight: normal">
                            <?= $this->Form->control('dtemissao', ['label' => false, 'type' => 'checkbox', 'hiddenField' => false]); ?> 
                            <?= __('Data de Emissão') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é utilizado para filtrar os registros por data de emissão.') ?>"></i>
                        </label>
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