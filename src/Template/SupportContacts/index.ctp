<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* SupportContacts */
/* File: src/Template/SupportContacts/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'SupportContacts', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-size' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Chamado'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Chamados de Suporte') ?></h3>
    </div>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                    <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-nowrap col-xs-1"><?= __('Data de Cadastro') ?></th>
                    <th class="text-left"><?= __('Assunto') ?></th>
                    <th class="text-left"><?= __('Detalhamento') ?></th>
                    <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                    <th class="text-left"><?= __('Empresa') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-left col-xs-1"><?= __('Solicitante') ?></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($supportContacts as $supportContact): ?>
                    <tr class="initialism">
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <td class="text-left"><?= str_pad($supportContact->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        <td class="text-left"><?= $this->MyHtml->date($supportContact->created) ?></td>
                        <td class="text-left"><?= $supportContact->title ?></td>
                        <td class="text-left"><?= $supportContact->descricao ?></td>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <td class="text-left"><?= $supportContact->Parameters['razao'] ?></td>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        <td class="text-left"><?= $supportContact->username ?></td>
                        <td class="text-center"><?= $this->SupportContacts->status($supportContact->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $supportContact->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?php if ($supportContact->status != 'F') { ?>
                            <?= $this->Html->link('', ['action' => 'edit', $supportContact->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil-square-o', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Editar Cadastro'), __('Editar Cadastro'), 'escape' => false]) ?>
                            <?php }//if ($supportContact->status != 'F') ?>
                            <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                            <?= $this->Html->link('', ['action' => 'add_response', $supportContact->id], ['class' => 'btn btn-actions btn_modal fa fa-send', 'data-loading-text' => __('Carregando...'), 'data-size' => 'sm', 'data-title' => __('Responder Chamado'), 'title' => __('Responder')]) ?>
                            <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                            <?php if ($this->request->Session()->read('sessionRule') != 'super' && $supportContact->status == 'B') { ?>
                            <?= $this->Html->link('', ['action' => 'finaliza', $supportContact->id], ['class' => 'btn btn-actions fa fa-ok', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Finalizar', 'title' => 'Finalizar']) ?>
                            <?php }//if ($this->request->Session()->read('sessionRule') != 'super' && $supportContact->status == 'B') ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $supportContact->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>