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

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('DESPESAS E RECEITAS - FLUXO DIÁRIO - SINTÉTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviments'); ?>
        <?php
        if (empty($moviments)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else {
            $total = $totalco = $totalcr = $totaldo = $totaldr = $saldo = 0;
            $totalcdesc = $totalddesc = 0;
            ?>
    </div>
            <table class="col-xs-12 table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left text-nowrap col-xs-1"><?= __('Data') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Crédito Orçado') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Crédito Realizado') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Débito Orçado') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Débito Realizado') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo Realizado') ?></th>
                    </tr>
                </thead>
                <tbody>   
                    <?php 
                    foreach ($moviments as $index => $value):
                        if ($value['creditodebito'] == 'C' || $value['creditodebito'] == 'D') {
                            $dt = explode('-', $value['vencimento']);
                            $vencimento[$index] = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                        }//if ($value['creditodebito'] == 'C' || $value['creditodebito'] == 'D')
                    endforeach;
                    
                    $saldo = $saldoc = $saldod = 0;

                    foreach (array_unique($vencimento) as $index => $value):
                        $creditoo = $debitoo = $creditor = $debitor = 0;
                        $dt      = explode('-', $value);
                        $mes     = $this->MyHtml->MesPorExtenso($dt[1]);
                        ?>
                        <tr>
                            <td class="text-left text-nowrap col-xs-1"><?= $dt[2] . '/' . $dt[1] . '/' . $dt[0] ?></td>
                            <?php
                            foreach ($moviments as $value):
                                if ($value['vencimento'] == $vencimento[$index]) {
                                    $valorpago = $mergeds = 0;
                                    
                                    if (isset($movimentMergeds)) {
                                       foreach ($movimentMergeds as $merged):
                                            if ($merged['moviments_id'] == $value['id']) { //TÍTULOS COM VINCULADOS
                                                if ($merged->Moviments['status'] == 'B' || //BAIXADO
                                                   $merged->Moviments['status'] == 'O') {  //BAIXA PARCIAL
                                                    $mergeds++;
                                                    $valorpago += $merged->Moviments['valorbaixa'];
                                                }
                                            } elseif ($merged['moviments_merged'] == $value['id']) { //TÍTULOS PARCIAIS
                                                if ($merged->Moviments['status'] == 'B' || //BAIXADO
                                                   $merged->Moviments['status'] == 'O') {  //BAIXA PARCIAL
                                                    $mergeds++;
                                                }
                                            }
                                        endforeach; 
                                    }//if (isset($movimentMergeds))

                                    if ($mergeds > 0) {
                                        '<i class="fa fa-paperclip"></i> ';
                                    }//if ($mergeds > 0)

                                    if ($value['creditodebito'] == 'C') {
                                        $creditoo += $value['valor'];
                                        
                                        if ($value['dtbaixa']) { 
                                            $totalcdesc += $value['valorbaixa'] - $value['valor'];
                                            $creditor   += $value['valorbaixa']; 
                                            $saldo      += $value['valorbaixa']; 
                                        } else {
                                            if ($mergeds > 0) {
                                                $creditoo -= $valorpago; 
                                                $saldo    -= $valorpago; 
                                            }
                                        }
                                    }//if ($value['creditodebito'] == 'C')

                                    if ($value['creditodebito'] == 'D') {
                                        $debitoo += $value['valor'];
                                        
                                        if ($value['dtbaixa']) { 
                                            $totalddesc += $value['valorbaixa'] - $value['valor'];
                                            $debitor    += $value['valorbaixa']; 
                                            $saldo      -= $value['valorbaixa']; 
                                        } else {
                                            if ($mergeds > 0) {
                                                $debitoo -= $valorpago; 
                                                $saldo   += $valorpago; 
                                            }
                                        }
                                    }//if ($value['creditodebito'] == 'D')
                                }//if ($value['vencimento'] == $vencimento[$index])
                            endforeach;
                            ?>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($creditoo, 'BRL'); $totalco += $creditoo; ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($creditor, 'BRL'); $totalcr += $creditor; ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($debitoo, 'BRL'); $totaldo += $debitoo; ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($debitor, 'BRL'); $totaldr += $debitor; ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></td>
                        </tr>
                        <?php
                    endforeach;
                    ?> 
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <th class="text-left"><?= __('TOTAIS') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totalco, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totalcr, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totaldo, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totaldr, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></th>
                    </tr>
                </tfoot>
            </table>
            <table>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Créditos Orçados: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totalco, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Créditos Realizados: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totalcr, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Descontos/Acréscimos nos Créditos: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totalcdesc, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Créditos em Aberto: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totalco - $totalcr + $totalcdesc, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Débitos Orçados: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totaldo, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Débitos Realizados: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totaldr, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Descontos/Acréscimos nos Débitos: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totalddesc, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Débitos em Aberto: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$') ?> <?= $this->Number->currency($totaldo - $totaldr + $totalddesc, 'BRL'); ?></th>
                </tr>
            </table>
            <?php
        } //if (empty($moviments)) ?>
</div>
<?= $this->element('report-footer'); ?>