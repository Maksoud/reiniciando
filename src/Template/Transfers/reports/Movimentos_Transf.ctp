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
    
    <h4 class="page-header">
        <span class="text-bold"><?= __('MOVIMENTOS DE TRANSFERÊNCIAS') ?></span>
    </h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-transfers'); ?>
        <?php
        if (empty($transfers->toArray())) {
            echo '<h3 class="text-center">'.__('Não há registros para o filtro selecionado.').'</h3>';
        } else {
    ?>
    </div>
        <?php $saldo = 0; ?> 
            <table class="table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left" style="width: 40px"><?= __('Ordem') ?></th>
                        <th class="text-left" style="width: 90px"><?= __('Data') ?></th>
                        <th class="text-left" style="width: 90px"><?= __('Documento') ?></th>
                        <th class="text-left" style="width: 90px"><?= __('Centros de Custos') ?></th>
                        <th class="text-left" style="width: 90px"><?= __('Planos de Contas') ?></th>
                        <th><?= __('Histórico') ?></th>
                        <th class="text-center" style="width: 80px"><?= __('Ordem Origem') ?></th>
                        <th class="text-center" style="width: 150px"><?= __('Banco/Carteira Origem') ?></th>
                        <th class="text-center" style="width: 80px"><?= __('Ordem Destino') ?></th>
                        <th class="text-center" style="width: 150px"><?= __('Banco/Carteira Destino') ?></th>
                        <th class="text-right" style="width: 135px"><?= __('Valor') ?></th>
                        <th class="text-right" style="width: 135px"><?= __('Saldo') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transfers as $transfer): ?>
                        <tr>
                            <td><?= str_pad($transfer->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                            <td><?= date("d/m/Y", strtotime($transfer->data)) ?></td>
                            <td class="text-nowrap"><?= $transfer['documento'] ? $transfer['documento'] : '-'; ?></td>
                            <td class="text-nowrap">
                                <?= $transfer->costs_id ? $transfer->Costs['title'] : ''; ?>
                                <?php if ($transfer->costs_id && $transfer->costs_dest) echo " / ";?>
                                <?= $transfer->costs_dest ? $transfer->CostsDest['title'] : ''; ?>
                            </td>
                            <td class="text-nowrap">
                                <?= $transfer->account_plans_id ? $transfer->AccountPlans['title'] : ''; ?>
                                <?php if ($transfer->costs_id && $transfer->costs_dest) echo " / ";?>
                                <?= $transfer->account_plans_dest ? $transfer->AccountPlansDest['title'] : ''; ?>
                            </td>
                            <td class="text-nowrap"><?= ($transfer->historico) ?></td>
                            <td class="text-nowrap">
                                <?= $transfer->MovimentBanks['ordem'] ? str_pad($transfer->MovimentBanks['ordem'], 6, '0', STR_PAD_LEFT) : '' ?>
                                <?= $transfer->MovimentBoxes['ordem'] ? str_pad($transfer->MovimentBoxes['ordem'], 6, '0', STR_PAD_LEFT) : '' ?>
                            </td>
                            <td class="text-nowrap"><?= ($transfer->Banks['title']) ?><?= ($transfer->Boxes['title']) ?></td>
                            <td class="text-nowrap">
                                <?= $transfer->MovimentBanksDest['ordem'] ? str_pad($transfer->MovimentBanksDest['ordem'], 6, '0', STR_PAD_LEFT) : '' ?>
                                <?= $transfer->MovimentBoxesDest['ordem'] ? str_pad($transfer->MovimentBoxesDest['ordem'], 6, '0', STR_PAD_LEFT) : '' ?>
                            </td>
                            <td class="text-nowrap"><?= ($transfer->BanksDest['title']) ?><?= ($transfer->BoxesDest['title']) ?></td>
                            <td class="text-nowrap text-right text-primary"><?= $this->Number->currency($transfer->valor,'BRL'); ?></td>
                            <td class="text-nowrap text-right"><?= $this->Number->currency($saldo += $transfer->valor,'BRL') ?></td>
                        </tr>    
                    <?php endforeach; ?>             
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <td colspan="8"></td>
                        <th class="text-nowrap text-right"><?= __('SALDOS GERAIS') ?></th>
                        <th class="text-nowrap text-right"><?= $this->Number->currency($saldo, 'BRL') ?></th>                                
                    </tr>
                </tfoot>
            </table>
        <?php 
        }?>
</div>