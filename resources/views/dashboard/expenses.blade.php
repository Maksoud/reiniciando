<?php 
$count = 0;
if (isset($debitos)) {
    foreach ($debitos as $Movement):
        ++$count;
    endforeach;
}//if (isset($debitos))
if ($count > 0) { ?>
    <div class="box panel panel-default bg-danger box-shadow" style="padding:0;">
        <div class="panel-heading box-header" style="background-color: #f2dede;">
            <span class="text-bold">{{ __('CONTAS A PAGAR') }} <?= ' ('.$count.')'; ?></span>
            <h5><small>(*) {{ __('Com vencimento até') }} <?= date('t/m/Y'); ?></small></h5>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus-square-o"></i>
                </button>
            </div>
        </div>
        <div class="box-body panel-body">
            <div class="table-responsive" style="max-height: 500px; overflow-y: scroll;">
                <table class="table no-margin table-striped table-condensed">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1">{{ __('Ordem') }}</th>
                            <th class="text-left col-xs-1">{{ __('Vencimento') }}</th>
                            @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                            	<th class="text-left col-xs-1">{{ __('Documento') }}</th>
                                <th class="text-left">{{ __('Cliente/Fornecedor') }}</th>
                            @endif
                            <th class="text-left">{{ __('Histórico') }}</th>
                            <th class="text-right">{{ __('Valor') }}</th>
                            <th class="text-center"></th>
                            <th class="text-center">{{ __('Status') }}</th>
                            <th class="text-center col-xs-1">{{ __('Ações') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($debitos as $Movement): ?>
                            <tr>
                                <td class="text-left"><?= ($Movement->ordem); ?></td>
                                <td class="text-left">
                                    <?php 
                                    if ($Movement->vencimento < date('Y-m-d')) { ?>
                                        <span style="color: #ce8483">
                                            <?= date('d/m/Y', strtotime($Movement->vencimento)); ?>
                                        </span>    
                                        <?php
                                    } elseif ($Movement->vencimento > date('Y-m-d')) { ?>
                                        <span style="color: #2aabd2">
                                            <?= date('d/m/Y', strtotime($Movement->vencimento)); ?>
                                        </span>
                                        <?php
                                    } elseif ($Movement->vencimento == date('Y-m-d')) { ?>
                                        <span style="color: #0a0">
                                            <?= date('d/m/Y', strtotime($Movement->vencimento)); ?>
                                        </span>
                                        <?php
                                    }//elseif ($Movement->vencimento == date('Y-m-d'))?>
                                </td>
                                @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                                	<td class="text-left"><?= ($Movement->documento); ?></td>
                                    <td class="text-left">
                                        <?= h($Movement->Provider['title']); ?>
                                        <?= h($Movement->Customer['title']); ?>
                                    </td>
                                @endif
                                <td class="text-left"><?= ($Movement->historico); ?></td>
                                <td class="text-right text-nowrap">
                                    <?php
                                    $valorpago = 0;
                                    if ($Movement->status == 'P') {
                                        if (!empty($MovementMergeds->toArray())) {
                                            foreach ($MovementMergeds as $merged): 
                                                if ($merged->Movement_id == $Movement->id) {
                                                    if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->Movement_id == $Movement->id)
                                            endforeach;
                                        }//if (!empty($MovementMergeds->toArray()))
                                    }//if ($Movement->status == 'P')
                                    echo $this->Number->precision($Movement->valor - $valorpago, 2); ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                    if ($Movement->creditodebito == 'C') { ?>
                                        <i class="fa fa-plus-circle" style="color: lightblue" title="{{ __('Crédito') }}"></i>
                                        <?php
                                    } elseif ($Movement->creditodebito == 'D') { ?>
                                        <i class="fa fa-minus-circle" style="color: #e4b9c0" title="{{ __('Débito') }}"></i>
                                        <?php
                                    }//elseif ($Movement->creditodebito == 'D')
                                    //Lista os Movementos recorrentes
                                    if ($MovementRecurrents) {
                                        foreach ($MovementRecurrents as $MovementRecurrent):
                                            if ($Movement->id == $MovementRecurrent->id) { ?>
                                                <i class="fa fa-repeat" style="color: lightblue" title="{{ __('Recorrente') }}"></i>
                                                <?php
                                            }//if ($Movement->id == $MovementRecurrent->id)
                                        endforeach;
                                    }//if ($MovementRecurrents) ?>
                                </td>
                                <td class="text-center col-xs-1">
                                    <?php if ($Movement->status == 'A') {
                                        echo __('Aberto');
                                    } ?>
                                    <?php if ($Movement->status == 'B') {
                                        echo __('Baixado');
                                    } ?>
                                    <?php if ($Movement->status == 'C') {
                                        echo __('Cancelado');
                                    } ?>
                                    <?php if ($Movement->status == 'G') {
                                        echo __('Agrupado');
                                    } ?>
                                    <?php if ($Movement->status == 'V') {
                                        echo __('Vinculado');
                                    } ?>
                                    <?php if ($Movement->status == 'O') {
                                        echo __('B.Parcial');
                                    } ?>
                                    <?php if ($Movement->status == 'P') {
                                        echo __('Parcial');
                                    } ?>
                                </td>
                                <td class="btn-actions-group">
                                    
                                    @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                                    	<?php 
	                                    if ($Movement->status == 'A') { ?>
                                            <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?php 
                                            if ($Movement['vinculapgto'] == 'S' && empty($Movement['Card_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'group', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => __('Agrupar Lançamentos'), 'title' => {{ __('Agrupar') }}]); ?>
                                                <?php
                                            }//if ($Movement['vinculapgto'] == 'S' && empty($Movement['Card_id']))?>
                                            <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                            <?php
                                        } elseif ($Movement->status == 'B') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => {{ __('Cancelar') }}]); ?>
                                            <?php
                                        }//elseif ($Movement->status == 'B') 
                                            if ($Movement->status == 'C') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                            <?php
                                        }//if ($Movement->status == 'C') 
                                            if ($Movement->status == 'V') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?php
                                        } elseif ($Movement->status == 'O') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => {{ __('Cancelar') }}]); ?>
                                            <?php
                                        }//elseif ($Movement->status == 'O') 
                                            if ($Movement->status == 'P') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?php
                                        }//if ($Movement->status == 'P') 
                                        if ($Movement->status == 'G' && empty($Movement['Card_id'])) { ?>
                                            <?= $this->Html->link('', ['action' => 'view', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'group', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => __('Agrupar Lançamentos'), 'title' => {{ __('Agrupar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?php
                                        }//if ($Movement->status == 'G' && empty($Movement['Card_id'])) ?>
                                    @endif
                                    
                                    @if (session('parameter_plan') == 1)
                                    	<?php 
	                                    if ($Movement->status == 'A') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                            <?php
                                        } elseif ($Movement->status == 'B') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => {{ __('Cancelar') }}]); ?>
                                            <?php
                                        }//elseif ($Movement->status == 'B') 
                                        if ($Movement->status == 'C') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                            <?php
                                        }//if ($Movement->status == 'C')
                                        if ($Movement->status == 'V') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?php
                                        } elseif ($Movement->status == 'O') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => {{ __('Cancelar') }}]); ?>
                                            <?php
                                        }//elseif ($Movement->status == 'O')
                                        if ($Movement->status == 'P') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?php
                                        }//if ($Movement->status == 'P') 
                                        if ($Movement->status == 'G' && empty($Movement['Card_id'])) { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?php
                                        }//if ($Movement->status == 'G' && empty($Movement['Card_id'])) ?>
                                    @endif
                                    
                                    @if (session('parameter_plan') == 4)
                                    	<?php
	                                    if ($Movement->status == 'A') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                            <?php
                                        } elseif ($Movement->status == 'B') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => {{ __('Cancelar') }}]); ?>
                                            <?php
                                        }//elseif ($Movement->status == 'B') 
                                        if ($Movement->status == 'C') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                            <?php
                                        }//if ($Movement->status == 'C') 
                                        if ($Movement->status == 'V') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?php
                                        } elseif ($Movement->status == 'O') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Movement', $Movement->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => {{ __('Cancelar') }}]); ?>
                                            <?php
                                        }//elseif ($Movement->status == 'O') 
                                        if ($Movement->status == 'P') { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Movement', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?php
                                        }//if ($Movement->status == 'P') 
                                        if ($Movement->status == 'G' && empty($Movement['Card_id'])) { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Baixar Lançamento') }}, 'title' => {{ __('Baixar') }}]); ?>
                                            <?= $this->Html->link('', ['action' => 'edit_simple', $Movement->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Editar Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
                                            <?php
                                        }//if ($Movement->status == 'G' && empty($Movement['Card_id'])) ?>
                                    @endif
                                    
                                </td>
                            </tr>
                        <?php 
                    endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-heading" style="font-size: 11px;">
            <span class="text-bold">{{ __('Legenda:') ?></span><br>
            <span style="color: #ce8483">{{ __('Datas de Contas Vencidas,') }} </span>
            <span style="color: #0a0">{{ __('Contas que Vencem Hoje e') }} </span>
            <span style="color: #2aabd2">{{ __('Contas a Vencer.') }}</span>
        </div>
    </div>
    <?php
}//if ($count > 0) ?>