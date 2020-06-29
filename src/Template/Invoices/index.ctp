<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Invoices */
/* File: src/Template/Invoices/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Invoices', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Nova Nota Fiscal'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Faturamentos') ?></h3>
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
                    <?= $this->Form->control('nf_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Número da NF'), 'value' => @$this->request->query['nf_search']]); ?>
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- status -'), 'options' => ['P' => __('Em Entrega'),
                                                                                                                                                                                                                                     'C' => __('Cancelado'),
                                                                                                                                                                                                                                     'F' => __('Finalizado')
                                                                                                                                                                                                                                    ], // P - delivering, C - cancelled, F - finalized
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
                    <th class="text-nowrap col-xs-1"><?= __('Nota Fiscal') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Nº Pedido') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Emissão da NF') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Previsão de Entrega') ?></th>
                    <th class="text-left"><?= __('Cliente') ?></th>
                    <th class="text-left"><?= __('Fornecedor') ?></th>
                    <th class="text-center text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                    <th class="text-center text-nowrap col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                    <tr>
                        <td class="text-left"><?= $invoice->nf ? str_pad($invoice->nf, 6, '0', STR_PAD_LEFT) : 'Avulso' ?></td>
                        <td class="text-left">
                            <?= $invoice->Sells['code'] ? $this->Html->link('V'.str_pad($invoice->Sells['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Sells', 'action' => 'view', $invoice->Sells['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Pedido de Venda']) : ''; ?>
                            <?= $invoice->Purchases['code'] ? $this->Html->link('C'.str_pad($invoice->Purchases['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Purchases', 'action' => 'view', $invoice->Purchases['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Pedido de Compra']) : ''; ?>
                            <?= !$invoice->Sells['code'] && !$invoice->Purchases['code'] ? 'Avulso' : '' ?>
                        </td>
                        <td class="text-left"><?= $this->MyHtml->date($invoice->dtemissaonf) ?></td>
                        <td class="text-left"><?= $this->MyHtml->date($invoice->dtdelivery) ?></td>
                        <td class="text-left"><?= $invoice->Customers['title'] ? $invoice->Customers['title'] : '-' ?></td>
                        <td class="text-left"><?= $invoice->Providers['title'] ? $invoice->Providers['title'] : '-' ?></td>
                        <td class="text-right"><?= $this->Number->precision($invoice->grandtotal, 2) ?></td>
                        <td class="text-center"><?= $this->Invoices->status($invoice->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $invoice->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?php if ($invoice->status == 'P') { // P - delivering, C - cancelled, F - finalized ?>
                            <?= $this->Html->link('', ['action' => 'finish', $invoice->id], ['class' => 'btn btn-actions btn_modal fa fa-check', 'data-size' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Finalizar Faturamento'), 'title' => __('Finalizar'), 'escape' => false]) ?>
                            <?php $this->Form->postLink('', ['action' => 'delete', $invoice->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//if ($invoice->status == 'P') ?>
                            <?php if ($invoice->status == 'F') { // P - delivering, C - cancelled, F - finalized ?>
                                <?= $this->Form->postLink('', ['action' => 'cancel', $invoice->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'data-loading-text' => __('Carregando...'), 'title' => __('Cancelar'), 'escape' => false]) ?>
                            <?php }//if ($invoice->status == 'F') ?>
                            <?php if ($invoice->status == 'C') { // P - delivering, C - cancelled, F - finalized ?>
                            <?= $this->Form->postLink('', ['action' => 'reopen', $invoice->id], ['confirm' => __('Você tem certeza que deseja reativar o registro?'), 'class' => 'btn btn-actions fa fa-refresh', 'title' => __('Reativar'), 'escape' => false]) ?>
                            <?php $this->Form->postLink('', ['action' => 'delete', $invoice->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//if ($invoice->status == 'C') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
    <div class="col-xs-12 bottom-50">
        <div class="box">
            <?= $this->Html->link(__(' Relação de Pedidos'), ['controller' => 'pages', 'action' => 'pedidos'], ['class' => 'btn_modal box-shadow scroll-modal btn btn-warning btn-shortcut fa fa-eye ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relação de Pedidos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Relação de Pedidos'), 'escape' => false]) ?>
        </div>
    </div>
    
</div>