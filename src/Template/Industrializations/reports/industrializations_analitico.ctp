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
    
    <h3 class="page-header"><span class="text-bold"><?= __('ORDENS DE FABRICAÇÃO - ANALÍTICO') ?></span></h3>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-industrializations'); ?>
    </div>

    <?php                    
        if (!empty($industrializations->toArray())) { ?>

            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left text-nowrap"><?= __('Data') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Código') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Status') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Multa') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Inspeção') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Databook') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Certificado') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Código do Pedido') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Pedido do Cliente') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Valor do Pedido') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Previsão de Entrega') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('Data Encerramento') ?></th>
                            <th class="text-center width-r300 text-nowrap"><?= __('Cliente') ?></th>
                            <th class="text-center width-r200 text-nowrap"><?= __('CPF/CNPJ') ?></th>
                            <th class="text-left width-r400 text-nowrap"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($industrializations as $value): ?>

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
                                    <?= $value->multa == 'S' ? 'Sim' : 'Não' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->inspecao == 'S' ? 'Sim' : 'Não' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->databook == 'S' ? 'Sim' : 'Não' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->certificado ? h($value->certificado) : 'Não' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Sells['code'] ? str_pad($value->Sells['code'], 6, '0', STR_PAD_LEFT) : '-'  ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Sells['customercode'] ? $value->Sells['customercode'] : '-'  ?>
                                </td>
                                <td class="text-right">
                                    <?= $value->Sells['code'] ? $this->Number->precision($value->Sells['grandtotal'], 2) : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->Sells['deadline'] ? date("d/m/Y", strtotime($value->Sells['deadline'])) : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?= $value->Sells['endingdate'] ? date("d/m/Y", strtotime($value->Sells['endingdate'])) : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Customers['title'] ? $value->Customers['title'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->Customers['cpfcnpj'] ? $value->Customers['cpfcnpj'] : '-' ?>
                                </td>
                                <td class="text-left">
                                    <?= $value->obs ? h($value->obs) : '-' ?>
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
    }//else if (!empty($industrializations)) ?>
</div>
<?= $this->element('report-footer'); ?>