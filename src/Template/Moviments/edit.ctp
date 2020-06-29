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
/* File: src/Template/Moviments/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($moviment) ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-customers.min',
                         'list-providers.min',
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
?>

<?php if ($moviment->status == 'P') { $disabled = 'disabled'; } else { $disabled = null; } ?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 230px;">

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
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de não informar o vencimento, este será preenchido considerando a periodicidade e a data do documento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020')]) ?>
                    </div>
                </div>

                <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:200px; margin-top:15px; margin-bottom:4px;">
                    <div class="btn btn-link">
                        <?= $this->Form->radio('creditodebito', ['C' => __('Receita'), 'D' => __('Despesa')], 
                                                                ['legend'      => false, 
                                                                 'hiddenField' => false,
                                                                 'label'       => ['class' => 'radio-inline btn']
                                                                ]) ?>
                    </div>
                </div>

                <div class="row" style="margin-bottom: -10px;">
                    <!-- CONTROLE DE VISUALIZAÇÃO -->
                    <div class="<?= $single ?> C <?php if ($moviment->creditodebito != 'C') {echo 'hidden';} ?>">
                        <label class="<?= $label ?>">
                            <?= __('Cliente') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de ser uma receita, este campo deverá ser preenchido.') ?>"></i>
                        </label>
                        <?php if ($moviment->creditodebito != 'D') {$required = true;} else {$required = false;} ?>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'customers', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Cliente'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Adicionar Cliente'), 'escape' => false, $disabled]) ?>
                            </div>
                            <?php if (!empty($moviment->Customers['id'])) {$customer = $moviment->Customers['title'].' ('.$moviment->Customers['cpfcnpj'].')';} else {$customer = null;} ?>
                            <input id="customers_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do cliente ou adicione') ?>" value="<?= $customer ?>" <?= $disabled ?>><div class="loadingCustomers"></div>
                        </div>
                        <input name="customers_id" id="customers_id" type="hidden" value="<?= $moviment->Customers['id'] ?>">
                    </div>
                    <!-- CONTROLE DE VISUALIZAÇÃO -->
                    <div class="<?= $single ?> D <?php if ($moviment->creditodebito != 'D') {echo 'hidden';} ?>">
                        <label class="<?= $label ?>">
                            <?= __('Fornecedor') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de ser uma despesa, este campo deverá ser preenchido.') ?>"></i>
                        </label>
                        <?php if ($moviment->creditodebito != 'C') {$required = true;} else {$required = false;} ?>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'providers', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Fornecedor'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Adicionar Fornecedor'), 'escape' => false, $disabled]) ?>
                            </div>
                            <?php if (!empty($moviment->Providers['id'])) {$provider = $moviment->Providers['title'].' ('.$moviment->Providers['cpfcnpj'].')';} else {$provider = null;} ?>
                            <input id="providers_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do fornecedor ou adicione') ?>" value="<?= $provider ?>" <?= $disabled ?>><div class="loadingProviders"></div>
                        </div>
                        <input name="providers_id" id="providers_id" type="hidden" value="<?= $moviment->Providers['id'] ?>">
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> well" style="min-height: 230px;">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor da Parcela') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor da parcela.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                                <?php //MUITO IMPORTANTE NO TRATAMENTO DOS DADOS NO CONTROLLER ?>
                                <?= $this->Form->control('status', ['label' => false, 'type' => 'hidden', 'value' => $moviment->status]) ?>
                                <?php //BAIXA PARCIAL NÃO PERMITE MUDAR O VALOR EM ABERTO ?>
                                <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input.' input-border-right valuemask', 'value' => $this->MyForm->decimal($moviment->valor - $moviment->valorpago), 'placeholder' => __('0,00'), 'required' => true, $disabled]) ?>
                        </div>
                    </div>
                    <div class="<?= $double ?>">
                        <?php
                            //Se houver lançamentos vinculados, não será permitido a mudança de tipo de documento.
                            $disabled = null;
                            if (!empty($movimentMergeds->toArray())) {
                                $disabled = 'disabled';
                            }
                        ?>
                        <label class="<?= $label ?>">
                            <?= __('Tipo de Documento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de documentos. Ex: À vista, Boleto, etc.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'document_types', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Documento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Documento'), 'escape' => false, $disabled]) ?>
                            </div>
                            <input id="document_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Fatura') ?>" required="true" value="<?= $moviment->DocumentTypes['title'] ?>" <?= $disabled ?>><div class="loadingDocuments"></div>
                        </div>
                        <input name="document_types_id" id="document_types_id" type="hidden" value="<?= $moviment->DocumentTypes['id'] ?>">
                    </div>
                    <?php
                        if (isset($disabled)) { echo $disabled;
                            echo '<small style="color:red;">'.__('Há lançamentos vinculados, tipo de documento não pode ser alterado.').'</small>';
                        }
                    ?>
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
                                <?= $this->Html->link('', ['controller' => 'costs', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Centro de Custos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Centro de Custos'), 'escape' => false]) ?>
                            </div>
                            <input id="costs_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do centro de custos ou adicione') ?>" value="<?= $moviment->Costs['title'] ?>"><div class="loadingCosts"></div>
                        </div>
                        <input name="costs_id" id="costs_id" type="hidden" value="<?= $moviment->Costs['id'] ?>">
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
                                <?= $this->Html->link('', ['controller' => 'accountPlans', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Plano de Contas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Plano de Contas'), 'escape' => false]) ?>
                            </div>
                            <input id="account_plans_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do plano de contas ou adicione') ?>" value="<?= $moviment->AccountPlans['classification'] ?> - <?= $moviment->AccountPlans['title'] ?>"><div class="loadingAccounts"></div>
                        </div>
                        <input name="account_plans_id" id="account_plans_id" type="hidden" value="<?= $moviment->AccountPlans['id'] ?>">
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
	<?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
	<?= $this->Html->link(__(' Lista de Planos de Contas'), ['controller' => 'AccountPlans', 'action' => 'listPlans'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Lista de Planos de Contas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>