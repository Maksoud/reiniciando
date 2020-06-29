<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Transfers */
/* File: src/Template/Transfers/view_simple.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9 col-xs-12">
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header">
                <span class="text-bold"><?= __('Detalhes do Lançamento') ?></span>
            </div>
            <div class="box-body panel-body">
                <div class="form-group">
                    <label><?= __('Descrição') ?></label><br>
                    <?= h($transfer->historico) ?>
                </div>
                <?php if ($transfer->obs != null) { ?>
                <div class="form-group">
                    <label><?= __('Observações') ?></label><br>
                    <?= h($transfer->obs) ?>
                </div>
                <?php }//if ($transfer->obs != null) ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right: 5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" style="background-color:#d9edf7">
                    <span class="text-bold"><?= __('Informações Financeiras') ?>*</span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Lançamento') ?></label><br>
                        <?= $this->MyHtml->date($transfer->data) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= $this->Number->precision($transfer->valor, 2) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($transfer->programacao)) { ?>
            <div class="col-md-6 col-xs-12 no-padding-lat">
                <div class="box panel panel-default box-shadow" style="padding:0;">
                    <div class="panel-heading box-header">
                        <span class="text-bold"><?= __('Agendamento de Transferência') ?></span>
                    </div>
                    <div class="box-body panel-body">
                        <div class="form-group">
                            <label><?= __('Data de Agendamento') ?></label><br>
                            <?= $this->MyHtml->date($transfer->programacao) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }//if (!empty($transfer->programacao)) ?>
        
        <div class="col-xs-12 no-padding-lat">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" style="background-color:#fcf8e3;">
                    <span class="text-bold"><?= __('Detalhamento da Transferência') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="col-md-5">
                        <div class="bloco-cabecalho"><?= __('DADOS DE ORIGEM') ?></div>
                        <?php if ($transfer->Banks['title']) { ?>
                        <div class="form-group">
                            <label><?= __('Banco') ?></label><br>
                            <?= h($transfer->Banks['title']) ?>
                        </div>
                        <?php }//if ($transfer->Banks['title']) ?>
                        <?php if ($transfer->boxes_id) { ?>
                        <div class="form-group">
                            <label><?= __('Carteira') ?></label><br>
                            <?= h($transfer->Boxes['title']) ?>
                        </div>
                        <?php }//if ($transfer->boxes_id) ?>
                        <?php if ($transfer->costs_id) { ?>
                        <div class="form-group">
                            <label><?= __('Categoria') ?></label><br>
                            <?= h($transfer->Costs['title']) ?>
                        </div>
                        <?php }//if ($transfer->costs_id) ?>
                    </div>
                    <div class="col-md-2 hidden-xs" style="position: fixed; left: 305px; height: 150px; font-size: 95px; opacity: 0.4;">
                        <i class="fa fa-angle-double-right"></i>
                    </div>
                    <div class="col-md-offset-2 col-md-5">
                        <div class="bloco-cabecalho"><?= __('DADOS DE DESTINO') ?></div>
                        <?php if ($transfer->banks_dest) { ?>
                        <div class="form-group">
                            <label><?= __('Banco') ?></label><br>
                            <?= h($transfer->BanksDest['title']) ?>
                        </div>
                        <?php }//if ($transfer->banks_dest) { ?>
                        <?php if ($transfer->boxes_dest) { ?>
                        <div class="form-group">
                            <label><?= __('Carteira') ?></label><br>
                            <?= h($transfer->BoxesDest['title']) ?>
                        </div>
                        <?php }//if ($transfer->boxes_dest) ?>
                        <?php if ($transfer->costs_dest) { ?>
                        <div class="form-group">
                            <label><?= __('Categoria') ?></label><br>
                            <?= h($transfer->CostsDest['title']) ?>
                        </div>
                        <?php }//if ($transfer->costs_dest) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($transfer->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-success">
                <label><?= __('Situação') ?></label><br>
                <?= $transfer->contabil == 'S' ? '<span class="label label-primary">'.__('Contábil').'</span>' : '<span class="label label-danger">'.__('Não Contábil').'</span>' ?>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Transfers->status($transfer->status) ?>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($transfer->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($transfer->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($transfer->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php

    ////////////////////////////////////////////////////////////////////
    
    //LANÇAMENTOS NOS MOVIMENTOS DE BANCO/CAIXA DE ORIGEM/DESTINO
    ?>
    <div class="col-xs-12 box-shadow bg-success panel-group">
        <div class="sub-header"><h5><label><?= __('MOVIMENTOS DE BANCOS/CARTEIRAS') ?></label></h5></div>
        <div class="table-responsive">
            <table class="table no-margin table-striped">
                <thead>
                    <tr>
                        <th class="text-left"><?= __('Movimento') ?></th>
                        <th class="text-left"><?= __('Ordem') ?></th>
                        <th class="text-left"><?= __('Data') ?></th>
                        <th class="text-left"><?= __('Vencimento') ?></th>
                        <th class="text-left"><?= __('Descrição') ?></th>
                        <th class="text-right"><?= __('Valor') ?></th>
                    </tr>
                </thead>
                <?php if (!empty($transfer->banks_id)) {?>
                <tbody>
                    <td class="text-left">
                        <?= __('Mov. Banco de Origem') ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Html->link(str_pad($transfer->MovimentBanks['ordem'], 6, '0', STR_PAD_LEFT), ['controller' => 'MovimentBanks', 'action' => 'view_simple', $transfer->MovimentBanks['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Lançamento', 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBanks['data']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBanks['vencimento']); ?>
                    </td>
                    <td class="text-left">
                        <?= $transfer->MovimentBanks['historico']; ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Number->precision($transfer->MovimentBanks['valorbaixa'], 2); ?>
                    </td>
                </tbody>
                <?php } ?>
                <?php if (!empty($transfer->boxes_id)) { ?>
                <tbody>
                    <td class="text-left">
                        <?=  __('Mov. Carteira de Origem') ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Html->link(str_pad($transfer->MovimentBoxes['ordem'], 6, '0', STR_PAD_LEFT), ['controller' => 'MovimentBoxes', 'action' => 'view_simple', $transfer->MovimentBoxes['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Lançamento', 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBoxes['data']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBoxes['vencimento']); ?>
                    </td>
                    <td class="text-left">
                        <?= $transfer->MovimentBoxes['historico']; ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Number->precision($transfer->MovimentBoxes['valorbaixa'], 2); ?>
                    </td>
                </tbody>
                <?php } ?>
                <?php if (!empty($transfer->banks_dest)) { ?>
                <tbody>
                    <td class="text-left">
                        <?= __('Mov. Banco de Destino') ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Html->link(str_pad($transfer->MovimentBanksDest['ordem'], 6, '0', STR_PAD_LEFT), ['controller' => 'MovimentBanks', 'action' => 'view_simple', $transfer->MovimentBanksDest['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Lançamento', 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBanksDest['data']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBanksDest['vencimento']); ?>
                    </td>
                    <td class="text-left">
                        <?= $transfer->MovimentBanksDest['historico']; ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Number->precision($transfer->MovimentBanksDest['valorbaixa'], 2); ?>
                    </td>
                </tbody>
                <?php } ?>
                <?php if (!empty($transfer->boxes_dest)) { ?>
                <tbody>
                    <td class="text-left">
                        <?= __('Mov. Carteira de Destino') ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Html->link(str_pad($transfer->MovimentBoxesDest['ordem'], 6, '0', STR_PAD_LEFT), ['controller' => 'MovimentBoxes', 'action' => 'view_simple', $transfer->MovimentBoxesDest['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Lançamento', 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBoxesDest['data']); ?>
                    </td>
                    <td class="text-left">
                        <?= $this->MyHtml->tinyDate($transfer->MovimentBoxesDest['vencimento']); ?>
                    </td>
                    <td class="text-left">
                        <?= $transfer->MovimentBoxesDest['historico']; ?>
                    </td>
                    <td class="text-left">
                        <?= $this->Number->precision($transfer->MovimentBoxesDest['valorbaixa'], 2); ?>
                    </td>
                </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
    <?php 
    //LANÇAMENTOS VINCULADOS (AGRUPAMENTOS)
    ?>
    
</div>