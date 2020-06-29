<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Regs */
/* File: src/Template/Regs/index.ctp */
?>
<?= $this->Form->create('Reg') ?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Form->button(' Excluir Selecionados', ['type' => 'submit', 'class' => 'btn btn-primary top-20 right-10 fa fa-trash-o', 'div' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Log do Sistema') ?></h3>
    </div>
<!-- 
    Implementado para corrigir falha de conflito do postLink
    com o Form->button que permite a exclusão de mais de um
    registro ao mesmo tempo. Falha: O primeiro postLink após
    a declaração do Form->create não exibe o <form> no HTML.
    Necessário estar localizado após o Form->button e antes
    da listagem. 07/2017
-->
<?= $this->Form->postLink('') ?>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-center hidden-print" style="width: 20px">
                        <?= $this->Form->control('select_all', ['type'        => 'checkbox', 
                                                                'id'          => 'select_all',
                                                                'label'       => false, 
                                                                'templates'   => ['inputContainer' => '{{content}}'],
                                                                'hiddenField' => false,
                                                                'class'       => 'btn btn-actions',
                                                               ]) ?>
                    </th>
                    <th class="text-nowrap"><?= __('Data de Cadastro') ?></th>
                    <th class="text-nowrap"><?= __('Tipo de LOG') ?></th>
                    <th class="text-left"><?= __('Função') ?></th>
                    <th class="text-nowrap"><?= __('Usuário do Registro') ?></th>
                    <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                    <th class="text-left"><?= __('Empresa') ?></th>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($regs as $reg): ?>
                <tr>
                    <td class="text-center hidden-print">
                        <div>
                            <?= $this->Form->control('record['.$reg->id.']', ['type'        => 'checkbox', 
                                                                              'id'          => 'listRecord_'.$reg->id,
                                                                              'label'       => false, 
                                                                              'templates'   => ['inputContainer' => '{{content}}'],
                                                                              'hiddenField' => false,
                                                                              'class'       => 'btn btn-actions',
                                                                              'value'       => $reg->id
                                                                             ]) ?>
                        </div>
                    </td>
                    <td class="text-left"><?= $reg->created ?></td>
                    <td class="text-left"><?= $reg->log_type ?></td>
                    <td class="text-left"><?= $reg->function ?></td>
                    <td class="text-left"><?= $reg->username ?></td>
                    <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                    <td><?= $reg->Parameters->razao ?></td>
                    <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    <td class="btn-actions-group">
                        <?= $this->Html->link('', ['action' => 'view', $reg->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <?= $this->Form->postLink('', ['action' => 'delete', $reg->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'aria-hidden' => true]) ?>
                        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>
<?= $this->Form->end() ?>