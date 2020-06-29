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
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTO DE CAIXA - ANALÍTICO') ?></h4>
    <div class="pull-4 prt-report bottom-20">
        <?= $this->element('report-filter-moviment-boxes'); ?>
        <?php
        if (empty($movimentBoxes->toArray())) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else { ?>
    </div>
            <?php 
            foreach ($movimentBoxes as $index => $value) :
                if ($value['creditodebito'] == $this->request->data['creditodebito'] || $this->request->data['creditodebito'] == 'A') { //14/07/2017
                    $boxesid[$index] = $value['boxes_id'];
                    $boxestitle[$index] = $value->Boxes['title'];
                }
            endforeach;
            
            $somatitulo = $somatitulototal = 0;
            $somacredito = $somadebito = $somadesc = 0;
            $somacreditototal = $somadebitototal = $somadesctotal = 0;
            $saldototal = $somasaldoanterior = 0;
            
            if (isset($boxesid)) {
                
                foreach ($movimentBoxes as $index => $value):
                    if ($value['creditodebito'] == $this->request->data['creditodebito'] || $this->request->data['creditodebito'] == 'A') { //14/07/2017
                        if ($value['boxes_id'] == $boxesid[$index]) {
                            $dtbaixa[$index] = $value['dtbaixa'];
                        }//if ($value['boxes_id'] == $boxesid[$index])
                    }
                endforeach;
                
                foreach (array_unique($boxesid) as $box => $boxid): ?>

                    <div class="pull-right text-bold">
                        <?php 
                        $saldo = 0;

                        if ($balances->boxes_id == $boxesid[$box]) {
                            $saldo = $balances->value;
                            $somasaldoanterior += $saldo;
                        }//if ($balances->boxes_id == $boxesid[$box])

                        //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                        if (!isset($saldo)) {
                            $saldo = '0.00';
                        }//if (!isset($saldo))
                            
                        if (!empty($balance)) {
                            foreach($balance as $value):
                                $saldo += $value['value'];
                            endforeach;
                        }//if (!empty($balance))
                        
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
                        $somatitulo = $somacredito = $somadebito = $somadesc = 0;
                        
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
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                                        <th class="text-center text-nowrap col-xs-1 hidden-print"><?= __('Emissão') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Vencimento') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Pagamento') ?></th>
                                        <th class="text-left text-nowrap col-xs-1 hidden-print"><?= __('Documento') ?></th>
                                        <th class="text-left"><?= __('Históricos') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Créd/Déb') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Título') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acresc.') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($movimentBoxes as $movimentBox):
                                        if ($movimentBox['boxes_id'] == $boxesid[$box]) { ?>
                                            <tr>
                                                <td class="text-left text-nowrap col-xs-1"><?= ($movimentBox['ordem'] ? str_pad($movimentBox['ordem'], 6, '0', STR_PAD_LEFT) : '') ?></td>
                                                <td class="text-center text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($movimentBox['data'])) ?></td>
                                                <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($movimentBox['vencimento'])) ?></td>
                                                <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($movimentBox['dtbaixa'])) ?></td>
                                                <td class="text-left text-nowrap col-xs-1 hidden-print"><?= $movimentBox['documento'] ? $movimentBox['documento'] : '-'; ?></td>
                                                <td class="text-left"><?= $movimentBox['historico'] ?></td>
                                                <td class="text-center text-nowrap col-xs-1">
                                                    <?php if ($movimentBox['creditodebito'] == 'C') { ?>
                                                        <span class="fa fa-plus-circle" style="color: #2aabd2" title="<?= __('Crédito') ?>"></span>
                                                    <?php } elseif ($movimentBox['creditodebito'] == 'D') { ?>
                                                        <span class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito') ?>"></span>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    $somatitulo += $movimentBox['valor'];
                                                ?>
                                                    <?= $this->Number->currency($movimentBox['valor'], 'BRL') ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    $desc = $movimentBox['valorbaixa'] - $movimentBox['valor'];
                                                    $somadesc += $desc;
                                                ?>
                                                    <?= $this->Number->currency($desc, 'BRL') ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    if ($movimentBox['creditodebito'] == 'C') { 
                                                        $somacredito += $movimentBox['valorbaixa']; 
                                                        $saldo       += $movimentBox['valorbaixa'];
                                                    }
                                                    elseif ($movimentBox['creditodebito'] == 'D') { 
                                                        $somadebito += $movimentBox['valorbaixa']; 
                                                        $saldo      -= $movimentBox['valorbaixa'];
                                                    }
                                                ?>
                                                    <?= $this->Number->currency($movimentBox['valorbaixa'], 'BRL') ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                    <?= $this->Number->currency($saldo, 'BRL'); ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    endforeach; ?>             
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
                                    </tr>
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
                    }//if (!empty($dtbaixa))
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
                                </tr>
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
            }////if (isset($boxesid))
    }//if (empty($movimentBoxes))?>
</div>