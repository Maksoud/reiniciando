<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Transfers */
/* File: src/Template/Transfers/report_form.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Transfer', ['target' => '_blank']) ?>

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
            <div class="<?= $double ?> well">
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
            <div class="<?= $double ?> box">
                <div class="top-5 bottom-20 row box-panel">
                    <label class="<?= $label ?>">
                        <?= __('OPCIONAIS') ?>
                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Estes campos podem ser usados para filtro do relatório.') ?>"></i>
                    </label>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Documento') ?>
                        </label>
                        <?= $this->Form->control('documento', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => false, 'maxlength' => '25']) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Histórico') ?>
                        </label>
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => false]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $single ?> well">
                <div class="<?= $double ?>">
                    <h4 class="text-center"><?= __('DADOS DE ORIGEM') ?></h4>
                    <div class="text-center">
                        <div class="btn btn-link">
                            <?= $this->Form->radio('radio_origem', [''             => __('Todos'), 
	                            									'banco_origem' => __('Banco'), 
	                            									'caixa_origem' => __('Caixa')
	                            								   ], 
                                                                   ['legend'      => false,
                                                                    'default'     => 'banco_origem',
                                                                    'hiddenField' => false,
                                                                    'label'       => ['class' => 'radio-inline btn']
                                                                   ]) ?>
                        </div>
                    </div>
					
					<div class="row">
                    	<div class="<?= $single ?>">
		                    <div class="banco_origem report">
		                        <label class="<?= $label ?>" style="font-weight: normal">
		                            <?= __('Banco') ?>
		                        </label>
		                        <?= $this->Form->control('banks_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $banks, 'empty' => __('Todos')]) ?>
		                    </div>
		                    <div class="caixa_origem report hidden">
		                        <label class="<?= $label ?>" style="font-weight: normal">
		                            <?= __('Caixa') ?>
		                        </label>
		                        <?= $this->Form->control('boxes_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $boxes, 'empty' => __('Todos')]) ?>
		                    </div>
                    	</div>
					</div>
					
					<div class="row">
                    	<div class="<?= $single ?>">
		                    <label class="<?= $label ?>" style="font-weight: normal">
		                        <?= __('Centro de Custo') ?>
		                    </label>
		                    <?= $this->Form->control('costs_id', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $costs, 'empty' => __('Todos')]) ?>
                    	</div>
					</div>
                    
					<div class="row">
                    	<div class="<?= $single ?>">
		                    <script type="text/javascript">
		                        $(document).ready(function() {
		                            $('#account_plans_id').multiselect({
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
		                    <label class="<?= $label ?>" style="font-weight: normal">
		                        <?= __('Plano de Contas') ?>
		                    </label>
                            <?= $this->Form->control('account_plans_id', ['id'      => 'account_plans_id',
                                                                          'options' => $accountPlans,
                                                                          'class'   => $input,
                                                                          'type'    => 'select',
                                                                          'label'   => false, 
                                                                          'empty'   => __('Todos'),
                                                                          'title'   => __('Plano de Contas')
                                                                         ]
		                                           ) ?>
                    	</div>
					</div>
                </div>

                <div class="<?= $double ?>">
                    <h4 class="text-center"><?= __('DADOS DE DESTINO') ?></h4>
                    <div class="text-center">
                        <div class="btn btn-link">
                            <?= $this->Form->radio('radio_destino', [''              => __('Todos'), 
	                            									 'banco_destino' => __('Banco'), 
	                            									 'caixa_destino' => __('Caixa')
	                            									], 
                                                                    ['legend'      => false, 
                                                                     'default'     => 'banco_destino', 
                                                                     'hiddenField' => false,
                                                                     'label'       => ['class' => 'radio-inline btn']
                                                                    ]) ?>
                        </div>
                    </div>
					
					<div class="row">
                    	<div class="<?= $single ?>">
		                    <div class="banco_destino report">
		                        <label class="<?= $label ?>" style="font-weight: normal">
		                            <?= __('Banco') ?>
		                        </label>
		                        <?= $this->Form->control('banks_dest', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $banks_dest, 'empty' => __('Todos')]) ?>
		                    </div>
		                    <div class="caixa_destino report hidden">
		                        <label class="<?= $label ?>" style="font-weight: normal">
		                            <?= __('Caixa') ?>
		                        </label>
		                        <?= $this->Form->control('boxes_dest', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $boxes_dest, 'empty' => __('Todos')]) ?>
		                    </div>
                        </div>
                    </div>
					
					<div class="row">
                    	<div class="<?= $single ?>">
		                    <label class="<?= $label ?>" style="font-weight: normal">
		                        <?= __('Centro de Custo') ?>
		                    </label>
		                    <?= $this->Form->control('costs_dest', ['label' => false, 'class' => $input, 'type' => 'select', 'options' => $costs_dest, 'empty' => __('Todos')]) ?>
                        </div>
                    </div>
					
					<div class="row">
                    	<div class="<?= $single ?>">
		                    <script type="text/javascript">
		                        $(document).ready(function() {
		                            $('#account_plans_dest').multiselect({
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
		                    <label class="<?= $label ?>" style="font-weight: normal">
		                        <?= __('Plano de Contas') ?>
		                    </label>
                            <?= $this->Form->control('account_plans_dest', ['id'      => 'account_plans_dest',
                                                                            'options' => $accountPlans_dest,
                                                                            'class'   => $input,
                                                                            'type'    => 'select',
                                                                            'label'   => false, 
                                                                            'empty'   => __('Todos'),
                                                                            'title'   => __('Plano de Contas')
                                                                            ]
		                                           ) ?>
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
                                                                                                                                  //'status'            => __('Status')
                                                                                                                                 ]
                                                              ]
                                                ); ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="margin-top: -7px; font-weight: normal">
                            <?= __('Detalhamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione o nível do detalhamento: Analítico ou Sintético.') ?>"></i>
                        </label>
                        <?= $this->Form->control('Detalhamento', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['analitico' => __('Analítico'),
                                                                                                                                         'sintetico' => __('Sintético')
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
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 
                                                                                                                                     'N' => __('Não')
                                                                                                                                    ], 'empty' => __('Todos')]) ?>
                    </div>
                </div>
            </div>
			
            <div class="box-panel">
                <div class="col-xs-12 col-sm-6">
                    <?= $this->Form->radio(__('Tipo'), ['Movimentos_Transf' => ''], 
                                                       ['default'     => 'Movimentos_Transf',
                                                        'separator'   => '<br/>',
                                                        'legend'      => false,
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