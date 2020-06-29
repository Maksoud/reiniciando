<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Plannings */
/* File: src/Template/Plannings/index_simple.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">
    
    <div class="col-xs-12 panel" style="float: none;">
        <div class="pull-right"><?= $this->Html->link(__(' Incluir'), ['controller' => 'Plannings', 'action' => 'add_simple'], ['class' => 'btn btn-primary fa fa-plus-circle top-20 right-10 btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Novo Planejamento/Meta', 'escape' => false]) ?></div>
        <h3 class="page-header top-20"><?= __('Planejamentos & Metas') ?></h3>
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
                    <?= $this->Form->control('title_search', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'placeholder' => __('Descrição'), 'value' => @$this->request->query['title_search']]); ?>
                    <?= $this->Form->control('valor_search', ['type' => 'text', 'id' => 'buscaValor', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5 valuemask', 'label' => false, 'placeholder' => __('Valor em Reais'), 'value' => @$this->request->query['valor_search']]); ?>
                    <?= $this->MyForm->select_meses('mes_search', ['class' => 'form-control top-5', 'label' => false, 'empty' => __('- mês -'), 'value' => @$this->request->query['mes_search']]); ?>
                    <?= $this->MyForm->select_dez_anos('ano_search', ['class' => 'form-control top-5', 'label' => false, 'empty' => __('- ano -'), 'value' => @$this->request->query['ano_search']]); ?>
                    <?= $this->Form->control('status_search', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'class' => 'form-control top-5', 'label' => false, 'empty' => __('- status -'), ['P' => __('Pendente'),
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
                    <th class="text-left col-xs-1"><?= __('Data') ?></th>
                    <th class="text-left col-xs-1"><?= __('Categoria') ?></th>
                    <th class="text-left"><?= __('Descrição') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Valor Parcela') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Nº Parcelas') ?></th>
                    <th class="text-nowrap col-xs-1"><?= __('Valor Total') ?></th>
                    <th class="text-nowrap text-center col-xs-1"><?= __('Concluído') ?> (%)</th>
                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($plannings as $planning):
                    //CALCULA O PERCENTUAL DE PAGAMENTO
                    $concluido = 0.00;
                    foreach($balance_planning as $balance):
                        if ($balance->plannings_id == $planning->id) {
                            $concluido = round((($balance->value / ($planning->valor * $planning->parcelas)) * 100));
                        }//if ($balance->plannings_id == $planning->id)
                    endforeach; ?>
                    <tr class="initialism">
                        <td class="text-left"><?= $this->MyHtml->date($planning->data) ?></td>
                        <td class="text-left"><?= $planning->costs_id ? $planning->Costs['title'] : '-'  ?></td>
                        <td class="text-left"><?= $planning->title ?></td>
                        <td class="text-left"><?= $this->Number->precision($planning->valor, 2); ?></td>
                        <td class="text-left"><?= $planning->parcelas ?></td>
                        <td class="text-left"><?= $this->Number->precision($planning->valor * $planning->parcelas, 2); ?></td>
                        <td class="text-center"><?= ($concluido . '%') ?></td>
                        <td class="text-center"><?= $this->Plannings->status($planning->status) ?></td>
                        <td class="btn-actions-group">
                            <?= $this->Html->link('', ['action' => 'view_simple', $planning->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                            <?php if ($planning->status != 'F') { ?>
                            <?= $this->Form->postLink('', ['action' => 'delete', $planning->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                            <?php }//if ($planning->status != 'F') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <?= $this->element('pagination') ?>
    
    <div class="col-xs-12 bottom-50">
        <div class="box">
            <?= $this->Html->link(__(' Saldos de Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal box-shadow btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
        </div>
    </div>
</div>