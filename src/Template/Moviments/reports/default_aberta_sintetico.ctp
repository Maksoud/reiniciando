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
    
    <h4 class="page-header text-bold"><?= __('DESPESAS E RECEITAS - EM ABERTO - SINTÉTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviments'); ?>
        <?php
        if (empty($moviments)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else {
            $total = $totalc = $totald = $saldo = 0;
            ?>
    </div>
            <table class="col-xs-12 table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left text-nowrap col-xs-1"><?= __('Ano') ?></th>
                        <th class="text-left text-nowrap col-xs-1"><?= __('Mês') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Crédito') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Débito') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                    </tr>
                </thead>
                <tbody>   
                    <?php 
                    foreach ($moviments as $index => $value):
                        if ($value['creditodebito'] == 'C' || $value['creditodebito'] == 'D') {
                            if ($value['status'] == 'A' || //ABERTO
                               $value['status'] == 'P' || //PARCIAL
                               $value['status'] == 'G') {  //AGRUPADO
                                $dt = explode('-',$value['vencimento']);
                                $vencimento[$index] = $dt[0].'-'.$dt[1];
                            }
                        }
                    endforeach;
                    
                    if (!empty($vencimento)) {
                        foreach (array_unique($vencimento) as $index => $value):
                            $credito = $debito = 0;
                            $dt = explode('-', $value);
                            $mes = $this->MyHtml->MesPorExtenso($dt[1]);
                                ?>
                                <tr>
                                    <td class="text-left text-nowrap col-xs-1"><?= $dt[0] ?></td>
                                    <td class="text-left text-nowrap col-xs-1"><?= $mes ?></td>
                                    <?php
                                        foreach ($moviments as $value):
                                            $dt = explode('-', $value['vencimento']);
                                            $venc = $dt[0].'-'.$dt[1];
                                        
                                            //LOCALIZA PAGAMENTOS PARCIAIS
                                            $valorpago = 0;
                                            if (isset($movimentMergeds)) {
                                               foreach ($movimentMergeds as $merged):
                                                    if ($merged['moviments_id'] == $value['id']) { //TÍTULOS COM VINCULADOS
                                                        if ($merged->Moviments['status'] == 'B' || //BAIXADO
                                                           $merged->Moviments['status'] == 'O') {  //BAIXA PARCIAL
                                                            $valorpago += $merged->Moviments['valorbaixa'];
                                                        }
                                                    } 
                                                endforeach; 
                                            }
                                            
                                            if ($venc == $vencimento[$index]) {
                                                if ($value['status'] == 'A' || $value['status'] == 'P') {
                                                    if ($value['creditodebito'] == 'C') {
                                                        $credito += $value['valor'] - $valorpago;
                                                    } elseif ($value['creditodebito'] == 'D') {
                                                        $debito += $value['valor'] - $valorpago;
                                                    }
                                                }
                                            }
                                        endforeach;
                                    ?>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($credito, 'BRL'); $saldo += $credito; $totalc += $credito; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($debito,'BRL'); $saldo -= $debito;  $totald += $debito; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL') ?></td>
                                </tr>
                                <?php
                        endforeach;
                    } else {
                        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
                    }
                ?> 
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <th colspan="2"><?= __('TOTAIS') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totalc, 'BRL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totald, 'BRL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL') ?></th>
                    </tr>
                </tfoot>
            </table>
            <?php
        } //if (empty($moviments)) ?>
</div>
<?= $this->element('report-footer'); ?>