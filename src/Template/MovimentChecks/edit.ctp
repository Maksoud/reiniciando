<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentChecks */
/* File: src/Template/MovimentChecks/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($movimentCheck) ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-event-types.min',
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
            <div class="<?= $double ?> well" style="min-height: 200px;">
                
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Cheque') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data de emissão do cheque.') ?>"></i>
                        </label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'disabled' => true]) ?>
                    </div>
                
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nº Cheque') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o número do cheque se a movimentação for realizada com cheque.') ?>"></i>
                        </label>
                        <?= $this->Form->control('cheque', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input, 'disabled' => true]) ?>
                    </div>
                </div>
                
                <div class="row" style="margin-bottom: -10px;">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Banco') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório.') ?>"></i>
                        </label>
                        <?= $this->Form->control('banks_id', ['label' => false, 'type' => 'select', 'class' => $input, 'disabled' => true]) ?>
                    </div>
                </div>
                
            </div>
            
            <div class="<?= $double ?> well" style="min-height: 200px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Tipo de Evento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de eventos. Ex: Dinheiro, Cheque, Cartão, etc.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'event_types', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Evento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Evento'), 'escape' => false]) ?>
                            </div>
                            <input id="event_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Dinheiro') ?>" required="true" value="<?= $movimentCheck->EventTypes['title'] ?>"><div class="loadingEvents"></div>
                        </div>
                        <input id="event_types_id" type="hidden" value="<?= $movimentCheck->EventTypes['id'] ?>">
                    </div>
                    
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor do Cheque') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Valor do cheque.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'value' => $this->MyForm->decimal($movimentCheck['valor']), 'class' => $input.' input-border-right valuemask', 'placeholder' => __('0,00'), 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nominal à') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o nome da pessoa ou empresa em que o cheque está nominado.') ?>"></i>
                        </label>
                        <?= $this->Form->control('nominal', ['label' => false, 'type' => 'text', 'class' => $input, 'disabled' => true]) ?>
                    </div>
                </div>
                
            </div>
            
            <div class="clearfix"></div>
            
            <div class="<?= $double ?> box" style="min-height: 180px;">
                
                <div class="row">
                    
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Documento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é opcional. Deverá ser usado para agrupamento por assunto. Ex: Energia, Água, NF1234.') ?>"></i>
                        </label>
                        <?= $this->Form->control('documento', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '25']) ?>
                    </div>
                    
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento. É possível filtrar em relatórios.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'disabled' => true, 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
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
                                <?= $this->Html->link('', ['controller' => 'costs', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Centro de Custos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Centro de Custos'), 'escape' => false]) ?>
                            </div>
                            <input id="costs_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do centro de custos ou adicione') ?>" value="<?= $movimentCheck->Costs['title'] ?>"><div class="loadingCosts"></div>
                        </div>
                        <input id="costs_id" type="hidden" value="<?= $movimentCheck->Costs['id'] ?>">
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
                            <input id="account_plans_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do plano de contas ou adicione') ?>" value="<?= $movimentCheck->AccountPlans['classification'] ?> - <?= $movimentCheck->AccountPlans['title'] ?>"><div class="loadingAccounts"></div>
                        </div>
                        <input id="account_plans_id" type="hidden" value="<?= $movimentCheck->AccountPlans['id'] ?>">
                    </div>
                </div>
                
            </div>
            
            <div class="<?= $single ?>">
                <div class="row">
                    <label class="<?= $label ?>">
                        <?= __('Observações') ?>
                    </label>
                    <?= $this->Form->textarea('obs', ['label' => false, 'type' => 'textarea', 'id' => 'text', 'maxlength' => '300', 'class' => 'form-control form-group']) ?>
                    <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                </div>
            </div>
            
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>