<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Sells */
/* File: src/Template/Sells/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Código') ?></label><br>
                <?= str_pad($sell->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <?php if (!empty($sell->customercode)) { ?>
            <div class="form-group">
                <label><?= __('Pedido do Cliente') ?></label><br>
                <?= $sell->customercode ?>
            </div>
            <?php }//if (!empty($sell->customercode)) ?>
            <div class="form-group">
                <label><?= __('Cliente') ?></label><br>
                <?= $sell->Customers['cpfcnpj'] ?> - <?= $sell->Customers['title'] ?>
            </div>
            <div class="form-group">
                <label><?= __('Data do Lançamento') ?></label><br>
                <?= $this->MyHtml->date($sell->date) ?>
            </div>
            <?php if ($sell->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $sell->obs ?>
            </div>
            <?php }//if ($sell->obs) ?>
        </div>

        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right:5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" style="background-color:#d9edf7">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Transação') ?></label><br>
                        <?= __('Venda') ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('ICMS Total') ?></label><br>
                        <?= $this->Number->precision($sell->totalicms, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('IPI Total') ?></label><br>
                        <?= $this->Number->precision($sell->totalipi, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('ICMS Subst. Total') ?></label><br>
                        <?= $this->Number->precision($sell->totalicmssubst, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Frete Total') ?></label><br>
                        <?= $this->Number->precision($sell->totalfreight, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Desconto Total') ?></label><br>
                        <?= $this->Number->precision($sell->totaldiscount, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Total Geral') ?></label><br>
                        <?= $this->Number->precision($sell->grandtotal, 2) ?>
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
                        <label><?= __('Data de Embarque') ?></label><br>
                        <?= $this->MyHtml->date($sell->shipment) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Prazo de Entrega') ?></label><br>
                        <?= $this->MyHtml->date($sell->deadline) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo do Frete') ?></label><br>
                        <?= $this->Sells->freighttype($sell->freighttype) ?>
                    </div>
                    <?php if (!empty($sell->endingdate)) { ?>
                    <div class="form-group">
                        <label><?= __('Finalização do Pedido') ?></label><br>
                        <?= $this->MyHtml->date($sell->endingdate) ?>
                    </div>
                    <?php }//if ($sell->endingdate) ?>
                </div>
            </div>
        </div>

    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Sells->status($sell->status) ?><br>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($sell->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($sell->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($sell->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //Itens
    if (!empty($sellItems->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$sellItems->toArray()) ?>)</label></h5></div>
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
                        foreach ($sellItems as $sellItem): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= $this->Html->link(str_pad($sellItem->Products['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Products', 'action' => 'view', $sellItem->products_id], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Produto']) ?></td>
                                <td class="text-left text-nowrap"><?= h($sellItem->Products['title']) ?></td>
                                <td class="text-center text-nowrap"><?= h($sellItem->unity) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($sellItem->quantity, 4) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($sellItem->vlunity, 4) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($sellItem->vldiscount, 2) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($sellItem->ipi, 2) ?> (<?= $this->Number->precision($sellItem->peripi, 2) ?>%)</td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($sellItem->icms, 2) ?> (<?= $this->Number->precision($sellItem->pericms, 2) ?>%)</td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($sellItem->icmssubst, 2) ?> (<?= $this->Number->precision($sellItem->icmssubst, 2) ?>%)</td>
                                <th class="text-right text-nowrap"><?= $this->Number->precision($sellItem->vltotal, 2); $vltotal += $sellItem->vltotal; ?></th>
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
    }//if (!empty($sellItems))
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
                            <th class="text-nowrap"><?= __('Cliente') ?></th>
                            <th class="text-nowrap col-xs-1"><?= __('Total Geral') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $vltotal = 0;
                    foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?= $invoice->nf ? str_pad($invoice->nf, 6, '0', STR_PAD_LEFT) : 'Avulso' ?></td>
                            <td><?= $this->MyHtml->date($invoice->dtemissaonf) ?></td>
                            <td><?= $this->MyHtml->date($invoice->dtdelivery) ?></td>
                            <td><?= $invoice->Customers['title'] ? $invoice->Customers['title'] : '-' ?></td>
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