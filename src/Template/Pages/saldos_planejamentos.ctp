<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Pages */
/* File: src/Template/Pages/saldos_planejamentos.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
        <?php 
        if (!empty($plannings->toArray())) { ?>
            <div class="row">
                <div class="box panel panel-default box-shadow" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold"><i class="fa fa-trophy"></i> <?= __('Progresso dos Planejamentos') ?></span>
                    </div>
                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left"><?= __('Descrição') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Planejamento') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Progresso') ?></th>
                                        <th class="text-nowrap text-right col-xs-1"><?= __('Total Poupado') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $saldo_total = $vlr_total = 0;
                                    foreach ($plannings as $planning):

                                        //CALCULA O PERCENTUAL DE PAGAMENTO
                                        foreach ($saldos as $balance):
                                            
                                            if ($balance->plannings_id == $planning->id) {
                                                $concluido = round((($balance->value / ($planning->valor * $planning->parcelas)) * 100));
                                                $vlr_total += $balance->value;
                                            }
                                            
                                        endforeach;
                                        
                                        if (!isset($concluido)) {
                                            $concluido = 0.00;
                                        }
                                        
                                        // IDENTIFICA O ÚLTIMO VENCIMENTO NOS MOVIMENTOS
                                        $vencimento = null;
                                        
                                        if ($vencimento < $planning->Moviments['vencimento']) {
                                            $vencimento = $planning->Moviments['vencimento'];
                                        }
                                            
                                        ?>
                                        <tr>
                                            <th>
                                                <?= '<i class="fa fa-trophy"></i> ' . $planning->title; ?>
                                            </th>
                                            <td class="text-right"> 
                                                <?= $this->Number->precision($planning->valor * $planning->parcelas, 2); ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $this->Number->toPercentage($concluido); ?>
                                            </td>
                                            <td class="text-right"> 
                                                <?= $this->Number->precision($vlr_total, 2); $saldo_total += $vlr_total; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray">
                                        <th colspan="3">TOTAL POUPADO</th>
                                        <th class="text-right">
                                            <?= $this->Number->precision($saldo_total, 2) ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        } //if (isset($plannings_id))
        else {
            echo '<h4 class="text-center">Não há registros.</h4>';
        } ?>
        
    </div>
</div>