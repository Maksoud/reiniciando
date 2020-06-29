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
    
    <h4 class="page-header text-bold"><?= __('DESPESAS E RECEITAS - PAGAS E RECEBIDAS - FLUXO DIÁRIO - SINTÉTICO') ?></h4>
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
                            if ($value['status'] == 'B' || //BAIXADO
                               $value['status'] == 'O') {  //BAIXA PARCIAL
                                $dt = explode('-',$value['dtbaixa']);
                                $dtbaixa[$index] = $dt[0].'-'.$dt[1];
                            }
                        }
                    endforeach;
                    
                    if (!empty($dtbaixa)) {
                        foreach (array_unique($dtbaixa) as $index => $value):
                            $credito = $debito = 0;
                            $dt = explode('-', $value);
                            $mes = $this->MyHtml->MesPorExtenso($dt[1]);
                                ?>
                                <tr>
                                    <td class="text-left text-nowrap col-xs-1"><?= $dt[0] ?></td>
                                    <td class="text-left text-nowrap col-xs-1"><?= $mes ?></td>
                                    <?php
                                        foreach ($moviments as $value):
                                            $dt = explode('-', $value['dtbaixa']);
                                            $baixa = $dt[0].'-'.$dt[1];
                                            
                                            if ($baixa == $dtbaixa[$index]) {
                                                if ($value['status'] == 'B' || //BAIXADO
                                                   $value['status'] == 'O') {  //BAIXA PARCIAL
                                                    if ($value['creditodebito'] == 'C') {
                                                        $credito += $value['valorbaixa'];
                                                    } elseif ($value['creditodebito'] == 'D') {
                                                        $debito += $value['valorbaixa'];
                                                    }
                                                }
                                            }
                                        endforeach;
                                    ?>
                                    <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($credito, 'BRL'); $saldo += $credito; $totalc += $credito; ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($debito,'BRL'); $saldo -= $debito;  $totald += $debito; ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL') ?></th>
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