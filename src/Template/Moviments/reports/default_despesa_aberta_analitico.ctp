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
    
    <h4 class="page-header text-bold"><?= __('DESPESAS A PAGAR - ANALÍTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviments'); ?>
        <?php
        if (empty($moviments)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        }else {
        ?>
    </div>
            <?php 
            $total = $saldot = 0;

            foreach ($moviments as $index => $value):
                if ($value['creditodebito'] == 'D') {
                    if ($value['status'] == 'A' || //ABERTO
                       $value['status'] == 'P' || //PARCIAL
                       $value['status'] == 'G') {  //AGRUPADO
                        $vencimento[$index] = $value['vencimento'];
                    }
                }
            endforeach;

            if (!empty($vencimento)) {
                $saldo = 0;
                ?>        
                <table class="col-xs-12 table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Emissão') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Vencimento') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Fornecedor') ?></th>
                            <th class="text-left"><?= __('Histórico') ?></th>
                            <th class="col-xs-1"></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($moviments as $value): 
                            if ($value['creditodebito'] == 'D') {
                                if ($value['status'] == 'A' || //ABERTO
                                   $value['status'] == 'P' || //PARCIAL
                                   $value['status'] == 'G') {  //AGRUPADO
                                    ?>
                                    <tr>
                                        <td class="text-left text-nowrap col-xs-1">
                                            <?= ($value['ordem'] ? str_pad($value['ordem'], 6, '0', STR_PAD_LEFT) : '') ?>
                                        </td>
                                        <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($value['data'])) ?></td>
                                        <td class="text-center text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($value['vencimento'])) ?></td>
                                        <td class="text-left text-nowrap col-xs-1">
                                            <?= $value['Providers']['title'] ?>
                                        </td>
                                        <td class="text-left"><?= $value['historico'] ?></td>
                                        <td class="text-right text-nowrap col-xs-1">
                                        <?php
                                            $valorpago = $mergeds = 0;
                                            if (isset($movimentMergeds)) {
                                               foreach ($movimentMergeds as $merged):
                                                    if ($merged['moviments_id'] == $value['id']) { //TÍTULOS COM VINCULADOS
                                                        if ($merged->Moviments['status'] == 'O' || 
                                                           $merged->Moviments['status'] == 'B') {
                                                            $mergeds++;
                                                            $valorpago += $merged->Moviments['valorbaixa'];
                                                        }
                                                    } elseif ($merged['moviments_merged'] == $value['id']) { //TÍTULOS PARCIAIS
                                                        if ($merged->Moviments['status'] == 'O' || 
                                                           $merged->Moviments['status'] == 'B') {
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
                                    </tr>
                                    <?php
                                }
                            }
                        endforeach;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue">
                            <th colspan="6"><?= 'Totais' ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); $saldot+=$saldo ?></th>
                        </tr>
                    </tfoot>
                </table>
            <?php
                echo '<i class="fa fa-paperclip"></i> <span style="font-size:10px;">Símbolo referente a títulos vinculados ou parciais.</span>';
            } else {
                echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        }}?>
</div>
<?= $this->element('report-footer'); ?>