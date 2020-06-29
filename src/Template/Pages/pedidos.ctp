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
/* File: src/Template/Pages/pedidos.ctp */
?>

<?php $this->layout = 'ajax'; ?>


<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
        
        <?php 
        if (!empty($purchases->toArray())) {
            ?>
            <div class="row">
                <div class="box panel panel-default" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold"><i class="fa fa-shopping-cart"></i> <?= __('Pedidos de Compras em Aberto') ?>*</span>
                        <h5>
                            <small>(*) <?= __('Para simples conferência') ?></small><br/>
                        </h5>
                    </div>
                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Código') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Data do Cadastro') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Prazo de Entrega') ?></th>
                                        <th class="text-left"><?= __('Fornecedor') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($purchases as $purchase): ?>
                                        <tr>
                                            <td class="text-left"><?= str_pad($purchase->code, 6, '0', STR_PAD_LEFT) ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($purchase->date)) ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($purchase->deadline)) ?></td>
                                            <td class="text-left"><?= $purchase->Providers['title'] ?></td>
                                            <td class="text-left"><?= $this->Number->precision($purchase->grandtotal, 2); ?></td>
                                            <td class="text-center"><?= $this->Purchases->status($purchase->status) ?></td>
                                            <td class="btn-actions-group">
                                                <?= $this->Html->link('', ['controller' => 'Purchases', 'action' => 'view', $purchase->id], ['class' => 'btn btn-actions btn_modal3 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
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
        } //if (!empty($purchases)) { 

        if (!empty($sells->toArray())) {
            ?>
            <div class="row">
                <div class="box panel panel-default" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold"><i class="fa fa-briefcase"></i> <?= __('Pedidos de Vendas em Aberto') ?>*</span>
                        <h5>
                            <small>(*) <?= __('Para simples conferência') ?></small><br/>
                        </h5>
                    </div>
                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Código') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Data do Cadastro') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Prazo de Entrega') ?></th>
                                        <th class="text-left"><?= __('Cliente') ?></th>
                                        <th class="text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($sells as $sell): ?>
                                        <tr>
                                            <td class="text-left"><?= str_pad($sell->code, 6, '0', STR_PAD_LEFT) ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($sell->date)) ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($sell->deadline)) ?></td>
                                            <td class="text-left"><?= $sell->Customers['title'] ?></td>
                                            <td class="text-left"><?= $this->Number->precision($sell->grandtotal, 2); ?></td>
                                            <td class="text-center"><?= $this->Sells->status($sell->status) ?></td>
                                            <td class="btn-actions-group">
                                                <?= $this->Html->link('', ['controller' => 'Sells', 'action' => 'view', $sell->id], ['class' => 'btn btn-actions btn_modal3 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
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
        } //if (!empty($sells)) { 
        
        ?>
    </div>
</div>