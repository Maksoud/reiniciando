<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Knowledges */
/* File: src/Template/Knowledges/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Knowledges', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-size' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Novo Conhecimento', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Base de Conhecimento') ?></h3>
    </div>

    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed box-shadow btn bottom-10" style="color:#fff;background-color:#337ab7;border-color:#2e6da4;" data-toggle="collapse" data-target="#search-collapse">
            <i class="fa fa-search"></i> <?= __('Filtros de Busca') ?>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="search-collapse">
        <div class="row form-busca bottom-10">
            <div class="col-xs-12">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
                    <?= $this->Form->text('busca', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Título do Registro', 'value' => @$this->request->query['busca']]); ?>
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> <?= __('Buscar') ?></button>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
                <?= $this->Form->end(); ?>        
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                    <th class="text-nowrap col-xs-1"><?= __('ID') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-nowrap"><?= __('Descrição') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Data de Cadastro') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Data de Alteração') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($knowledges as $knowledge): ?>
                    <tr>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <td class="text-left"><?= str_pad($knowledge['id'], 6, '0', STR_PAD_LEFT) ?></td>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        <td class="text-left"><?= $knowledge->title ?></td>
                        <td class="text-left"><?= $knowledge->created ?></td>
                        <td class="text-left"><?= $knowledge->modified ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $knowledge->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                            <?= $this->Html->link('', ['action' => 'edit', $knowledge->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $knowledge->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>