<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Plannings */
/* File: src/Template/Plannings/edit_simple.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($planning) ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         'maksoud-plannings.min',
                         //Lista de itens
                         'list-cards.min',
                         'list-costs.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 257px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório e necessário para cálculo do vencimento, de acordo com a periodicidade selecionada.') ?>"></i>
                        </label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input.' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Vencimento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data de vencimento da primeira parcela.') ?>"></i>
                        </label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'id' => 'vencimento', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020')]) ?>
                    </div>
                </div>
                <div class="row box text-center" style="padding-top: 0px; padding-bottom: 0px; display: block; margin: auto; width: 210px; margin-top: 15px; margin-bottom: 4px;">
                    <div class="btn btn-link">
                        <?= $this->Form->radio('creditodebito', ['C' => __('Receita'), 'D' => __('Despesa')],
                                                                ['legend'      => false,
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="min-height: 257px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento. É possível filtrar em relatórios.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')], 'default' => 'S']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Descrição') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Nele você deverá informar a descrição do lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '100', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Categoria') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Utilize a categoria para agrupar despesas e receitas por fonte. Ex: Energia, alimentação, impostos.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'costs', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Categoria'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Categoria'), 'escape' => false]) ?>
                            </div>
                            <input id="costs_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome da categoria ou adicione') ?>" value="<?= $planning->Costs['title']; ?>"><div class="loadingCosts"></div>
                        </div>
                        <input name="costs_id" id="costs_id" type="hidden" value="<?= $planning->costs_id; ?>">
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="<?= $double ?> well" style="min-height: 258px;">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nº de Parcelas') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o número de parcelas. Quantidade mínima é 1 parcela.') ?>"></i>
                        </label>
                        <?= $this->Form->control('parcelas', ['label' => false, 'id' => 'parcelas', 'type' => 'number', 'class' => $input, 'value' => 1]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Periodicidade') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Escolha a periodicidade para cálculo dos próximos vencimentos.') ?>"></i>
                        </label>
                        <?= $this->Form->control('dd', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['R'   => __('Recorrente'),
                                                                                                                               '10'  => __('Decimal'),
                                                                                                                               '15'  => __('Quinzenal'), 
                                                                                                                               '30'  => __('Mensal'), 
                                                                                                                               'bim' => __('Bimestral'),
                                                                                                                               'tri' => __('Trimestral'),
                                                                                                                               'sem' => __('Semestral'),
                                                                                                                               'anu' => __('Anual')
                                                                                                                              ], 'default' => '30']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor da Parcela') ?>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valor', ['label' => false, 'id' => 'valor', 'type' => 'text', 'class' => $input.' input-border-right valuemask', 'value' => $this->MyForm->decimal($planning->valor), 'placeholder' => __('0,00'), 'required' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?> top-20 bottom-20 text-right font-20" style="display: inline; font-weight: bolder;">
                        <?= __('Valor Total:') ?> <?= __('R$') ?> <span id="total"><?= __('0,00') ?></span>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="min-height: 258px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Observações') ?>
                        </label>
                        <?= $this->Form->textarea('obs', ['label' => false, 'type' => 'textarea', 'id' => 'text', 'maxlength' => '300', 'class' => 'form-control form-group']) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
    <?= $this->Html->link(__(' Saldos Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>