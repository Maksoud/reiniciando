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
/* File: src/Template/Pages/saldos_cartoes.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
        <?php 
            
        foreach ($saldos as $balance): 
            if (isset($balance->cards_id)) {
                $cards = true;
            }
        endforeach;

        if (!empty($cards)) { ?>
            <div class="row">
                <div class="box panel panel-default box-shadow" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold"><i class="fa fa-credit-card-alt"></i> <?= __('Limite de Cartões') ?>*</span>
                        <h5><small>(*) <?= __('Saldos atualizados em') ?> <?= date("d/m/Y"); ?></small></h5>
                    </div>
                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left"><?= __('Descrição') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Dia Vencimento') ?></th>
                                        <th class="text-center text-nowrap col-xs-1"><?= __('Melhor Dia') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Limite') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Utilizado') ?> (%)</th>
                                        <th class="text-center col-xs-1"><?= __('Utilizado') ?> (<?= __('R$') ?>)</th>
                                        <th class="text-right col-xs-1"><?= __('Disponível') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $saldo_total = $saldo_disponivel = $saldo_utilizado = 0.00;

                                    foreach ($saldos as $balance):  

                                        if (isset($balance->cards_id)) { ?>
                                            <tr>
                                                <th>
                                                <?php 
                                                    if ($balance->id < 10 && isset($balance->id)) { 
                                                        $balance->id = '0'.$balance->id;
                                                    }
                                                    elseif (!empty($balance->cards_id)) { 
                                                        echo '<i class="fa fa-credit-card-alt"></i> ' . $balance->Cards['title'];
                                                    }
                                                    $uso = $balance->Cards['limite'] - $balance->value;
                                                    $saldo_utilizado += $uso;
                                                ?>
                                                </th>
                                                <td class="text-center">
                                                    <?= $balance->Cards['vencimento']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $balance->Cards['melhor_dia']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $this->Number->precision($balance->Cards['limite'], 2); ?>
                                                </td>
                                                <td class="text-center">
                                                    <!-- LIMITE DO CARTÃO UTILIZADO -->
                                                    <div class="progress bottom-0 top-0">
                                                        <?php
                                                        $usedPercent = $this->Number->format(($uso / $balance->Cards['limite']) * 100, ['places' => 2, 'locale' => 'en_US', 'pattern' => '####.00']);
                                                        $percentualUsado = $this->Number->toPercentage(($uso / $balance->Cards['limite']) * 100); 
                                                        if ($usedPercent < 50) {
                                                            $progress = "progress-bar-info";
                                                        } elseif ($usedPercent >= 50 && $usedPercent < 85) {
                                                            $progress = "progress-bar-warning";
                                                        } else {
                                                            $progress = "progress-bar-danger";
                                                        }
                                                        
                                                        ?>
                                                        <div class="progress-bar <?= $progress ?>" role="progressbar" aria-valuenow="<?= $usedPercent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $usedPercent ?>%">
                                                            <?= $percentualUsado ?>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <!-- LIMITE DO CARTÃO UTILIZADO -->
                                                    <?= $this->Number->precision($uso, 2); ?>
                                                </td>
                                                <td class="text-right">
                                                    <?= $this->Number->precision($balance->value, 2); ?>
                                                    <?php $saldo_disponivel += $balance->value; ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray">
                                        <th colspan="6"><?= __('CRÉDITO DISPONÍVEL') ?></th>
                                        <th class="text-right">
                                            <?= $this->Number->precision($saldo_disponivel, 2) ?>
                                        </th>
                                    </tr>
                                    <tr class="bg-gray">
                                        <th colspan="6"><?= __('CRÉDITO UTILIZADO') ?></th>
                                        <th class="text-right">
                                            <?= $this->Number->precision($saldo_utilizado, 2) ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        } //if (!empty($cards)) { 
        else {
            echo '<h4 class="text-center">Não há registros.</h4>';
        } ?>
        
    </div>
</div>