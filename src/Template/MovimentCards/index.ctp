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
/* File: src/Template/MovimentCards/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'MovimentCards', 'action' => 'add'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Novo Movimento de Cartão', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Movimentos de Cartão') ?></h3>
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
                    <?= $this->Form->control('title_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Documento ou histórico'), 'value' => @$this->request->query['title_search']]); ?>
                    <?= $this->Form->control('valor_search', ['type' => 'text', 'id' => 'buscaValor', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5 valuemask', 'label' => false, 'placeholder' => __('Valor em Reais'), 'value' => @$this->request->query['valor_search']]); ?>
                    <?= $this->Form->control('cards_id_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- cartão -'), 'options' => $cards, 'value' => @$this->request->query['cards_id_search']]); ?>
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
                    <th class="text-left col-xs-1"><?= __('Cartão') ?></th>
                    <th class="text-left col-xs-1"><?= __('Lançamento') ?></th>
                    <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                    <th class="text-left"><?= __('Histórico') ?></th>
                    <th class="text-center text-nowrap col-xs-1"><?= __('Valor da Parcela') ?></th>
                    <th class="col-xs-1"></th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimentCards as $movimentCard): ?>
                    <tr class="initialism">
                        <td class="text-left"><?= str_pad($movimentCard->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left"><?= $movimentCard->documento ? $movimentCard->documento : '-'; ?></td>
                        <td class="text-center">
                            <?= $movimentCard->has('moviments_id') ? $this->Html->link('CPR'.str_pad($movimentCard->Moviments['ordem'], 4, '0', STR_PAD_LEFT), ['controller' => 'Moviments', 'action' => 'view', $movimentCard->Moviments['id']], ['class' => 'btn_modal label label-primary', 'data-title' => 'Visualizar Lançamento de Contas a Pagar/Receber']) : ''; ?>
                            <?php if (empty($movimentCard->moviments_id)) {echo '-';} ?>
                        </td>
                        <td class="text-nowrap"><?= $movimentCard->Cards['title'] ?></td>
                        <td class="text-left"><?= date("d/m/Y", strtotime($movimentCard->data)) ?></td>
                        <td class="text-left">
                        <?php if ($movimentCard->status == 'A') { ?>
                            <?php if (date('Y-m-d') < $movimentCard->vencimento) { ?>
                                <span style="color: #2aabd2">
                                    <?= date("d/m/Y", strtotime($movimentCard->vencimento)) ?>
                                </span>
                            <?php } elseif (date('Y-m-d') > $movimentCard->vencimento) { ?>
                                <span style="color: #ce8483">
                                    <?= date("d/m/Y", strtotime($movimentCard->vencimento)) ?>
                                </span>
                            <?php } elseif ($movimentCard->vencimento == date('Y-m-d')) { ?>
                                <span style="color: #0a0">
                                    <?= date("d/m/Y", strtotime($movimentCard->vencimento)) ?>
                                </span>
                            <?php } ?>
                        <?php } else { ?>
                            <?= date("d/m/Y", strtotime($movimentCard->vencimento)) ?>
                        <?php }//else if ($movimentCard->status == 'A') ?>
                        </td>
                        <td class="text-nowrap"><?= $movimentCard->title ?></td>
                        <td class="text-right text-nowrap"><?= $this->Number->precision($movimentCard->valor, 2) ?></td>
                        <td class="text-center">
                        <?php if ($movimentCard->creditodebito == 'C') { ?>
                            <span class="fa fa-plus-circle" style="color: #2aabd2" title="<?= __('Crédito') ?>"></span>
                        <?php } elseif ($movimentCard->creditodebito == 'D') { ?>
                            <span class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito') ?>"></span>
                        <?php } //elseif ($movimentCard->creditodebito == 'D')
                        //Lista os movimentos recorrentes
                        foreach($movimentRecurrents as $movimentRecurrent): 
                            if ($movimentCard->id == $movimentRecurrent->moviment_cards_id) { ?>
                                <i class="fa fa-repeat" style="color: lightblue" title="<?= __('Recorrente') ?>"></i><?php
                            }//if ($movimentCard->id == $movimentRecurrent->moviment_cards_id)
                        endforeach; ?>
                        </td>
                        <td class="text-center">
                            <?= $this->MovimentCards->status($movimentCard->status) ?>
                        </td>
                        <td class="btn-actions-group">
                            <?php if ($movimentCard->status == 'A') { ?>
                                <?= $this->Html->link('', ['action' => 'view', $movimentCard->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                <?= $this->Html->link('', ['action' => 'edit', $movimentCard->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                <?= $this->Html->link('', ['action' => 'editaVenc', $movimentCard->id, 'backward'], ['class' => 'btn btn-actions fa fa-backward', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Lançar no Vencimento Anterior'), 'title' => __('Retornar'), 'escape' => false]) ?>
                                <?= $this->Html->link('', ['action' => 'editaVenc', $movimentCard->id, 'forward'], ['class' => 'btn btn-actions fa fa-forward', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Lançar no Próximo Vencimento'), 'title' => __('Avançar'), 'escape' => false]) ?>
                                <?= $this->Form->postLink('', ['action' => 'delete', $movimentCard->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro e suas dependências?'), 'class' => 'btn btn-actions fa fa-trash-o', 'data-title' => __('Excluir Lançamento'), 'escape' => false]) ?>
                            <?php } elseif ($movimentCard->status == 'B') { ?>
                                <?= $this->Html->link('', ['action' => 'view', $movimentCard->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//elseif ($movimentCard->status == 'B') ?>
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
            <?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Saldos de Cartões'), ['controller' => 'pages', 'action' => 'saldosCartoes'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Cartões'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Faturas de Cartões'), ['controller' => 'pages', 'action' => 'faturaCartoes'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-list-ul', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Faturas dos Cartões de Crédito'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
        </div>
    </div>
    
</div>