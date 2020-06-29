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
    
    <h4 class="page-header text-bold"><?= __('DESPESAS - ANALÍTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviments'); ?>
        <?php
        if (empty($moviments)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        }else {
            ?>
    </div>
            <?php 
            $saldot = $saldobt = $saldodt = 0;

            foreach ($moviments as $index => $value):
                if ($value['creditodebito'] == 'D') {
                    $vencimento[$index] = $value['vencimento'];
                }
            endforeach;

            if (!empty($vencimento)) {
                $saldob = $saldo = $saldod = 0;
                ?>        
                <table class="col-xs-12 table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                            <th class="text-center text-nowrap col-xs-1 hidden-print"><?= __('Emissão') ?></th>
                            <th class="text-center text-nowrap col-xs-1 hidden-print"><?= __('Vencimento') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Pagamento') ?></th>
                            <th class="text-left text-nowrap col-xs-2"><?= __('Fornecedor') ?></th>
                            <th class="text-left"><?= __('Histórico') ?></th>
                            <th class="col-xs-1"></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acres.') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Pgto.') ?></th>
                        </tr>
                    </thead>
                    <tbody>    
                        <?php
                        foreach ($moviments as $value): 
                            if ($value['creditodebito'] == 'D') {
                                ?>
                                <tr>
                                    <td class="text-left text-nowrap col-xs-1">
                                        <?= ($value['ordem'] ? str_pad($value['ordem'], 6, '0', STR_PAD_LEFT) : '') ?>
                                    </td>
                                    <td class="text-center text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($value['data'])) ?></td>
                                    <td class="text-center text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($value['vencimento'])) ?></td>
                                    <td class="text-center text-nowrap col-xs-1">
                                        <?php 
                                        if ($value['dtbaixa']) {
                                            echo date("d/m/Y", strtotime($value['dtbaixa']));
                                        }
                                        ?>
                                    </td>
                                    <td class="text-nowrap col-xs-2">
                                        <?= $value['Providers']['title'] ?>
                                    </td>
                                    <td class="text-left"><?= $value['historico'] ?></td>
                                    <td class="text-right text-nowrap col-xs-1">
                                    <?php
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
                                            echo '<i class="fa fa-paperclip"></i> ';
                                        }
                                    ?>
                                    </td>
                                    <td class="text-right text-nowrap col-xs-1">
                                    <?php 
                                        if ($mergeds > 0) {
                                            echo $this->Number->currency($value['valor'] - $valorpago,'BRL'); 
                                            $saldo += $value['valor'] - $valorpago;
                                        } else {
                                            echo $this->Number->currency($value['valor'],'BRL'); 
                                            $saldo += $value['valor'];
                                        }
                                    ?>
                                    </td>
                                    <td class="text-right text-nowrap col-xs-1">
                                    <?php 
                                        if ($value['valorbaixa']) {
                                            if ($mergeds > 0) {
                                                echo $this->Number->currency($desc = $value['valorbaixa'] - ($value['valor'] - $valorpago),'BRL'); 
                                                $saldod += $desc; 
                                            } else {
                                                echo $this->Number->currency($desc = $value['valorbaixa'] - $value['valor'],'BRL'); 
                                                $saldod += $desc; 
                                            }
                                        }
                                    ?>
                                    </td>
                                    <td class="text-right text-nowrap col-xs-1">
                                    <?php 
                                        if ($value['valorbaixa']) {
                                            echo $this->Number->currency($value['valorbaixa'],'BRL'); 
                                            $saldob += $value['valorbaixa']; 
                                        }
                                    ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        endforeach;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue">
                            <th colspan="5"><?= 'Totais' ?></th>
                            <th colspan="2" class="hidden-print"></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); $saldot+=$saldo ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldod,'BRL'); $saldodt+=$saldod ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldob, 'BRL'); $saldobt+=$saldob ?></th>
                        </tr>
                    </tfoot>
                </table>
                <table class="col-xs-12 table table-striped table-condensed prt-report">
                    <tr class="bg-blue">
                        <td colspan="6"></td>
                        <th class="text-right text-nowrap col-xs-1">Valor Título</th>
                        <th class="text-right text-nowrap col-xs-1">Desc./Acres.</th>
                        <th class="text-right text-nowrap col-xs-1">Valor Pgto.</th>
                    </tr>
                </table>
            <?php
                echo '<i class="fa fa-paperclip"></i> <span style="font-size:10px;">Símbolo referente a títulos vinculados ou parciais.</span>';
            } else {
                echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
            }
        }?>
</div>
<?= $this->element('report-footer'); ?>