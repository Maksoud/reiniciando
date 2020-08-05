<?php 
if (!empty($saldos)) {
    foreach ($saldos as $balance):
        if (isset($balance->Planning_id)) {
            $Planning_id = true;
        }//if (isset($balance->Planning_id))
    endforeach;
}//if (isset($saldos))

if (!empty($Planning->toArray())) { ?>
    <div class="box panel panel-default box-shadow" style="padding:0;">
        <div class="panel-heading box-header" id="numero1">
            <span class="text-bold"><i class="fa fa-trophy"></i> {{ __('Progresso dos Planejamentos') }}</span>

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
                            <th class="text-right">{{ __('Planejamento') }}</th>
                            <th class="text-center">{{ __('Progresso') }}</th>
                            <th class="text-right text-nowrap">{{ __('Total Poupado') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $saldo_total = $vlr_total = 0;

                        if (!empty($Planning->toArray())) {
                            
                            foreach ($Planning as $planning):

                                if (!empty($balance_Planning->toArray())) {

                                    //CALCULA O PERCENTUAL DE PAGAMENTO
                                    foreach ($balance_Planning as $balance):

                                        if ($balance->Planning_id == $planning->id) {
                                            $concluido = round((($balance->value / ($planning->valor * $planning->parcelas)) * 100));
                                            $vlr_total += $balance->value;
                                        }//if ($balance->Planning_id == $planning->id)

                                    endforeach;

                                    if (!isset($concluido)) {
                                        $concluido = 0.00;
                                    }//if (!isset($concluido))

                                    // IDENTIFICA O ÚLTIMO VENCIMENTO NOS MovementOS
                                    $vencimento = null;

                                    if ($vencimento < $planning->Movement['vencimento']) {
                                        $vencimento = $planning->Movement['vencimento'];
                                    }//if ($vencimento < $planning->Movement->vencimento) ?>
                                    
                                    <tr>
                                        <th class="text-nowrap">
                                            <?= $planning->title; ?>
                                        </th>
                                        <td class="text-right"> 
                                            <?= $this->Number->precision($planning->valor * $planning->parcelas, 2); ?>
                                        </td>
                                        <td class="text-center">
                                            <?= $this->Number->toPercentage($concluido); ?>
                                        </td>
                                        <td class="text-right"> 
                                            <?= $this->Number->precision($vlr_total, 2);
                                            $saldo_total += $vlr_total; ?>
                                        </td>
                                    </tr>

                                    <?php
                                }//if (!empty($balance_Planning->toArray())) {

                            endforeach;

                        }//if (!empty($Planning->toArray()))
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray">
                            <th colspan="3">{{ __('TOTAL POUPADO') }} </th>
                            <th class="text-right">
                                <?= $this->Number->precision($saldo_total, 2); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php
} //if (!empty($Planning->toArray()))?>