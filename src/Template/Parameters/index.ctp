<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Parameters */
/* File: src/Template/Parameters/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
       <div class="pull-right">
            <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
            <?= $this->Html->link(__(' Relação de Clientes'), ['controller' => 'Pages', 'action' => 'system_customers'], ['class' => 'btn btn-primary fa fa-file-text-o top-20 right-10', 'data-loading-text' => __('Enviando...'), 'escape' => false]) ?>
            <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
            <?= $this->Html->link(__(' Incluir'), ['controller' => 'Parameters', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Cadastro'), 'escape' => false]) ?>
       </div>
       <h3 class="page-header top-20"><?= __('Meus Dados') ?></h3> 
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
                    <?= $this->Form->text('razao_search', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Razão Social', 'value' => @$this->request->query['razao_search']]); ?>
                    <?= $this->Form->text('cpfcnpj_search', ['class' => 'form-control', 'label' => false, 'placeholder' => 'CPF ou CNPJ', 'value' => @$this->request->query['cpfcnpj_search']]); ?>
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
                    <th class="text-left col-xs-1"><?= __('ID') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-nowrap"><?= __('Nome/Razão Social') ?></th>
                    <th class="text-nowrap"><?= __('CPF/CNPJ') ?></th>
                    <th class="text-left"><?= __('Contato') ?></th>
                    <th class="text-nowrap"><?= __('E-mail de Cobrança') ?></th>
                    <th class="text-left col-xs-1"><?= __('Plano') ?></th>
                    <th class="text-left col-xs-1"><?= __('Validade') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($parameters as $parameter): ?>
                    <tr class="initialism">
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <td class="text-left"><?= str_pad($parameter->id, 3, '0', STR_PAD_LEFT) ?></td>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        <td class="text-left"><?= $parameter->razao ?></td>
                        <td class="text-left"><?= $parameter->cpfcnpj ?></td>
                        <td class="text-left"><?= $parameter->telefone ?></td>
                        <td class="text-left"><?= $parameter->email_cobranca ?></td>
                        <td class="text-left"><?= $parameter->plans_id . ' - ' . $this->Parameters->planos($parameter->plans_id) ?></td>
                        <td class="text-left">
                        <?php if (!isset($parameter->dtvalidade)) { ?>
                            <?= h('-') ?>
                        <?php } else { ?>
                            <?php if (date('Y-m-d') < $parameter->dtvalidade) { ?>
                                <span style="color: #2aabd2">
                                    <?= date("d/m/Y", strtotime($parameter->dtvalidade)) ?>
                                </span>
                            <?php } elseif (date('Y-m-d') > $parameter->dtvalidade) { ?>
                                <span style="color: #ce8483">
                                    <?= date("d/m/Y", strtotime($parameter->dtvalidade)) ?>
                                </span>
                            <?php } elseif ($parameter->dtvalidade == date('Y-m-d')) { ?>
                                <span style="color: #0a0">
                                    <?= date("d/m/Y", strtotime($parameter->dtvalidade)) ?>
                                </span>
                            <?php } ?>
                        <?php }//else if (!isset($parameter->dtvalidade)) ?>
                        </td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $parameter->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit', $parameter->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil-square-o', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar Cadastro'), 'escape' => false]) ?>
                            <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                            <?= $this->Html->link('', ['action' => 'admin', $parameter->id], ['class' => 'btn btn-actions btn_modal fa fa-tags', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Modificar Plano', 'title' => 'Modificar Plano', 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit_novo', $parameter->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil edit', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Editar Cadastro', 'title' => __('Editar Cadastro'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $parameter->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o cadastro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
    <div class="panel-heading" style="font-size: 11px;">
        <span class="text-bold"><?= __('Legenda:') ?></span><br />
        <span style="color: #ce8483"><?= __('Sistema Vencido, ') ?></span>
        <span style="color: #0a0"><?= __('Vence Hoje ou ') ?></span>
        <span style="color: #2aabd2"><?= __('Dentro da Validade.') ?></span>
    </div>
</div>