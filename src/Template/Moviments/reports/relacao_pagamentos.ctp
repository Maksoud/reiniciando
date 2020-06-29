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
                <th class="text-left text-nowrap col-xs-1"><?= __('Documento') ?></th>
                <th class="text-left text-nowrap col-xs-1"><?= __('Cedente') ?></th>
                <th class="text-left text-nowrap col-xs-1"><?= __('Banco') ?></th>
                <th class="text-left text-nowrap col-xs-1"><?= __('Agência') ?></th>
                <th class="text-left text-nowrap col-xs-1"><?= __('Conta') ?></th>
                <th class="text-right text-nowrap col-xs-1"><?= __('Valor do Título') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $saldo = $saldob = $saldod = $desc = 0;
            foreach ($moviments as $moviment):  ?>
                <tr>
                    <td><?= $moviment->ordem ?></td>
                    <td><?= $moviment->documento ? $moviment->documento : '-'; ?></td>
                    <td class="text-left text-nowrap col-xs-1"><?= $moviment->Providers['title'] ?></td>
                    <td class="text-left text-nowrap col-xs-1"><?= $moviment->Providers['banco'] ?></td>
                    <td class="text-left text-nowrap col-xs-1"><?= $moviment->Providers['agencia'] ?></td>
                    <td class="text-left text-nowrap col-xs-1"><?= $moviment->Providers['conta'] ?></td>
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
                <td colspan="6"></td>
                <td class="text-right text-nowrap col-xs-1"><span class="text-bold"><?= $this->Number->currency($saldo, 'BRL') ?></span></td>
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