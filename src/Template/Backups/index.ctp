<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Backups */
/* File: src/Template/Backup/index.ctp */
?>

<?= $this->Form->create('Backup') ?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <h3 class="page-header top-20"><?= __('Lista de Arquivos de Backup') ?></h3>
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
	
    <div class="col-xs-12 panel" style="float: none;">
        <div class="bottom-20 form-inline">
            <?= $this->Form->button(' Excluir Selecionados', ['type' => 'submit', 'class' => 'btn btn-primary top-20 right-10 fa fa-trash-o', 'div' => false]) ?>
            <span class="left-20 top-15 pull-right">
                <strong><?= __('Total Remoto') ?>:</strong> <?= $remote_files['quantity']; ?> <?= __('Arquivos') ?> = <?= $this->Number->precision($remote_files['size'], 2); ?> <?= __('Kb'); ?><br>
                <strong><?= __('Total Local') ?>:</strong> <?= $local_files['quantity']; ?> <?= __('Arquivos') ?> = <?= $this->Number->precision($local_files['size'], 2); ?> <?= __('Kb'); ?>
            </span>
        </div>
    </div>
    
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
                    <th class="text-left col-xs-1"><?= __('Origem') ?></th>
                    <th class="text-left"><?= __('Arquivo') ?></th>
                    <th class="text-left col-xs-1"><?= __('Modificação') ?></th>
                    <th class="text-left col-xs-1"><?= __('Tamanho') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($backups as $backup): ?>
                    <tr>
                        <td class="text-center hidden-print">
                            <?= $this->Form->control('record['.$backup['id'].']', ['type'        => 'checkbox', 
                                                                                   'multiple'    => true,
                                                                                   'label'       => false, 
                                                                                   'templates'   => ['inputContainer' => '{{content}}'],
                                                                                   'hiddenField' => false,
                                                                                   'class'       => 'btn btn-actions',
                                                                                   'value'       => $backup['file'],
                                                                                  ]) ?>
                            <?= $this->Form->control('source['.$backup['id'].']', ['type' => 'hidden', 'value' => $backup['source']]) ?>
                        </td>
                        <td class="text-center"><?= h($backup['source']) ?></td>
                        <td class="text-left"><?= h($backup['file']) ?></td>
                        <td class="text-left"><?= h($backup['modifield']) ?></td>
                        <td class="text-right"><?= $this->Number->precision($backup['size'], 2) ?> Kb</td>
                        <td class="btn-actions-group">
                            <?php if ($backup['source'] == 'Local'){ ?>
                                <?= $this->Html->link((''), ['action' => 'upload', $backup['file']], ['class' => 'btn btn-actions fa fa-upload', 'data-loading-text' => __('Carregando...'), 'title' => 'Upload', 'escape' => false]) ?>
                                <?= $this->Html->link((''), ['action' => 'download', $backup['file']], ['class' => 'btn btn-actions fa fa-download', 'data-loading-text' => __('Carregando...'), 'title' => 'Download', 'escape' => false]) ?>
                                <?= $this->Form->Postlink((''), ['action' => 'delete', $backup['file']], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php } elseif ($backup['source'] == 'Remoto') { ?>
                                <?= $this->Html->link((''), ['action' => 'downloadFTP', $backup['file']], ['class' => 'btn btn-actions fa fa-download', 'data-loading-text' => __('Carregando...'), 'title' => 'Download', 'escape' => false]) ?>
                                <?= $this->Form->Postlink((''), ['action' => 'deleteFTP', $backup['file']], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//elseif ($backup['source'] == 'Remoto') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 panel" style="float: none;">
        <div class="bottom-20"><?= $this->Form->button(' Excluir Selecionados', ['type' => 'submit', 'class' => 'btn btn-primary top-20 right-10 fa fa-trash-o', 'div' => false]) ?></div>
    </div>
</div>

<?= $this->Form->end() ?>