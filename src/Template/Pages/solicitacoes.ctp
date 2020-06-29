<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Pages */
/* File: src/Template/Pages/solicitacoes.ctp */
?>

<?php $this->layout = 'ajax'; ?>


<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
        <?php 
        if (!empty($purchaseRequests->toArray())) {
            ?>
            <div class="row">
                <div class="box panel panel-default" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold"><i class="fa fa-shopping-cart"></i> <?= __('Solicitações de Compras') ?>*</span>
                        <h5>
                            <small>(*) <?= __('Não lista solicitações canceladas, somente pendentes e em andamento') ?></small><br/>
                        </h5>
                    </div>
                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Código') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Data do Lançamento') ?></th>
                                        <th class="text-nowrap"><?= __('Ordem de Fabricação') ?></th>
                                        <th class="text-left"><?= __('Solicitante') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($purchaseRequests as $purchaseRequest): ?>
                                        <tr>
                                            <td class="text-left"><?= str_pad($purchaseRequest->code, 6, '0', STR_PAD_LEFT) ?></td>
                                            <td class="text-left"><?= $this->MyHtml->date($purchaseRequest->date) ?></td>
                                            <td class="text-left"><?= $purchaseRequest->Industrializations['code'] ? $this->Html->link(str_pad($purchaseRequest->Industrializations['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Industrializations', 'action' => 'view', $purchaseRequest->Industrializations['id']], ['class' => 'btn_modal3 label label-primary', 'data-title' => 'Visualizar Ordem de Fabricação']) : '-'; ?></td>
                                            <td class="text-left"><?= $purchaseRequest->applicant ?></td>
                                            <td class="text-center"><?= $this->PurchaseRequests->status($purchaseRequest->status) ?></td>
                                            <td class="btn-actions-group">
                                                <?= $this->Html->link('', ['controller' => 'PurchaseRequests', 'action' => 'view', $purchaseRequest->id], ['class' => 'btn btn-actions btn_modal3 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                                            </td>
                                        </tr>
                                        <?php 
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } //if (!empty($purchaseRequests)) { 
        ?>
    </div>
</div>