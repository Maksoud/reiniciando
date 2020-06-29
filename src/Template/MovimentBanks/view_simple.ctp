<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentBanks */
/* File: src/Template/MovimentBanks/view_simple.ctp */
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
                    <?= h($movimentBank->historico) ?>
                </div>
                <?php if ($movimentBank->obs != null) { ?>
                <div class="form-group">
                    <label><?= __('Observações') ?></label><br>
                    <?= h($movimentBank->obs) ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right: 5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $movimentBank->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Emissão') ?></label><br>
                        <?= $this->MyHtml->date($movimentBank->data) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Vencimento') ?></label><br>
                        <?= $this->MyHtml->date($movimentBank->vencimento) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo') ?></label><br>
                        <?= $movimentBank->creditodebito == 'C' ? 'Receita' : 'Despesa' ?>
                    </div>
                    <?php if (isset($movimentBank->costs_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Categoria') ?></label><br>
                        <?= h($movimentBank->Costs['title']) ?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= $this->Number->precision($movimentBank->valor, 2) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $movimentBank->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Dados do Pagamento') ?>*</span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= h($movimentBank->coins['simbolo']) ?>
                        <?= $this->Number->precision($movimentBank->valorbaixa, 2) ?>
                    </div>
                    <?php if ($movimentBank->valor > $movimentBank->valorbaixa) { ?>
                    <div class="form-group">
                        <label><?= __('Desconto Aplicado') ?></label><br>
                        <?php $desconto = $movimentBank->valorbaixa - $movimentBank->valor; ?>
                        <?php $percentual = $desconto / $movimentBank->valor * 100; ?>
                        <?php echo $this->Number->precision($desconto, 2).' / '.$this->Number->toPercentage($percentual,2);?>
                    </div>
                    <?php } elseif ($movimentBank->valor < $movimentBank->valorbaixa) { ?>
                    <div class="form-group">
                        <label><?= __('Acréscimo Aplicado') ?></label><br>
                        <?php $acrescimo = $movimentBank->valorbaixa - $movimentBank->valor; ?>
                        <?php $percentual = $acrescimo / $movimentBank->valor * 100; ?>
                        <?php echo $this->Number->precision($acrescimo, 2).' / '.$this->Number->toPercentage($percentual,2);?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label><?= __('Data') ?></label><br>
                        <?= h(date("d/m/Y", strtotime($movimentBank->dtbaixa))) ?>
                    </div> 
                    <?php if (isset($movimentBank->boxes_id)){ ?>
                    <div class="form-group">
                        <label><?= __('Caixa') ?></label><br>
                        <?= h($movimentBank->Boxes['title']) ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($movimentBank->banks_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Banco') ?></label><br>
                        <?= h($movimentBank->Banks['title']) ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($movimentBank->userbaixa)) { ?>
                    <div class="form-group">
                        <label><?= __('Usuário') ?></label><br>
                        <?= h($movimentBank->userbaixa) ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($movimentBank->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-success">
                <label><?= __('Situação') ?></label><br>
                <?= $movimentBank->contabil == 'S' ? '<span class="label label-primary">'.__('Contábil').'</span>' : '<span class="label label-danger">'.__('Não Contábil').'</span>' ?>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->MovimentBanks->status($movimentBank->status) ?>
            </div>
            <?php if (isset($movimentBank->moviments_id)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Contas a P/R') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentBank->Moviments['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php } ?>
            <?php if (isset($movimentBank->transfers_id)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Transferência') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentBank->Transfers['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php } ?>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($movimentBank->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($movimentBank->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($movimentBank->username) ?></span>
            </div>
        </div>
    </div>
</div>