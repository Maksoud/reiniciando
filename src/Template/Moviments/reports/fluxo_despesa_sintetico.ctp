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
    
    <h4 class="page-header text-bold"><?= __('DESPESAS - FLUXO DIÁRIO - SINTÉTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviments'); ?>
        <?php
        if (empty($moviments)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else {
            $saldot = $saldobt = $saldodt = 0;
            ?>
    </div>
            <table class="col-xs-12 table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left text-nowrap col-xs-1"><?= __('Data') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acres.') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor Pgto') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo Pgto') ?></th>
                    </tr>
                </thead>
                <tbody>   
                    <?php 
                    foreach ($moviments as $index => $value):
                        if ($value['creditodebito'] == 'D') {
                            $dt = explode('-',$value['vencimento']);
                            $vencimento[$index] = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                        }
                    endforeach;
                    $total = $totalr = $totaldesc = $saldo = $saldoc = 0;
                    foreach (array_unique($vencimento) as $index => $value):
                        $realizado = $valor = $valorbaixa = $desc = 0;
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
                                    }

                                    if ($mergeds > 0) {
                                        '<i class="fa fa-paperclip"></i> ';
                                    }

                                    if ($value['creditodebito'] == 'D') {
                                        $valor += $value['valor'];
                                        
                                        if ($value['dtbaixa']) { 
                                            $desc       += $value['valorbaixa'] - $value['valor'];
                                            $valorbaixa += $value['valorbaixa'];
                                            $realizado  += $value['valorbaixa'];
                                            $saldo      += $value['valorbaixa'];
                                            $totalr     += $value['valorbaixa'];
                                        } else {
                                            if ($mergeds > 0) {
                                                $valor  -= $valorpago;
                                                $saldo  -= $valorpago;
                                            }
                                        }
                                    }
                                }
                            endforeach;
                            ?>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($valor, 'BRL'); $total += $valor; ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($desc, 'BRL'); $totaldesc  += $desc; ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($realizado, 'BRL'); ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></td>
                        </tr>
                        <?php
                    endforeach;
                    ?> 
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <th class="text-left"><?= __('TOTAIS') ?></td>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($total, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totaldesc, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totalr, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></th>
                    </tr>
                </tfoot>
            </table>
            <table>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Títulos: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$ ') ?><?= $this->Number->currency($total, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Descontos/Acréscimos: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$ ') ?><?= $this->Number->currency($totaldesc, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total dos Pagamentos: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$ ') ?><?= $this->Number->currency($totalr, 'BRL'); ?></th>
                </tr>
                <tr class="bg-blue">
                    <th class="text-left text-nowrap col-xs-1"><?= __('Total em Aberto: ') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('R$ ') ?><?= $this->Number->currency($total - $totalr + $totaldesc, 'BRL'); ?></th>
                </tr>
            </table>
            <?php
        } //if (empty($moviments)) ?>
</div>
<?= $this->element('report-footer'); ?>