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
/* File: src/Template/Moviments/cash_flow_simple.ctp */
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
            
            <div class="<?= $double ?> box" style="min-height: 229px;">
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
                        <?= $this->Form->control('dtinicial', ['label' => false, 'autocomplete' => 'off', 'class' => $input.' focus datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtinicial', 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data Final') ?>*
                        </label>
                        <?= $this->Form->control('dtfinal', ['label' => false, 'autocomplete' => 'off', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtfinal', 'required' => true]) ?>
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
            
            <div class="<?= $double ?> box" style="min-height: 229px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('BANCOS E/OU CARTEIRAS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível fazer um relatório unindo os dados de vários bancos e/ou carteiras.') ?>"></i>
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
                        <label class="<?= $label ?> text-nowrap"><?= __('Carteira') ?>*</label>
                        <?= $this->Form->control('boxes_id', ['id'       => 'boxes_id',
                                                              'type'     => 'select',
                                                              'options'  => $boxes, 
                                                              'class'    => $input,
                                                              'empty'    => false,
                                                              'title'    => __('Carteiras'),
                                                              'label'    => false, 
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
                        <?= $this->Form->control('Detalhamento', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['analitico_simples' => __('Analítico (Simplificado)'),
                                                                                                                                         'sintetico'         => __('Sintético'),
                                                                                                                                         'categorias'        => __('Sintético (por Categorias)')
                                                                                                                                        ]
                                                                 ]
                                                ); ?>
                    </div>
                </div>
                <div class="row">
                    <?php if ($this->request->Session()->read('sessionPlan') != 4) { ?>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 
                                                                                                                                     'N' => __('Não')
                                                                                                                                    ], 'empty' => __('Todos')]) ?>
                    </div>
                    <?php }//if ($this->request->Session()->read('sessionPlan') == 4) ?>
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
                    <div class="radio-inline btn btn-link">
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
                            <?= __('Categorias') ?>
                        </label>
                        <?= $this->Form->control('costs_id', ['id'       => 'costs_id',
                                                              'label'    => false,
                                                              'type'     => 'select',
                                                              'options'  => $costs,
                                                              'class'    => $input,
                                                              'empty'    => false,
                                                              'multiple' => 'multiple'
                                                             ]) ?>
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