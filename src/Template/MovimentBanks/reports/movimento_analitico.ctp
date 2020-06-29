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

<!-- MovimentBanks -->
<?php $this->layout = 'layout-clean'; ?>

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTOS DE BANCO - ANALÍTICO') ?></h4>
    <div class="pull-4 prt-report bottom-20">
        <?= $this->element('report-filter-moviment-banks'); ?>
        <?php 
        if (empty($movimentBanks->toArray())) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else { ?>
    </div>
            <?php 
            
            foreach ($movimentBanks as $index => $value):
                if ($value['creditodebito'] == $this->request->data['creditodebito'] || $this->request->data['creditodebito'] == 'A') { //14/07/2017
                    $banksid[$index]    = $value['banks_id'];
                    $bankstitle[$index] = $value->Banks['title'];
                }
            endforeach;
            
            $somatitulo = $somatitulototal = 0;
            $somacredito = $somadebito = $somadesc = 0;
            $somacreditototal = $somadebitototal = $somadesctotal = 0;
            $saldototal = $somasaldoanterior = 0;
            
            if (isset($banksid)) {
                foreach ($movimentBanks as $index => $value):
                    if ($value['creditodebito'] == $this->request->data['creditodebito'] || $this->request->data['creditodebito'] == 'A') { //14/07/2017
                        if ($value['banks_id'] == $banksid[$index]) {
                            $dtbaixa[$index] = $value['dtbaixa'];
                        }//if ($value['banks_id'] == $banksid[$index])
                    }
                endforeach;
                
                foreach (array_unique($banksid) as $bank => $bankid): ?>

                    <div class="pull-right text-bold">
                        <?php 
                        $saldo = 0;

                        if ($balances->banks_id == $banksid[$bank]) {
                            $saldo = $balances->value;
                            $saldototal += $balances->value;
                            $somasaldoanterior += $saldo;
                        }//if ($balances->banks_id == $banksid[$bank])

                        //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                        if (!isset($saldo)) {
                            $saldo = '0.00';
                        }//if (!isset($saldo))
                            
                        if (!empty($balance)) {
                            foreach($balance as $value):
                                $saldo += $value['value'];
                                $saldototal += $value['value'];
                            endforeach;
                        }//if (!empty($balance))
                        
                        echo 'Saldo Inicial: ' . $this->Number->currency($saldo, 'BRL');
                        ?>
                    </div>

                    <table class="table table-striped table-condensed prt-report">
                        <thead>
                            <tr class="bg-primary">
                                <th><?= $bankstitle[$bank] ?></th>
                            </tr>
                        </thead>
                    </table>

                    <?php 
                    if (!empty($dtbaixa)) {

                        $somatitulo = $somacredito = $somadebito = $somadesc = $saldoanterior = 0;

                        $saldoanterior += $saldo;
                        
                        if ($saldo < 0) {
                            //$somadebito       += $saldo; //Já existe o destaque do saldo anterior
                            //$somadebitototal  += $saldo; //Já existe o destaque do saldo anterior
                            //$saldototal       -= $saldo;
                        } else { 
                            //$somacredito      += $saldo; //Já existe o destaque do saldo anterior
                            //$somacreditototal += $saldo; //Já existe o destaque do saldo anterior
                            //$saldototal       += $saldo;
                        } ?>

                        <div class="col-xs-12 no-padding-lat table-responsive">
                            <table class="table table-striped table-condensed prt-report bottom-20">
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
                                    foreach ($movimentBanks as $movimentBank):
                                        if ($movimentBank['banks_id'] == $banksid[$bank]) { ?>
                                            <tr>
                                                <td class="text-left text-nowrap col-xs-1"><?= ($movimentBank['ordem'] ? str_pad($movimentBank['ordem'], 6, '0', STR_PAD_LEFT) : '') ?></td>
                                                <td class="text-center text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($movimentBank['data'])) ?></td>
                                                <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($movimentBank['vencimento'])) ?></td>
                                                <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($movimentBank['dtbaixa'])) ?></td>
                                                <td class="text-left text-nowrap col-xs-1 hidden-print"><?= $movimentBank['documento'] ? $movimentBank['documento'] : "-"; ?></td>
                                                <td class="text-left"><?= $movimentBank['historico'] ?></td>
                                                <td class="text-center text-nowrap col-xs-1">
                                                    <?php if ($movimentBank['creditodebito'] == 'C') { ?>
                                                        <span class="fa fa-plus-circle" style="color: #2aabd2" title="<?= __('Crédito') ?>"></span>
                                                    <?php } elseif ($movimentBank['creditodebito'] == 'D') { ?>
                                                        <span class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito') ?>"></span>
                                                    <?php }?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    $somatitulo      += $movimentBank['valor'];
                                                    $somatitulototal += $movimentBank['valor'];
                                                ?>
                                                    <?= $this->Number->currency($movimentBank['valor'], 'BRL') ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    $desc = $movimentBank['valorbaixa'] - $movimentBank['valor'];
                                                    $somadesc      += $desc;
                                                    $somadesctotal += $desc;
                                                ?>
                                                    <?= $this->Number->currency($desc, 'BRL') ?>
                                                </td>
                                                <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    if ($movimentBank['creditodebito'] == 'C') { 
                                                        $somacredito      += $movimentBank['valorbaixa'];
                                                        $somacreditototal += $movimentBank['valorbaixa'];
                                                        $saldo            += $movimentBank['valorbaixa'];
                                                        $saldototal       += $movimentBank['valorbaixa'];
                                                    }
                                                    elseif ($movimentBank['creditodebito'] == 'D') { 
                                                        $somadebito      += $movimentBank['valorbaixa']; 
                                                        $somadebitototal += $movimentBank['valorbaixa'];
                                                        $saldo           -= $movimentBank['valorbaixa'];
                                                        $saldototal      -= $movimentBank['valorbaixa'];
                                                    }
                                                ?>
                                                    <?= $this->Number->currency($movimentBank['valorbaixa'], 'BRL') ?>
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
                                        <th colspan="2"><?= $bankstitle[$bank] ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo Anterior') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Título') ?></th>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Desc/Acresc') ?></th>
                                        <?php if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Créditos') ?></th>
                                        <?php }//if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') ?>
                                        <?php if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Débitos') ?></th>
                                        <?php }//if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') ?>
                                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo Total') ?></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="bg-primary">
                                        <th colspan="2"><?= __('SALDO TOTAL') ?></th>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($saldoanterior, 'BRL') ?>
                                        </td>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somatitulo, 'BRL') ?>
                                        </td>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somadesc, 'BRL') ?>
                                        </td>
                                        <?php if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somacredito, 'BRL') ?>
                                        </td>
                                        <?php }//if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'A') ?>
                                        <?php if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') { ?>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($somadebito, 'BRL') ?>
                                        </td>
                                        <?php }//if ($this->request->data['creditodebito'] == 'D' || $this->request->data['creditodebito'] == 'A') ?>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?= $this->Number->currency($saldo, 'BRL') ?>
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
                                    <th class="text-right text-nowrap col-xs-1"><?= __('Saldos Anteriores') ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= __('Total Geral Título') ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= __('Total Geral Desc/Acresc') ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= __('Total Geral Créditos') ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= __('Total Geral Débitos') ?></th>
                                    <th class="text-right text-nowrap col-xs-1"><?= __('Saldo Geral') ?></th>
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
            }//if (isset($banksid))
    }//if (empty($movimentBanks))?>
</div>