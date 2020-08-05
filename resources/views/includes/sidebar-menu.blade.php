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

    <li class="treeview">
        <a href="#">
            <i class="fa fa-list-ul"></i> <span>{{ __('Lançamentos Financeiros') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu menu">
        <?php 
        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
            <li><a href="{{url('Movement')}}" class="link_active"><i class="fa fa-folder-open-o">{{ __('Contas a Pagar/Receber') }}</i></a></li>
            <li><a href="{{url('MovementBox')}}" class="link_active"><i class="fa fa-money">{{ __('Movimentos de Banco') }}</i></a></li>
            <li><a href="{{url('MovementBank')}}" class="link_active"><i class="fa fa-university">{{ __('Movimentos de Caixa') }}</i></a></li>
            <li><a href="{{url('MovementCheck')}}" class="link_active"><i class="fa fa-cc">{{ __('Movimentos de Cheque') }}</i></a></li>
            <li><a href="{{url('MovementCard')}}" class="link_active"><i class="fa fa-credit-card-alt">{{ __('Lançamentos de Cartão') }}</i></a></li>
            <li><a href="{{url('Transfer')}}" class="link_active"><i class="fa fa-exchange">{{ __('Transferências') }}</i></a></li>
            <li><a href="{{url('Planning')}}" class="link_active"><i class="fa fa-trophy">{{ __('Planejamentos & Metas') }}</i></a></li>
            <?php 
        } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
            <li><a href="{{url('Movement/simple')}}" class="link_active"><i class="fa fa-folder-open-o">{{ __('Contas a Pagar/Receber') }}</i></a></li>
            <li><a href="{{url('MovementBox/simple')}}" class="link_active"><i class="fa fa-money">{{ __('Movimentos de Banco') }}</i></a></li>
            <li><a href="{{url('MovementBank/simple')}}" class="link_active"><i class="fa fa-university">{{ __('Movimentos de Carteira') }}</i></a></li>
            <li><a href="{{url('MovementCard/simple')}}" class="link_active"><i class="fa fa-credit-card-alt">{{ __('Lançamentos de Cartão') }}</i></a></li>
            <li><a href="{{url('Transfer/simple')}}" class="link_active"><i class="fa fa-exchange">{{ __('Transferências') }}</i></a></li>
            <li><a href="{{url('Planning/simple')}}" class="link_active"><i class="fa fa-trophy">{{ __('Planejamentos & Metas') }}</i></a></li>
            <?php 
        } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
            <li><a href="{{url('Movement/simple')}}" class="link_active"><i class="fa fa-folder-open-o">{{ __('Contas a Pagar/Receber') }}</i></a></li>
            <li><a href="{{url('MovementCard/simple')}}" class="link_active"><i class="fa fa-credit-card-alt">{{ __('Lançamentos de Cartão') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Movimentos de Carteira') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Movimentos de Banco') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Movimentos de Cheque') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Transferências') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Planejamentos & Metas') }}</i></a></li>
            <?php 
        }//elseif ($this->request->Session()->read('sessionPlan') == 4) 
        ?>
        </ul>
    </li>
    
    <li class="treeview">
        <a href="#">
            <i class="fa fa-pencil-square-o"></i> <span>{{ __('Cadastros') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu menu">
        <?php 
        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
            <li><a href="{{url('Customer')}}" class="link_active"><i class="fa fa-briefcase">{{ __('Clientes') }}</i></a></li>
            <li><a href="{{url('Provider')}}" class="link_active"><i class="fa fa-shopping-cart">{{ __('Fornecedores') }}</i></a></li>
            <li><a href="{{url('Box')}}" class="link_active"><i class="fa fa-money">{{ __('Caixas') }}</i></a></li>
            <li><a href="{{url('Bank')}}" class="link_active"><i class="fa fa-university">{{ __('Bancos') }}</i></a></li>
            <li><a href="{{url('Card')}}" class="link_active"><i class="fa fa-credit-card-alt">{{ __('Cartões') }}</i></a></li>
            <li><a href="{{url('AccountPlan')}}" class="link_active"><i class="fa fa-sort-amount-asc">{{ __('Planos de Contas') }}</i></a></li>
            <li><a href="{{url('Cost')}}" class="link_active"><i class="fa fa-arrows-alt">{{ __('Centros de Custos') }}</i></a></li>
            <li><a href="{{url('DocumentType')}}" class="link_active"><i class="fa fa-files-o">{{ __('Tipos de Documentos') }}</i></a></li>
            <li><a href="{{url('EventType')}}" class="link_active"><i class="fa fa-random">{{ __('Tipos de Eventos') }}</i></a></li>
            <?php 
        } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
            <li><a href="{{url('Box/simple')}}" class="link_active"><i class="fa fa-money">{{ __('Carteiras') }}</i></a></li>
            <li><a href="{{url('Bank/simple')}}" class="link_active"><i class="fa fa-university">{{ __('Bancos') }}</i></a></li>
            <li><a href="{{url('Card/simple')}}" class="link_active"><i class="fa fa-credit-card-alt">{{ __('Cartões') }}</i></a></li>
            <li><a href="{{url('Cost/simple')}}" class="link_active"><i class="fa fa-arrows-alt">{{ __('Categorias') }}</i></a></li>
            <?php 
        } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
            <li><a href="{{url('Box/simple')}}" class="link_active"><i class="fa fa-money">{{ __('Carteiras') }}</i></a></li>
            <li><a href="{{url('Bank/simple')}}" class="link_active"><i class="fa fa-university">{{ __('Bancos') }}</i></a></li>
            <li><a href="{{url('Card/simple')}}" class="link_active"><i class="fa fa-credit-card-alt">{{ __('Cartões') }}</i></a></li>
            <li><a href="{{url('Cost/simple')}}" class="link_active"><i class="fa fa-arrows-alt">{{ __('Categorias') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Clientes') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Fornecedores') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Caixas') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Planos de Contas') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Centros de Custos') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Tipos de Documentos') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Tipos de Eventos') }}</i></a></li>
            <?php 
        }//elseif ($this->request->Session()->read('sessionPlan') == 4) 
        ?>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-file-text-o"></i> <span>{{ __('Relatórios') }}</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu menu">
        <?php 
        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
            <li><a href="{{url('Movement/report_flow')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório Geral"><i class="fa fa-bar-chart">{{ __('Relatório Geral') }}</i></a></li>
            <li><a href="{{url('Movement/report')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório Contas a Pagar/Receber"><i class="fa fa-folder-open-o">{{ __('Contas a Pagar/Receber') }}</i></a></li>
            <li><a href="{{url('MovementBox/report')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Movimentos de Caixa"><i class="fa fa-money">{{ __('Movimentos de Caixa') }}</i></a></li>
            <li><a href="{{url('MovementBank/report')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Movimentos de Banco"><i class="fa fa-university">{{ __('Movimentos de Banco') }}</i></a></li>
            <li><a href="{{url('MovementCheck/report')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Movimentos de Cheque"><i class="fa fa-cc">{{ __('Movimentos de Cheque') }}</i></a></li>
            <li><a href="{{url('MovementCard/report')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Lançamentos de Cartão"><i class="fa fa-credit-card-alt">{{ __('Lançamentos de Cartão') }}</i></a></li>
            <li><a href="{{url('Transfer/report')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Transferências"><i class="fa fa-exchange">{{ __('Transferências') }}</i></a></li>
            <li><a href="{{url('Movement/report_rp')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Relação de Pagamentos"><i class="fa fa-list-ul">{{ __('Relação de Pagamentos') }}</i></a></li>
            <?php 
        } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
            <li><a href="{{url('Movement/report_flow_simple')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório Geral"><i class="fa fa-bar-chart">{{ __('Relatório Geral') }}</i></a></li>
            <li><a href="{{url('MovementCard/report_simple')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Lançamentos de Cartão"><i class="fa fa-credit-card-alt">{{ __('Lançamentos de Cartão') }}</i></a></li>
            <li><a href="{{url('Transfer/report_simple')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Transferências"><i class="fa fa-exchange">{{ __('Transferências') }}</i></a></li>
            <?php 
        } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
            <li><a href="{{url('Movement/report_flow_simple')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório Geral"><i class="fa fa-bar-chart">{{ __('Relatório Geral') }}</i></a></li>
            <li><a href="{{url('MovementCard/report_simple')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Lançamentos de Cartão"><i class="fa fa-credit-card-alt">{{ __('Lançamentos de Cartão') }}</i></a></li>
            <li><a href="{{url('Transfer/report_simple')}}" class="btn_modal" data-loading-text="Carregando..." data-title="Relatório de Transferências"><i class="fa fa-exchange">{{ __('Transferências') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Movimentos de Caixa') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Movimentos de Banco') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Movimentos de Cheque') }}</i></a></li>
            <li><a href="#" class="btn_modal text-inactive" title="Disponível na versão completa"><i class="fa fa-lock">{{ __('Relação de Pagamentos') }}</i></a></li>
            <?php 
        }//if ($this->request->Session()->read('sessionPlan') == 4) 
        ?>
        </ul>
    </li>

    <li class="treeview">
        <a href="#">
            <i class="fa fa-question-circle-o"></i> <span>{{ __('Sistema') }}</span>
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