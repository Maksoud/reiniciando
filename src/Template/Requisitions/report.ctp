<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Report */
/* File: src/Template/Requisitions/report.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Requisition', ['target' => '_blank']) ?>

<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script('bootstrap-multiselect.min') ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            
            <div class="<?= $double ?> box" style="min-height: 227px;">
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
            </div>
            <div class="<?= $double ?> well" style="min-height: 227px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('FILTROS') ?>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Ordem') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o campo que será utilizado para ordenar os itens do relatório.') ?>"></i>
                        </label>
                        <?= $this->Form->control('Ordem', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['code'      => __('Código'),
                                                                                                                                  'date'      => __('Data da Requisição'),
                                                                                                                                  'applicant' => __('Solicitante'),
                                                                                                                                  'status'    => __('Status')
                                                                                                                                 ],
                                                            'default' => 'date'
                                                          ]
                                                ); ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Status') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Filtre por status ou deixe em branco para trazer todos os resultados.') ?>"></i>
                        </label>
                        <?= $this->Form->control('status', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['F' => __('Finalizado'),
                                                                                                                                   'C' => __('Cancelado')
                                                                                                                                  ],
                                                            'empty' => 'Todos'
                                                          ]
                                                ); ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well" style="min-height: 227px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#sells').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 300,
                                    dropUp: false,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Lista de Pedidos de Venda',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Pedidos de Vendas') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os pedidos de vendas em aberto ou em processamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('sells_id', ['label' => false, 'type' => 'select', 'id' => 'sells', 'class' => $input, 'empty' => false, 'options' => $sells, 'multiple' => 'multiple']) ?>
                    </div>
                    <div class="<?= $single ?>">
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
                                    dropUp: false,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Lista de Clientes',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Clientes') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os clientes.') ?>"></i>
                        </label>
                        <?= $this->Form->control('customers_id', ['label' => false, 'type' => 'select', 'id' => 'customers', 'class' => $input, 'empty' => false, 'options' => $customers, 'multiple' => 'multiple']) ?>
                    </div>
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#industrializations').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 300,
                                    dropUp: false,
                                    includeSelectAllOption: true,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Lista de Ordens de Fabricação',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Ordens de Fabricação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar as ordens de fabricação em processo e finalizadas.') ?>"></i>
                        </label>
                        <?= $this->Form->control('industrializations_id', ['label' => false, 'type' => 'select', 'id' => 'industrializations', 'class' => $input, 'empty' => false, 'options' => $industrializations, 'multiple' => 'multiple']) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?>">
                <div class="clearfix"></div>
            </div>
            
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gerar Relatório'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>