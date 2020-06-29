<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Products */
/* File: src/Template/Products/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Products', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Produto'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Produtos') ?></h3>
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
                    <?= $this->Form->control('code_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Códigos int, ext, NCM, EAN'), 'value' => @$this->request->query['code_search']]); ?>
                    <?= $this->Form->control('title_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Título do Registro'), 'value' => @$this->request->query['title_search']]); ?>
                    <?= $this->Form->control('product_types_id_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- tipos -'), 'options' => $types, 'value' => @$this->request->query['product_types_id_search']]); ?>
                    <?= $this->Form->control('product_groups_id_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- grupos -'), 'options' => $groups, 'value' => @$this->request->query['product_groups_id_search']]); ?>
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
                    <th class="text-nowrap col-xs-1"><?= __('Cód.Interno') ?></th>
                    <th class="text-left"><?= __('Título') ?></th>
                    <th class="text-left"><?= __('Tipos') ?></th>
                    <th class="text-left"><?= __('Grupos') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="text-left"><?= str_pad($product->code, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left">
                            <?= $product->title ?>
                            <?php
                            if (!empty($product->ProductTitles)) {
                                echo '<i class="fa fa-paperclip"></i>';
                            }//if (!empty($product->ProductTitles))
                            ?>
                        </td>
                        <td class="text-left"><?= $product->product_types_id ? $product->product_types_id.' - '.$product->ProductTypes['title'] : '-'; ?></td>
                        <td class="text-left"><?= $product->product_groups_id ? $product->product_groups_id.' - '.$product->ProductGroups['title'] : '-'; ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $product->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                            <?= $this->Html->link('', ['action' => 'edit', $product->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $product->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro e todos os vinculados?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="panel-heading" style="font-size: 11px;">
        <i class="fa fa-paperclip"></i> <span style="font-size:10px;"><?= __('Descrição secundária de produto vinculado a um produto principal.') ?></span>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>