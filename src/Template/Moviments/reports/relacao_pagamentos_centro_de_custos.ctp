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

<!-- Reports/relacao_pagamentos -->
<?php $this->layout = 'layout-clean'; ?>

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold">
        <?= __('RELAÇÃO DE PAGAMENTOS ').' - '.$rp['data'].' '.$rp['descrp'].'<br />' ?>
    </h4>
    <span class="text-bold"><?= $Bank->title.' AGÊNCIA: '.$Bank->agencia.' CONTA: '.$Bank->conta ?></span>
    <table class="col-xs-12 table table-striped table-condensed prt-report">
        <thead>
            <tr class="bg-blue">
                <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                <th class="text-left text-nowrap col-xs-1"><?= __('Cedente') ?></th>
                <th class="text-left"><?= __('Histórico') ?></th>
                <th class="text-left text-nowrap col-xs-1"><?= __('Centro de Custos') ?></th>
                <th class="text-right text-nowrap col-xs-1"><?= __('Valor do Título') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $saldo = $saldob = $saldod = $desc = 0;
            foreach ($moviments as $moviment):  ?>
                <tr>
                    <td><?= ($moviment['ordem'] ? str_pad($moviment['ordem'], 6, '0', STR_PAD_LEFT) : '') ?></td>
                    <td class="text-left text-nowrap col-xs-1"><?= $moviment->Providers['title'] ?></td>
                    <td class="text-left"><?= $moviment->historico ?></td>
                    <td class="text-left text-nowrap col-xs-1"><?= $moviment->Costs['title'] ?></td>
                    <td class="text-right text-nowrap col-xs-1">
                        <?= $this->Number->currency($moviment->valor,'BRL');
                        $saldo += $moviment->valor; ?>
                    </td>
                </tr>
                <?php 
            endforeach; ?>         
        </tbody>
        <tfoot>
            <tr class="bg-blue">
                <td colspan="4"></td>
                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL') ?></th>
            </tr>
        </tfoot>
    </table>
    <span class="text-bold">
        <?php 
        if (!empty($rp['cheque'])) { ?>
            <?= 'NOMINAL: '.$rp['nominal'].'<br>' ?><?= 'CHEQUE: '.$rp['cheque'] ?>
            <?php 
        }//if (!empty($rp['cheque'])) ?>
    </span>
    <br /><br /><br /><br /><br /><br /><br />
    <div class="text-center center-block text-bold">
        <?= h('_________________________________________')?><br />
        <?= $parameter->razao; ?><br />
        <?= $parameter->cnpj; ?>
    </div>
</div>
<?= $this->element('report-footer'); ?>