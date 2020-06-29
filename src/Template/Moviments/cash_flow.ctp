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
/* File: src/Template/Moviments/cash_flow.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Moviment', ['target' => '_blank']) ?>

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
            
            <div class="<?= $double ?> well" style="min-height: 229px;">
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
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-left: 25px; margin-top: 3px; font-weight: normal">
                            <?= $this->Form->control('dtemissao', ['label' => false, 'type' => 'checkbox', 'hiddenField' => false]); ?> 
                            <?= __('Data de Emissão') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é utilizado para filtrar os registros por data de emissão.') ?>"></i>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> well" style="min-height: 229px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('BANCOS E/OU CAIXAS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível fazer um relatório unindo os dados de vários bancos e/ou caixas.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $single ?> bottom-10">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#banks_id').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 317,
                                    dropUp: false,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Selecione uma opção',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?> text-nowrap"><?= __('Banco') ?>*</label>
                        <?= $this->Form->control('banks_id', ['id'       => 'banks_id',
                                                              'type'     => 'select',
                                                              'options'  => $banks,
                                                              'class'    => $input,
                                                              'empty'    => false,
                                                              'title'    => __('Bancos'),
                                                              'label'    => false, 
                                                              'multiple' => 'multiple'
                                                             ]
                                               ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#boxes_id').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 317,
                                    dropUp: false,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Selecione uma opção',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?> text-nowrap"><?= __('Caixa') ?>*</label>
                        <?= $this->Form->control('boxes_id', ['id'       => 'boxes_id',
                                                              'type'     => 'select',
                                                              'options'  => $boxes,
                                                              'class'    => $input,
                                                              'empty'    => false,
                                                              'title'    => __('Caixas'),
                                                              'label'    => false, 
                                                              'multiple' => 'multiple'
                                                             ]
                                               ) ?>
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
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#costs_id').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 317,
                                    dropUp: true,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Todos',
                                    nSelectedText: 'selecionados'
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Centro de Custos') ?>
                        </label>
                        <?= $this->Form->control('costs_id', ['label'    => false,
                                                              'id'       => 'costs_id',
                                                              'type'     => 'select',
                                                              'class'    => $input, 
                                                              'options'  => $costs, 
                                                              'empty'    => false, 
                                                              'multiple' => 'multiple'
                                                             ]) ?>
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
                                    dropUp: true,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Todos',
                                    nSelectedText: 'selecionados'
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Plano de Contas') ?>
                        </label>
                        <?= $this->Form->control('account_plans_id', ['label'    => false, 
                                                                      'id'       => 'account_plans_id',
                                                                      'class'    => $input,
                                                                      'options'  => $accountPlans, 
                                                                      'empty'    => false, 
                                                                      'multiple' => 'multiple'
                                                                     ]
                                               ) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> well" style="min-height: 237px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('FILTROS') ?>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Status') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o títulos já pagos/recebidos ou em aberto.') ?>"></i>
                        </label>
                        <?= $this->Form->control('Situação', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['todos'   => __('Todos'),
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
                        <?= $this->Form->control('Detalhamento', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['analitico_cashflow' => __('Analítico (Fluxo Diário)'),
                                                                                                                                         'analitico_simples'  => __('Analítico (Simplificado)'),
                                                                                                                                         //'analitico_clieforn' => __('Analítico (Clientes/Fornecedores)'), apresentou falha 13/08/19
                                                                                                                                         'sintetico'          => __('Sintético'),
                                                                                                                                         'contas'             => __('Sintético (Plano de Contas)'),
                                                                                                                                         //'sintetico_clieforn' => __('Sintético (Clientes/Fornecedores)') apresentou falha 13/08/19
                                                                                                                                        ]
                                                                 ]
                                                ); ?>
                    </div>
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
                        <?= $this->Form->control('Ordem', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['data'       => __('Data do Lançamento'),
                                                                                                                                  'vencimento' => __('Data do Vencimento'),
                                                                                                                                  'dtbaixa'    => __('Data do Pagamento')
                                                                                                                                 ],
                                                           'default' => 'vencimento'
                                                          ]
                                                ); ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> well" style="min-height: 237px;">
                <div class="row text-center">
                    <div class="btn btn-link">
                        <?= $this->Form->radio('creditodebito', [''        => __('Todos'), 
                                                                 'C'       => __('Receita'), 
                                                                 'D'       => __('Despesa')
                                                                ], 
                                                                ['legend'      => false, 
                                                                 'default'     => '', 
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]
                                              ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <div class="D report hidden">
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
                                        dropUp: false
                                    });
                                });
                            </script>
                            <label class="<?= $label ?>" style="font-weight: normal">
                                <?= __('Fornecedor') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os fornecedores da despesa.') ?>"></i>
                            </label>
                            <?= $this->Form->control('providers_id', ['label' => false, 'type' => 'select', 'id' => 'providers', 'class' => $input, 'options' => $providers, 'empty' => 'Opcional']) ?>
                        </div>
                        <div class="C report hidden">
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
                                        dropUp: false
                                    });
                                });
                            </script>
                            <label class="<?= $label ?>" style="font-weight: normal">
                                <?= __('Cliente') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os clientes da receita.') ?>"></i>
                            </label>
                            <?= $this->Form->control('customers_id', ['label' => false, 'type' => 'select', 'id' => 'customers', 'class' => $input, 'options' => $customers, 'empty' => 'Opcional']) ?>
                        </div>
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