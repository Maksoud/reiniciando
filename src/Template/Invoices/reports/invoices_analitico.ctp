<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>
 
<?php 
    $this->layout = 'layout-clean';
    
    $dtinicial = $this->request->data['dtinicial'];
    $dtfinal   = $this->request->data['dtfinal'];
?>

<div class="col-xs-12 main bottom-50">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h3 class="page-header"><span class="text-bold"><?= __('FATURAMENTOS - ANALÍTICO') ?></span></h3>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-invoices'); ?>
    </div>

    <?php                    
        if (!empty($invoices->toArray())) { ?>

            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data da NF') ?></th>
                            <th class="text-left width-r100 text-nowrap"><?= __('NF') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Previsão de Entrega') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Encerramento do Pedido') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo do Frete') ?></th>
                            <th class="text-right width-r100 text-nowrap"><?= __('Valor Total') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Pedido de Compra') ?></th>
                            <th class="text-center width-r300 text-nowrap"><?= __('Fornecedor') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('CPF/CNPJ') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Pedido de Venda') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Pedido do Cliente') ?></th>
                            <th class="text-center width-r300 text-nowrap"><?= __('Cliente') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('CPF/CNPJ') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status Pedido') ?></th>
                            <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($invoices as $value): ?>

                            <tr>
                                <td class="text-left">
                                    <?= date("d/m/Y", strtotime($value->dtemissaonf)) ?>
                                </td>
                                <td class="text-left">
                                    <?= str_pad($value->nf, 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td class="text-center">
                                    <?= $this->Invoices->type($value->type) ?>
                                </td>
                                <td class="text-center">
                                    <?= $this->Invoices->status($value->status) ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->dtdelivery ? date("d/m/Y", strtotime($value->dtdelivery)) : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Sells['endingdate'] ? date("d/m/Y", strtotime($value->Sells['endingdate'])) : '' ?>
                                    <?= $value->Purchases['endingdate'] ? date("d/m/Y", strtotime($value->Purchases['endingdate'])) : '' ?>
                                    <?php if (empty($value->Sells['endingdate']) && empty($value->Purchases['endingdate'])) { echo '-'; } ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->freighttype ? $this->Invoices->freighttype($value->freighttype) : '-' ?>
                                </td>
                                <td class="text-right">
                                    <?= $this->Number->precision($value->grandtotal, 2); ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Purchases['code'] ? str_pad($value->Purchases['code'], 6, '0', STR_PAD_LEFT) : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Providers['title'] ? $value->Providers['title'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Providers['cpfcnpj'] ? $value->Providers['cpfcnpj'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Sells['code'] ? str_pad($value->Sells['code'], 6, '0', STR_PAD_LEFT) : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Sells['customercode'] ? $value->Sells['customercode'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Customers['title'] ? $value->Customers['title'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Customers['cpfcnpj'] ? $value->Customers['cpfcnpj'] : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->Sells['status'] ? $this->Sells->status($value->Sells['status']) : '' ?>
                                    <?= $value->Purchases['status'] ? $this->Purchases->status($value->Purchases['status']) : '' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->obs ? h($value->obs) : '-' ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="100%">
                                    <div class="panel well-sm table-responsive bottom-0 bg-gray" style="margin-top:-6px;">
                                        <table class="table table-bordered table-condensed table-hover prt-report font-10">
                                            <thead>
                                                <tr class="bg-info">
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Cód. Interno') ?></th>
                                                    <th class="text-left width-r300 text-nowrap"><?= __('Descrição') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Quantidade') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Unidade') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Imobilizado') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('ICMS') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('ICMS (%)') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('IPI') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('IPI (%)') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('ICMS Subst.') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('ICMS Subst.(%)') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Unitário') ?></th>
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Total') ?></th>
                                                </tr>
                                            </thead>
                                            <?php
                                            foreach ($invoiceItems as $item): 
                                                if ($item->invoices_id == $value->id) { ?>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-left">
                                                                <?= $item->Products['code'] ? $item->Products['code'] : '-' ?>
                                                            </td>
                                                            <td class="text-left">
                                                                <?= $item->Products['title'] ? $item->Products['title'] : '-' ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->quantity, 4); ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $item->unity ? h($item->unity) : '-' ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $item->imobilizado == 'S' ? 'Sim' : 'Não' ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->icms, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->pericms, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->ipi, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->peripi, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->icmssubst, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->pericmssubst, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->vlunity, 2); ?>
                                                            </td>
                                                            <td class="text-right">
                                                                <?= $this->Number->precision($item->vltotal, 2); ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    <?php
                                                }//if ($item->invoices_id == $value->id)
                                            endforeach; ?>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                            
                            <?php
                        endforeach; ?>

                    </tbody>
                </table>
            </div>
        
        <?php 
    } else { ?>
        <table class="table table-striped table-condensed prt-report">
            <tr>
                <td class="text-center"><?= __('NÃO HÁ DADOS A SEREM EXIBIDOS') ?></td>
            </tr>
        </table>
        <?php 
    }//else if (!empty($invoices)) ?>
</div>
<?= $this->element('report-footer'); ?>