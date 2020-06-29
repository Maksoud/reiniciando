<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* PurchaseRequests */
/* File: src/Template/PurchaseRequests/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Código') ?></label><br>
                <?= str_pad($purchaseRequest->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="form-group">
                <label><?= __('Data do Lançamento') ?></label><br>
                <?= $this->MyHtml->date($purchaseRequest->date) ?>
            </div>
            <?php if (!empty($purchaseRequest->industrializations_id)) { ?>
            <div class="form-group">
                <label><?= __('Cliente') ?></label><br>
                <?= $purchaseRequest->Customers['cpfcnpj'] ?> - <?= $purchaseRequest->Customers['title'] ?>
            </div>
            <?php }//if (!empty($repurchaseRequestquisition->industrializations_id)) ?>
            <?php if ($purchaseRequest->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $purchaseRequest->obs ?>
            </div>
            <?php }//if ($purchaseRequest->obs) ?>
        </div>

    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->PurchaseRequests->status($purchaseRequest->status) ?><br>
            </div>
            <?php if (!empty($purchaseRequest->industrializations_id)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem de Fabricação') ?></label><br>
                <?= $this->Html->link(str_pad($purchaseRequest->Industrializations['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Industrializations', 'action' => 'view', $purchaseRequest->Industrializations['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Ordem de Fabricação']) ?><br>
            </div>
            <?php }//if (!empty($purchaseRequest->industrializations_id)) ?>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($purchaseRequest->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($purchaseRequest->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($purchaseRequest->username) ?></span>
            </div>
        </div>
    </div>

    <?php
    //Solicitações de compras
    if (!empty($purchases) && !empty($purchases->toArray())) { ?>
        <div class="col-xs-12 box box-shadow bg-warning panel-group">
            <div class="sub-header"><h5><label><?= __('PEDIDOS DE COMPRAS') ?> (<?= count((array)$purchases->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Código') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Data do Lançamento') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Prazo de Entrega') ?></th>
                            <th class="text-left"><?= __('Fornecedor') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                            <th class="text-left col-xs-1"><?= __('Status') ?></th>
                            <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchases as $purchase): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= str_pad($purchase->code, 6, '0', STR_PAD_LEFT) ?></td>
                                <td class="text-left text-nowrap"><?= $this->MyHtml->date($purchase->date) ?></td>
                                <td class="text-left text-nowrap"><?= $this->MyHtml->date($purchase->deadline) ?></td>
                                <td class="text-left text-nowrap"><?= $purchase->Providers['title'] ?></td>
                                <td class="text-left text-nowrap"><?= $this->Number->precision($purchase->grandtotal, 2); ?></td>
                                <td class="text-center text-nowrap"><?= $this->Purchases->status($purchase->status) ?></td>
                                <td class="btn-actions-group">
                                    <?= $this->Html->link('', ['controller' => 'Purchases', 'action' => 'view', $purchase->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }//if (!empty($purchases->toArray()))
    //Pedidos de compras
    ?>
    
    <?php
    //Itens
    if (!empty($purchaseRequestItems->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$purchaseRequestItems->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Código') ?></th>
                            <th class="text-left"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Quantidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Entrega') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($purchaseRequestItems as $purchaseRequestItem): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= $this->Html->link(str_pad($purchaseRequestItem->Products['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Products', 'action' => 'view', $purchaseRequestItem->products_id], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Produto']) ?></td>
                                <td class="text-left text-nowrap"><?= h($purchaseRequestItem->Products['title']) ?></td>
                                <td class="text-center text-nowrap"><?= h($purchaseRequestItem->unity) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseRequestItem->quantity, 4) ?></td>
                                <td class="text-center text-nowrap"><?= $purchaseRequestItem->deadline ? date("d/m/Y", strtotime($purchaseRequestItem->deadline)) : '-' ?></td>
                            </tr>
                            <?php 
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
    }//if (!empty($purchaseRequestItems))
    //Itens
    ?>
    
</div>