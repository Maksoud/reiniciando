<?php
if (!empty($saldos)) {
    foreach ($saldos as $balance):
        if (isset($balance->Card_id)) {
            $Card = true;
        }//if (isset($balance->Card_id))
    endforeach;
}//if (isset($saldos))

if (!empty($Card)) { ?>
    <div class="box panel panel-default box-shadow" style="padding:0;">
        <div class="panel-heading box-header" id="numero1" style="background-color: #d9edf7;">
            <span class="text-bold"><i class="fa fa-credit-card-alt"></i> {{ __('Limite de Cartões') }}*</span>
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
                            <th class="text-center col-xs-1">{{ __('Limite') }}</th>
                            <th class="text-center col-xs-1">{{ __('Utilizado') }}</th>
                            <th class="text-right col-xs-1">{{ __('Disponível') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $saldo_total = $saldo_disponivel = $saldo_utilizado = 0.00;
                        foreach ($saldos as $balance):

                            if (isset($balance->Card_id)) { ?>
                                <tr>
                                    <th class="text-nowrap">
                                        <?php
                                        if ($balance->id < 10 && isset($balance->id)) {
                                            $balance->id = '0'.$balance->id;
                                        } elseif (!empty($balance->Card_id)) {
                                            echo $balance->Card['title'];
                                        }
                                        $uso = $balance->Card['limite'] - $balance->value;
                                        $saldo_utilizado += $uso; ?>
                                    </th>
                                    <td class="text-right">
                                        <?= $this->Number->precision($balance->Card['limite'], 2); ?>
                                    </td>
                                    <td class="text-right">
                                        <!-- LIMITE DO CARTÃO UTILIZADO -->
                                        <?= $this->Number->toPercentage(($uso / $balance->Card['limite']) * 100); ?>
                                    </td>
                                    <td class="text-right">
                                        <?= $this->Number->precision($balance->value, 2); ?>
                                        <?php $saldo_disponivel += $balance->value; ?>
                                    </td>
                                </tr>
                                <?php
                            }//if (isset($balance->Card_id))

                        endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray">
                            <th colspan="3">{{ __('CRÉDITO DISPONÍVEL') }}</th>
                            <th class="text-right">
                                <?= $this->Number->precision($saldo_disponivel, 2); ?>
                            </th>
                        </tr>
                        <tr class="bg-gray">
                            <th colspan="3">{{ __('CRÉDITO UTILIZADO') }}</th>
                            <th class="text-right">
                                <?= $this->Number->precision($saldo_utilizado, 2); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php
} //(!empty($Card)) ?>