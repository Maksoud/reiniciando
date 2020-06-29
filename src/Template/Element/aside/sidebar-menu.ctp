<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

use Cake\Core\Configure;

?>
<ul class="sidebar-menu tree" data-widget="tree">

    <li class="header text-center text-bold">

        <?php 
        $logomarca = $this->request->Session()->read('logomarca');

        if (!empty($logomarca) && file_exists($logomarca)) {

            echo $this->Html->image($logomarca, ['alt'    => 'logomarca',
                                                 'height' => '38px',
                                                 'style'  => 'background-color:#ecf0f5;'
                                                ]);

        } else {

            echo $this->request->Session()->read('brand');

        }//else if (!empty($logomarca) && file_exists($logomarca))
        ?>
        
    </li>

    <li>
        <?= $this->Html->link($this->Html->tag('i', '',['class' => 'fa fa-dashboard']).
                              $this->Html->tag('span', __(' Início')), 
                              ['controller' => 'Pages', 'action' => 'home'], 
                              ['escape' => false]
                             ) ?>
    </li>

    <?php 
    if ($this->request->Session()->read('module') == 'F' || $this->request->Session()->read('module') == 'A') { ?>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-list-ul"></i> <span><?= __(' Lançamentos Financeiros') ?></span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu menu">
                <?php 
                if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                    <li><?= $this->Html->link('<i class="fa fa-folder-open-o"></i> '.__('Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-money"></i> '.__('Movimentos de Caixa'), ['controller' => 'MovimentBoxes', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-university"></i> '.__('Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-cc"></i> '.__('Movimentos de Cheque'), ['controller' => 'MovimentChecks', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Lançamentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-exchange"></i> '.__('Transferências'), ['controller' => 'Transfers', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-trophy"></i> '.__('Planejamentos & Metas'), ['controller' => 'Plannings', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <?php 
                } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                    <li><?= $this->Html->link('<i class="fa fa-folder-open-o"></i> '.__('Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-money"></i> '.__('Movimentos de Carteira'), ['controller' => 'MovimentBoxes', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-university"></i> '.__('Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Lançamentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-exchange"></i> '.__('Transferências'), ['controller' => 'Transfers', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-trophy"></i> '.__('Planejamentos & Metas'), ['controller' => 'Plannings', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <?php 
                } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                    <li><?= $this->Html->link('<i class="fa fa-folder-open-o"></i> '.__('Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Lançamentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Movimentos de Carteira'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Movimentos de Banco'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Movimentos de Cheque'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Transferências'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Planejamentos & Metas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                    <?php 
                }//elseif ($this->request->Session()->read('sessionPlan') == 4) 
                ?>
            </ul>
        </li>
        <?php
    }//if ($this->request->Session()->read('module') == 'F' || $this->request->Session()->read('module') == 'A') 
    ?>

    <?php
    if ($this->request->Session()->read('module') == 'S' || $this->request->Session()->read('module') == 'A') { 
        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i><span><?= __(' Lançamentos de Estoque') ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu menu">
                    <li><?= $this->Html->link('<i class="fa fa-briefcase"></i> '.__('Pedidos de Vendas'), ['controller' => 'Sells', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-shopping-cart"></i> '.__('Pedidos de Compras'), ['controller' => 'Purchases', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-paw"></i> '.__('Faturamentos'), ['controller' => 'Invoices', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-bullhorn"></i> '.__('Ordens de Fabricação'), ['controller' => 'Industrializations', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-check-square-o"></i> '.__('Solicitações de Compra'), ['controller' => 'PurchaseRequests', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-shopping-basket"></i> '.__('Requisições'), ['controller' => 'Requisitions', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-file-text-o"></i> '.__('Inventários'), ['controller' => 'Inventories', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                </ul>
            </li>
            <?php 
        }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)
    }//if ($this->request->Session()->read('module') == 'S' || $this->request->Session()->read('module') == 'A') 
    ?>
    
    <li class="treeview">
        <a href="#">
            <i class="fa fa-pencil-square-o"></i><span><?= __(' Cadastros') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu menu">
        <?php 
        if ($this->request->Session()->read('module') == 'F' || $this->request->Session()->read('module') == 'A') {

            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                <li><?= $this->Html->link('<i class="fa fa-briefcase"></i> '.__('Clientes'), ['controller' => 'Customers', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-shopping-cart"></i> '.__('Fornecedores'), ['controller' => 'Providers', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-money"></i> '.__('Caixas'), ['controller' => 'Boxes', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-university"></i> '.__('Bancos'), ['controller' => 'Banks', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Cartões'), ['controller' => 'Cards', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-sort-amount-asc"></i> '.__('Planos de Contas'), ['controller' => 'AccountPlans', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-arrows-alt"></i> '.__('Centros de Custos'), ['controller' => 'Costs', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-files-o"></i> '.__('Tipos de Documentos'), ['controller' => 'DocumentTypes', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-random"></i> '.__('Tipos de Eventos'), ['controller' => 'EventTypes', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <?php 
            } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                <li><?= $this->Html->link('<i class="fa fa-money"></i> '.__('Carteiras'), ['controller' => 'Boxes', 'action' => 'index-simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-university"></i> '.__('Bancos'), ['controller' => 'Banks', 'action' => 'index-simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Cartões'), ['controller' => 'Cards', 'action' => 'index-simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-arrows-alt"></i> '.__('Categorias'), ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <?php 
            } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                <li><?= $this->Html->link('<i class="fa fa-money"></i> '.__('Carteiras'), ['controller' => 'Boxes', 'action' => 'index-simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-university"></i> '.__('Bancos'), ['controller' => 'Banks', 'action' => 'index-simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Cartões'), ['controller' => 'Cards', 'action' => 'index-simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-arrows-alt"></i> '.__('Categorias'), ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Clientes'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Fornecedores'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Caixas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Planos de Contas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Centros de Custos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Tipos de Documentos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Tipos de Eventos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?></li>
                <?php 
            }//elseif ($this->request->Session()->read('sessionPlan') == 4) 

        }//if ($this->request->Session()->read('module') == 'F' || $this->request->Session()->read('module') == 'A')
        if ($this->request->Session()->read('module') == 'S' || $this->request->Session()->read('module') == 'A') { 
            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                <li><?= $this->Html->link('<i class="fa fa-cube"></i> '.__('Produtos'), ['controller' => 'Products', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-truck"></i> '.__('Transportadoras'), ['controller' => 'Transporters', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-cubes"></i> '.__('Grupos de Produtos'), ['controller' => 'ProductGroups', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-tags"></i> '.__('Tipos de Produtos'), ['controller' => 'ProductTypes', 'action' => 'index'], ['class' => 'link_active', 'escape' => false]) ?></li>
                <?php 
            }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)
        }//if ($this->request->Session()->read('module') == 'S' || $this->request->Session()->read('module') == 'A')
        ?>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-text-o"></i><span><?= __(' Relatórios') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu menu">
        <?php 

        if ($this->request->Session()->read('module') == 'F' || $this->request->Session()->read('module') == 'A') {

            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                <li><?= $this->Html->link('<i class="fa fa-bar-chart"></i> '.__('Relatório Geral'), ['controller' => 'Moviments', 'action' => 'cash_flow'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório Geral'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-folder-open-o"></i> '.__('Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'report_form'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos Financeiros'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-money"></i> '.__('Movimentos de Caixa'), ['controller' => 'MovimentBoxes', 'action' => 'report_form'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Caixa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-university"></i> '.__('Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'report_form'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Banco'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-cc"></i> '.__('Movimentos de Cheque'), ['controller' => 'MovimentChecks', 'action' => 'report_form'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cheques'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Lançamentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'report_form'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cartões'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-exchange"></i> '.__('Transferências'), ['controller' => 'Transfers', 'action' => 'report_form'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Transferência'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-list-ul"></i> '.__('Relação de Pagamentos'), ['controller' => 'Moviments', 'action' => 'report_rp'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Relação de Pagamentos'), 'escape' => false]) ?></li>
                <?php 
            } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                <li><?= $this->Html->link('<i class="fa fa-bar-chart"></i> '.__('Relatório Geral'), ['controller' => 'Moviments', 'action' => 'cash_flow_simple'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório Geral'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Lançamentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'report_form_simple'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cartões'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-exchange"></i> '.__('Transferências'), ['controller' => 'Transfers', 'action' => 'report_form_simple'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Transferência'), 'escape' => false]) ?></li>
                <?php 
            } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                <li><?= $this->Html->link('<i class="fa fa-bar-chart"></i> '.__('Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'cash_flow_simple'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório Geral'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-credit-card-alt"></i> '.__('Lançamentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'report_form_simple'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cartões'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Movimentos de Caixa'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'data-title' => __('Relatório - Movimentos de Caixa'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Movimentos de Banco'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'data-title' => __('Relatório - Movimentos de Banco'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock "></i> '.__('Movimentos de Cheque'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'text-inactive', 'data-title' => __('Relatório - Movimentos de Cheques'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Transferências'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'data-title' => __('Relatório - Movimentos de Transferência'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-lock"></i> '.__('Relação de Pagamentos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn_modal text-inactive', 'data-title' => __('Relatório - Relação de Pagamentos'), 'escape' => false]) ?></li>
                <?php 
            }//if ($this->request->Session()->read('sessionPlan') == 4) 

        }//if ($this->request->Session()->read('module') == 'F' || $this->request->Session()->read('module') == 'A')
        if ($this->request->Session()->read('module') == 'S' || $this->request->Session()->read('module') == 'A') {

            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                <li><?= $this->Html->link('<i class="fa fa-briefcase"></i> '.__('Relatório de Vendas'), ['controller' => 'Sells', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Vendas'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-shopping-cart"></i> '.__('Relatório de Compras'), ['controller' => 'Purchases', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Compras'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-paw"></i> '.__('Relatório de Faturamentos'), ['controller' => 'Invoices', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Faturamentos'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-bullhorn"></i> '.__('Relatório de OF'), ['controller' => 'Industrializations', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Ordens de Fabricação'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-check-square-o"></i> '.__('Relatório de Solicitações'), ['controller' => 'PurchaseRequests', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Solicitações de Compras'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-shopping-basket"></i> '.__('Relatório de Requisições'), ['controller' => 'Requisitions', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Requisições'), 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-search"></i> '.__('Rastreamento de OF'), ['controller' => 'Industrializations', 'action' => 'reportFull'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Rastreamento de OF'), 'data-size' => 'sm', 'escape' => false]) ?></li>
                <li><?= $this->Html->link('<i class="fa fa-cube"></i> '.__('Relatório de Produtos'), ['controller' => 'Products', 'action' => 'report'], ['class' => 'btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório de Produtos'), 'escape' => false]) ?></li>
                <?php 
            }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)
            
        }//if ($this->request->Session()->read('module') == 'S' || $this->request->Session()->read('module') == 'A')
        ?>
        </ul>
    </li>

    <!-- 
    <li><a href="<php echo $this->Url->build('/pages/debug'); ?>"><i class="fa fa-bug"></i> Debug</a></li>
    -->

    <li>
        <?= $this->Html->link($this->Html->tag('i', '',['class' => 'fa fa-comments-o']).
                              $this->Html->tag('span', __(' Chamados de Suporte')), 
                              ['controller' => 'SupportContacts', 'action' => 'index'], 
                              ['escape' => false]
                             ) ?>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-question-circle-o"></i><span><?= __(' Sistema') ?></span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu menu">
            <li class="text-nowrap"><a href="#"><i class="fa fa-calendar"></i> <?= __('Validade: ').$this->request->Session()->read('validade') ?></a></li>
            <li class="text-nowrap"><a href="#"><i class="fa fa-briefcase"></i> <?= __('Plano: ').$this->request->Session()->read('plano') ?></a></li>
            <li class="text-nowrap"><a href="#"><i class="fa fa-key"></i> <?= __('Acesso: ').$this->UsersParameters->rules($this->request->Session()->read('sessionRuleId')) ?></a></li>
            <li class="text-nowrap"><a href="#"><i class="fa fa-code"></i> <?= __('Versão: ').$this->request->Session()->read('version') ?></a></li>
            <li class="text-nowrap"><a href="#"><i class="fa fa-picture-o"></i> <?= __('Res. Janela: ') ?><span class="window-size"></span></a></li>
            <li class="text-nowrap"><a href="#"><i class="fa fa-television" class="fa fa-television"></i> <?= __('Res. Monitor: ') ?><span class="screen-size"></span></a></li>
        </ul>
    </li>
</ul>