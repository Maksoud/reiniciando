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
/* File: src/Template/Transfers/add_simple.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('transfer') ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-boxes.min',
                         'list-banks.min',
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
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="min-height: 190px;">
                <div class="row">
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
                            <?= __('Descrição') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Nele você deverá informar a descrição do lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '100', 'required' => true]) ?>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="<?= $double ?> well" style="min-height: 294px;">
                <div class="row">
                    <div class="<?= $double ?> top-10">
                        <h5 class="text-center">
                            <span class="text-bold"><?= __('DADOS DE ORIGEM') ?></span>
                        </h5>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="radio-inline btn btn-link">
                            <?= $this->Form->radio('radio_origem', ['banco_origem' => __('Banco'), 'caixa_origem' => __('Carteira')], 
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
                                <?= __('Carteira') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a carteira de origem.') ?>"></i>
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
                <div class="row">
                    <div class="<?= $double ?> top-10">
                        <h5 class="text-center">
                            <span class="text-bold"><?= __('DADOS DE DESTINO') ?></span>
                        </h5>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="radio-inline btn btn-link">
                            <?= $this->Form->radio('radio_destino', ['banco_destino' => __('Banco'), 'caixa_destino' => __('Carteira')], 
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
                                <?= __('Carteira') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a carteira de destino.') ?>"></i>
                            </label>
                            <div class="input-group">
                                <div class="input-group-addon input-border-left">
                                    <?= $this->Html->link('', ['controller' => 'boxes', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Carteira'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Carteira'), 'escape' => false]) ?>
                                </div>
                                <input id="boxes_title_dest" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome da carteira ou adicione') ?>"><div class="loadingBoxesDest"></div>
                            </div>
                            <input name="boxes_dest" id="boxes_dest" type="hidden">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="min-height: 294px;">
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