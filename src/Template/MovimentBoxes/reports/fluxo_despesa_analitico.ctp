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
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTOS DE CAIXAS - DESPESAS - FLUXO DIÁRIO - ANALÍTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviment-boxes'); ?>
        <?php
        if (empty($movimentBoxes)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else { ?>
    </div>
            <?php 
            foreach ($movimentBoxes as $box => $movimentBox):
                if ($movimentBox['creditodebito'] == 'D') { //RELATÓRIO DE DESPESAS
                    $boxesid[$box]    = $movimentBox['boxes_id'];
                    $boxestitle[$box] = $movimentBox['Boxes']['title'];
                } else {
                    echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
                    die();
                }
            endforeach;
            
            $saldo = $saldototal = $somatitulototal = $somadesctotal = $somadebitototal = 0;
            
            foreach ($movimentBoxes as $index => $value):
                if ($value['creditodebito'] == 'D') {
                    if ($value['boxes_id'] == $boxesid[$box]) {
                        $dtbaixa[$index] = $value['dtbaixa'];
                    }
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
                    }
                    ?> 
                </div>
                <span class="text-bold"><?= $boxestitle[$box] ?></span>
                <?php
                if (!empty($dtbaixa)) {
                    foreach (array_unique($dtbaixa) as $index => $values):
                        $somatitulo = $somadesc = $somadebito = 0;
                        ?> 
                        <div class="col-xs-12 no-padding-lat table-responsive">
                            <table class="table table-striped table-condensed prt-report">
                                <div class="text-bold"><?= __('Pagamentos do dia ').date("d/m/Y", strtotime($values)) ?></div>
                                <thead>
                                    <tr class="bg-blue">
                                        <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                                        <th class="text-center text-nowrap col-xs-1 hidden-print"><?= __('Emissão') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Vencimento') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Pagamento') ?></th>
                                        <th class="text-left text-nowrap col-xs-1 hidden-print"><?= __('Documento') ?></th>
                                        <th class="text-left"><?= __('Histórico') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Título') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acresc.') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor Pago') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                                    </tr>
                                </thead>
                                <tbody>    
                                    <?php
                                    foreach ($movimentBoxes as $value):
                                        if ($value['dtbaixa'] == $dtbaixa[$index] && $value['creditodebito'] == 'D') {
                                            ?>
                                            <tr>
                                                <td class="text-left text-nowrap col-xs-1"><?= ($value['ordem'] ? str_pad($value['ordem'], 6, '0', STR_PAD_LEFT) : '') ?></td>
                                                <td class="text-center text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($value['data'])) ?></td>
                                                <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($value['vencimento'])) ?></td>
                                                <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($value['dtbaixa'])) ?></td>
                                                <td class="text-left text-nowrap col-xs-1 hidden-print"><?= $value['documento'] ? $value['documento'] : '-'; ?></td>
                                                <td class="text-left"><?= $value['historico'] ?></td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    echo $this->Number->currency($value['valor'], 'BRL'); 
                                                    $somatitulo += $value['valor'];
                                                ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    $desc = $value['valorbaixa'] - $value['valor'];
                                                    echo $this->Number->currency($desc, 'BRL'); 
                                                    $somadesc += $desc;
                                                ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    echo $this->Number->currency($value['valorbaixa'], 'BRL'); 
                                                    $somadebito += $value['valorbaixa'];
                                                    $saldo += $value['valorbaixa'];
                                                ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                    <?= $this->Number->currency($saldo, 'BRL'); ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-blue">
                                        <th colspan="4"><?= __('Totais dos Pagamentos do dia ').date("d/m/Y", strtotime($values)) ?></th>
                                        <th colspan="2" class="hidden-print"></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somatitulo, 'BRL'); $somatitulototal += $somatitulo; ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadesc, 'BRL');   $somadesctotal += $somadesc; ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadebito, 'BRL'); $somadebitototal += $somadebito; ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                        <?php
                    endforeach;
                }//if (!empty($dtbaixa))
            endforeach; 
            if (!empty($dtbaixa)) {
                ?>
                <div class="col-xs-12 no-padding-lat table-responsive">
                    <table class="table table-striped table-condensed prt-report">
                        <thead>
                            <tr class="bg-blue">
                                <th colspan="6"></th>
                                <th class="text-right col-xs-1"><?= __('Total Título') ?></th>
                                <th class="text-right col-xs-1"><?= __('Total Desc/Acresc') ?></th>
                                <th class="text-right col-xs-1"><?= __('Total Valor Pago') ?></th>
                        </thead>
                        <tfoot>
                            <tr class="bg-blue">
                                <th colspan="6"><?= __('SALDO TOTAL GERAL') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somatitulototal, 'BRL') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadesctotal, 'BRL') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadebitototal, 'BRL') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                
        <?php } else {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        }//else if (!empty($dtbaixa))
    }//else if (empty($movimentBoxes))?>
</div>