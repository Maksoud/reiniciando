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
/* File: src/Template/Transfers/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Transfers', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Nova Transferência', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Transferências') ?></h3>
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
                    <?= $this->Form->control('valor_search', ['type' => 'text', 'id' => 'buscaValor', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5 valuemask', 'label' => false, 'placeholder' => __('Valor em Reais'), 'value' => @$this->request->query['valor_search']]); ?>
                    <?= $this->MyForm->select_meses('mes_search', ['class' => 'form-control top-5', 'label' => false, 'empty' => __('- mês -'), 'value' => @$this->request->query['mes_search']]); ?>
                    <?= $this->MyForm->select_dez_anos('ano_search', ['class' => 'form-control top-5', 'label' => false, 'empty' => __('- ano -'), 'value' => @$this->request->query['ano_search']]); ?>
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- status -'), 'options' => ['P' => __('Pendente'),
                                                                                                                                                                                                                                     'E' => __('Processando'),
                                                                                                                                                                                                                                     'F' => __('Finalizado'),
                                                                                                                                                                                                                                     'C' => __('Cancelado')
                                                                                                                                                                                                                                    ],
                                                        'value' => @$this->request->query['status_search']]); ?> 
                    <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                    <input type="hidden" name="iniciar_busca" value="true">
                    <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
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
                    <th class="text-left col-xs-1"><?= __('Lançamento') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Ordem Ori.') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Origem') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Ordem Des.') ?></th>
                    <th class="text-left col-xs-1"><?= __('Destino') ?></th>
                    <th class="text-left"><?= __('Histórico') ?></th>
                    <th class="col-xs-1"></th>
                    <th class="text-center col-xs-1"><?= __('Valor') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transfers as $transfer): ?>
                    <tr class="initialism">
                        <td class="text-left"><?= str_pad($transfer->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?php if (!empty($transfer->documento)) { echo $transfer->documento; } else { echo '-'; } ?></td>
                        <td class="text-left"><?= date("d/m/Y", strtotime($transfer->data)) ?></td>
                        <td class="text-left">
                            <?= $transfer->has('banks_id') ? $this->Html->link('MB'.str_pad($transfer->MovimentBanks['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'MovimentBanks', 'action' => 'view', $transfer->MovimentBanks['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Movimento de Banco']) : ''; ?>
                            <?= $transfer->has('boxes_id') ? $this->Html->link('MC'.str_pad($transfer->MovimentBoxes['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'MovimentBoxes', 'action' => 'view', $transfer->MovimentBoxes['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Movimento de Caixa']) : ''; ?>
                        </td>
                        <td class="text-left">
                            <?= $transfer->banks_id ? $transfer->Banks['title'] : ''; ?>
                            <?= $transfer->boxes_id ? $transfer->Boxes['title'] : ''; ?>
                        </td>
                        <td class="text-left">
                            <?= $transfer->has('banks_dest') ? $this->Html->link('MB'.str_pad($transfer->MovimentBanksDest['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'MovimentBanks', 'action' => 'view', $transfer->MovimentBanksDest['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Movimento de Banco']) : ''; ?>
                            <?= $transfer->has('boxes_dest') ? $this->Html->link('MC'.str_pad($transfer->MovimentBoxesDest['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'MovimentBoxes', 'action' => 'view', $transfer->MovimentBoxesDest['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Movimento de Caixa']) : ''; ?>
                        </td>
                        <td class="text-left">
                            <?= $transfer->BanksDest ? $transfer->BanksDest['title'] : ''; ?>
                            <?= $transfer->BoxesDest ? $transfer->BoxesDest['title'] : ''; ?>
                        </td>
                        <td class="text-left"><?= ($transfer->historico) ?></td> 
                        <td class="text-right text-nowrap">
                        <?php if ($transfer->status == 'P') { ?>
                            <i class="fa fa-calendar"></i>
                        <?php }//if ($transfer->status == 'P') ?>
                        </td>
                        <td class="text-right text-nowrap"><?= $this->Number->precision($transfer->valor, 2) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?php if ($transfer->status == 'P') { ?>
                                <?= $this->Form->postLink('', ['action' => 'confirm', $transfer->id], ['confirm' => __('Você tem certeza que deseja confimar a transferência na data programada?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => __('Carregando...'), 'title' => __('Confirmar'), 'escape' => false]) ?>
                                <?= $this->Html->link('', ['action' => 'edit', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?php } else { ?>
                                <?= $this->Html->link('', ['action' => 'edit_baixado', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?php }//else if ($transfer->status == 'P') ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $transfer->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
        
    <div class="panel-heading" style="font-size: 11px;">
        <span class="text-bold"><?= __('Legenda:') ?></span><br />
        <span style="color: #2aabd2"><?= __('Tipos de Vínculos: MB: Movimentos de Bancos; MC: Movimentos de Caixas.') ?></span><br />
        <i class="fa fa-calendar"></i><span style="color: #2aabd2"><?= __('Lançamentos agendados, pendentes de aprovação.') ?></span>
    </div>
    
    <div class="col-xs-12 bottom-50">
        <div class="box">
            <?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
        </div>
    </div>
    
</div>