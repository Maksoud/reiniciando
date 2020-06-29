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
?>

<div class="col-xs-12 main bottom-50">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h3 class="page-header"><span class="text-bold"><?= __('RASTREAMENTO DE ORDENS DE FABRICAÇÃO') ?> - <?= __('OF #') ?><?= str_pad($industrialization->code, 6, '0', STR_PAD_LEFT) ?></span></h3>
    <div class="pull-4 bottom-20">
        <?php //$this->element('report-filter-industrializations'); ?>
    </div>

    <?php 

    /******************************************************************/

    //CLIENTE

    if (!empty($customer)) { ?>
        <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('CLIENTE') ?></small></div>
        <div class="col-xs-12 no-padding-lat table-responsive">
            <table class="table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-center width-r300 text-nowrap"><?= __('Nome / Razão Social') ?></th>
                        <th class="text-center width-r300 text-nowrap"><?= __('Nome Fantasia') ?></th>
                        <th class="text-center width-r200 text-nowrap"><?= __('CPF/CNPJ') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Insc. Estadual') ?></th>
                        <th class="text-center width-r200 text-nowrap"><?= __('E-mail') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Estado') ?></th>
                        <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $value = $customer; ?>
                    <tr>
                        <td class="text-left">
                            <?= $value->title ? h($value->title) : '-' ?>
                        </td>
                        <td class="text-left">
                            <?= $value->fantasia ? h($value->fantasia) : '-' ?>
                        </td>
                        <td class="text-center">
                            <?= $value->cpfcnpj ? h($value->cpfcnpj) : '-' ?>
                        </td>
                        <td class="text-center">
                            <?= $value->ie ? h($value->ie) : '-' ?>
                        </td>
                        <td class="text-left">
                            <?= $value->email ? h($value->email) : '-' ?>
                        </td>
                        <td class="text-center">
                            <?= $value->estado ? h($value->estado) : '-' ?>
                        </td>
                        <td class="text-left">
                            <?= $value->obs ? h($value->obs) : '-' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php 
    }//if (!empty($customer)) 

    /******************************************************************/
        
    //ORDEM DE FABRICAÇÃO

    if (!empty($industrialization)) { ?>
        <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('ORDEM DE FABRICAÇÃO') ?></small></div>
        <div class="col-xs-12 no-padding-lat table-responsive">
            <table class="table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left width-r100 text-nowrap"><?= __('Data') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Multa') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Inspeção') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Databook') ?></th>
                        <th class="text-center width-r100 text-nowrap"><?= __('Certificado') ?></th>
                        <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $value = $industrialization; ?>
                    <tr>
                        <td class="text-left">
                            <?= date("d/m/Y", strtotime($value->date)) ?>
                        </td>
                        <td class="text-left">
                            <?= str_pad($value->code, 6, '0', STR_PAD_LEFT) ?>
                        </td>
                        <td class="text-center">
                            <?= $this->Industrializations->status($value->status) ?>
                        </td>
                        <td class="text-center">
                            <?= $value->penalty == 'S' ? 'Sim' : 'Não' ?>
                        </td>
                        <td class="text-center">
                            <?= $value->inspection == 'S' ? 'Sim' : 'Não' ?>
                        </td>
                        <td class="text-center">
                            <?= $value->databook == 'S' ? 'Sim' : 'Não' ?>
                        </td>
                        <td class="text-center">
                            <?= $value->certificate == 'S' ? 'Sim' : 'Não' ?>
                        </td>
                        <td class="text-left">
                            <?= $value->obs ? h($value->obs) : '-' ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <?php 

        /******************************************************************/

        //PEDIDO DE VENDA

        if (!empty($sell)) { ?>
            <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('PEDIDO DE VENDA') ?></small></div>
            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Pedido do Cliente') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo do Frete') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Valor Frete') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Valor Total') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Data Embarque') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Prazo de Entrega') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Data Encerramento') ?></th>
                            <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $value = $sell; ?>
                        <tr>
                            <td class="text-left">
                                <?= date("d/m/Y", strtotime($value->date)) ?>
                            </td>
                            <td class="text-left">
                                <?= str_pad($value->code, 6, '0', STR_PAD_LEFT) ?>
                            </td>
                            <td class="text-left">
                                <?= $value->customercode ? $value->customercode : '-' ?>
                            </td>
                            <td class="text-center">
                                <?= $this->Sells->status($value->status) ?>
                            </td>
                            <td class="text-center">
                                <?= $this->Sells->freighttype($value->freighttype) ?>
                            </td>
                            <td class="text-right">
                                <?= $this->Number->precision($value->totalfreight, 2); ?>
                            </td>
                            <td class="text-right">
                                <?= $this->Number->precision($value->grandtotal, 2); ?>
                            </td>
                            <td class="text-center">
                                <?= $value->shipment ? date("d/m/Y", strtotime($value->shipment)) : '-' ?>
                            </td>
                            <td class="text-center">
                                <?= $value->deadline ? date("d/m/Y", strtotime($value->deadline)) : '-' ?>
                            </td>
                            <td class="text-center">
                                <?= $value->endingdate ? date("d/m/Y", strtotime($value->endingdate)) : '-' ?>
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
                                        foreach ($sellItems as $item): 
                                            if ($item->sells_id == $value->id) { ?>
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
                                            }//if ($item->sells_id == $value->id)
                                        endforeach; ?>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <?php 
        }//if (!empty($sell)) 

        /******************************************************************/

        //SOLICITAÇÕES DE COMPRAS
        
        if (!empty($purchaseRequests) && !empty($purchaseRequests->toArray())) { ?>
            <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('SOLICITAÇÕES DE COMPRAS') ?></small></div>
            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Solicitante') ?></th>
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
                                <td class="text-left">
                                    <?= $value->applicant ? h($value->applicant) : '-' ?>
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
                                                    <th class="text-center width-r100 text-nowrap"><?= __('Entrega') ?></th>
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
                                                            <td class="text-center">
                                                                <?= $item->deadline ? date("d/m/Y", strtotime($item->deadline)) : '-' ?>
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
        }//if (!empty($purchaseRequests)) 

        /******************************************************************/

        //PEDIDOS DE COMPRAS
        
        if (!empty($purchaseRequests) && !empty($purchaseRequests->toArray()) && !empty($purchases) && !empty($purchases->toArray())) { ?>
            <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('PEDIDOS DE COMPRAS') ?></small></div>
            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo do Frete') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Valor Frete') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Valor Total') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Prazo de Entrega') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Data Encerramento') ?></th>
                            <th class="text-center width-r300 text-nowrap"><?= __('Fornecedor') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('CPF/CNPJ') ?></th>
                            <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($purchases as $value): ?>
                            <tr>
                                <td class="text-left">
                                    <?= date("d/m/Y", strtotime($value->date)) ?>
                                </td>
                                <td class="text-left">
                                    <?= str_pad($value->code, 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td class="text-center">
                                    <?= $this->Purchases->status($value->status) ?>
                                </td>
                                <td class="text-center">
                                    <?= $this->Purchases->freighttype($value->freighttype) ?>
                                </td>
                                <td class="text-right">
                                    <?= $this->Number->precision($value->totalfreight, 2); ?>
                                </td>
                                <td class="text-right">
                                    <?= $this->Number->precision($value->grandtotal, 2); ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->deadline ? date("d/m/Y", strtotime($value->deadline)) : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->endingdate ? date("d/m/Y", strtotime($value->endingdate)) : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Providers['title'] ? $value->Providers['title'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Providers['cpfcnpj'] ? $value->Providers['cpfcnpj'] : '-' ?>
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
                                            foreach ($purchaseItems as $item): 
                                                if ($item->purchases_id == $value->id) { ?>
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
                                            }//if ($item->purchases_id == $value->id)
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
        }//if (!empty($purchases)) 

        /******************************************************************/

        //REQUISIÇÕES
        
        if (!empty($requisitions) && !empty($requisitions->toArray())) { ?>
            <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('REQUISIÇÕES') ?></small></div>
            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Solicitante') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($requisitions as $value): ?>
                            <tr>
                                <td class="text-left">
                                    <?= date("d/m/Y", strtotime($value->date)) ?>
                                </td>
                                <td class="text-left">
                                    <?= str_pad($value->code, 6, '0', STR_PAD_LEFT) ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->applicant ? $value->applicant : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $this->Requisitions->status($value->status) ?>
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
                                            foreach ($requisitionItems as $item): 
                                                if ($item->requisitions_id == $value->id) { ?>
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-center">
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
                                                }//if ($item->requisitions_id == $value->id)
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
        }//if (!empty($requisitions))

        /******************************************************************/

        //FATURAMENTOS
        
        if (!empty($invoices) && !empty($invoices->toArray())) { ?>
            <div class="col-xs-12 no-padding-lat top-20 bottom-10"><small class="text-bold text-primary"><?= __('FATURAMENTOS') ?></small></div>
            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left width-r100 text-nowrap"><?= __('Data da NF') ?></th>
                            <th class="text-left width-r100 text-nowrap"><?= __('NF') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Prazo de Entrega') ?></th>
                            <th class="text-left width-r200 text-nowrap"><?= __('Encerramento do Pedido') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo do Frete') ?></th>
                            <th class="text-right width-r100 text-nowrap"><?= __('Valor Total') ?></th>
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
        }//if (!empty($invoices)) 
        
    } else { ?>
        <table class="table table-striped table-condensed prt-report">
            <tr>
                <td class="text-center"><?= __('NÃO HÁ DADOS A SEREM EXIBIDOS') ?></td>
            </tr>
        </table>
        <?php 
    }//else if (!empty($industrialization)) ?>
</div>
<?= $this->element('report-footer'); ?>