<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Moviments */
/* File: src/Template/Moviments/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Moviments', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Nova Conta a Pagar/Receber'), 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Lançamentos de Contas a Pagar/Receber') ?></h3>
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
                                                                                                                                                                                                                                     'C' => __('Cancelado'),
                                                                                                                                                                                                                                     'G' => __('Agrupado'),
                                                                                                                                                                                                                                     'V' => __('Vinculado'),
                                                                                                                                                                                                                                     'O' => __('B.Parcial'),
                                                                                                                                                                                                                                     'P' => __('Parcial')
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
                    <th class="text-left col-xs-1"><?= __('Lançamento') ?></th>
                    <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Cliente/Fornecedor') ?></th>
                    <th class="text-left"><?= __('Histórico') ?></th>
                    <th class="text-center col-xs-1"><?= __('Valor') ?></th>
                    <th class="col-xs-1"></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($moviments as $moviment): ?>
                    <tr class="initialism">
                        <td class="text-left"><?= str_pad($moviment->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?= $moviment->documento ? $moviment->documento : '-'; ?></td>
                        <td class="text-left"><?= date("d/m/Y", strtotime($moviment->data)) ?></td>
                        <td class="text-left">
                        <?php if ($moviment->status == 'A' || $moviment->status == 'P' || $moviment->status == 'G') { ?>
                            <?php if (date('Y-m-d') < $moviment->vencimento) { ?>
                                <span style="color: #2aabd2">
                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                </span>
                            <?php } elseif (date('Y-m-d') > $moviment->vencimento) { ?>
                                <span style="color: #ce8483">
                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                </span>
                            <?php } elseif ($moviment->vencimento == date('Y-m-d')) { ?>
                                <span style="color: #0a0">
                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                </span>
                            <?php }//elseif ($moviment->vencimento == date('Y-m-d')) ?>
                        <?php } else { ?>
                            <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                        <?php }//else if ($moviment->status == 'A' || $moviment->status == 'P' || $moviment->status == 'G') ?>
                        </td>
                        <td class="text-left">
                            <?= h($moviment->Customers['title']) ?>
                            <?= h($moviment->Providers['title']) ?>
                            <?php if (!$moviment->Customers['title'] && !$moviment->Providers['title']) echo '-'; ?>
                        </td>
                        <td class="text-left"><?= ($moviment->historico) ?></td>
                        <td class="text-right text-nowrap">
                            <?php
                                $valorpago = 0;
                                if ($moviment->status == 'P') {
                                    if (isset($movimentMergeds)) { 
                                        foreach ($movimentMergeds as $merged):
                                            if ($merged->moviments_id == $moviment->id) {
                                                if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                    $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                }
                                            }//if ($merged->moviments_id == $moviment->id)                                   
                                        endforeach; 
                                    }//if (isset($movimentMergeds))
                                }//if ($moviment->status == 'P')
                                /* VALOR BAIXA QUANDO HÁ TÍTULOS PARCIAIS ESTÁ 0,00 26/02/2018 */
                                if ($moviment->status == 'B') {
                                    echo $this->Number->precision($moviment->valorbaixa, 2);
                                } else {
                                    echo $this->Number->precision($moviment->valor - $valorpago, 2);
                                }//else if ($moviment->status == 'B')
                            ?>
                        </td>
                        <td class="text-center">
                            <?php if ($moviment->creditodebito == 'C') { ?>
                                <span class="fa fa-plus-circle" style="color: #2aabd2" title="<?= __('Crédito') ?>"></span>
                            <?php } elseif ($moviment->creditodebito == 'D') { ?>
                                <span class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito') ?>"></span>
                            <?php }//elseif ($moviment->creditodebito == 'D')

                            //Lista os movimentos recorrentes
                            foreach($movimentRecurrents as $movimentRecurrent):
                                if ($moviment->id == $movimentRecurrent->moviments_id) { ?>
                                    <i class="fa fa-repeat" style="color: lightblue" title="<?= __('Recorrente') ?>"></i>
                                    <?php
                                }//if ($moviment->id == $movimentRecurrent->moviments_id)
                            endforeach; ?>
                        </td>
                        <td class="text-center">
                            <?= $this->Moviments->status($moviment->status) ?>
                        </td>
                        <td class="btn-actions-group">
                            <?php if ($moviment->status == 'A') { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                <?php if (isset($moviment->cards_id) && $moviment->valor != 0 || empty($moviment->cards_id)) { ?>
                                    <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                <?php }//if (isset($moviment->cards_id) && $moviment->valor != 0 || empty($moviment->cards_id)) ?>
                                <?php if ($moviment->DocumentTypes['vinculapgto'] == 'S' && empty($moviment->cards_id)) { ?>
                                    <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Agrupar Lançamentos'), 'title' => __('Agrupar'), 'escape' => false]) ?>
                                <?php }//if ($moviment->DocumentTypes['vinculapgto'] == 'S' && empty($moviment->cards_id)) ?>
                                <?php if (empty($moviment->cards_id) && empty($moviment->plannings_id)) { ?>
                                <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil edit', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                <?php }//if (empty($moviment->cards_id) && empty($moviment->plannings_id)) ?>
                                <?php if (!empty($moviment->cards_id) && $moviment->valor == 0 || empty($moviment->cards_id)) { if (empty($moviment->plannings_id)) { ?>
                                    <?= $this->Form->postLink('', ['action' => 'delete', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir')]) ?>
                                <?php }//if (!empty($moviment->cards_id) && $moviment->valor == 0 || empty($moviment->cards_id)) { if (empty($moviment->plannings_id))
                            }//if ($moviment->status == 'A') ?>
                            <?php } elseif ($moviment->status == 'B') { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit_baixado', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil edit', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'cancel', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                            <?php }//elseif ($moviment->status == 'B') ?>
                            <?php if ($moviment->status == 'C') { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'reopen', $moviment->id], ['confirm' => __('Você tem certeza que deseja reativar o registro?'), 'class' => 'btn btn-actions fa fa-refresh', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Reativar'), 'escape' => false]) ?>
                                <?php if (empty($moviment->cards_id) && ($moviment->valor != '0.00') && empty($moviment->plannings_id)) { ?>
                                    <?= $this->Form->postLink('', ['action' => 'delete', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                <?php }//if (empty($moviment->cards_id) && ($moviment->valor != '0.00') && empty($moviment->plannings_id)) ?>
                            <?php }//if ($moviment->status == 'C') ?>
                            <?php if ($moviment->status == 'V') { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?php } elseif ($moviment->status == 'O') { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit_baixado', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil edit', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?= $this->Form->postLink('', ['action' => 'cancel', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//elseif ($moviment->status == 'O') ?>
                            <?php if ($moviment->status == 'P') { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil edit', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?php }//if ($moviment->status == 'P') ?>
                            <?php if ($moviment->status == 'G' && empty($moviment->cards_id)) { ?>
                            <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Agrupar Lançamentos', 'title' => 'Agrupar', 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                            <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil edit', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                            <?php }//if ($moviment->status == 'G' && empty($moviment->cards_id)) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
    <div class="panel-heading" style="font-size: 11px;">
        <span class="text-bold"><?= __('Legenda:') ?></span><br />
        <span style="color: #ce8483"><?= __('Datas de Contas Vencidas,') ?> </span>
        <span style="color: #0a0"><?= __('Contas que Vencem Hoje e') ?> </span>
        <span style="color: #2aabd2"><?= __('Contas a Vencer.') ?></span>
    </div>
    
    <div class="col-xs-12 bottom-50">
        <div class="box">
            <?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Extratos Financeiros'), ['controller' => 'pages', 'action' => 'extratos'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-list-ul', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Extratos Financeiros'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Faturas de Cartões'), ['controller' => 'pages', 'action' => 'faturaCartoes'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-list-ul', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Faturas dos Cartões de Crédito'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Saldos de Planejamentos'), ['controller' => 'pages', 'action' => 'saldosPlanejamentos'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-trophy ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Planejamentos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
        </div>
    </div>
</div>