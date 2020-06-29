<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentCards */
/* File: src/Template/MovimentCards/report_form.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('MovimentCard', ['target' => '_blank']) ?>

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
			
            <div class="<?= $double ?> well" style="min-height: 160px;">
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
			
            <div class="<?= $double ?> well" style="min-height: 160px;">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('ESPECÍFICOS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Estes campos podem ser usados para filtro do relatório.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $single ?> bottom-10">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#cards_id').multiselect({
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
                        <label class="<?= $label ?>" style="font-weight: normal"><?= __('Cartão') ?></label>
                        <?= $this->Form->control('cards_id', ['id'       => 'cards_id',
                                                              'type'     => 'select',
                                                              'options'  => $cards, 
                                                              'class'    => $input,
                                                              'empty'    => false,
                                                              'label'    => false, 
                                                              'title'    => __('Cartões'),
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
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Categorias') ?>
                        </label>
                        <?= $this->Form->control('costs_id', ['class'   => $input,
                                                              'type'    => 'select',
                                                              'options' => $costs, 
                                                              'label'   => false, 
                                                              'empty'   => __('Todos'),
                                                              'lable'   => false
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
                            <?= __('Tipo de Transação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe se as transações são compras, estornos ou todos.') ?>"></i>
                        </label>
                        <?= $this->Form->control('creditodebito', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => [''  => __('Todos'), 
                                                                                                                                          'D' => __('Compra'), 
                                                                                                                                          'C' => __('Estorno')
                                                                                                                                         ]]) ?>
                    </div>
				</div>
                <?php if ($this->request->Session()->read('sessionPlan') != 4) { ?>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => [''  => __('Todos'), 
                                                                                                                                     'S' => __('Sim'), 
                                                                                                                                     'N' => __('Não')
                                                                                                                                    ]]) ?>
                    </div>
                </div>
                <?php }//if ($this->request->Session()->read('sessionPlan') == 4) ?>
            </div>
			
            <div class="box-panel">
                <div class="col-xs-12 col-sm-6">
                    <?= $this->Form->radio(__('Tipo'), ['movimentCard' => ''], 
                                                       ['default'     => 'movimentCard',
                                                        'label'       => false, 
                                                        'hiddenField' => false,
                                                        'hidden'
                                                       ] 
                                          ); ?>
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