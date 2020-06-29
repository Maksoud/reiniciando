<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* DocumentTypes */
/* File: src/Template/DocumentTypes/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'DocumentTypes', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Novo Tipo de Documentos'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Tipos de Documentos') ?></h3>
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
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list top-5', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-nowrap col-xs-1"><?= __('Data do Cadastro') ?></th>
                    <th class="text-left"><?= __('Título') ?></th>
                    <th class="text-nowrap"><?= __('Agrupa Pagamentos') ?></th>
                    <th class="text-nowrap"><?= __('Duplica Documento') ?></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentTypes as $documentType): ?>
                    <tr>
                        <td class="text-left"><?= $this->MyHtml->date($documentType->created) ?></td>
                        <td class="text-left"><?= $documentType->title ?></td>
                        <td class="text-left"><?= $documentType->vinculapgto == 'S' ? __('Sim') : __('Não'); ?></td>
                        <td class="text-left"><?= $documentType->duplicadoc == 'S' ? __('Sim') : __('Não'); ?></td>
                        <td class="text-center"><?= $this->DocumentTypes->status($documentType->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $documentType->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                            <?= $this->Html->link('', ['action' => 'edit', $documentType->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $documentType->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>