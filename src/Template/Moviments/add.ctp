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
/* File: src/Template/Moviments/add.ctp */
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
                         'list-customers.min',
                         'list-providers.min',
                         'list-boxes.min',
                         'list-banks.min',
                         'list-event-types.min',
                         'list-document-types.min',
                         'list-cards.min',
                         'list-costs.min',
                         'list-account-plans.min'
                        ]) ?>

<?php
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 252px;">
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
                            <?= __('Tipo de Documento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de documentos. Ex: À vista, Boleto, etc.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'document_types', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'id' => 'document_types_add', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Documentos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Documentos'), 'escape' => false]) ?>
                            </div>
                            <input id="document_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Fatura') ?>" required="true"><div class="loadingDocuments"></div>
                        </div>
                        <input name="document_types_id" id="document_types_id" type="hidden">
                    </div>
                    <div class="<?= $double ?> bottom-0">
                        <div class="row top-15 left-5">
                            <div class="<?= $double ?> top-10 bottom-10">
                                <?= $this->Html->link(__(' Informar Cartão'), '#collapseCard', ['id' => 'informarCard', 'class' => 'btn btn-primary fa fa-credit-card', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="collapse" id="collapseCard">
                        <div class="<?= $single ?> top-5 bottom-0">
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
            </div>

            <div class="<?= $double ?> well" style="min-height: 252px;">
                <div class="row top-10">
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


                <div class="row" style="margin-bottom: -10px;">
                    
                    <div class="<?= $single ?> C hidden">
                        <label class="<?= $label ?>">
                            <?= __('Cliente') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de ser uma receita, este campo deverá ser preenchido.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'customers', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Cliente'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Adicionar Cliente'), 'escape' => false]) ?>
                            </div>
                            <input id="customers_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do cliente ou adicione') ?>"><div class="loadingCustomers"></div>
                        </div>
                        <input name="customers_id" id="customers_id" type="hidden">
                    </div>
                    
                    <div class="<?= $single ?> D">
                        <label class="<?= $label ?>">
                            <?= __('Fornecedor') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de ser uma despesa, este campo deverá ser preenchido.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'providers', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Fornecedor'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Adicionar Fornecedor'), 'escape' => false]) ?>
                            </div>
                            <input id="providers_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do fornecedor ou adicione') ?>"><div class="loadingProviders"></div>
                        </div>
                        <input name="providers_id" id="providers_id" type="hidden">
                    </div>
                    
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="<?= $double ?> box" style="min-height: 180px;">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Documento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é opcional. Deverá ser usado para agrupamento por assunto ex: Energia, Água, NF1234. Use no máximo 25 caracteres.') ?>"></i>
                        </label>
                        <?= $this->Form->control('documento', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '25']) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento. É possível filtrar em relatórios.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Histórico') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Nele você deverá informar a descrição do lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 180px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Centro de Custos') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Utilize os centros de custos para agrupar despesas e receitas por fonte. Ex: Reforma Predial, Loja A, Loja B, Automóveis.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'costs', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Centro de Custos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Centro de Custos'), 'escape' => false]) ?>
                            </div>
                            <input id="costs_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do centro de custos ou adicione') ?>"><div class="loadingCosts"></div>
                        </div>
                        <input name="costs_id" id="costs_id" type="hidden">
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Plano de Contas') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Utilize os planos de contas para agrupar despesas e receitas por assunto. Ex: Água, Luz, Lazer, Despesas Diversas, etc.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'accountPlans', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Plano de Contas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Plano de Contas'), 'escape' => false]) ?>
                            </div>
                            <input id="account_plans_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do plano de contas ou adicione') ?>"><div class="loadingAccounts"></div>
                        </div>
                        <input name="account_plans_id" id="account_plans_id" type="hidden">
                    </div>
                </div>
            </div>

            <div class="<?= $single ?>">
                <div class="row">
                    <label class="<?= $label ?>"><?= __('Observações') ?></label>
                    <?= $this->Form->textarea('obs', ['label' => false, 'type' => 'textarea', 'id' => 'text', 'maxlength' => '300', 'class' => 'form-control form-group']) ?>
                    <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                </div>
            </div>

            <div class="<?= $single ?> row" style="margin-top: -20px;">
                <?= $this->Html->link(__(' Informar Pagamento'), '#collapsePagamento', ['id' => 'informarPagamento', 'class' => 'btn btn-primary fa fa-usd', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
            </div>

            <div class="collapse" id="collapsePagamento">
                <div class="<?= $double ?> well" style="min-height: 190px;">
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Data do Pagamento') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data do evento. É importante que esteja igual a data da compensação do extrato bancário.') ?>"></i>
                            </label>
                            <?= $this->Form->control('dtbaixa', ['label' => false, 'type' => 'text', 'autocomplete' => 'off', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020')]) ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Tipo de Evento') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de eventos. Ex: Dinheiro, Cheque, Cartão, etc.') ?>"></i>
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon input-border-left">
                                    <?= $this->Html->link('', ['controller' => 'event_types', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Evento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Evento'), 'escape' => false]) ?>
                                </div>
                                <input id="event_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Dinheiro') ?>"><div class="loadingEvents"></div>
                            </div>
                            <input name="event_types_id" id="event_types_id" type="hidden">
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
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Tipo do Pagamento') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe se este pagamento refere-se ao total da fatura ou se é apenas uma parte do pagamento. No caso de pagamento parcial, a diferença será adicionada em uma nova fatura.') ?>"></i>
                            </label>
                            <?= $this->Form->control('parcial', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => [null => __('Pagamento Total'), 'P' => __('Pagamento Parcial')]]) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $double ?> well" style="min-height: 190px;">

                    <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:200px; margin-top:15px; margin-bottom:4px;">
                        <div class="btn btn-link">
                            <?= $this->Form->radio('radio_bc', ['banco'   => __('Banco'), 'caixa' => __('Caixa')],
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

                            <div class="<?= $double ?> bottom-0">
                                <div class="row top-5">
                                    <div class="<?= $double ?>">
                                        <?= $this->Html->link(__(' Informar Cheque'), '#collapseCheck', ['class' => 'btn btn-primary fa fa-cc', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="collapse" id="collapseCheck">
                                <div class="<?= $single ?>">
                                    <div class="box">
                                        <div class="row">
                                            <div class="<?= $double ?>">
                                                <label class="<?= $label ?>">
                                                    <?= __('Nº do Cheque') ?>
                                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o número do cheque se a movimentação for realizada com cheque.') ?>"></i>
                                                </label>
                                                <?= $this->Form->control('cheque', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                                            </div>
                                            <div class="<?= $double ?>">
                                                <label class="<?= $label ?>">
                                                    <?= __('Data de Emissão') ?>
                                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data de emissão do cheque.') ?>"></i>
                                                </label>
                                                <?= $this->Form->control('emissaoch', ['label' => false, 'type' => 'text', 'autocomplete' => 'off', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'type' => 'text']) ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="<?= $single ?>">
                                                <label class="<?= $label ?>">
                                                    <?= __('Nominal à') ?>
                                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o nome da pessoa ou empresa em que o cheque está nominado.') ?>"></i>
                                                </label>
                                                <?= $this->Form->control('nominal', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="<?= $single ?> caixa hidden">
                            <label class="<?= $label ?>">
                                <?= __('Caixa') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Selecione um caixa.') ?>"></i>
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon input-border-left">
                                    <?= $this->Html->link('', ['controller' => 'boxes', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Caixa'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Caixa'), 'escape' => false]) ?>
                                </div>
                                <input id="boxes_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do caixa ou adicione') ?>"><div class="loadingBoxes"></div>
                            </div>
                            <input name="boxes_id" id="boxes_id" type="hidden">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
	<?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
	<?= $this->Html->link(__(' Saldos de Cartões'), ['controller' => 'pages', 'action' => 'saldosCartoes'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos Cartões'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
	<?= $this->Html->link(__(' Lista de Planos de Contas'), ['controller' => 'AccountPlans', 'action' => 'listPlans'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Lista de Planos de Contas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>