<div class="panel-heading box-header" style="background-color: #fcf8e3">
    <span class="text-bold">{{ __('Planejamentos & Metas') }}*</span>
    <h5><small>(*) {{ __('Vencimentos até') }} <?= date('t/m/Y', strtotime('+ 60 days')); ?></small></h5>

    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus-square-o"></i>
        </button>
    </div>
</div>
<?php 
if (!empty($Movement_Planning->toArray())) { ?>
    <div class="box-body panel-body">
        <div class="table-responsive" style="max-height: 300px; overflow-x: hidden;">
            <table class="table no-margin font-12" style="margin-bottom: 0;">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('Data') }}</th>
                        <th class="text-left">{{ __('Descrição') }}</th>
                        <th class="text-center">{{ __('Valor') }}</th>
                        <th class="text-center col-xs-1">{{ __('Ações') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($Movement_Planning as $mov_planning): ?>
                        <tr>
                            <td><?= date('d/m', strtotime($mov_planning->vencimento)); ?></td>
                            <td><?= $mov_planning->historico; ?></td>
                            <td class="text-right"><?= $this->Number->precision($mov_planning->valor, 2); ?></td>
                            <td class="btn-actions-group">
                                
                                @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                                	<?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                    <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Movement', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                @endif
                                
                                @if (session('parameter_plan') == 1)
                                	<?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Movement', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                @endif
                                
                            </td>
                        </tr>
                        <?php
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="panel-body">
        <h5><small>{{ __('Todos os lançamentos para este período já foram pagos') }}</small></h5>
    </div>
    <?php
}//else if (!empty($Movement_Planning->toArray())) ?>