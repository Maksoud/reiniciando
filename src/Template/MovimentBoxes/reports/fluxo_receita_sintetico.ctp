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
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTOS DE CAIXAS - RECEITAS - FLUXO DIÁRIO - SINTÉTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviment-boxes'); ?>
        <?php
        if (empty($movimentBoxes)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else { 
            $totaldescacrescc = $totaltitulocred = $totalc = $saldo = 0;
            ?>
    </div>
            <?php 
            foreach ($movimentBoxes as $box => $movimentBox):
                if ($movimentBox['creditodebito'] == 'C') { //RELATÓRIO DE RECEITAS
                    $boxesid[$box]    = $movimentBox['boxes_id'];
                    $boxestitle[$box] = $movimentBox['Boxes']['title'];
                } 
            endforeach;
            
            foreach (array_unique($boxesid) as $box => $boxid): ?>
                <div class="pull-right text-bold">
                    <?php
                    $isset = NULL; //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                    foreach ($balances as $balance => $movimentBox):
                        if ($balance == $boxesid[$box]) {
                            $saldo = $movimentBox;
                            $isset = $saldo;
                            echo __('Saldo Inicial: ') . $this->Number->currency($saldo, 'BRL');
                        } 
                    endforeach; 

                    //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                    if (empty($isset)) {
                        $saldo = '0.00';
                        echo __('Saldo Inicial: ') . $this->Number->currency($saldo, 'BRL');
                    }//if (empty($isset))
                    ?> 
                </div>
                <span class="text-bold"><?= $boxestitle[$box] ?></span>
                <div class="col-xs-12 no-padding-lat table-responsive">
                    <table class="table table-striped table-condensed prt-report">
                        <thead>
                            <tr class="bg-blue">
                                <th class="text-left text-nowrap col-xs-1"><?= __('Data') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= __('Valor do Título') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= __('Descontos/Acréscimos') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= __('Crédito') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                            </tr>
                        </thead>
                        <tbody>   
                            <?php 
                            foreach ($movimentBoxes as $index => $value):
                                if ($value['creditodebito'] == 'C') {
                                    if ($value['boxes_id'] == $boxesid[$box]) {
                                        $dt = explode('-', $value['dtbaixa']);
                                        $dtbaixa[$index] = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                                    }
                                }
                            endforeach;
                            
                            foreach (array_unique($dtbaixa) as $index => $value):
                                $credito = $titulocred = $descacrescc = 0;
                                $dt      = explode('-', $value);
                                ?>
                                <tr>
                                    <td class="text-left text-nowrap"><?= $dt[2] . '/' . $dt[1] . '/' . $dt[0] ?></td>
                                    <?php
                                    foreach ($movimentBoxes as $value):
                                        if ($value['dtbaixa'] == $dtbaixa[$index]) {
                                            if ($value['creditodebito'] == 'C') {
                                                $titulocred  += $value['valor'];
                                                $descacrescc += $value['valorbaixa'] - $value['valor'];
                                                $credito     += $value['valorbaixa']; 
                                                $saldo       += $value['valorbaixa']; 
                                            }
                                        }
                                    endforeach;
                                    ?>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($titulocred, 'BRL'); $totaltitulocred += $titulocred; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($descacrescc, 'BRL'); $totaldescacrescc += $descacrescc; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($credito, 'BRL'); $totalc += $credito; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></td>
                                </tr>
                                <?php
                            endforeach;
                            ?> 
                        </tbody>
                        <tfoot>
                            <tr class="bg-blue">
                                <th class="text-left"><?= __('TOTAIS') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totaltitulocred, 'BRL'); ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totaldescacrescc, 'BRL'); ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($totalc, 'BRL'); ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php
            endforeach; 
        } //if (empty($movimentBoxes)) ?>
</div>