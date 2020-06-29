<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* MovimentBoxes */
/* File: src/Template/MovimentBoxes/view_simple.ctp */
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
                    <label><?= __('Histórico') ?></label><br>
                    <?= h($movimentBox->historico) ?>
                </div>
                <?php if ($movimentBox->obs != null) { ?>
                <div class="form-group">
                    <label><?= __('Observações') ?></label><br>
                    <?= h($movimentBox->obs) ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right: 5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $movimentBox->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Emissão') ?></label><br>
                        <?= $this->MyHtml->date($movimentBox->data) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Vencimento') ?></label><br>
                        <?= $this->MyHtml->date($movimentBox->vencimento) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo') ?></label><br>
                        <?= $movimentBox->creditodebito == 'C' ? __('Receita') : __('Despesa') ?>
                    </div>
                    <?php if (isset($movimentBox->costs_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Categoria') ?></label><br>
                        <?= h($movimentBox->Costs['title']) ?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= $this->Number->precision($movimentBox->valor, 2) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-xs-12 no-padding-lat">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $movimentBox->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Dados do Pagamento') ?>*</span>
                </div>
                <div class="box-body panel-body">
                    <?php if ($movimentBox->valor > $movimentBox->valorbaixa) { ?>
                    <div class="form-group">
                        <label><?= __('Desconto Aplicado') ?></label><br>
                        <?php $desconto = $movimentBox->valorbaixa - $movimentBox->valor; ?>
                        <?php $percentual = $desconto / $movimentBox->valor * 100; ?>
                        <?php echo $this->Number->precision($desconto, 2).' / '.$this->Number->toPercentage($percentual,2);?>
                    </div>
                    <?php } elseif ($movimentBox->valor < $movimentBox->valorbaixa) { ?>
                    <div class="form-group">
                        <label><?= __('Acréscimo Aplicado') ?></label><br>
                        <?php $acrescimo = $movimentBox->valorbaixa - $movimentBox->valor; ?>
                        <?php $percentual = $acrescimo / $movimentBox->valor * 100; ?>
                        <?php echo $this->Number->precision($acrescimo, 2).' / '.$this->Number->toPercentage($percentual,2);?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label><?= __('Data') ?></label><br>
                        <?= $this->MyHtml->date($movimentBox->dtbaixa) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Carteira') ?></label><br>
                        <?= h($movimentBox->Boxes['title']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($movimentBox->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-success">
                <label><?= __('Situação') ?></label><br>
                <?= $movimentBox->contabil == 'S' ? '<span class="label label-primary">'.__('Contábil').'</span>' : '<span class="label label-danger">'.__('Não Contábil').'</span>' ?>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->MovimentBoxes->status($movimentBox->status) ?>
            </div>
            <?php if (isset($movimentBox->moviments_id)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Contas a P/R') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentBox->Moviments['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php }//if (isset($movimentBox->moviments_id)) ?>
            <?php if (isset($movimentBox->transfers_id)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Transferência') ?></label><br>
                <span class="label label-danger"><?= str_pad($movimentBox->Transfers['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <?php }//if (isset($movimentBox->transfers_id)) ?>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($movimentBox->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($movimentBox->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($movimentBox->username) ?></span>
            </div>
        </div>
    </div>
</div>