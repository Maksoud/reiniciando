<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* UsersParameters */
/* File: src/Template/UsersParameters/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'UsersParameters', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-size' => 'sm', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Novo Vínculo'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Vínculo de Usuários à Empresas') ?></h3>
    </div>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-nowrap col-xs-1"><?= __('Data de Cadastro') ?></th>
                    <th class="text-left"><?= __('Usuário') ?></th>
                    <th class="col-xs-1"></th>
                    <th class="text-left"><?= __('Empresa') ?></th>
                    <th class="text-left"><?= __('Plano') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Permissão') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usersParameters as $usersParameter): ?>
                    <tr class="initialism">
                        <td class="text-center"><?= date("d/m/Y", strtotime($usersParameter->created)) ?></td>
                        <td class="text-left"><?= $usersParameter->Users['username'] ?></td>
                        <td class="text-left"><?= $usersParameter->sendmail == 'S' ? '<i class="fa fa-paper-plane-o" title="Recebe resumo de contas por e-mail"></i>' : ''; ?></td>
                        <td class="text-left"><?= $usersParameter->Parameters['id'] . ' - ' . $usersParameter->Parameters['razao'] ?></td>
                        <td class="text-left"><?= $usersParameter->Parameters->Plans['id'] . ' - ' . $this->Parameters->planos($usersParameter->Parameters->Plans['id']) ?></td>
                        <td class="text-left"><?= $this->UsersParameters->rules($usersParameter->rules_id) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'edit', $usersParameter->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-size'=> 'sm', 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink((''), ['action' => 'delete', $usersParameter->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>