<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Payments */
/* File: src/Template/Payments/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Payments', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Nova Fatura', 'escape' => false]) ?></div>
        <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
        <h3 class="page-header top-20"><?= __('Informações de Pagamentos') ?></h3>
    </div>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-nowrap col-xs-1"><?= __('Cód.Cobrança') ?></th>
                    <th class="text-nowrap"><?= __('Razão Social') ?></th>
                    <th class="text-nowrap"><?= __('Validade Atual') ?></th>
                    <th class="text-nowrap"><?= __('Vencimento da Fatura') ?></th>
                    <th class="text-nowrap"><?= __('Período de Ativação') ?></th>
                    <th class="text-nowrap"><?= __('Valor da Fatura') ?></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr class="initialism">
                        <td class="text-left"><?= '#'.str_pad($payment->id, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?= h($payment->Parameters['razao']) ?></td>
                        <td class="text-left"><?= date("d/m/Y", strtotime($payment->Parameters['dtvalidade'])) ?></td>
                        <td class="text-left">
                        <?php if ($payment->status == 'A') { ?>
                            <?php if (date('Y-m-d') < $payment->vencimento) { ?>
                                <span style="color: #2aabd2">
                                    <?= date("d/m/Y", strtotime($payment->vencimento)) ?>
                                </span>
                            <?php } elseif (date('Y-m-d') > $payment->vencimento) { ?>
                                <span style="color: #ce8483">
                                    <?= date("d/m/Y", strtotime($payment->vencimento)) ?>
                                </span>
                            <?php } elseif ($payment->vencimento == date('Y-m-d')) { ?>
                                <span style="color: #0a0">
                                    <?= date("d/m/Y", strtotime($payment->vencimento)) ?>
                                </span>
                            <?php } ?>
                        <?php } else { ?>
                            <?= date("d/m/Y", strtotime($payment->vencimento)) ?>
                        <?php }//else if ($payment->status == 'A') ?>
                        </td>
                        <td class="text-center"><?= $payment->periodo ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->precision($payment->valor, 2) ?></td>
                        <td class="text-center"><?= $this->Payments->status($payment->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link((''), ['action' => 'view', $payment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Dados da Fatura', 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                                <?php if ($payment->status == 'A') {?>
                                    <?= $this->Html->link((''), ['action' => 'edit', $payment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Editar Fatura', 'title' => __('Editar'), 'escape' => false]) ?>
                                    <?= $this->Form->postLink((''), ['action' => 'low', $payment->id], ['confirm' => __('Você tem certeza que deseja BAIXAR a fatura?'), 'class' => 'btn btn-actions fa fa-arrow-circle-o-down', 'title' => __('Baixar'), 'escape' => false]) ?>
                                    <?= $this->Form->postLink((''), ['action' => 'delete', $payment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR a fatura?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                <?php } elseif ($payment->status == 'B') { ?>
                                    <?= $this->Form->postLink((''), ['action' => 'cancel', $payment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR a fatura?'), 'class' => 'btn btn-actions fa fa-remove', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                <?php } elseif ($payment->status == 'C') { ?>
                                    <?= $this->Form->postLink((''), ['action' => 'renew', $payment->id], ['class' => 'btn btn-actions fa fa-repeat', 'title' => 'Reativar', 'escape' => false]) ?>
                                    <?= $this->Form->postLink((''), ['action' => 'delete', $payment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR a fatura?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                <?php }?>
                            <?php }//if ($this->request->Session()->read('sessionRule') == 'super') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
</div>