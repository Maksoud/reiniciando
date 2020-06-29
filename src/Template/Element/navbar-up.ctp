<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/navbar-up.ctp */
?>

<nav class="navbar navbar-default navbar-fixed-top">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only"><?= __('Menu') ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <span class="navbar-brand">
            <?php 
                if ($this->request->Session()->read('logomarca')) {
                    echo $this->Html->link($this->Html->image($this->request->Session()->read('logomarca'), ['alt'    => 'logomarca',
                                                                                                             'height'  => '38px'
                                                                                                            ]
                                                             ),
                                           ['controller'        => 'UsersParameters', 'action' => 'changeParameter'],
                                           ['class'             => 'btn btn_modal font-18',
                                            'style'             => 'margin-top: -15px;',
                                            'data-size'         => 'sm',
                                            'data-loading-text' => '',
                                            'data-title'        => 'Mudar de Perfil',
                                            'escape'            => false
                                           ]
                                          );
                } else {
                    echo $this->Html->link(($this->request->Session()->read('brand')), ['controller' => 'UsersParameters', 
                                                                                        'action'     => 'changeParameter'
                                                                                       ], 
                                                                                       ['class'             => 'btn btn_modal font-18', 
                                                                                        'style'             => 'margin-top: -8px;',
                                                                                        'data-size'         => 'sm', 
                                                                                        'data-loading-text' => '', 
                                                                                        'data-title'        => __('Mudar de Perfil')
                                                                                       ]);
                }//else if ($this->request->Session()->read('logomarca'))
            ?>
        </span>
        <span id="logo" data-url="<?= $this->Url->build('/', true)?>"></span>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
            <li>
                <?= $this->Html->link(__(' Início'), ['controller' => 'Pages', 'action' => 'home'], ['class' => 'fa fa-tachometer', 'escape' => false]); ?>
            </li>
            <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-list-ul"></i><?= __(' Lançamentos') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index'], ['class' => 'fa fa-folder-open-o', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Movimentos de Caixa'), ['controller' => 'MovimentBoxes', 'action' => 'index'], ['class' => 'fa fa-money', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index'], ['class' => 'fa fa-university', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cheque'), ['controller' => 'MovimentChecks', 'action' => 'index'], ['class' => 'fa fa-cc', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index'], ['class' => 'fa fa-credit-card-alt', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Transferências'), ['controller' => 'Transfers', 'action' => 'index'], ['class' => 'fa fa-exchange', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Planejamentos & Metas'), ['controller' => 'Plannings', 'action' => 'index'], ['class' => 'fa fa-trophy', 'escape' => false]) ?> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-pencil-square-o"></i><?= __(' Cadastros') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Clientes'), ['controller' => 'Customers', 'action' => 'index'], ['class' => 'fa fa-briefcase', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Fornecedores'), ['controller' => 'Providers', 'action' => 'index'], ['class' => 'fa fa-shopping-cart', 'escape' => false]) ?> </li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Caixas'), ['controller' => 'Boxes', 'action' => 'index'], ['class' => 'fa fa-money', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Bancos'), ['controller' => 'Banks', 'action' => 'index'], ['class' => 'fa fa-university', 'data-size' => 'sm', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Cartões'), ['controller' => 'Cards', 'action' => 'index'], ['class' => 'fa fa-credit-card-alt', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Planos de Contas'), ['controller' => 'AccountPlans', 'action' => 'index'], ['class' => 'fa fa-sort-amount-asc', 'data-size' => 'sm', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Centros de Custos'), ['controller' => 'Costs', 'action' => 'index'], ['class' => 'fa fa-arrows-alt', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Tipos de Documentos'), ['controller' => 'DocumentTypes', 'action' => 'index'], ['class' => 'fa fa-files-o', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Tipos de Eventos'), ['controller' => 'EventTypes', 'action' => 'index'], ['class' => 'fa fa-random', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-file-text-o"></i><?= __(' Relatórios') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Relatório Geral'), ['controller' => 'Moviments', 'action' => 'cash_flow'], ['class' => 'fa fa-bar-chart btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório Geral'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'report_form'], ['class' => 'fa fa-folder-open-o btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos Financeiros'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Movimentos de Caixa'), ['controller' => 'MovimentBoxes', 'action' => 'report_form'], ['class' => 'fa fa-money btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Caixa'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'report_form'], ['class' => 'fa fa-university btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Banco'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cheque'), ['controller' => 'MovimentChecks', 'action' => 'report_form'], ['class' => 'fa fa-cc btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cheques'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'report_form'], ['class' => 'fa fa-credit-card-alt btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cartões'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Transferências'), ['controller' => 'Transfers', 'action' => 'report_form'], ['class' => 'fa fa-exchange btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Transferência'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Relação de Pagamentos'), ['controller' => 'Moviments', 'action' => 'report_rp'], ['class' => 'fa fa-list-ul btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Relação de Pagamentos'), 'escape' => false]) ?></li>
                    </ul>
                </li>
            <?php } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-list-ul"></i><?= __(' Lançamentos') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'fa fa-folder-open-o', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Movimentos de Carteira'), ['controller' => 'MovimentBoxes', 'action' => 'index_simple'], ['class' => 'fa fa-money', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index_simple'], ['class' => 'fa fa-university', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index_simple'], ['class' => 'fa fa-credit-card-alt', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Transferências'), ['controller' => 'Transfers', 'action' => 'index_simple'], ['class' => 'fa fa-exchange', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Planejamentos & Metas'), ['controller' => 'Plannings', 'action' => 'index_simple'], ['class' => 'fa fa-trophy', 'escape' => false]) ?> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-pencil-square-o"></i><?= __(' Cadastros') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Carteiras'), ['controller' => 'Boxes', 'action' => 'index-simple'], ['class' => 'fa fa-money', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Bancos'), ['controller' => 'Banks', 'action' => 'index-simple'], ['class' => 'fa fa-university', 'data-size' => 'sm', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Cartões'), ['controller' => 'Cards', 'action' => 'index-simple'], ['class' => 'fa fa-credit-card-alt', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Categorias'), ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'fa fa-arrows-alt', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-file-text-o"></i><?= __(' Relatórios') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Relatório Geral'), ['controller' => 'Moviments', 'action' => 'cash_flow_simple'], ['class' => 'fa fa-bar-chart btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório Geral'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'report_form_simple'], ['class' => 'fa fa-credit-card-alt btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cartões'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Transferências'), ['controller' => 'Transfers', 'action' => 'report_form_simple'], ['class' => 'fa fa-exchange btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Transferência'), 'escape' => false]) ?></li>
                    </ul>
                </li>
            <?php } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-list-ul"></i><?= __(' Lançamentos') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'fa fa-folder-open-o', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Movimentos de Caixa'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-money btn_modal text-inactive', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Carteira'), ['controller' => 'MovimentBoxes', 'action' => 'index_simple'], ['class' => 'fa fa-money', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index_simple'], ['class' => 'fa fa-university', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cheque'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-cc btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-credit-card-alt btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Transferências'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-exchange btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Planejamentos & Metas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-trophy btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-pencil-square-o"></i><?= __(' Cadastros') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Clientes'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-briefcase btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Fornecedores'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-shopping-cart btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Caixas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-money btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Carteiras'), ['controller' => 'Boxes', 'action' => 'index-simple'], ['class' => 'fa fa-money', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Bancos'), ['controller' => 'Banks', 'action' => 'index-simple'], ['class' => 'fa fa-university', 'data-size' => 'sm', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Cartões'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-credit-card-alt btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Categorias'), ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'fa fa-arrows-alt', 'data-size' => 'sm', 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Planos de Contas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-sort-amount-asc btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Centros de Custos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-arrows-alt btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Tipos de Documentos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-files-o btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                        <li><?= $this->Html->link(__(' Tipos de Eventos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-random btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'escape' => false]) ?> </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"><i class="fa fa-file-text-o"></i><?= __(' Relatórios') ?><span class="caret"></span></a>
                    <ul class="dropdown-menu box-shadow" role="menu">
                        <li><?= $this->Html->link(__(' Relatório Geral'), ['controller' => 'Moviments', 'action' => 'cash_flow_simple'], ['class' => 'fa fa-bar-chart btn_modal', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório Geral'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-folder-open-o btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos Financeiros'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Movimentos de Caixa'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-money btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Caixa'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-university btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Banco'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Movimentos de Cheque'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-cc btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Cheques'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Transferências'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-exchange btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Movimentos de Transferência'), 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Relação de Pagamentos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa fa-list-ul btn_modal text-inactive', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relatório - Relação de Pagamentos'), 'escape' => false]) ?></li>
                    </ul>
                </li>
            <?php } //if ($this->request->Session()->read('sessionPlan') == 4) ?>
        </ul>
        <div class="pull-right text-nowrap">
            <span style="float: left; margin-top: 16px; color: #337ab7;">
                <span class="hidden-sm"><?= __('Sua sessão expira em:') ?> </span><span class="text-bold" id="countdown"></span>
                <span id="server_datetime" style="visibility: hidden; position: absolute;"><?= date('M d Y H:i:s') ?></span>
                <script>
                    
                    setInterval(function () {
                        var current_date = new Date(document.getElementById("server_datetime").innerHTML);
                        document.getElementById("server_datetime").innerHTML = new Date(current_date.setSeconds(current_date.getSeconds() + 1));
                    }, 1000);
                    
                    window.onload = function () {
                        
                        var session_timeout, current_date, target_date, hours, minutes, seconds;
                        var countdown = document.getElementById("countdown");
                        
                        //Timeout do sistema
                        session_timeout = <?= $this->request->Session()->read('Session.timeout'); ?>;
                        
                        current_date = new Date(document.getElementById("server_datetime").innerHTML);
                        target_date  = new Date(current_date.setMinutes(current_date.getMinutes() + parseInt(session_timeout)));
                        
                        setInterval(function () {
                            
                            //var current_date = new Date();
                            current_date = new Date(document.getElementById("server_datetime").innerHTML);
                            var seconds_left = (target_date - current_date) / 1000;
                            
                            //console.log("Target Date: " + target_date);
                            //console.log("Current Date: " + current_date);

                            minutes = parseInt(seconds_left / 60);
                            seconds = parseInt(seconds_left % 60);

                            if (minutes >= 0 && minutes < 10) {
                                minutes = "0" + minutes;
                            }
                            if (seconds >= 0 && seconds < 10) {
                                seconds = "0" + seconds;
                            }

                            if (minutes < 0 || seconds < 0) {
                                //location.reload(); 
                            } else {
                                if (minutes < 1 && seconds < 1) {
                                    //location.reload(); 
                                    location.href = "<?= $this->Url->build('/logout', true); ?>";
                                } else {
                                    countdown.innerHTML = minutes + ":" + seconds;
                                }
                            }
                        }, 1000);
                        
                    }//window.onload = function()
                    
                </script>
            </span>
            &nbsp;
            <?php 
            if ($this->request->Session()->read('locale') == 'pt_BR') {
                
                $locale = 'brz.png';
                $text_idioma = ' Mudar Idioma';
                
            } elseif ($this->request->Session()->read('locale') == 'en_US') {
                
                $locale = 'usa.png';
                $text_idioma = ' Change Idiom';
                
            } 
            ?>
            <ul class="nav navbar-nav navbar-right right-5">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cogs"></i><?= __(' Sistema') ?><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu box-shadow">
                        <li><?= $this->Html->link($this->Html->image($locale, ['width' => '15px']).$text_idioma, ['controller' => 'Pages', 'action' => 'changeLocale'], ['escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Meus Dados'), ['controller' => 'Parameters', 'action' => 'index'], ['class' => 'fa fa-database', 'escape' => false]) ?></li>
                        <?php if ($this->request->Session()->read('sessionRule') != 'cont') { ?>
                        <li><?= $this->Html->link(__(' Usuários'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'fa fa-user-plus', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Pagamentos do Sistema'), ['controller' => 'Payments', 'action' => 'index'], ['class' => 'fa fa-usd', 'escape' => false]) ?></li>
                        <?php } ?>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <li><?= $this->Html->link(__(' Vínculo de Usuários'), ['controller' => 'UsersParameters', 'action' => 'index'], ['class' => 'fa fa-users', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Atualizar Saldos'), ['controller' => 'Balances', 'action' => 'superAddBalance'], ['class' => 'fa fa-plus-circle btn_modal', 'data-loading-text' => 'Carregando...', 'data-title' => 'Atualizar Saldos', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Relatório de Saldos'), ['controller' => 'Balances', 'action' => 'index'], ['class' => 'fa fa-usd', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Gerar Recorrentes'), ['controller' => 'Cron', 'action' => 'recurrent'], ['target' => '_blank', 'class' => 'fa fa-repeat', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Lista de Backups'), ['controller' => 'Backups', 'action' => 'index'], ['class' => 'fa fa-archive', 'escape' => false]) ?></li>
                        <?php } if ($this->request->Session()->read('sessionRule') == 'admin' || $this->request->Session()->read('sessionRule') == 'super') { ?>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Log de Registros'), ['controller' => 'Regs', 'action' => 'index'], ['class' => 'fa fa-file-text-o', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' System Logs'), ['controller' => 'Pages', 'action' => 'viewSystemLog'], ['class' => 'fa fa-file-text-o btn_modal', 'data-loading-text' => __('Loading...'), 'data-title' => __('System and Debug Logs'), 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Update Logs'), ['controller' => 'Pages', 'action' => 'viewUpdateLog'], ['class' => 'fa fa-file-text-o btn_modal', 'data-loading-text' => __('Loading...'), 'data-title' => __('Update Logs'), 'escape' => false]) ?></li>
                        <li class="divider"></li>
                        <li><?= $this->Html->link(__(' Backup do Sistema'), ['controller' => 'Backups', 'action' => 'backupFTP'], ['class' => 'fa fa-download', 'escape' => false]) ?></li>
                        <li><?= $this->Html->link(__(' Atualizar Sistema'), ['controller' => 'Pages', 'action' => 'update?token=y5eehc123avse6463asd35k3cb6'], ['class' => 'fa fa-cloud-download', 'escape' => false]) ?></li>
                        <?php } ?>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Chamado de Suporte'), ['controller' => 'SupportContacts', 'action' => 'index'], ['class' => 'fa fa-comments-o', 'escape' => false]) ?></li>
                        <li role="separator" class="divider"></li>
                        <li><?= $this->Html->link(__(' Sair do Sistema'), ['controller' => 'Pages', 'action' => 'logout'], ['class' => 'fa fa-sign-out bg-danger', 'style' => 'background-color: #B22222; color: white;', 'escape' => false]) ?></li>
                    </ul>
                </li>
            </ul>
        </div>        
    </div>
</nav>