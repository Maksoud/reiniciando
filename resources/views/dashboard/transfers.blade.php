<div class="col-xs-12">
    <div class="box panel panel-default box-shadow" style="padding:0;">
	    <div class="panel-heading box-header">
	        <span class="text-bold"><i class="fa fa-clock-o"></i> {{ __('Transferências Programadas') }}</span>
	        <h5><small>{{ __('Agendamentos de Resgates/Aplicações (Transferências)') }}</small></h5>
	
	        <div class="box-tools pull-right">
	            <button type="button" class="btn btn-box-tool" data-widget="collapse">
	                <i class="fa fa-minus-square-o"></i>
	            </button>
	        </div>
	    </div>
	    <div class="box-body panel-body">
	        <div class="table-responsive" style="max-height: 250px; overflow-y: scroll;">
	            <table class="table no-margin font-12 table-striped table-condensed">
	                <thead>
	                    <tr>
	                        <th class="text-left col-xs-1">{{ __('Ordem') }}</th>
	                        <th class="text-left col-xs-1">{{ __('Programação') }}</th>
	                        <th class="text-left">{{ __('Histórico') }}</th>
	                        <th class="text-left col-xs-1">{{ __('Origem') }}</th>
	                        <th class="text-left col-xs-1">{{ __('Destino') }}</th>
	                        <th></th>
	                        <th class="text-center">{{ __('Valor') }}</th>
	                        <th class="text-center col-xs-1">{{ __('Ações') }}</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php 
	                    foreach ($Transfer as $transfer): ?>
	                        <tr>
	                            <td class="text-left"><?= str_pad($transfer->ordem, 6, '0', STR_PAD_LEFT); ?></td>
	                            <td class="text-left">
	                                <?php 
	                                if ($transfer->programacao < date('Y-m-d')) { ?>
	                                    <span style="color: #ce8483">
	                                    <?php
	                                } elseif ($transfer->programacao > date('Y-m-d')) { ?>
	                                    <span style="color: #2aabd2">
	                                    <?php
	                                } elseif ($transfer->programacao == date('Y-m-d')) { ?>
	                                    <span style="color: #0a0">
	                                    <?php
	                                }//elseif ($transfer->programacao == date('Y-m-d')) ?>
	                                    <?= date('d/m/Y', strtotime($transfer->programacao)); ?>
	                                </span>
	                            </td>
	                            <td class="text-left"><?= ($transfer->historico); ?></td>
	                            <td class="text-left">
	                                <?php
	                                if (isset($transfer->Bank_id)) {
	                                    echo $transfer->Bank['title'];
	                                }//if (isset($transfer->Bank_id))
	                                if (isset($transfer->Box_id)) {
	                                    echo $transfer->Box['title'];
	                                }//if (isset($transfer->Box_id)) ?>
	                            </td>
	                            <td class="text-left">
	                                <?php
	                                if (isset($transfer->Bank_dest)) {
	                                    echo $transfer->BankDest['title'];
	                                }//if (isset($transfer->Bank_dest))
	                                if (isset($transfer->Box_dest)) {
	                                    echo $transfer->BoxDest['title'];
	                                }//if (isset($transfer->Box_dest)) ?>
	                            </td>
	                            <td class="text-right text-nowrap">
	                                <?php 
	                                if ($transfer->status == 'P') { ?>
	                                    <i class="fa fa-calendar"></i>
	                                    <?php
	                                }//if ($transfer->status == 'P') ?>
	                            </td>
	                            <td class="text-right text-nowrap"><?= $this->Number->precision($transfer->valor, 2); ?></td>
	                            <td class="btn-actions-group">
	                                
	                                @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
	                                	<?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'view', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
	                                    <?php 
	                                    if ($transfer->status == 'P') { ?>
	                                        <?= $this->Form->postLink('', ['controller' => 'Transfer', 'action' => 'confirm', $transfer->id], ['confirm' => __('Você tem certeza que deseja confimar a transferência na data programada?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => {{ __('Carregando...') }}, 'title' => 'Confirmar']); ?>
	                                        <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'edit', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
	                                        <?php
	                                    } else { ?>
	                                        <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'edit_baixado', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
	                                        <?php
	                                    }//else if ($transfer->status == 'P') ?>
	                                    <?= $this->Form->postLink('', ['controller' => 'Transfer', 'action' => 'delete', $transfer->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
	                                @endif
	                                
	                                @if (session('parameter_plan') == 1)
	                                	<?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'view_simple', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Visualizar') }}]); ?>
	                                    <?php 
	                                    if ($transfer->status == 'P') { ?>
	                                        <?= $this->Form->postLink('', ['controller' => 'Transfer', 'action' => 'confirm', $transfer->id], ['confirm' => __('Você tem certeza que deseja confimar a transferência na data programada?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => {{ __('Carregando...') }}, 'title' => 'Confirmar']); ?>
	                                        <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'edit_simple', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
	                                        <?php
	                                    } else { ?>
	                                        <?= $this->Html->link('', ['controller' => 'Transfer', 'action' => 'edit_baixado_simple', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => {{ __('Carregando...') }}, 'data-title' => {{ __('Dados do Cadastro') }}, 'title' => {{ __('Editar') }}]); ?>
	                                        <?php
	                                    }//else if ($transfer->status == 'P') ?>
	                                    <?= $this->Form->postLink('', ['controller' => 'Transfer', 'action' => 'delete', $transfer->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
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
	        <span class="text-bold">{{ __('Legenda:') }}</span><br />
	        <span style="color: #ce8483">{{ __('Datas de Agendamentos Vencidos,') }} </span>
	        <span style="color: #0a0">{{ __('Agendamentos que Vencem Hoje e') }} </span>
	        <span style="color: #2aabd2">{{ __('Agendamentos a Vencer.') }}</span>
	    </div>
	</div>
</div>