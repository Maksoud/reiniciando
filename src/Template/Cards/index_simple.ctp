<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Cards */
/* File: src/Template/Cards/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Cards', 'action' => 'add_simple'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Cartão'), 'data-size' => 'sm', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Cartões') ?></h3>
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
                    <?= $this->Form->control('title_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Título do Registro'), 'value' => @$this->request->query['title_search']]); ?>
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => '- status -', 'options' => ['A' => __('Ativo'),
                                                                                                                                                                                                                                 'I' => __('Inativo'),
                                                                                                                                                                                                                                 'T' => __('Automático')
                                                                                                                                                                                                                                ], 
                                                        'value' => @$this->request->query['status_search']]); ?>
                    <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index_simple'], ['class'=>'btn btn-default fa fa-list top-5', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
                <?= $this->Form->end(); ?>        
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-left"><?= __('Título') ?></th>
                    <th class="text-left col-xs-1"><?= __('Bandeira') ?></th>
                    <th class="text-nowrap text-right"><?= __('Limite de Crédito') ?></th>
                    <th class="text-nowrap text-center col-xs-1"><?= __('Dia de Vencimento') ?></th>
                    <th class="text-nowrap text-center col-xs-1"><?= __('Melhor dia de Compra') ?></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cards as $card): ?>
                    <tr>
                        <td class="text-left"><?= $card->title ?></td>
                        <td class="text-left"><?= $card->bandeira ?></td>
                        <td class="text-right"><?= $this->Number->precision($card->limite, 2) ?></td>
                        <td class="text-center"><?= $card->vencimento ?></td>
                        <td class="text-center"><?= $card->melhor_dia ?></td>
                        <td class="text-center"><?= $this->Cards->status($card->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view_simple', $card->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'data-size' => 'sm', 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'editLimit', $card->id], ['class' => 'btn btn-actions btn_modal fa fa-usd', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Limite de Crédito'), 'data-size' => 'sm', 'title' => __('Limite de Crédito'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit_simple', $card->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'data-size' => 'sm', 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $card->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
    <div class="col-xs-12 bottom-50">
        <div class="box">
            <?= $this->Html->link(__(' Saldos de Cartões'), ['controller' => 'pages', 'action' => 'saldosCartoes'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Cartões'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Faturas de Cartões'), ['controller' => 'pages', 'action' => 'faturaCartoes'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-list-ul', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Faturas dos Cartões de Crédito'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
        </div>
    </div>
</div>