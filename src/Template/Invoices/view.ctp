<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Invoices */
/* File: src/Template/Invoices/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Nota Fiscal') ?></label><br>
                <?= str_pad($invoice->nf, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <?php if (!empty($invoice->Sells['customers_id'])) { ?>
            <div class="form-group">
                <label><?= __('Cliente') ?></label><br>
                <?= $invoice->Customers['cpfcnpj'] ?> - <?= $invoice->Customers['title'] ?>
            </div>
            <?php }//if (!empty($invoice->Sells['customers_id'])) ?>
            <?php if (!empty($invoice->Purchases['providers_id'])) { ?>
            <div class="form-group">
                <label><?= __('Fornecedor') ?></label><br>
                <?= $invoice->Providers['cpfcnpj'] ?> - <?= $invoice->Providers['title'] ?>
            </div>
            <?php }//if (!empty($invoice->Purchases['providers_id'])) ?>
            <div class="form-group">
                <label><?= __('CFOP') ?></label><br>
                <?= $invoice->cfop ?>
            </div>
            <div class="form-group">
                <label><?= __('Data de Emissão da NF') ?></label><br>
                <?= $this->MyHtml->date($invoice->dtemissaonf) ?>
            </div>
            <?php if ($invoice->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $invoice->obs ?>
            </div>
            <?php }//if ($invoice->obs) ?>
            <div class="form-group">
                <label><?= __('Tipo de Faturamento') ?></label><br>
                <?= $this->Invoices->type($invoice->type) ?>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right:5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" style="background-color:#d9edf7">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Total dos Produtos') ?></label><br>
                        <?= $this->Number->precision($invoice->grandtotal - $invoice->totalipi - $invoice->totalicms - $invoice->totalicmssubst, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('ICMS Total') ?></label><br>
                        <?= $this->Number->precision($invoice->totalicms, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('IPI Total') ?></label><br>
                        <?= $this->Number->precision($invoice->totalipi, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('ICMS Subst. Total') ?></label><br>
                        <?= $this->Number->precision($invoice->totalicmssubst, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Frete Total') ?></label><br>
                        <?= $this->Number->precision($invoice->totalfreight, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Desconto Total') ?></label><br>
                        <?= $this->Number->precision($invoice->totaldiscount, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Total Geral') ?> <?= __('(Produtos + IPI + ICMS + Desconto)') ?></label><br>
                        <?= $this->Number->precision($invoice->grandtotal, 2) ?>
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
                        <label><?= __('Previsão de Entrega') ?></label><br>
                        <?= $this->MyHtml->date($invoice->dtdelivery) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo do Frete') ?></label><br>
                        <?= $this->Invoices->freighttype($invoice->freighttype) ?>
                    </div>
                    <?php if (!empty($invoice->endingdate)) { ?>
                    <div class="form-group">
                        <label><?= __('Finalização do Faturamento') ?></label><br>
                        <?= $this->MyHtml->date($invoice->endingdate) ?>
                    </div>
                    <?php }//if ($invoice->endingdate) ?>
                </div>
            </div>
        </div>

    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Invoices->status($invoice->status) ?><br>
            </div>

            <div class="form-group box bottom-5 bg-info">
                <?php if ($invoice->type == 'S') { // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing ?>
                    <label><?= __('Pedido de Venda') ?></label><br>
                    <?= $this->Html->link(str_pad($invoice->Sells['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Sells', 'action' => 'view', $invoice->Sells['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Pedido de Venda']) ?><br>
                <?php } elseif ($invoice->type == 'P') { // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing ?>
                    <label><?= __('Pedido de Compra') ?></label><br>
                    <?= $this->Html->link(str_pad($invoice->Purchases['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Purchases', 'action' => 'view', $invoice->Purchases['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Pedido de Compra']) ?><br>
                <?php }//elseif ($invoice->type == 'P') ?>
            </div>

            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($invoice->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($invoice->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($invoice->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //Itens
    if (!empty($invoiceItems->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$invoiceItems->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Código') ?></th>
                            <th class="text-left"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Quantidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unit.') ?></th>
                            <th class="text-center col-xs-1"><?= __('Desconto') ?></th>
                            <th class="text-center"><?= __('IPI') ?></th>
                            <th class="text-center"><?= __('ICMS') ?></th>
                            <th class="text-center text-nowrap"><?= __('ICMS Subst.') ?></th>
                            <th class="text-center"><?= __('Total') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $vltotal = 0;
                        foreach ($invoiceItems as $invoiceItem): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= $this->Html->link(str_pad($invoiceItem->Products['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Products', 'action' => 'view', $invoiceItem->products_id], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Produto']) ?></td>
                                <td class="text-left text-nowrap"><?= h($invoiceItem->Products['title']) ?></td>
                                <td class="text-center text-nowrap"><?= h($invoiceItem->unity) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->quantity, 4) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->vlunity, 4) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->vldiscount, 2) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->ipi, 2) ?> (<?= $this->Number->precision($invoiceItem->peripi, 2) ?>%)</td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->icms, 2) ?> (<?= $this->Number->precision($invoiceItem->pericms, 2) ?>%)</td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->icmssubst, 2) ?> (<?= $this->Number->precision($invoiceItem->icmssubst, 2) ?>%)</td>
                                <th class="text-right text-nowrap"><?= $this->Number->precision($invoiceItem->vltotal, 2); $vltotal += $invoiceItem->vltotal; ?></th>
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
    }//if (!empty($invoiceItems))
    //Itens
    ?>
    
</div>