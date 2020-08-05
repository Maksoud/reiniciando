<div class="box panel panel-default box-shadow" style="padding:0;">
    <div class="panel-heading box-header" id="numero5" style="background-color:#fcf8e3">
        <span class="text-bold"><i class="fa fa-bolt"></i> {{ __('Atalhos') }}</span>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus-square-o"></i>
            </button>
        </div>
    </div>
    <div class="box-body panel-group bottom-0" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <?= $this->Html->link({{ __('Lançamentos') }}, '#collapseOne', ['class' => 'btn fa fa-list-ul fa-fw font-14', 'style' => 'width:100%;height:100%;', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseOne', 'aria-expanded' => true, 'aria-controls' => 'collapseOne', 'escape' => false]); ?>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <ul class="list-unstyled top_profiles scroll-view">
                    
                    @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                    	<li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CONTAS P/R') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Nova Conta a Pagar/Receber') }}, 'title' => {{ __('Incluir Registro') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos Financeiros') }} }}, 'title' => {{ __('Relatório - Movementos Financeiros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CAIXAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementBox', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Movemento de Caixa') }}, 'title' => {{ __('Incluir Registro') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBox', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBox', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ __('Relatório - Movementos de Caixa') }}, 'title' => {{ __('Relatório - Movementos de Caixa') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('BANCOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementBank', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Movemento de Banco') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBank', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBank', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Banco') }} }}, 'title' => 'Relatório - Movementos de Banco']); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CHEQUES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementCheck', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCheck', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ __('Relatório - Movementos de Cheques') }}, 'title' => {{ __('Relatório - Movementos de Cheques') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTÕES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Novo Movemento de Cartões', 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Cartões') }} }}, 'title' => {{ __('Relatório - Movementos de Cartões') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('TRANSFERÊNCIAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Nova Transferência', 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Transferência') }} }}, 'title' => {{ __('Relatório - Movementos de Transferência') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('PLANEJAMENTOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Planning', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Incluir Registros') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Planning', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('REL. DE PAGAMENTOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'report_rp'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => 'Relatório - Relação de Pagamentos', 'title' => __('Relação de Pagamentos')]); ?>
                                </div>
                            </div>
                        </li>
                    @endif
                    
                    @if (session('parameter_plan') == 1)
                    	<li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CONTAS P/R') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Nova Conta a Pagar/Receber') }}, 'title' => {{ __('Incluir Registro') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos Financeiros') }} }}, 'title' => __('Movementos Financeiros')]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTEIRAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementBox', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Movemento de Carteira'), 'title' => {{ __('Incluir Registro') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBox', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBox', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movementos de Carteira'), 'title' => __('Movementos de Carteira')]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('BANCOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementBank', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Movemento de Banco') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBank', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementBank', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Banco') }} }}, 'title' => 'Relatório - Movementos de Banco']); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTÕES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Novo Movemento de Cartões', 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Cartões') }} }}, 'title' => __('Movementos de Cartões')]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('TRANSFERÊNCIAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Nova Transferência', 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Transferência') }} }}, 'title' => {{ {{ __('Relatório - Movementos de Transferência') }} }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('PLANEJAMENTOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Planning', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Incluir Registros') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Planning', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                    @endif
                    
                    @if (session('parameter_plan') == 4)
                    	<li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CONTAS P/R') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Nova Conta a Pagar/Receber') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Movement', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn btn-actions btn_modal fa fa-usd', 'title' => __('Disponível na versão completa'), 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos Financeiros') }} }}, 'title' => {{ {{ __('Relatório - Movementos Financeiros') }} }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTÕES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Novo Movemento de Cartões', 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'MovementCard', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => {{ {{ __('Relatório - Movementos de Cartões') }} }}, 'title' => {{ {{ __('Relatório - Movementos de Cartões') }} }}]); ?>
                                </div>
                            </div>
                        </li>
                    @endif
                    
                </ul>
            </div>
        </div>

        <div class="panel panel-default top-0">
            <div class="panel-heading" role="tab" id="headingTwo">
                <?= $this->Html->link({{ __('Cadastros') }}, '#collapseTwo', ['class' => 'btn collapsed fa fa-pencil-square-o fa-fw font-14', 'style' => 'width:100%;height:100%;', 'style' => 'width:100%;height:100%;', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseTwo', 'aria-expanded' => false, 'aria-controls' => 'collapseTwo', 'escape' => false]); ?>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                <ul class="list-unstyled top_profiles scroll-view">

                    @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                    	<li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('FORNECEDORES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Provider', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Fornecedor') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Provider', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CLIENTES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Customer', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Cliente') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Customer', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('BANCOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Bank', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Banco') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Bank', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CAIXAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Box', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Caixa') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Box', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTÕES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Card', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Cartão') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Card', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('P. CONTAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'AccountPlan', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Plano de Contas') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'AccountPlan', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('C. CUSTOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Cost', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Centro de Custos') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Cost', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('T. DOCUMENTOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'DocumentType', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Tipo de Documento') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'DocumentType', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('T. EVENTOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'EventType', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Tipo de Evento') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'EventType', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                    @endif
                    
                    @if (session('parameter_plan') == 1)
                    	<li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('BANCOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Bank', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Banco') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Bank', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTEIRAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Box', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Nova Carteira') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Box', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTÕES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Card', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Cartão') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Card', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CATEGORIAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Cost', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Centro de Custos') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Cost', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                    @endif
                    
                    @if (session('parameter_plan') == 4)
                    	<li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTEIRAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Box', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Nova Carteira') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Box', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('BANCOS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Bank', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Banco') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Bank', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CARTÕES') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Card', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => {{ __('Novo Cartão') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Card', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                        <li class="media event">
                            <a class="pull-left border-blue profile_thumb">
                                <i class="fa fa-folder-open-o blue"></i>
                            </a>
                            <div class="row media-body">
                                <div class="media-title">{{ __('CATEGORIAS') }}</div>
                                <div>
                                    <?= $this->Html->link('', ['controller' => 'Cost', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => {{ __('Novo Centro de Custos') }}, 'title' => {{ __('Incluir Registros') }}]); ?>
                                    <?= $this->Html->link('', ['controller' => 'Cost', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => {{ __('Listar Registros') }}]); ?>
                                </div>
                            </div>
                        </li>
                    @endif
                    
                </ul>
            </div>
        </div>
    </div>
</div>