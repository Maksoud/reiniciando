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
    
    <h3 class="page-header"><span class="text-bold"><?= __('PRODUTOS - ANALÍTICO') ?></span></h3>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-products'); ?>
    </div>

    <?php                    
        if (!empty($products->toArray())) { ?>

            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left text-nowrap"><?= __('Título') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Cod.Interno') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('EAN') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('NCM') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Est.Atual') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Est.Mínimo') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Est.Máximo') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Tipo') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Grupo') ?></th>
                            <th class="text-center width-r100 text-nowrap"><?= __('Obs') ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach ($products as $value): ?>

                            <tr>
                                <td class="text-left width-r300">
                                    <?= h($value->title) ?>
                                </td>
                                <td class="text-right width-r100">
                                    <?= $value->code ?>
                                </td>
                                <td class="text-right width-r100">
                                    <?= $value->ean ? $value->ean : '-' ?>
                                </td>
                                <td class="text-right width-r100">
                                    <?= $value->ncm ? $value->ncm : '-' ?>
                                </td>
                                <td class="text-right width-r100">
                                    <?= $value->StockBalances['quantity'] ? $this->Number->precision($value->StockBalances['quantity'], 4) : '-' ?>
                                </td>
                                <td class="text-right width-r100">
                                    <?= $value->minimum ? $this->Number->precision($value->minimum, 4) : '-' ?>
                                </td>
                                <td class="text-right width-r100">
                                    <?= $value->maximum ? $this->Number->precision($value->maximum, 4) : '-' ?>
                                </td>
                                <td class="text-left width-r100">
                                    <?= $value->product_types_id ? $value->product_types_id .' - '. h($value->ProductTypes['title']) : '-' ?>
                                </td>
                                <td class="text-left width-r100">
                                    <?= $value->product_groups_id ? $value->product_groups_id .' - '. h($value->ProductGroups['title']) : '-' ?>
                                </td>
                                <td class="text-left width-r300">
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
    }//else if (!empty($products)) ?>
</div>
<?= $this->element('report-footer'); ?>