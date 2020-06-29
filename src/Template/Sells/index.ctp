<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Sells */
/* File: src/Template/Sells/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Sells', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Pedido de Venda'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Pedidos de Vendas') ?></h3>
    </div>

    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed box-shadow btn bottom-10" style="color:#fff;background-color:#337ab7;border-color:#2e6da4;" data-toggle="collapse" data-target="#search-collapse">
            <i class="fa fa-search"></i> <?= __('Filtros de Busca') ?>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="search-collapse">
        <div class="row form-busca bottom-10">
            <div class="col-xs-12 box box-body">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
                    <?= $this->Form->control('code_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Código do Registro'), 'value' => @$this->request->query['code_search']]); ?>
                    <?= $this->Form->control('customers_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Cliente'), 'value' => @$this->request->query['customers_search']]); ?>
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- status -'), 'options' => ['P' => __('Pendente'),
                                                                                                                                                                                                                                     'D' => __('Em Entrega'),
                                                                                                                                                                                                                                     'E' => __('Entrega Parcial'),
                                                                                                                                                                                                                                     'C' => __('Cancelado'),
                                                                                                                                                                                                                                     'F' => __('Finalizado')
                                                                                                                                                                                                                                    ], // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                                        'value' => @$this->request->query['status_search']]); ?>
                    <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list top-5', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer">
            <thead>
                <tr>
                    <th class="text-left col-xs-1"><?= __('Código') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Data do Lançamento') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Prazo de Entrega') ?></th>
                    <th class="text-left"><?= __('Cliente') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sells as $sell): ?>
                    <tr class="initialism">
                        <td class="text-left"><?= str_pad($sell->code, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?= $this->MyHtml->date($sell->date) ?></td>
                        <td class="text-left"><?= $this->MyHtml->date($sell->deadline) ?></td>
                        <td class="text-left"><?= $sell->Customers['title'] ?></td>
                        <td class="text-left"><?= $this->Number->precision($sell->grandtotal, 2); ?></td>
                        <td class="text-center"><?= $this->Sells->status($sell->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $sell->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                            <?php if ($sell->status == 'P') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized ?>
                            <?= $this->Html->link('', ['action' => 'edit', $sell->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?php }//if ($sell->status == 'P') ?>
                            <?php if ($sell->status == 'D' || $sell->status == 'E') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized ?>
                            <?= $this->Form->postLink('', ['action' => 'finish', $sell->id], ['confirm' => __('Você tem certeza que deseja FINALIZAR o registro?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => __('Carregando...'), 'title' => __('Finalizar Compra'), 'escape' => false]) ?>
                            <?php }//if ($sell->status == 'D' || $sell->status == 'E') ?>
                            <?php if ($sell->status != 'C') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized ?>
                            <?= $this->Form->postLink('', ['action' => 'cancel', $sell->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'data-loading-text' => __('Carregando...'), 'title' => __('Cancelar'), 'escape' => false]) ?>
                            <?php }//if ($sell->status != 'C') ?>
                            <?php if ($sell->status == 'C') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized ?>
                            <?= $this->Form->postLink('', ['action' => 'reopen', $sell->id], ['confirm' => __('Você tem certeza que deseja reativar o registro?'), 'class' => 'btn btn-actions fa fa-refresh', 'title' => __('Reativar'), 'escape' => false]) ?>
                            <?php $this->Form->postLink('', ['action' => 'delete', $sell->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//if ($sell->status == 'C') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>