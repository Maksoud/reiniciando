<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentCards */
/* File: src/Template/MovimentCards/view_simple.ctp */
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
                    <?= h($movimentCard->title) ?>
                </div>
                <?php if ($movimentCard->obs != null) { ?>
                <div class="form-group">
                    <label><?= __('Observações') ?></label><br>
                    <?= h($movimentCard->obs) ?>
                </div>
                <?php }//if ($movimentCard->obs != null) ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right: 5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $movimentCard->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Emissão') ?></label><br>
                        <?= date("d/m/Y", strtotime($movimentCard->data)) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo') ?></label><br>
                        <?= $movimentCard->creditodebito == 'C' ? 'Receita (Pagamento/Estorno)' : 'Despesa (Compra)' ?>
                    </div>
                    <?php if (isset($movimentCard->costs_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Categoria') ?></label><br>
                        <?= h($movimentCard->Costs['title']) ?>
                    </div>
                    <?php }//if (isset($movimentCard->costs_id)) ?>
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= $this->Number->precision($movimentCard->valor, 2) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Vencimento') ?></label><br>
                        <?= date("d/m/Y", strtotime($movimentCard->vencimento)) ?>
                    </div>
                    <?php if (!empty($movimentCard->dtbaixa)) { ?>
                    <div class="form-group">
                        <label><?= __('Pagamento') ?></label><br>
                        <?= date("d/m/Y", strtotime($movimentCard->dtbaixa)) ?>
                    </div>
                    <?php }//if (!empty($movimentCard->dtbaixa)) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $movimentCard->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Dados do Cartão') ?>*</span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Cartão') ?></label><br>
                        <?= h($movimentCard->Cards['title']) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Bandeira') ?></label><br>
                        <?= h($movimentCard->Cards['bandeira']) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Dia do Vencimento') ?></label><br>
                        <?= h($movimentCard->Cards['vencimento']) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Melhor Dia de compra') ?></label><br>
                        <?= h($movimentCard->Cards['melhor_dia']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($movimentCard->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php if ($this->request->Session()->read('sessionPlan') != 4) { ?>
            <div class="form-group box bottom-5 bg-success">
                <label><?= __('Situação') ?></label><br>
                <?= $movimentCard->contabil == 'S' ? '<span class="label label-primary">Contábil</span>' : '<span class="label label-danger">Não Contábil</span>' ?>
            </div>
            <?php }//if ($this->request->Session()->read('sessionPlan') == 4) ?>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->MovimentCards->status($movimentCard->status) ?>
            </div>
            <?php if (isset($movimentCard->moviments_id)) { ?>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Contas a P/R') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentCard->Moviments['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php } ?>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($movimentCard->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($movimentCard->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($movimentCard->username) ?></span>
            </div>
        </div>
    </div>  
</div>