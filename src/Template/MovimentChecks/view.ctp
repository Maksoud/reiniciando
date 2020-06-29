<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentChecks */
/* File: src/Template/MovimentChecks/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9 col-xs-12">
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header">
                <span class="text-bold"><?= __('Detalhes do Lançamento') ?></span>
            </div>
            <div class="box-body panel-body">
        
                <?php if (isset($movimentCheck->providers_id)) { ?>
                <div class="form-group borderRowBottom">
                    <label><?= __('Forncedor') ?></label><br>
                    <?= h($movimentCheck->Providers['title']) ?>
                </div>
                <?php } ?>
                <?php if (isset($movimentCheck->customers_id)) { ?>
                <div class="form-group borderRowBottom">
                    <label><?= __('Cliente') ?></label><br>
                    <?= h($movimentCheck->Customers['title']) ?>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label><?= __('Historico') ?></label><br>
                    <?= h($movimentCheck->historico) ?>
                </div>
                <?php if ($movimentCheck->obs != null) { ?>
                <div class="form-group">
                    <label><?= __('Observações') ?></label><br>
                    <?= h($movimentCheck->obs) ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right:5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" style="background-color:#f2dede">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <?php 
                    if (isset($movimentCheck->boxes_id)) { ?>
                        <div class="form-group">
                            <label><?= __('Caixa') ?></label><br>
                            <?= h($movimentCheck->Boxes['title']) ?>
                        </div>
                        <?php 
                    }//if (isset($movimentCheck->boxes_id)) ?>
                    <div class="form-group">
                        <label><?= __('Tipo de Evento') ?></label><br>
                        <?= h($movimentCheck->EventTypes['title']) ?>
                    </div>
                    <?php 
                    if (isset($movimentCheck->account_plans_id)) { ?>
                        <div class="form-group">
                            <label><?= __('Plano de Contas') ?></label><br>
                            <?= h($movimentCheck->AccountPlans['classification'].' - '.$movimentCheck->AccountPlans['title']) ?>
                        </div>
                        <?php 
                    }//if (isset($movimentCheck->account_plans_id)) 
                    if (isset($movimentCheck->costs_id)) { ?>
                        <div class="form-group">
                            <label><?= __('Centro de Custos') ?></label><br>
                            <?= h($movimentCheck->Costs['title']) ?>
                        </div>
                        <?php 
                    }//if (isset($movimentCheck->costs_id)) ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-xs-12 no-padding-lat">
            <div class="col-md-offset-1 col-md-5 bg-success box">
                <div class="bloco-cabecalho box-header">
                    <?= __('Dados do Cheque') ?>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Nº do Cheque') ?></label><br>
                        <?= h($movimentCheck->cheque) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Banco') ?></label><br>
                        <?= h($movimentCheck->Banks['title']) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Emissão') ?></label><br>
                        <?= $this->MyHtml->date($movimentCheck->data) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Nominal à') ?></label><br>
                        <?= h($movimentCheck->nominal) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= $this->Number->precision($movimentCheck->valor, 2) ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($movimentCheck->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php 
            if (!empty($movimentCheck->documento)) { ?>
                <div class="form-group box bottom-5 bg-info">
                    <label><?= __('Documento') ?></label><br>
                    <span class="label label-primary documento"><?= h($movimentCheck->documento) ?></span>
                </div>
                <?php 
            }//if (!empty($movimentCheck->documento)) ?>
        </div>
        <div class="form-group box bottom-5 bg-success">
            <label><?= __('Situação') ?></label><br>
            <?= $movimentCheck->contabil == 'S' ? '<span class="label label-primary">Contábil</span>' : '<span class="label label-danger">Não Contábil</span>' ?>
        </div>
        <div class="form-group box bottom-5 bg-primary">
            <label><?= __('Status') ?></label><br>
            <?= $this->MovimentChecks->status($movimentCheck->status) ?>
        </div>
        <?php 
        if (isset($movimentCheck->moviments_id)) { ?>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Contas a P/R') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentCheck->Moviments['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php 
        }//if (isset($movimentCheck->moviments_id)) 
        if (isset($movimentCheck->transfers_id)) { ?>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Transferência') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentCheck->Transfers['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php 
        }//if (isset($movimentCheck->transfers_id)) ?>
        <div class="form-group box bottom-5 bg-warning">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($movimentCheck->created) ?></span>
        </div>
        <div class="form-group box bottom-5 bg-warning">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($movimentCheck->modified) ?></span>
        </div>
        <div class="form-group box bottom-5 bg-warning">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($movimentCheck->username) ?></span>
        </div>
    </div>
    
</div>