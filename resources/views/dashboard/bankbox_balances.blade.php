<div class="box panel panel-default box-shadow" style="padding:0;">
    <div class="panel-heading box-header" id="numero1" style="background-color: #d9edf7;">
        @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
        	<span class="text-bold"><i class="fa fa-university"></i> {{ __('Saldos de Bancos e Caixas') }}*</span>
        @endif
        
        @if (session('parameter_plan') == 1) || (session('parameter_plan') == 4)
        	<span class="text-bold"><i class="fa fa-university"></i> {{ __('Saldos de Bancos e Carteiras') }}*</span>
        @endif
        <h5><small>(*) {{ __('Saldos atualizados em') }} <?= date('d/m/Y'); ?></small></h5>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus-square-o"></i>
            </button>
        </div>
    </div>
    
    <div class="box-body panel-body">
        <div class="table-responsive">
            <table class="table no-margin font-12">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('Descrição') }}</th>
                        <th class="text-right col-xs-1">{{ __('Valor') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $saldo_total = 0;
                    foreach ($saldos as $balance):

                        if (!isset($balance->Planning_id) && !isset($balance->Card_id)) { ?>
                            <tr>
                                <th>
                                    <?php 
                                    if ($balance->Bank_id < 10 && isset($balance->Bank_id)) {
                                        $balance->Bank_id = '0'.$balance->Bank_id;
                                    }
                                    if ($balance->Box_id < 10 && isset($balance->Box_id)) {
                                        $balance->Box_id = '0'.$balance->Box_id;
                                    }
                                    if ($balance->id < 10 && isset($balance->id)) {
                                        $balance->id = '0'.$balance->id;
                                    }
                                    if (!empty($balance->Bank_id)) {
                                        echo '<i class="fa fa-university"></i> '.$balance->Bank['title'];
                                    } elseif (!empty($balance->Box_id)) {
                                        echo '<i class="fa fa-money"></i> '.$balance->Box['title'];
                                    } ?>
                                </th>
                                <td class="text-right"> 
                                    <?php 
                                    echo $this->Number->precision($balance->value, 2);
                                    if (empty($balance->Card_id)) {
                                        $saldo_total += $balance->value;
                                    } ?>
                                </td>
                            </tr>
                            <?php
                        }//if (!isset($balance->Planning_id) && !isset($balance->Card_id))

                    endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-gray">
                        @if (session('parameter_plan') == 2) || (session('parameter_plan') == 3)
                        	<th>{{ __('SALDO TOTAL') }} - <small>{{ __('Bancos e Caixas') }}</small></th>
                        @endif
                        
                        @if (session('parameter_plan') == 1) || (session('parameter_plan') == 4)
                        	<th>{{ __('SALDO TOTAL') }} - <small>{{ __('Bancos e Carteiras') }}</small></th>
                        @endif
                        <th class="text-right">
                            <?= $this->Number->precision($saldo_total, 2); ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>