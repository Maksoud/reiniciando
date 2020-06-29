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

<?php $this->layout = 'layout-clean'; ?>

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTOS DE CAIXAS - RECEITAS - SINTÉTICO') ?></h4>
    <div class="pull-4 prt-report bottom-20">
        <?= $this->element('report-filter-moviment-boxes'); ?>
    <?php
    if (empty($movimentBoxes)) {
        if ($this->request->data['boxes_id']) {
            foreach ($balances as $index => $value):
                if ($index == $this->request->data['boxes_id']) {
                    echo '<span class="text-bold">'.$boxes->Boxes['title'].'</span><br />';
                    echo '<span class="text-bold">'.__('Saldo Atual: ').'</span>'.$this->Number->currency($value, 'BRL');
                } 
            endforeach;
        }
        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
    } else { ?>
    </div>
        <?php
        foreach ($movimentBoxes as $box => $movimentBox):
            if ($movimentBox['creditodebito'] == 'C') { //RELATÓRIO DE RECEITAS
                $boxesid[$box]    = $movimentBox['boxes_id'];
                $boxestitle[$box] = $movimentBox['Boxes']['title'];
            } else {
                echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
                die();
            }
        endforeach;
        
        $somatitulostotal = $somadesctotal = $somacreditototal = $saldototal = 0;
        
        foreach (array_unique($boxesid) as $box => $boxid) : 
            $somacredito = 0;
            ?>
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
                            <th class="text-left text-nowrap col-xs-1"><?= __('Ano') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Mês') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acresc.') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Recebido') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $totalc = 0;
                        foreach ($movimentBoxes as $index => $value):
                            if ($value['creditodebito'] == 'C') {
                                if ($value['boxes_id'] == $boxesid[$box]) {
                                    $dt = explode('-',$value['dtbaixa']);
                                    $dtbaixa[$index] = $dt[0].'-'.$dt[1];
                                }
                            }
                        endforeach;
                        
                        $somatitulo = $somadesc = $somacredito = 0;
                        
                        if (!empty($dtbaixa)) {
                            foreach (array_unique($dtbaixa) as $index => $value):
                                $titulo = $descacresc = $creditob = 0;
                                
                                $dt = explode('-', $value);
                                $mes = $this->MyHtml->MesPorExtenso($dt[1]);
                                ?>
                                <tr>
                                    <td class="text-left text-nowrap"><?= $dt[0] ?></td>
                                    <td class="text-left text-nowrap"><?= $mes ?></td>
                                    <?php
                                        foreach ($movimentBoxes as $value):
                                            if ($value['boxes_id'] == $boxesid[$box]) {
                                                $dt = explode('-', $value['dtbaixa']);
                                                $baixa = $dt[0].'-'.$dt[1];

                                                if ($baixa == $dtbaixa[$index]) {
                                                    if ($value['creditodebito'] == 'C') {
                                                        $titulo     += $value['valor'];
                                                        $descacresc += $value['valorbaixa'] - $value['valor'];
                                                        $creditob   += $value['valorbaixa'];
                                                    }
                                                }
                                            }
                                        endforeach;
                                    ?>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($titulo, 'BRL');     $somatitulo += $titulo; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($descacresc, 'BRL'); $somadesc += $descacresc; ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($creditob, 'BRL');   $saldo += $creditob; $somacredito += $creditob;  ?></td>
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
                            <th colspan="2"><?= ($boxestitle[$box]) ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somatitulo, 'BRL');  $somatitulostotal += $somatitulo; ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadesc, 'BRL');    $somadesctotal += $somadesc; ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somacredito, 'BRL'); $somacreditototal += $somacredito; ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL');       $saldototal += $saldo; ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
        endforeach; ?>
        <div class="col-xs-12 no-padding-lat table-responsive">
            <table class="table table-striped table-condensed prt-report">
                <tfoot>
                    <tr class="bg-blue">
                        <th colspan="2"></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Títulos') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Desc/Acresc') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Recebido') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Total Saldo') ?></th>
                    </tr>
                    <tr class="bg-blue">
                        <th colspan="2"><?= __('TOTAL GERAL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somatitulostotal, 'BRL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadesctotal, 'BRL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somacreditototal, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldototal, 'BRL'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
    }//if (empty($movimentBoxes))?>
</div>