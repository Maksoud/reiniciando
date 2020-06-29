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
/* File: src/Template/MovimentBanks/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9">
        <div class="panel panel-default box-shadow">
            <div class="panel-heading">
                <span class="text-bold"><?= __('Detalhes do Lançamento') ?></span>
            </div>
            <div class="panel-body">
                <?php if (isset($movimentBank->providers_id)) { ?>
                <div class="form-group borderRowBottom">
                    <label><?= __('Fornecedor') ?></label><br>
                    <?= h($movimentBank->Providers['title']) ?>
                </div>
                <?php } ?>
                <?php if (isset($movimentBank->customers_id)) { ?>
                <div class="form-group borderRowBottom">
                    <label><?= __('Cliente') ?></label><br>
                    <?= h($movimentBank->Customers['title']) ?>
                </div>
                <?php } ?>
                <div class="form-group">
                    <label><?= __('Histórico') ?></label><br>
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
        <div class="col-xs-6 no-padding-lat" style="padding-right: 5px!important;">
            <div class="panel panel-default box-shadow">
                <?php $movimentBank->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Informações Financeiras') ?></span>
                </div>
                <div class="panel-body">
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
                    <div class="form-group">
                        <label><?= __('Valor') ?></label><br>
                        <?= $this->Number->precision($movimentBank->valor, 2) ?>
                    </div>
                    <?php if (isset($movimentBank->document_types_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Tipo de Documento') ?></label><br>
                        <?= h($movimentBank->DocumentTypes['title']) ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($movimentBank->account_plans_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Plano de Contas') ?></label><br>
                        <?= h($movimentBank->AccountPlans['classification'].' - '.$movimentBank->AccountPlans['title']) ?>
                    </div>
                    <?php } ?>
                    <?php if (isset($movimentBank->costs_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Centro de Custos') ?></label><br>
                        <?= h($movimentBank->Costs['title']) ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        
        <div class="col-xs-6 no-padding-lat">
            <div class="panel panel-default box-shadow">
                <?php $movimentBank->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Dados do Pagamento') ?>*</span>
                </div>
                <div class="panel-body">
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
                    <?php if (isset($movimentBank->boxes_id)) { ?>
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
                    <?php if (isset($movimentBank->event_types_id)) { ?>
                    <div class="form-group">
                        <label><?= __('Tipo de Evento') ?></label><br>
                        <?= h($movimentBank->EventTypes['title']) ?>
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
        
        <?php if (isset($movimentBank->moviment_checks_id)) { ?>
            <div class="col-xs-6 no-padding-lat">
                <div class="col-md-offset-1 col-md-5 bg-success box">
                    <div class="bloco-cabecalho"><?= __('DADOS DO CHEQUE') ?></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label><?= __('Nº Cheque: ') ?></label>
                            <?= h($movimentBank->MovimentChecks['cheque']) ?>
                        </div>
                        <div class="form-group">
                            <label><?= __('Nominal: ') ?></label>
                            <?= h($movimentBank->MovimentChecks['nominal']) ?>
                        </div>
                        <div class="form-group">
                            <label><?= __('Emissão: ') ?></label>
                            <?= $this->MyHtml->date($movimentBank->MovimentChecks['data']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php }//if (isset($movimentBank->moviment_checks_id)) ?>
    </div>
    
    <div class="col-md-3 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
				<label><?= __('Ordem') ?></label><br>
				<span class="label label-primary"><?= str_pad($movimentBank->ordem, 6, '0', STR_PAD_LEFT) ?></span>
			</div>
			<?php if (!empty($movimentBank->documento)) { ?>
			<div class="form-group box bottom-5 bg-info">
				<label><?= __('Documento') ?></label><br>
				<span class="label label-primary documento"><?= h($movimentBank->documento) ?></span>
			</div>
			<?php } ?>
			<div class="form-group box bottom-5 bg-success">
				<label><?= __('Situação') ?></label><br>
				<?= $movimentBank->contabil == 'S' ? '<span class="label label-primary">Contábil</span>' : '<span class="label label-danger">Não Contábil</span>' ?>
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
			<?php if (isset($movimentBank->moviment_checks_id)) { ?>
			<div class="form-group box bottom-5 bg-info">
				<label><?= __('Mov. de Cheque') ?></label><br>
				<span class="label label-danger"><?= str_pad($movimentBank->MovimentChecks['ordem'], 6, '0', STR_PAD_LEFT) ?></span>
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