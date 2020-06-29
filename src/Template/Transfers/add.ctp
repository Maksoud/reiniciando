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
/* File: src/Template/Transfers/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('transfer') ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-boxes.min',
                         'list-banks.min',
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
    $style_check  = 'margin: -15px 0 0 -15px;';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 190px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório e necessário para o lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input.' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Programação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é opcional e deverá ser preenchido apenas em caso de transferência agendada.') ?>"></i>
                        </label>
                        <?= $this->Form->control('prog', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => false]) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> well" style="min-height: 190px;">
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
                            <input id="document_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Fatura') ?>"><div class="loadingDocuments"></div>
                        </div>
                        <input name="document_types_id" id="document_types_id" type="hidden">
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor da transferência.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input.' input-border-right valuemask', 'placeholder' => __('0,00'), 'required' => true]) ?>
                        </div>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Tipo de Evento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de documentos. Ex: À vista, Boleto, etc.') ?>"></i>
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
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nº do Cheque') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o número do cheque se a movimentação for realizada com cheque.') ?>"></i>
                        </label>
                        <?= $this->Form->control('cheque', ['label' => false, 'type' => 'text', 'maxlength' => '20', 'class' => $input]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data de Emissão') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data de emissão do cheque.') ?>"></i>
                        </label>
                        <?= $this->Form->control('emissaoch', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => 'Ex. 01/01/2020']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nominal à') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o nome da pessoa ou empresa em que o cheque está nominado.') ?>"></i>
                        </label>
                        <?= $this->Form->control('nominal', ['label' => false, 'type' => 'text', 'maxlength' => '120', 'class' => $input]) ?>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="<?= $double ?> well">
                <h5 class="text-center">
                    <span class="text-bold"span class="text-bold"><?= __('DADOS DE ORIGEM') ?></span>
                </h5>
                <div class="text-center">
                    <div class="radio-inline btn btn-link">
                        <?= $this->Form->radio('radio_origem', ['banco_origem' => __('Banco'), 'caixa_origem' => __('Caixa')], 
                                                               ['legend'      => false, 
                                                                'default'     => 'banco_origem', 
                                                                'hiddenField' => false,
                                                                'label'       => ['class' => 'radio-inline btn']
                                                               ]) ?>
                    </div>
                </div>
                <div class="<?= $single ?>">
                    <div class="banco_origem">
                        <label class="<?= $label ?>">
                            <?= __('Banco') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o banco de origem.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'banks', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Banco'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Banco'), 'escape' => false]) ?>
                            </div>
                            <input id="banks_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do banco ou adicione') ?>"><div class="loadingBanks"></div>
                        </div>
                        <input name="banks_id" id="banks_id" type="hidden">
                    </div>
                    <div class="caixa_origem hidden">
                        <label class="<?= $label ?>">
                            <?= __('Caixa') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o caixa de origem.') ?>"></i>
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
                <div class="<?= $single ?>">
                    <label class="<?= $label ?>" style="font-weight: normal">
                        <?= __('Centro de Custo') ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon input-border-left">
                            <?= $this->Html->link('', ['controller' => 'costs', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Centro de Custos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Centro de Custos'), 'escape' => false]) ?>
                        </div>
                        <input id="costs_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do centro de custos ou adicione') ?>"><div class="loadingCosts"></div>
                    </div>
                    <input name="costs_id" id="costs_id" type="hidden">
                </div>
                <div class="<?= $single ?>">
                    <label class="<?= $label ?>" style="font-weight: normal">
                        <?= __('Plano de Contas') ?>
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
            
            <div class="<?= $double ?> well">
                <h5 class="text-center">
                    <span class="text-bold"><?= __('DADOS DE DESTINO') ?></span>
                </h5>
                <div class="text-center">
                    <div class="radio-inline btn btn-link">
                        <?= $this->Form->radio('radio_destino', ['banco_destino' => __('Banco'), 'caixa_destino' => __('Caixa')], 
                                                                ['legend'      => false,
                                                                 'default'     =>'banco_destino',
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]) ?>
                    </div>
                </div>
                <div class="<?= $single ?>">
                    <div class="banco_destino">
                        <label class="<?= $label ?>">
                            <?= __('Banco') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o banco de destino.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'banks', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Banco'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Banco'), 'escape' => false]) ?>
                            </div>
                            <input id="banks_title_dest" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do banco ou adicione') ?>"><div class="loadingBanksDest"></div>
                        </div>
                        <input name="banks_dest" id="banks_dest" type="hidden">
                    </div>
                    <div class="caixa_destino hidden">
                        <label class="<?= $label ?>">
                            <?= __('Caixa') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o caixa de destino.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'boxes', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Caixa'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Caixa'), 'escape' => false]) ?>
                            </div>
                            <input id="boxes_title_dest" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do caixa ou adicione') ?>"><div class="loadingBoxesDest"></div>
                        </div>
                        <input name="boxes_dest" id="boxes_dest" type="hidden">
                    </div>
                </div>
                <div class="<?= $single ?>">
                    <label class="<?= $label ?>" style="font-weight: normal">
                        <?= __('Centro de Custo') ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon input-border-left">
                            <?= $this->Html->link('', ['controller' => 'costs', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Centro de Custos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Centro de Custos'), 'escape' => false]) ?>
                        </div>
                        <input id="costs_title_dest" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do centro de custos ou adicione') ?>"><div class="loadingCostsDest"></div>
                    </div>
                    <input name="costs_dest" id="costs_dest" type="hidden">
                </div>
                <div class="<?= $single ?>">
                    <label class="<?= $label ?>" style="font-weight: normal">
                        <?= __('Plano de Contas') ?>
                    </label>
                    <div class="input-group">
                        <div class="input-group-addon input-border-left">
                            <?= $this->Html->link('', ['controller' => 'accountPlans', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Plano de Contas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Plano de Contas'), 'escape' => false]) ?>
                        </div>
                        <input id="account_plans_title_dest" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do plano de contas ou adicione') ?>"><div class="loadingAccountsDest"></div>
                    </div>
                    <input name="account_plans_dest" id="account_plans_dest" type="hidden">
                </div>
            </div>
            
            <div class="<?= $single ?>">
                <div class="row">
                    <label class="<?= $label ?>" style="font-weight: normal">
                        <?= __('Observações') ?>
                    </label>
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