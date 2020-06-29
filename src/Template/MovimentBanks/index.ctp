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
/* File: src/Template/MovimentBanks/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'MovimentBanks', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Novo Movimento de Banco', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Movimentos de Banco') ?></h3> 
    </div>

    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed box-shadow btn bottom-10" style="color:#fff;background-color:#337ab7;border-color:#2e6da4;" data-toggle="collapse" data-target="#search-collapse">
            <i class="fa fa-search"></i> <?= __('Filtros de Busca') ?>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="search-collapse">
        <div class="row form-busca bottom-10">
            <div class="col-xs-12 box box-body">
                <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
                    <?= $this->Form->control('ordem_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Ordem'), 'value' => @$this->request->query['ordem_search']]); ?>
                    <?= $this->Form->control('historico_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Documento ou histórico'), 'value' => @$this->request->query['historico_search']]); ?>
                    <?= $this->Form->control('custprov_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Cliente ou Fornecedor'), 'value' => @$this->request->query['custprov_search']]); ?>
                    <?= $this->Form->control('valor_search', ['type' => 'text', 'id' => 'buscaValor', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5 valuemask', 'label' => false, 'placeholder' => __('Valor em Reais'), 'value' => @$this->request->query['valor_search']]); ?>
                    <?= $this->MyForm->select_meses('mes_search', ['class' => 'form-control top-5', 'label' => false, 'empty' => __('- mês -'), 'value' => @$this->request->query['mes_search']]); ?>
                    <?= $this->MyForm->select_dez_anos('ano_search', ['class' => 'form-control top-5', 'label' => false, 'empty' => __('- ano -'), 'value' => @$this->request->query['ano_search']]); ?>
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- status -'), 'options' => ['A' => __('Aberto'),
                                                                                                                                                                                                                                     'B' => __('Finalizado'),
                                                                                                                                                                                                                                     'C' => __('Cancelado')
                                                                                                                                                                                                                                    ], 
                                                      'value' => @$this->request->query['status_search']]); ?> 
                    <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list top-5', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
                <?= $this->Form->end(); ?>        
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                    <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                    <th class="text-left col-xs-1"><?= __('Vínculo') ?></th>
                    <th class="text-left col-xs-1"><?= __('Pagamento') ?></th>
                    <th class="text-left"><?= __('Banco') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Cliente/Fornecedor') ?></th>
                    <th class="text-left"><?= __('Histórico') ?></th>
                    <th class="text-center text-nowrap col-xs-1"><?= __('Valor Pago') ?></th>
                    <th class="col-xs-1"></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimentBanks as $movimentBank): ?>
                    <tr class="initialism">
                        <td class="text-left"><?= str_pad($movimentBank->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?php if (!empty($movimentBank->documento)) {echo $movimentBank->documento;}else{echo '-';} ?></td>
                        <td class="text-center">
                            <?= $movimentBank->has('moviments_id') ? $this->Html->link('CPR'.str_pad($movimentBank->Moviments['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'Moviments', 'action' => 'view', $movimentBank->Moviments['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Contas a Pagar/Receber']) : ''; ?>
                            <?= $movimentBank->has('transfers_id') ? $this->Html->link('TRN'.str_pad($movimentBank->Transfers['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'Transfers', 'action' => 'view', $movimentBank->Transfers['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Transferência']) : ''; ?>
                            <?= $movimentBank->has('moviment_checks_id') ? $this->Html->link('MCH'.str_pad($movimentBank->MovimentChecks['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'MovimentChecks', 'action' => 'view', $movimentBank->MovimentChecks['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Movimento de Cheque']) : ''; ?>
                            <?php if (empty($movimentBank->moviments_id) && empty($movimentBank->transfers_id) && empty($movimentBank->moviment_checks_id)) {echo '-';} ?>
                        </td>
                        <td class="text-left"><?= date("d/m/Y", strtotime($movimentBank->dtbaixa)) ?></td>
                        <td class="text-nowrap"><?= $movimentBank->Banks['title'] ?></td>
                        <td class="text-left">
                            <?= h($movimentBank->Customers['title']) ?>
                            <?= h($movimentBank->Providers['title']) ?>
                            <?php if (!$movimentBank->Customers['title'] && !$movimentBank->Providers['title']) echo '-'; ?>
                        </td>
                        <td class="text-left"><?= $movimentBank->historico ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->precision($movimentBank->valorbaixa, 2) ?></td>
                        <td class="text-center">
                            <?php if ($movimentBank->creditodebito == 'C') { ?>
                                <span class="fa fa-plus-circle" style="color: #2aabd2" title="<?= __('Crédito') ?>"></span>
                            <?php } elseif ($movimentBank->creditodebito == 'D') { ?>
                                <span class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito') ?>"></span>
                            <?php }//elseif ($movimentBank->creditodebito == 'D') ?>
                        </td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $movimentBank->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit', $movimentBank->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $movimentBank->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
        
    <div class="panel-heading" style="font-size: 11px;">
        <span class="text-bold"><?= __('Legenda:') ?></span><br />
		<span style="color: #2aabd2"><?= __('Tipos de Vínculos: CPR: Contas a Pargar/Receber; MCH: Movimentos de Cheques; TRN: Transferências') ?></span>
    </div>
    
    <div class="col-xs-12 bottom-50">
        <div class="box">
            <?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
        </div>
    </div>
    
</div>