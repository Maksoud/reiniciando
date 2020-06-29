<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Boxes */
/* File: src/Template/Boxes/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Código') ?></label><br>
                <?= str_pad($purchase->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="form-group">
                <label><?= __('Cliente') ?></label><br>
                <?= $purchase->Providers['cpfcnpj'] ?> - <?= $purchase->Providers['title'] ?>
            </div>
            <div class="form-group">
                <label><?= __('Data do Lançamento') ?></label><br>
                <?= $this->MyHtml->date($purchase->date) ?>
            </div>
            <?php if ($purchase->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $purchase->obs ?>
            </div>
            <?php }//if ($purchase->obs) ?>
        </div>

        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right:5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" style="background-color:#d9edf7">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Transação') ?></label><br>
                        <?= __('Compra') ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('ICMS Total') ?></label><br>
                        <?= $this->Number->precision($purchase->totalicms, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('IPI Total') ?></label><br>
                        <?= $this->Number->precision($purchase->totalipi, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('ICMS Subst. Total') ?></label><br>
                        <?= $this->Number->precision($purchase->totalicmssubst, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Frete Total') ?></label><br>
                        <?= $this->Number->precision($purchase->totalfreight, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Desconto Total') ?></label><br>
                        <?= $this->Number->precision($purchase->totaldiscount, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Total Geral') ?></label><br>
                        <?= $this->Number->precision($purchase->grandtotal, 2) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right:5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header bg-primary">
                    <span class="text-bold"><?= __('Informações de Entrega') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Prazo de Entrega') ?></label><br>
                        <?= $this->MyHtml->date($purchase->deadline) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo do Frete') ?></label><br>
                        <?= $this->Purchases->freighttype($purchase->freighttype) ?>
                    </div>
                    <?php if (!empty($purchase->endingdate)) { ?>
                    <div class="form-group">
                        <label><?= __('Finalização do Pedido') ?></label><br>
                        <?= $this->MyHtml->date($purchase->endingdate) ?>
                    </div>
                    <?php }//if ($purchase->endingdate) ?>
                </div>
            </div>
        </div>

    </div>
        
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Purchases->status($purchase->status) ?><br>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($purchase->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($purchase->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($purchase->username) ?></span>
            </div>
        </div>
    </div>

    <?php
    //Solicitações de compras
    if (!empty($purchaseRequests) && !empty($purchaseRequests->toArray())) { ?>
        <div class="col-xs-12 box box-shadow bg-warning panel-group">
            <div class="sub-header"><h5><label><?= __('SOLICITAÇÕES DE COMPRAS') ?> (<?= count((array)$purchaseRequests->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Código') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Data do Lançamento') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Ordem de Fabricação') ?></th>
                            <th class="text-left"><?= __('Solicitante') ?></th>
                            <th class="text-left"><?= __('Observações') ?></th>
                            <th class="text-center col-xs-1"><?= __('Status') ?></th>
                            <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchaseRequests as $purchaseRequest): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= str_pad($purchaseRequest->code, 6, '0', STR_PAD_LEFT) ?></td>
                                <td class="text-left text-nowrap"><?= $this->MyHtml->date($purchaseRequest->date) ?></td>
                                <td class="text-left text-nowrap"><?= $purchaseRequest->Industrializations['code'] ? $this->Html->link(str_pad($purchaseRequest->Industrializations['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Industrializations', 'action' => 'view', $purchaseRequest->Industrializations['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Ordem de Fabricação']) : '-'; ?></td>
                                <td class="text-left text-nowrap"><?= $purchaseRequest->applicant ?></td>
                                <td class="text-left text-nowrap"><?= $purchaseRequest->obs ?></td>
                                <td class="text-center"><?= $this->PurchaseRequests->status($purchaseRequest->status) ?></td>
                                <td class="btn-actions-group">
                                    <?= $this->Html->link('', ['controller' => 'PurchaseRequests', 'action' => 'view', $purchaseRequest->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>                         
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }//if (!empty($purchaseRequests) && !empty($purchaseRequests->toArray()))
    //Solicitações de compras
    ?>
    
    <?php
    //Itens
    if (!empty($purchaseItems->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$purchaseItems->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Código') ?></th>
                            <th class="text-left"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Quantidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unit.') ?></th>
                            <th class="text-center col-xs-1"><?= __('Desconto') ?></th>
                            <th class="text-center col-xs-1"><?= __('IPI') ?></th>
                            <th class="text-center col-xs-1"><?= __('ICMS') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('ICMS Subst.') ?></th>
                            <th class="text-center col-xs-1"><?= __('Total') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $vltotal = 0;
                        foreach ($purchaseItems as $purchaseItem): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= $this->Html->link(str_pad($purchaseItem->Products['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Products', 'action' => 'view', $purchaseItem->products_id], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Produto']) ?></td>
                                <td class="text-left text-nowrap"><?= h($purchaseItem->Products['title']) ?></td>
                                <td class="text-center text-nowrap"><?= h($purchaseItem->unity) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->quantity, 4) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->vlunity, 4) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->vldiscount, 2) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->ipi, 2) ?> (<?= $this->Number->precision($purchaseItem->peripi, 2) ?>%)</td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->icms, 2) ?> (<?= $this->Number->precision($purchaseItem->pericms, 2) ?>%)</td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->icmssubst, 2) ?> (<?= $this->Number->precision($purchaseItem->icmssubst, 2) ?>%)</td>
                                <th class="text-right text-nowrap"><?= $this->Number->precision($purchaseItem->vltotal, 2); $vltotal += $purchaseItem->vltotal; ?></th>
                            </tr>
                            <?php 
                        endforeach; 
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8"></td>
                            <th class="text-right text-nowrap"><?= __('R$') ?> <?= $this->Number->precision($vltotal, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php 
    }//if (!empty($purchaseItems))
    //Itens
    ?>

    <?php
    //Faturamentos
    if (!empty($invoices->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-info panel-group">
            <div class="sub-header"><h5><label><?= __('FATURAMENTOS VINCULADOS') ?></label></h5></div>
            <div class="table-responsive">
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th class="text-nowrap col-xs-1"><?= __('Nota Fiscal') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Emissão da NF') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Prazo de Entrega') ?></th>
                            <th class="text-nowrap"><?= __('Fornecedor') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $vltotal = 0;
                    foreach ($invoices as $invoice): ?>
                        <tr>
                            <td class="text-left text-nowrap"><?= $invoice->nf ? str_pad($invoice->nf, 6, '0', STR_PAD_LEFT) : 'Avulso' ?></td>
                            <td class="text-left text-nowrap"><?= $this->MyHtml->date($invoice->dtemissaonf) ?></td>
                            <td class="text-left text-nowrap"><?= $this->MyHtml->date($invoice->dtdelivery) ?></td>
                            <td class="text-left text-nowrap"><?= $invoice->Providers['title'] ? $invoice->Providers['title'] : '-' ?></td>
                            <td class="text-right"><?= $this->Number->precision($invoice->grandtotal, 2); $vltotal += $invoice->grandtotal; ?></td>
                        </tr>
                        <?php 
                    endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right"><?= __('Total') ?></th>
                            <th class="text-center"><?= $this->Number->precision($vltotal, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php
    }//if (!empty($invoices->toArray()))
    //Faturamentos
    ?>
    
</div>