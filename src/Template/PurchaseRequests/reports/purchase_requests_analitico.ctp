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
    
    <h3 class="page-header"><span class="text-bold"><?= __('SOLICITAÇÕES DE COMPRAS - ANALÍTICO') ?></span></h3>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-purchase-requests'); ?>
    </div>

    <?php                    
        if (!empty($purchaseRequests->toArray())) { ?>

            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Solicitante') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Ordem de Fabricação') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Data OF') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Pedido de Venda') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Código do Cliente') ?></th>
                            <th class="text-center width-r300 text-nowrap"><?= __('Cliente') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Encerramento do Pedido') ?></th>
                            <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($purchaseRequests as $value): ?>

                            <tr>
                                <td class="text-left">
                                    <?= date("d/m/Y", strtotime($value->date)) ?>
                                </td>
                                <td class="text-left">
                                    <?= str_pad($value->code, 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td class="text-center">
                                    <?= $this->PurchaseRequests->status($value->status) ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->applicant ? h($value->applicant) : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->Industrializations['code'] ? str_pad($value->Industrializations['code'], 6, '0', STR_PAD_LEFT) : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->Industrializations['date'] ? date("d/m/Y", strtotime($value->Industrializations['date'])) : '-' ?>
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
                                <td class="text-center">
                                    <?= $value->Sells['endingdate'] ? date("d/m/Y", strtotime($value->Sells['endingdate'])) : '-' ?>
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
                                                </tr>
                                            </thead>
                                            <?php
                                            foreach ($purchaseRequestItems as $item): 
                                                if ($item->purchase_requests_id == $value->id) { ?>
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
                                                        </tr>
                                                    </tbody>
                                                <?php
                                                }//if ($item->purchase_requests_id == $value->id)
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
    }//else if (!empty($purchaseRequests)) ?>
</div>
<?= $this->element('report-footer'); ?>