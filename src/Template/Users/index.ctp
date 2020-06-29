<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Users */
/* File: src/Template/Users/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-size' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Novo Usuário', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Usuários') ?></h3>
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
                    <?= $this->Form->text('dtinicial_search', ['id' => 'dtinicial', 'autocomplete' => 'off', 'class' => 'form-control datepicker datemask', 'label' => false, 'placeholder' => 'Data Incial', 'value' => @$this->request->query['dtinicial_search']]) ?>
                    <?= $this->Form->text('dtfinal_search', ['id' => 'dtfinal', 'autocomplete' => 'off', 'class' => 'form-control datepicker datemask', 'label' => false, 'placeholder' => 'Data Final', 'value' => @$this->request->query['dtfinal_search']]) ?>
                    <?= $this->Form->text('name_search', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Nome', 'value' => @$this->request->query['name_search']]); ?>
                    <?= $this->Form->text('username_search', ['class' => 'form-control', 'label' => false, 'placeholder' => 'E-mail', 'value' => @$this->request->query['username_search']]); ?>
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
                    <th class="text-left"><?= __('ID') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-left"><?= __('Nome') ?></th>
                    <th class="text-left"><?= __('Usuário') ?></th>
                    <th class="text-left"><?= __('Permissão') ?></th>
                    <th class="text-center text-nowrap"><?= __('Último Acesso') ?></th>
                    <th class="text-center text-nowrap"></th>
                    <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                    <th class="text-nowrap"><?= __('Dados Cadastrais') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <td class="text-left"><?= str_pad($user->id, 3, '0', STR_PAD_LEFT) ?></td>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        <td class="text-left"><?= h($user->name) ?></td>
                        <td class="text-left"><?= h($user->username) ?></td>
                        <td class="text-left"><?= $this->UsersParameters->rules($user->UsersParameters['rules_id']) ?></td>
                        <td class="text-center"><?= $user->last_login ? date("d/m/Y H:i:s", strtotime($user->last_login)) : '-'; ?></td>
                        <td class="text-left"><?= $user->UsersParameters['sendmail'] == 'S' ? '<i class="fa fa-paper-plane-o" title="Recebe resumo de contas por e-mail"></i>' : ''; ?></td>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <td class="text-left"><?= h($user->Parameters['razao']) ?></td>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $user->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-size'=> 'sm', 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit', $user->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-size'=> 'sm', 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $user->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>

<?= $this->element('modal') ?>