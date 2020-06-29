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
/* File: src/Template/Balances/report_form.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Balance', ['target' => '_blank']) ?>
<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script('bootstrap-multiselect.min') ?>

    <div class="container-fluid">
        <div class="row">
            
            <div class="col-xs-12 well">
                <div class="row">
                    <label class="control-label text-nowrap">
                        <?= __('SELECIONE UM PERÍODO') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Campos necessários para identificação dos lançamentos.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <label class="control-label text-nowrap">
                            <?= __('Data Inicial') ?>
                        </label>
                        <?= $this->Form->control('dtinicial', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control form-group'.' focus datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtinicial', 'required' => true]) ?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <label class="control-label text-nowrap">
                            <?= __('Data Final') ?>
                        </label>
                        <?= $this->Form->control('dtfinal', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => 'form-control form-group'.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'id' => 'dtfinal', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <label class="control-label text-nowrap text-nowrap">
                        <?= __('Grupos e Tipos de Produtos') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('É possível fazer um relatório unindo os dados de vários grupos e tipos de produtos.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom-20">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#product_types_id').multiselect({
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
                                    nonSelectedText: 'Selecione uma opção',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="control-label text-nowrap text-nowrap"><?= __('Tipos') ?></label>
                        <?= $this->Form->control('product_types_id', ['id'       => 'product_types_id',
                                                              'class'    => 'form-control form-group',
                                                              'empty'    => false,
                                                              'label'    => false, 
                                                              'type'     => 'select',
                                                              'options'  => $productTypes, 
                                                              'title'    => __('Tipos'),
                                                              'multiple' => 'multiple'
                                                             ]
                                               ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom-20">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#product_groups_id').multiselect({
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
                                    nonSelectedText: 'Selecione uma opção',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="control-label text-nowrap text-nowrap"><?= __('Grupos') ?></label>
                        <?= $this->Form->control('product_groups_id', ['id'       => 'product_groups_id',
                                                              'class'    => 'form-control form-group',
                                                              'empty'    => false,
                                                              'label'    => false, 
                                                              'type'     => 'select',
                                                              'options'  => $productGroups, 
                                                              'title'    => __('Grupos'),
                                                              'multiple' => 'multiple'
                                                             ]
                                               ) ?>
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