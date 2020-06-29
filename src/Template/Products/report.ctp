<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Products */
/* File: src/Template/Products/report.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Product', ['target' => '_blank']) ?>

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
            
            <div class="<?= $double ?> box" style="min-height: 180px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('SELECIONE UM PERÍODO') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório e necessário busca dos lançamentos.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data Inicial') ?>*
                        </label>
                        <?= $this->Form->control('dtinicial', ['label' => false, 'autocomplete' => 'off', 'class' => $input.' focus datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtinicial', 'required' => false]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data Final') ?>*
                        </label>
                        <?= $this->Form->control('dtfinal', ['label' => false, 'autocomplete' => 'off', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtfinal', 'required' => false]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?> well" style="min-height: 180px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#types').multiselect({
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
                                    nonSelectedText: 'Selecione uma opção',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Tipos') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os fornecedores da despesa.') ?>"></i>
                        </label>
                        <?= $this->Form->control('product_types_id', ['label' => false, 'type' => 'select', 'id' => 'types', 'class' => $input, 'empty' => false, 'options' => $types, 'multiple' => 'multiple']) ?>
                    </div>
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#groups').multiselect({
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
                                    nonSelectedText: 'Selecione uma opção',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Grupos') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível filtrar os clientes da receita.') ?>"></i>
                        </label>
                        <?= $this->Form->control('product_groups_id', ['label' => false, 'type' => 'select', 'id' => 'groups', 'class' => $input, 'empty' => false, 'options' => $groups, 'multiple' => 'multiple']) ?>
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
                            <?= __('Ordem') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o campo que será utilizado para ordenar os itens do relatório.') ?>"></i>
                        </label>
                        <?= $this->Form->control('Ordem', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['title'   => __('Título'),
                                                                                                                                  'code' => __('Códito Interno'),
                                                                                                                                  'ncm'     => __('NCM'),
                                                                                                                                  'ean'     => __('EAN'),
                                                                                                                                  'minimum' => __('Estoque Mínimo'),
                                                                                                                                  'maximum' => __('Estoque Máximo')
                                                                                                                                 ],
                                                            'default' => 'title'
                                                          ]
                                                ); ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Produtos com Estoque') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Lista apenas os produtos com estoque maior que 0.') ?>"></i>
                        </label>
                        <?= $this->Form->control('withbalance', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['N' => 'Todos', 'S' => 'Somente com saldo']]); ?>
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