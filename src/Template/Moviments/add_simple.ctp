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
/* File: src/Template/Moviments/add_simple.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('moviment', ['id' => 'cprCardsForm']) ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         'maksoud-moviments.min',
                         //Calcula o vencimento do cartão
                         'calcula-vencimento-cartao.min',
                         //Lista de itens
                         'list-boxes.min',
                         'list-banks.min',
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
            <div class="<?= $double ?> well" style="min-height: 262px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório e necessário para cálculo do vencimento, de acordo com a periodicidade selecionada.') ?>"></i>
                        </label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input . ' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Vencimento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de não informar o vencimento, este será preenchido considerando a periodicidade e a data do documento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020')]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nº de Parcelas') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o número de parcelas. Quantidade mínima é 1 parcela.') ?>"></i>
                        </label>
                        <?= $this->Form->control('parcelas', ['label' => false, 'type' => 'number', 'class' => $input, 'value' => 1, 'required' => true]) ?>
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
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor da parcela, no caso de parcelamento.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input . ' input-border-right valuemask', 'id' => 'valor', 'placeholder' => __('0,00'), 'required' => true]) ?>
                        </div>
                    </div>
                </div>

                <div class="row box text-center pull-right-md" style="padding:0 0 0 15px; display:block; margin:auto; width:200px; margin-top:15px; margin-bottom:4px;">
                    <div class="btn btn-link">
                        <?= $this->Form->radio('creditodebito', ['C' => __('Receita'), 'D' => __('Despesa')], 
                                                                ['legend'      => false, 
                                                                 'default'     => 'D',
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 262px;">
                <div class="row top-10">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Descrição') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Nele você deverá informar a descrição do lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
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
                            <input id="costs_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome da categoria ou adicione') ?>"><div class="loadingCosts"></div>
                        </div>
                        <input name="costs_id" id="costs_id" type="hidden">
                    </div>
                </div>
                <?php if ($this->request->Session()->read('sessionPlan') != 4) { ?>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento. É possível filtrar em relatórios.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                    </div>
                </div>
                <?php }//if ($this->request->Session()->read('sessionPlan') == 4) ?>
            </div>

            <div class="clearfix"></div>

            <div class="<?= $double ?> box" style="min-height: 214px;">
                <div class="row">
                    <?php if ($this->request->Session()->read('sessionPlan') != 4) { ?>
                    <div class="<?= $double ?>">
                        <div class="<?= $single ?> bottom-0 top-10">
                            <?= $this->Html->link(__(' Informar Cartão'), '#collapseCard', ['id' => 'informarCard', 'class' => 'btn btn-primary fa fa-credit-card', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                        </div>
                    </div>
                    <?php }//if ($this->request->Session()->read('sessionPlan') != 4) ?>
                    <div class="<?= $double ?>">
                        <div class="<?= $single ?> bottom-0 top-10">
                            <?= $this->Html->link(__(' Informar Pagamento'), '#collapsePagamento', ['id' => 'informarPagamento', 'class' => 'btn btn-primary fa fa-usd', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="collapseCard">
                    <div class="row">
                        <div class="<?= $single ?> bottom-0 top-10">
                            <label class="<?= $label ?>">
                                <?= __('Cartão de Crédito') ?>
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon input-border-left">
                                    <?= $this->Html->link('', ['controller' => 'cards', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Cartão'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Cartão'), 'escape' => false]) ?>
                                </div>
                                <input id="cards_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do cartão ou adicione') ?>"><div class="loadingCards"></div>
                            </div>
                            <input name="cards_id" id="cards_id" type="hidden">
                        </div>
                    </div>
                </div>

                <div class="collapse" id="collapsePagamento">
                    <div class="row">
                        <div class="<?= $single ?> bottom-0 top-10">

                            <div class="row">
                                <div class="<?= $double ?>">
                                    <label class="<?= $label ?>">
                                        <?= __('Data do Pagamento') ?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data do evento. É importante que esteja igual a data da compensação do extrato bancário.') ?>"></i>
                                    </label>
                                    <?= $this->Form->control('dtbaixa', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020')]) ?>
                                </div>
                                <div class="<?= $double ?>">
                                    <label class="<?= $label ?>">
                                        <?= __('Tipo do Pagamento') ?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe se este pagamento refere-se ao total da fatura ou se é apenas uma parte do pagamento. No caso de pagamento parcial, a diferença será adicionada em uma nova fatura.') ?>"></i>
                                    </label>
                                    <?= $this->Form->control('parcial', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => [null => __('Pagamento Total'), 'P' => __('Pagamento Parcial')]]) ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="<?= $double ?>">
                                    <label class="<?= $label ?>">
                                        <?= __('Valor do Pagamento') ?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor total do evento. É importante que esteja igual ao valor da compensação do extrato bancário.') ?>"></i>
                                    </label>
                                    <?= $this->Form->control('valorbaixa', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'placeholder' => __('0,00'), 'id' => 'valorbaixa']) ?>
                                </div>
                            </div>

                            <div class="row box text-center pull-right-md" style="padding:0 0 0 15px; display:block; margin:auto; width:200px; margin-top:15px; margin-bottom:4px;">
                                <div class="btn btn-link">
                                    <?= $this->Form->radio('radio_bc', ['banco' => __('Banco'), 
                                                                        'caixa' => __('Carteira')
                                                                       ],
                                                                       ['legend'      => false,
                                                                        'default'     => 'banco',
                                                                        'hiddenField' => false,
                                                                        'label'       => ['class' => 'radio-inline btn']
                                                                       ]) ?>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: -15px;">
                                <div class="<?= $single ?> banco">
                                    <label class="<?= $label ?>">
                                        <?= __('Banco') ?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Selecione um banco.') ?>"></i>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon input-border-left">
                                            <?= $this->Html->link('', ['controller' => 'banks', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Banco'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Banco'), 'escape' => false]) ?>
                                        </div>
                                        <input id="banks_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do banco ou adicione') ?>"><div class="loadingBanks"></div>
                                    </div>
                                    <input name="banks_id" id="banks_id" type="hidden">
                                </div>

                                <div class="<?= $single ?> caixa hidden">
                                    <label class="<?= $label ?>">
                                        <?= __('Carteira') ?>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Selecione uma carteira.') ?>"></i>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-addon input-border-left">
                                            <?= $this->Html->link('', ['controller' => 'boxes', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Carteira'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Carteira'), 'escape' => false]) ?>
                                        </div>
                                        <input id="boxes_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome da carteira ou adicione') ?>"><div class="loadingBoxes"></div>
                                    </div>
                                    <input name="boxes_id" id="boxes_id" type="hidden">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="<?= $double ?> box" style="min-height: 214px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Observações') ?></label>
                        <?= $this->Form->textarea('obs', ['label' => false, 'type' => 'textarea', 'id' => 'text', 'maxlength' => '300', 'class' => 'form-control form-group']) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
    <?= $this->Html->link(__(' Saldos de Bancos/Carteiras'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Carteiras'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
    <?php if ($this->request->Session()->read('sessionPlan') != 4) { ?>
    <?= $this->Html->link(__(' Saldos de Cartões'), ['controller' => 'pages', 'action' => 'saldosCartoes'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos Cartões'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
    <?php }//if ($this->request->Session()->read('sessionPlan') != 4) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>