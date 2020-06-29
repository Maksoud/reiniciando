<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* PurchaseRequests */
/* File: src/Template/PurchaseRequests/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'PurchaseRequests', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-size' => 'lg', 'data-title' => __('Nova Solicitação de Compra'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Solicitações de Compras') ?></h3>
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
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- status -'), 'options' => ['P' => __('Pendente'),
                                                                                                                                                                                                                                     'A' => __('Em Andamento'),
                                                                                                                                                                                                                                     'C' => __('Cancelado'),
                                                                                                                                                                                                                                     'F' => __('Finalizado')
                                                                                                                                                                                                                                    ], 
                                                        'value' => @$this->request->query['status_search']]); ?>
                    <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list top-5', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
                <?= $this->Form->end(); ?>        
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-left col-xs-1"><?= __('Código') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Data do Lançamento') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Ordem de Fabricação') ?></th>
                    <th class="text-left"><?= __('Solicitante') ?></th>
                    <th class="text-left"><?= __('Observações') ?></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchaseRequests as $purchaseRequest): ?>
                    <tr>
                        <td class="text-left"><?= str_pad($purchaseRequest->code, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?= $this->MyHtml->date($purchaseRequest->date) ?></td>
                        <td class="text-left"><?= $purchaseRequest->Industrializations['code'] ? $this->Html->link(str_pad($purchaseRequest->Industrializations['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Industrializations', 'action' => 'view', $purchaseRequest->Industrializations['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Ordem de Fabricação']) : '-'; ?></td>
                        <td class="text-left"><?= $purchaseRequest->applicant ?></td>
                        <td class="text-left"><?= $purchaseRequest->obs ?></td>
                        <td class="text-center"><?= $this->PurchaseRequests->status($purchaseRequest->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $purchaseRequest->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                            <?php if ($purchaseRequest->status == 'P') { // P - pending, A - in progress, C - cancelled, F - finalized ?>
                            <?= $this->Html->link('', ['action' => 'edit', $purchaseRequest->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?php }//if ($purchaseRequest->status == 'P') ?>
                            <?php if ($purchaseRequest->status == 'A') { // P - pending, A - in progress, C - cancelled, F - finalized ?>
                            <?= $this->Form->postLink('', ['action' => 'finish', $purchaseRequest->id], ['confirm' => __('Você tem certeza que deseja FINALIZAR o registro?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => __('Carregando...'), 'title' => __('Finalizar Solicitação'), 'escape' => false]) ?>
                            <?php }//if ($purchaseRequest->status == 'A') ?>
                            <?php if ($purchaseRequest->status == 'P') { // P - pending, A - in progress, C - cancelled, F - finalized ?>
                            <?= $this->Form->postLink('', ['action' => 'cancel', $purchaseRequest->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'data-loading-text' => __('Carregando...'), 'title' => __('Cancelar'), 'escape' => false]) ?>
                            <?php }//if ($purchaseRequest->status == 'P') ?>
                            <?php //$this->Form->postLink('', ['action' => 'delete', $purchaseRequest->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>