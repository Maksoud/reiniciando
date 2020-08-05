<div class="box panel panel-default box-shadow" style="padding:0;">
    <div class="panel-heading box-header" style="background-color: #fcf8e3">
        <span class="text-bold">{{ __('Faturas dos Cartões de Crédito') }}**</span>
        <h5>
            <small>(*) {{ __('Vencimentos até') }} <?= date('t/m/Y', strtotime('+ 60 days')); ?></small><br/>
            <small>(**) {{ __('Títulos recorrentes são gerados após o vencimento.') }}</small>
        </h5>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus-square-o"></i>
            </button>
        </div>
    </div>
    <div class="box-body panel-body">
        <div class="table-responsive" style="max-height: 300px;">
            <table class="table no-margin font-12">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('Cartão') }}</th>
                        <th class="text-left col-xs-1">{{ __('Venc.') }}</th>
                        <th class="text-center col-xs-1">{{ __('Valor') }}</th>
                        <th class="text-center col-xs-1">{{ __('Ações') }}</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach ($faturas_cartoes as $fatura):

                        //Valor da fatura
                        $valor = $fatura->valor;
                        
                        //ANALISA BAIXAS PARCIAIS
                        if ($MovementMergeds->toArray()) {

                            foreach ($MovementMergeds as $MovementMerged):

                                if ($MovementMerged->Movement_id == $fatura->id) {
                                    if ($MovementMerged->Movement_Mergeds['status'] == 'O' || $MovementMerged->Movement_Mergeds['status'] == 'B') {
                                        //Deduz o valor pago parcial
                                        $valor -= $MovementMerged->Movement_Mergeds['valorbaixa'];
                                    }
                                }//else if ($MovementMerged->Movement_id == $fatura->id)

                            endforeach;

                        }//if ($MovementMergeds)
                        ?>
                        <tr>
                            <td class="text-left"><?= $fatura->Card['title']; ?></td>
                            <td class="text-left"><?= date('d/m', strtotime($fatura->vencimento)); ?></td>
                            <td class="text-right"><?= $this->Number->precision($valor, 2); ?></td>
                            <td class="btn-actions-group">
                                
                                @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                                	<?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                    <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Movement', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                @endif
                                
                                @if (session('parameter_plan') == 1)
                                	<?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Movement', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                @endif
                                
                            </td>
                        </tr>
                        <?php

                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>