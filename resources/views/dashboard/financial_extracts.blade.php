<div class="box panel panel-default box-shadow" style="padding:0;">
    <div class="panel-heading box-header" id="numero2" style="background-color: #fcf8e3">
        <span class="text-bold"><i class="fa fa-list-ul"></i> {{ __('Extratos Financeiros') }}*</span>
        <h5><small>(*) {{ __('Com vencimento até') }} <?= utf8_encode(strftime('%B de %Y', strtotime('today'))); ?></small></h5>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus-square-o"></i>
            </button>
        </div>
    </div>
    <div class="box-body panel-body table-responsive">
        <div class="table-responsive">
            <table class="table no-margin table-condensed font-12" style="margin: -10px 0 -15px -5px;">
                <thead>
                    <th></th>
                    <th class="text-center text-nowrap">
                        {{ __('Em Atraso') }}
                    </th>
                    <th class="text-center text-nowrap">
                        {{ __('Hoje') }}
                    </th>
                    <th class="text-center text-nowrap">
                        {{ __('A Vencer') }}
                    </th>
                </thead>
                <tbody>
                    <!-- RECEITAS-->
                    <tr>
                        <td class="text-left">
                            <?= $this->Html->link(__(' Receitas'), '#relacaoReceitas', ['class' => 'btn btn-default top-5 width-90 fa fa-plus-circle scroll', 'escape' => false]); ?>
                        </td>
                        <!-- VENCIDOS-->
                        <td class="text-center padding-15">
                        <?php
                            $valorpago = $creditosLateC = $totalCreditosLateC = 0;

                            if ($creditos_late) {

                                foreach ($creditos_late as $value):

                                    ++$creditosLateC;
                                    if ($value->status == 'P') {

                                        foreach ($MovementMergeds as $merged):

                                            if ($merged->Movement_id == $value->id) {
                                                if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                    $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                }
                                            }//if ($merged->Movement_id == $value->id)

                                        endforeach;
                                        $totalCreditosLateC += $value->valor - $valorpago;

                                    } else {
                                        $totalCreditosLateC += $value->valor;
                                    }//else if ($value->status == 'P')

                                endforeach;

                            }//if ($creditos_late)

                            if ($creditosLateC > 0) {
                                echo $this->Number->precision($totalCreditosLateC, 2).' ('.$creditosLateC.')';
                            } else {
                                echo '-';
                            }
                        ?>
                        </td>
                        <!-- VENCEM HOJE-->
                        <td class="text-center padding-15">
                        <?php 
                            $valorpago = $creditosMesC = $totalDiaC = 0;
                            if ($creditos_dia) {

                                foreach ($creditos_dia as $value):

                                    ++$creditosMesC;
                                    if ($value->status == 'P') {

                                        foreach ($MovementMergeds as $merged):

                                                if ($merged->Movement_id == $value->id) {
                                                    if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->Movement_id == $value->id)

                                        endforeach;
                                        $totalDiaC += $value->valor - $valorpago;

                                    } else {
                                        $totalDiaC += $value->valor;
                                    }//else if ($value->status == 'P')

                                endforeach;

                            }//if ($creditos_dia)

                            if ($creditosMesC > 0) {
                                echo $this->Number->precision($totalDiaC, 2).' ('.$creditosMesC.')';
                            } else {
                                echo '-';
                            }
                        ?>
                        </td>
                        <!-- A VENCER-->
                        <td class="text-center padding-15">
                        <?php 
                            $valorpago = $creditosFuturoC = $totalCreditosFuturoC = 0;

                            if ($creditos_future) {

                                foreach ($creditos_future as $value):

                                    ++$creditosFuturoC;
                                    if ($value->status == 'P') {
                                        
                                        foreach ($MovementMergeds as $merged):
                                            
                                            if ($merged->Movement_id == $value->id) {
                                                if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                    $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                }
                                            }//if ($merged->Movement_id == $value->id)

                                        endforeach;
                                        $totalCreditosFuturoC += $value->valor - $valorpago;

                                    } else {
                                        $totalCreditosFuturoC += $value->valor;
                                    }//if ($value->status == 'P')

                                endforeach;

                            }//if ($creditos_future)

                            if ($creditosFuturoC > 0) {
                                echo $this->Number->precision($totalCreditosFuturoC, 2).' ('.$creditosFuturoC.')';
                            } else {
                                echo '-';
                            }
                        ?>
                        </td>
                    </tr>
                    <!-- DESPESAS-->
                    <tr>
                        <td class="text-left">
                            <?= $this->Html->link(__(' Despesas'), '#relacaoDespesas', ['class' => 'btn btn-default top-5 width-90 fa fa-minus-circle scroll', 'escape' => false]); ?>
                        </td>
                        <!-- ATRASADOS-->
                        <td class="text-center padding-15">
                        <?php 
                            $valorpago = $debitosLateD = $totalDebitosLateD = 0;

                            if ($debitos_late) {

                                foreach ($debitos_late as $value):

                                    ++$debitosLateD;

                                    if ($value->status == 'P') {

                                        foreach ($MovementMergeds as $merged):

                                            if ($merged->Movement_id == $value->id) {
                                                if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                    $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                }
                                            }//if ($merged->Movement_id == $value->id)

                                        endforeach;
                                        $totalDebitosLateD += $value->valor - $valorpago;

                                    } else {
                                        $totalDebitosLateD += $value->valor;
                                    }//if ($value->status == 'P')

                                endforeach;

                            }//if ($debitos_late)

                            if ($debitosLateD > 0) {
                                echo $this->Number->precision($totalDebitosLateD, 2).' ('.$debitosLateD.')';
                            } else {
                                echo '-';
                            }
                        ?>
                        </td>
                        <!-- VENCEM HOJE-->
                        <td class="text-center padding-15">
                        <?php 
                            $valorpago = $debitosMesD = $totalDebitosMesD = 0;

                            if ($debitos_dia) {

                                foreach ($debitos_dia as $value):

                                    ++$debitosMesD;
                                    if ($value->status == 'P') {

                                        foreach ($MovementMergeds as $merged):

                                            if ($merged->Movement_id == $value->id) {
                                                if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                    $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                }
                                            }//if ($merged->Movement_id == $value->id)

                                        endforeach;
                                        $totalDebitosMesD += $value->valor - $valorpago;

                                    } else {
                                        $totalDebitosMesD += $value->valor;
                                    }//if ($value->status == 'P')

                                endforeach;

                            }//if ($debitos_dia)

                            if ($debitosMesD > 0) {
                                echo $this->Number->precision($totalDebitosMesD, 2).' ('.$debitosMesD.')';
                            } else {
                                echo '-';
                            }
                        ?>
                        </td>
                        <!-- A VENCER-->
                        <td class="text-center padding-15">
                        <?php 
                            $valorpago = $debitosFuturosD = $totalDebitosFuturoD = 0;

                            if ($debitos_future) {

                                foreach ($debitos_future as $value):

                                    ++$debitosFuturosD;
                                    if ($value->status == 'P') {

                                        foreach ($MovementMergeds as $merged):

                                            if ($merged->Movement_id == $value->id) {
                                                if ($merged->Movement_Mergeds['status'] == 'O' || $merged->Movement_Mergeds['status'] == 'B') {
                                                    $valorpago += $merged->Movement_Mergeds['valorbaixa'];
                                                }
                                            }//if ($merged->Movement_id == $value->id)

                                        endforeach;
                                        $totalDebitosFuturoD += $value->valor - $valorpago;

                                    } else {
                                        $totalDebitosFuturoD += $value->valor;
                                    }//if ($value->status == 'P')

                                endforeach;

                            }//if ($debitos_future)

                            if ($debitosFuturosD > 0) {
                                echo $this->Number->precision($totalDebitosFuturoD, 2).' ('.$debitosFuturosD.')';
                            } else {
                                echo '-';
                            }//else if ($debitosFuturosD > 0)
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>