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

<!-- MovimentBoxes -->
<?php $this->layout = 'layout-clean'; ?>

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTOS DE CAIXA - SINTÉTICO') ?></h4>
    <div class="pull-4 prt-report bottom-20">
        <?= $this->element('report-filter-moviment-boxes'); ?>
        <?php
        if (empty($movimentBoxes->toArray())) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else { ?>
    </div>
            <?php 
            //IDENTIFICA TODOS OS CAIXAS E SEUS NOMES
            foreach ($movimentBoxes as $box => $movimentBox) :
                $boxesid[$box]    = $movimentBox['boxes_id'];
                $boxestitle[$box] = $movimentBox['Boxes']['title'];
            endforeach;

            //INICIA VARIÁVEIS
            $somatitulo = $somatitulototal = 0;
            $somacredito = $somadebito = $somadesc = 0;
            $somacreditototal = $somadebitototal = $somadesctotal = 0;
            $saldototal = $somasaldoanterior = 0;

            if (isset($boxesid)) {

                //IDENTIFICA TODAS AS DATAS DE BAIXAS DOS MOVIMENTOS
                foreach ($movimentBoxes as $index => $value):
                    if ($value['creditodebito'] == $this->request->data['creditodebito'] || 
                        $this->request->data['creditodebito'] == 'A') { //14/07/2017
                        $dtbaixa[$index] = $value['dtbaixa'];
                    }
                endforeach;

                //LISTA OS REGISTROS POR BANCOS
                foreach (array_unique($boxesid) as $box => $boxid): ?>

                    <div class="pull-right text-bold">
                        <?php 
                        $saldo = 0;

                        //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                        if (!isset($saldo)) {
                            $saldo = '0.00';
                        }//if (!isset($saldo))
                            
                        if (!empty($balance)) {
                            foreach($balance as $value):
                                $saldo += $value['value'];
                            endforeach;
                        }//if (!empty($balance))

                        if ($balances->boxes_id == $boxesid[$box]) {
                            $saldo = $balances->value;
                            $somasaldoanterior += $saldo;
                        }//if ($balances->boxes_id == $boxesid[$box])
                        
                        echo 'Saldo Inicial: ' . $this->Number->currency($saldo, 'BRL');
                        ?>
                    </div>

                    <table class="table table-striped table-condensed prt-report">
                        <thead>
                            <tr class="bg-primary">
                                <th><?= $boxestitle[$box] ?></th>
                            </tr>
                        </thead>
                    </table>

                    <?php 
                    if (!empty($dtbaixa)) {
                        //INCREMENTA O SOMATÓRIO COM O SALDO ANTERIOR
                        if ($saldo < 0) {
                            $somadebito       += $saldo;
                            $somadebitototal  += $saldo;
                        } else { 
                            $somacredito      += $saldo;
                            $somacreditototal += $saldo;
                        }
                        ?>
                        <div class="col-xs-12 no-padding-lat table-responsive">
                            <table class="table table-striped table-condensed prt-report">
                                <thead>
                                    <tr class="bg-blue">
                                        <th class="text-left text-nowrap col-xs-1"><?= __('Ano') ?></th>
                                        <th class="text-left text-nowrap col-xs-1"><?= __('Mês') ?></th>
                                        <th class="text-right text-nowrap col-xs-1">
                                            <!-- -->
                                        </th>
                                        <?php if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Crédito') ?></th>
                                        <?php } ?>
                                        <?php if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Débito') ?></th>
                                        <?php } ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    //INICIA VARIÁVEIS
                                    $baixa = null;
                                    $somatitulo = $somacredito = $somadebito = $somadesc = 0;
                                    
                                    foreach ($movimentBoxes as $index => $value):
                                        if ($value['creditodebito'] == $this->request->data['creditodebito'] || $this->request->data['creditodebito'] == 'A') { //14/07/2017
                                            if ($value['boxes_id'] == $boxesid[$box]) {
                                                $dt = explode('-',$value['dtbaixa']);
                                                $baixa[$index] = $dt[0].'-'.$dt[1];
                                            }
                                        }
                                    endforeach;
                                    
                                    foreach (array_unique($baixa) as $index => $value):
                                        //INICIA VARIÁVEIS
                                        $credito = $debito = 0;
                                        $dt = explode('-', $value);
                                        $mesano = $dt[0].'-'.$dt[1];
                                        //$mes = $this->MyHtml->MesPorExtenso($dt[1]); ?>
                                        <tr>
                                            <td class="text-nowrap col-xs-1"><?= $dt[0] ?></td>
                                            <td class="text-nowrap col-xs-1"><?= $dt[1] ?></td>
                                            <?php
                                            foreach ($movimentBoxes as $value):
                                                $mesanodtbaixa = explode('-', $dtbaixa[$index]);
                                                $mesanodtbaixa = $mesanodtbaixa[0].'-'.$mesanodtbaixa[1];
                                                $mesanovalue = explode('-', $value['dtbaixa']);
                                                $mesanovalue = $mesanovalue[0].'-'.$mesanovalue[1];
                                                if ($mesanovalue == $mesanodtbaixa && $value['boxes_id'] == $boxesid[$box]) {
                                                    if ($value['creditodebito'] == 'C') {
                                                        $credito += $value['valorbaixa'];
                                                        $saldo   += $value['valorbaixa'];
                                                    }
                                                    if ($value['creditodebito'] == 'D') {
                                                        $debito  += $value['valorbaixa'];
                                                        $saldo   -= $value['valorbaixa'];
                                                    }
                                                    $somadesc    += $value['valorbaixa'] - $value['valor'];
                                                    $somatitulo  += $value['valor']; 
                                                }
                                            endforeach;
                                            $somacredito += $credito;
                                            $somadebito  += $debito;
                                            ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <!-- -->
                                            </td>
                                            <?php if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') { ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($credito, 'BRL'); ?>
                                            </td>
                                            <?php } ?>
                                            <?php if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') { ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($debito,'BRL'); ?>
                                            </td>
                                            <?php } ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($saldo, 'BRL') ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach;
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-12 no-padding-lat table-responsive">
                            <table class="table table-striped table-condensed prt-report">
                                <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"><?= $boxestitle[$box] ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Título') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Desc/Acresc') ?></th>
                                        <?php if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Créditos') ?></th>
                                        <?php } ?>
                                        <?php if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Débitos') ?></th>
                                        <?php } ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo Total') ?></th>
                                </thead>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <th colspan="2"><?= __('SALDO TOTAL') ?></th>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somatitulo, 'BRL') ?>
                                            <?php 
                                                $somatitulototal += $somatitulo;
                                            ?>
                                        </td>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somadesc, 'BRL') ?>
                                            <?php 
                                                $somadesctotal += $somadesc;
                                            ?>
                                        </td>
                                        <?php if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somacredito, 'BRL') ?>
                                            <?php 
                                                $somacreditototal += $somacredito;
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <?php if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somadebito, 'BRL') ?>
                                            <?php 
                                                $somadebitototal += $somadebito;
                                            ?>
                                        </td>
                                        <?php } ?>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($saldo, 'BRL') ?>
                                            <?php
                                                $saldototal += $saldo;
                                            ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php
                    }//if (!empty($dtbaixa)) {
                endforeach; 
                if (!empty($dtbaixa)) {
                    ?>
                    <div class="col-xs-12 no-padding-lat table-responsive">
                        <table class="table table-striped table-condensed prt-report">
                            <thead>
                                    <tr class="bg-primary">
                                        <th colspan="2"><?= __('SALDO TOTAL GERAL') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Saldos Anteriores') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Total Geral Título') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Total Geral Desc/Acresc') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Total Geral Créditos') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Total Geral Débitos') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Saldo Geral') ?></th>
                                </thead>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <th colspan="2"></th>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somasaldoanterior, 'BRL') ?></td>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somatitulototal, 'BRL') ?></td>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadesctotal, 'BRL') ?></td>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somacreditototal, 'BRL') ?></td>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadebitototal, 'BRL') ?></td>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldototal, 'BRL') ?></td>
                                    </tr>
                                </tfoot>
                        </table>
                    </div>
                    <?php
                } else {
                    echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
                }//else if (!empty($dtbaixa))
            } else {
                echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
            }//if (isset($banksid))
        }//if (empty($movimentBoxes))?>
</div>