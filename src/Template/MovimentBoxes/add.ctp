<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentBoxes */
/* File: src/Template/MovimentBoxes/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('movimentBox') ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-customers.min',
                         'list-providers.min',
                         'list-boxes.min',
                         'list-event-types.min',
                         'list-document-types.min',
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
            <div class="<?= $double ?> well" style="min-height: 230px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório e necessário para cálculo do vencimento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input.' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Vencimento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de não informar o vencimento, este será preenchido com a data do documento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020')]) ?>
                    </div>
                </div>
                <div class="row box text-center" style="padding-top: 0px; padding-bottom: 0px; display: block; margin: auto; width: 210px; margin-top: 15px; margin-bottom: 4px;">
                    <div class="btn btn-link">
                        <?= $this->Form->radio('creditodebito', ['C' => 'Receita', 'D' => 'Despesa'], 
                                                                ['legend'      => false, 
                                                                 'default'     => 'C',
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]) ?>
                    </div>
                </div>
                <div class="row" style="margin-bottom: -10px;">
                    <div class="<?= $single ?> C">
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
                    <div class="<?= $single ?> D hidden">
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
            <div class="<?= $double ?> well" style="min-height: 230px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Tipo de Documento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de documentos. Ex: À vista, Boleto, etc.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'document_types', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Documento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Documento'), 'escape' => false]) ?>
                            </div>
                            <input id="document_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Fatura') ?>" required="true"><div class="loadingDocuments"></div>
                        </div>
                        <input name="document_types_id" id="document_types_id" type="hidden">
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor do lançamento.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input.' input-border-right valuemask', 'placeholder' => __('0,00'), 'required' => true]) ?>
                        </div>
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
                            <input id="event_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Dinheiro') ?>" required="true"><div class="loadingEvents"></div>
                        </div>
                        <input name="event_types_id" id="event_types_id" type="hidden">
                    </div>
                </div>
                <div class="row" style="margin-bottom: -10px;">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Caixa') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Campo obrigatório') ?>"></i>
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
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '100', 'required' => true]) ?>
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
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
	<?= $this->Html->link(__(' Saldos Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
	<?= $this->Html->link(__(' Lista de Planos de Contas'), ['controller' => 'AccountPlans', 'action' => 'listPlans'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Lista de Planos de Contas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>