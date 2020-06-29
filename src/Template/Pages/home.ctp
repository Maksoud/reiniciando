<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig.
 *
 * All rights reserved - 2015-2019
 */

/* Pages */
/* File: src/Template/Pages/home.ctp */
?>

<?php //$this->layout = 'layout-full';?>
<?= $this->Html->script('Chart'); ?>

<!-- /////////////////////////////////////////////////////////////////////// -->

<div class="col-xs-12 panel">
    <div class="col-xs-12 col-sm-4 text-nowrap">
        <h4><?= __('Bem vindo(a),'); ?> <?= h($username); ?></h4>
    </div>
    <div class="col-xs-12 col-sm-4 text-nowrap text-right pull-right">
        <span style="color: #777777">
            <h4><?= $this->MyHtml->fullDate(date('Y-m-d')); ?> - <span id="timer"><?= date('H:i:s'); ?></span></h4>
        </span>
    </div>
</div>

<!-- /////////////////////////////////////////////////////////////////////// -->

<div class="col-xs-12 col-sm-5">
    <?php 
    if (!empty($saldos)) { ?>
        <!-- SALDOS FINANCEIROS -->
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header" id="numero1" style="background-color: #d9edf7;">
                <?php 
                if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                    <span class="text-bold"><i class="fa fa-university"></i> <?= __('Saldos de Bancos e Caixas'); ?>*</span>
                    <?php
                } elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) { ?>
                    <span class="text-bold"><i class="fa fa-university"></i> <?= __('Saldos de Bancos e Carteiras'); ?>*</span>
                    <?php
                } //if ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) ?>
                <h5><small>(*) <?= __('Saldos atualizados em'); ?> <?= date('d/m/Y'); ?></small></h5>

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
                                <th class="text-left"><?= __('Descrição'); ?></th>
                                <th class="text-right col-xs-1"><?= __('Valor'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $saldo_total = 0;
                            foreach ($saldos as $balance):

                                if (!isset($balance->plannings_id) && !isset($balance->cards_id)) { ?>
                                    <tr>
                                        <th>
                                            <?php 
                                            if ($balance->banks_id < 10 && isset($balance->banks_id)) {
                                                $balance->banks_id = '0'.$balance->banks_id;
                                            }
                                            if ($balance->boxes_id < 10 && isset($balance->boxes_id)) {
                                                $balance->boxes_id = '0'.$balance->boxes_id;
                                            }
                                            if ($balance->id < 10 && isset($balance->id)) {
                                                $balance->id = '0'.$balance->id;
                                            }
                                            if (!empty($balance->banks_id)) {
                                                echo '<i class="fa fa-university"></i> '.$balance->Banks['title'];
                                            } elseif (!empty($balance->boxes_id)) {
                                                echo '<i class="fa fa-money"></i> '.$balance->Boxes['title'];
                                            } ?>
                                        </th>
                                        <td class="text-right"> 
                                            <?php 
                                            echo $this->Number->precision($balance->value, 2);
                                            if (empty($balance->cards_id)) {
                                                $saldo_total += $balance->value;
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }//if (!isset($balance->plannings_id) && !isset($balance->cards_id))

                            endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray">
                                <?php 
                                if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                                    <th><?= __('SALDO TOTAL'); ?> - <small><?= __('Bancos e Caixas'); ?></small></th>
                                    <?php
                                } elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) { ?>
                                    <th><?= __('SALDO TOTAL'); ?> - <small><?= __('Bancos e Carteiras'); ?></small></th>
                                    <?php
                                } //if ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4)?>
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
    }//if (!empty($saldos)) ?>
    
    <!-- /////////////////////////////////////////////////////////////////// -->
    <?php 
    if ($this->request->Session()->read('sessionPlan') != 4) {
            
        foreach ($saldos as $balance):
            if (isset($balance->cards_id)) {
                $cards = true;
            }//if (isset($balance->cards_id))
        endforeach;
        
        if (!empty($cards)) { ?>
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" id="numero1" style="background-color: #d9edf7;">
                    <span class="text-bold"><i class="fa fa-credit-card-alt"></i> <?= __('Limite de Cartões'); ?>*</span>
                    <h5><small>(*) <?= __('Saldos atualizados em'); ?> <?= date('d/m/Y'); ?></small></h5>

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
                                    <th class="text-left"><?= __('Descrição'); ?></th>
                                    <th class="text-center col-xs-1"><?= __('Limite'); ?></th>
                                    <th class="text-center col-xs-1"><?= __('Utilizado'); ?></th>
                                    <th class="text-right col-xs-1"><?= __('Disponível'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $saldo_total = $saldo_disponivel = $saldo_utilizado = 0.00;
                                foreach ($saldos as $balance):

                                    if (isset($balance->cards_id)) { ?>
                                        <tr>
                                            <th class="text-nowrap">
                                                <?php
                                                if ($balance->id < 10 && isset($balance->id)) {
                                                    $balance->id = '0'.$balance->id;
                                                } elseif (!empty($balance->cards_id)) {
                                                    echo $balance->Cards['title'];
                                                }
                                                $uso = $balance->Cards['limite'] - $balance->value;
                                                $saldo_utilizado += $uso; ?>
                                            </th>
                                            <td class="text-right">
                                                <?= $this->Number->precision($balance->Cards['limite'], 2); ?>
                                            </td>
                                            <td class="text-right">
                                                <!-- LIMITE DO CARTÃO UTILIZADO -->
                                                <?= $this->Number->toPercentage(($uso / $balance->Cards['limite']) * 100); ?>
                                            </td>
                                            <td class="text-right">
                                                <?= $this->Number->precision($balance->value, 2); ?>
                                                <?php $saldo_disponivel += $balance->value; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }//if (isset($balance->cards_id))

                                endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray">
                                    <th colspan="3"><?= __('CRÉDITO DISPONÍVEL'); ?></th>
                                    <th class="text-right">
                                        <?= $this->Number->precision($saldo_disponivel, 2); ?>
                                    </th>
                                </tr>
                                <tr class="bg-gray">
                                    <th colspan="3"><?= __('CRÉDITO UTILIZADO'); ?></th>
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
        } //(!empty($cards)) ?>
    
        <!-- /////////////////////////////////////////////////////////////////// -->
    
        <?php 
        foreach ($saldos as $balance):
            if (isset($balance->plannings_id)) {
                $plannings_id = true;
            }//if (isset($balance->plannings_id))
        endforeach;
        
        if (!empty($plannings->toArray())) { ?>
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <div class="panel-heading box-header" id="numero1">
                    <span class="text-bold"><i class="fa fa-trophy"></i> <?= __('Progresso dos Planejamentos'); ?></span>

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
                                    <th class="text-left"><?= __('Descrição'); ?></th>
                                    <th class="text-right"><?= __('Planejamento'); ?></th>
                                    <th class="text-center"><?= __('Progresso'); ?></th>
                                    <th class="text-right text-nowrap"><?= __('Total Poupado'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $saldo_total = $vlr_total = 0;

                                if (!empty($plannings->toArray())) {
                                    
                                    foreach ($plannings as $planning):

                                        if (!empty($balance_plannings->toArray())) {

                                            //CALCULA O PERCENTUAL DE PAGAMENTO
                                            foreach ($balance_plannings as $balance):
        
                                                if ($balance->plannings_id == $planning->id) {
                                                    $concluido = round((($balance->value / ($planning->valor * $planning->parcelas)) * 100));
                                                    $vlr_total += $balance->value;
                                                }//if ($balance->plannings_id == $planning->id)
        
                                            endforeach;
        
                                            if (!isset($concluido)) {
                                                $concluido = 0.00;
                                            }//if (!isset($concluido))
        
                                            // IDENTIFICA O ÚLTIMO VENCIMENTO NOS MOVIMENTOS
                                            $vencimento = null;
        
                                            if ($vencimento < $planning->Moviments['vencimento']) {
                                                $vencimento = $planning->Moviments['vencimento'];
                                            }//if ($vencimento < $planning->Moviments->vencimento) ?>
                                            
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
                                        }//if (!empty($balance_plannings->toArray())) {

                                    endforeach;

                                }//if (!empty($plannings->toArray()))
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray">
                                    <th colspan="3"><?= __('TOTAL POUPADO'); ?> </th>
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
        } //if (!empty($plannings->toArray()))?>
    
    <?php
    }//if ($this->request->Session()->read('sessionPlan') != 4)?>

    <!-- /////////////////////////////////////////////////////////////////// -->
    
    <div class="box panel panel-default box-shadow" style="padding:0;">
        <div class="panel-heading box-header" id="numero2" style="background-color: #fcf8e3">
            <span class="text-bold"><i class="fa fa-list-ul"></i> <?= __('Extratos Financeiros'); ?>*</span>
            <h5><small>(*) <?= __('Com vencimento até'); ?> <?= utf8_encode(strftime('%B de %Y', strtotime('today'))); ?></small></h5>

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
                            <?= __('Em Atraso'); ?>
                        </th>
                        <th class="text-center text-nowrap">
                            <?= __('Hoje'); ?>
                        </th>
                        <th class="text-center text-nowrap">
                            <?= __('A Vencer'); ?>
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

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

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

                                            foreach ($movimentMergeds as $merged):

                                                    if ($merged->moviments_id == $value->id) {
                                                        if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                            $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                        }
                                                    }//if ($merged->moviments_id == $value->id)

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
                                            
                                            foreach ($movimentMergeds as $merged):
                                                
                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

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

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

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

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

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

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

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

</div>

<!-- /////////////////////////////////////////////////////////////////////// -->

<div class="col-xs-12 col-sm-4">
    <div class="box panel panel-default box-shadow" style="padding:0;">
        <div class="panel-heading box-header" id="numero3" style="background-color: #fcf8e3">
            <span class="text-bold"><i class="fa fa-line-chart"></i> <?= __('Receitas x Despesas'); ?>*</span>
            <h5><small>(*) <?= __('Vencimentos contábeis em '); ?><?= date('Y'); ?><?= __(', provisionando os movimentos recorrentes.'); ?></small></h5>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus-square-o"></i>
                </button>
            </div>
        </div>
        <div class="box-body panel-body">
            <div class="text-center"><span class="text-bold"><?= __('Saúde Financeira ').(date('Y')); ?></span></div>
            <div class="progress" style="background-color: #777777">
                <?php 
                    //APRESENTA MENSAGEM
                    if ($saude_media_ano < 0) {
                        $saude_media_ano = $saude_media_ano * -1;
                        echo "<div class='progress-bar progress-bar-danger' title='".__('Média Anual')."' style='width:".$saude_media_ano."%; max-width: 100%;'><span align='center'>".$saude_media_ano.'%</span></div>';
                    } elseif ($saude_media_ano >= 0 && $saude_media_ano <= 20) {
                        echo "<div class='progress-bar progress-bar-warning' title='".__('Média Anual')."' style='width:".$saude_media_ano."%; max-width: 100%;'><span align='center'>".$saude_media_ano.'%</span></div>';
                    } elseif ($saude_media_ano > 20) {
                        echo "<div class='progress-bar progress-bar-info' title='".__('Média Anual')."' style='width:".$saude_media_ano."%; max-width: 100%;'><span align='center'>".$saude_media_ano.'%</span></div>';
                    }
                ?>
            </div>
            
            <!-- GRÁFICO -->
            <div class="top-10 panel">
                <canvas id="myChart" width="386" height="275"></canvas>
            </div>
            <!-- GRÁFICO -->
            
            <script>
                var ctx = document.getElementById("myChart");
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ["Janeiro", 
                                 "Fevereiro", 
                                 "Março", 
                                 "Abril", 
                                 "Maio", 
                                 "Junho", 
                                 "Julho", 
                                 "Agosto", 
                                 "Setembro", 
                                 "Outubro", 
                                 "Novembro", 
                                 "Dezembro"],
                        datasets: [{
                            label: "Realizado",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "rgba(75,192,192,0.4)",
                            borderColor: "rgba(75,192,192,1)",
                            borderCapStyle: 'butt',
                            borderDash: [],
                            borderDashOffset: 0.0,
                            borderJoinStyle: 'miter',
                            pointBorderColor: "rgba(75,192,192,1)",
                            pointBackgroundColor: "#fff",
                            pointBorderWidth: 1,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(75,192,192,1)",
                            pointHoverBorderColor: "rgba(220,220,220,1)",
                            pointHoverBorderWidth: 2,
                            pointRadius: 1,
                            pointHitRadius: 10,
                            data: [<?= implode(', ', $saude_realizado); ?>]
                        },{
                            label: "Orçado",
                            backgroundColor: "rgba(179,181,198,0.2)",
                            borderColor: "rgba(179,181,198,1)",
                            pointBackgroundColor: "rgba(179,181,198,1)",
                            pointBorderColor: "#fff",
                            pointHoverBackgroundColor: "#fff",
                            pointHoverBorderColor: "rgba(179,181,198,1)",
                            data: [<?= implode(', ', $saude_orcado); ?>]
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    max: 100,
                                    min: -100
                                }
                            }]
                        }
                    }
                });
            </script>
            <!-- GRÁFICO -->
            
            <div class="col-xs-12 no-padding-lat bottom-0 font-9">
                <div class="table-responsive">
                    <table class="table no-margin table-condensed">
                        <thead>
                            <tr>
                                <th class="text-nowrap"><?= $this->MyHtml->mesPorExtenso(date('m')).' de '.date('Y'); ?></th>
                                <td class="text-right" title="<?= __('Não considera transferências ou lançamentos que não estejam no CPR.'); ?>"><?= __('Orçado') ?></td>
                                <td class="text-right" title="<?= __('Despesas e Receitas contábeis que já foram finalizadas.'); ?>"><?= __('Realizado') ?></td>
                                <td class="text-right" title="<?= __('Despesas e Receitas que ainda não foram pagas.'); ?>"><?= __('Em aberto') ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?= __('RECEITAS'); ?></th>
                                <th class="text-right"><label><?= $this->Number->precision($receitas_mes_orcado, 2); ?></label></th>
                                <th class="text-right"><label><?= $this->Number->precision($receitas_mes_realizado, 2); ?></label></th>
                                <th class="text-right"><label><?= $this->Number->precision($receitas_mes_aberto, 2); ?></label></th>
                            </tr>
                            <tr>
                                <th><?= __('DESPESAS'); ?></th>
                                <th class="text-right"><label><?= $this->Number->precision($despesas_mes_orcado, 2); ?></label></th>
                                <th class="text-right"><label><?= $this->Number->precision($despesas_mes_realizado, 2); ?></label></th>
                                <th class="text-right"><label><?= $this->Number->precision($despesas_mes_aberto, 2); ?></label></th>
                            </tr>
                            <tr style="color: #777;">
                                <th><?= __('RESULTADOS'); ?></th>
                                <th class="text-right" title="<?= $this->Number->precision($receitas_mes_orcado - $despesas_mes_orcado, 2); ?>"><?= $per_orcado; ?>%</th>
                                <th class="text-right" title="<?= $this->Number->precision($receitas_mes_realizado - $despesas_mes_realizado, 2); ?>"><?= $per_realizado; ?>%</th>
                                <th class="text-right" title="<?= $this->Number->precision($receitas_mes_aberto - $despesas_mes_aberto, 2); ?>"><?= $per_aberto; ?>%</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                
        </div>
    </div>
    
    <!-- /////////////////////////////////////////////////////////////////// -->
    
    <?php 
    if (!empty($faturas_cartoes->toArray())) { ?>
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header" style="background-color: #fcf8e3">
                <span class="text-bold"><?= __('Faturas dos Cartões de Crédito'); ?>**</span>
                <h5>
                    <small>(*) <?= __('Vencimentos até'); ?> <?= date('t/m/Y', strtotime('+ 60 days')); ?></small><br/>
                    <small>(**) <?= __('Títulos recorrentes são gerados após o vencimento.'); ?></small>
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
                                <th class="text-left"><?= __('Cartão'); ?></th>
                                <th class="text-left col-xs-1"><?= __('Venc.'); ?></th>
                                <th class="text-center col-xs-1"><?= __('Valor'); ?></th>
                                <th class="text-center col-xs-1"><?= __('Ações'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            foreach ($faturas_cartoes as $fatura):

                                //Valor da fatura
                                $valor = $fatura->valor;
                                
                                //ANALISA BAIXAS PARCIAIS
                                if ($movimentMergeds->toArray()) {

                                    foreach ($movimentMergeds as $movimentMerged):

                                        if ($movimentMerged->moviments_id == $fatura->id) {
                                            if ($movimentMerged->Moviment_Mergeds['status'] == 'O' || $movimentMerged->Moviment_Mergeds['status'] == 'B') {
                                                //Deduz o valor pago parcial
                                                $valor -= $movimentMerged->Moviment_Mergeds['valorbaixa'];
                                            }
                                        }//else if ($movimentMerged->moviments_id == $fatura->id)

                                    endforeach;

                                }//if ($movimentMergeds)
                                ?>
                                <tr>
                                    <td class="text-left"><?= $fatura->Cards['title']; ?></td>
                                    <td class="text-left"><?= date('d/m', strtotime($fatura->vencimento)); ?></td>
                                    <td class="text-right"><?= $this->Number->precision($valor, 2); ?></td>
                                    <td class="btn-actions-group">
                                        <?php 
                                        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                                            <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                            <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                            <?php
                                        } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                                            <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                            <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                            <?php
                                        }//elseif ($this->request->Session()->read('sessionPlan') == 1)?>
                                    </td>
                                </tr>
                                <?php

                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }//if (!empty($faturas_cartoes->toArray())) ?>
    
    <!-- /////////////////////////////////////////////////////////////////// -->
    
    <?php 
    if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header" id="numero4">
                <span class="text-bold"><i class="fa fa-newspaper-o"></i> <?= __('Títulos por Plano de Contas'); ?>*</span>
                <h5><small>(*) <?= __('Vencimentos em '); ?><?= utf8_encode(strftime('%B de %Y', strtotime('today'))); ?></small></h5>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus-square-o"></i>
                    </button>
                </div>
            </div>
            <div class="box-body panel-body table-responsive" style="max-height: 277px;">
                <?php 

                foreach ($accountPlans as $index => $accountPlan):
                    if (strlen($accountPlan->classification) == 2) {
                        $classification[$index] = $accountPlan->classification;
                        $title[$index] = $accountPlan->title;
                    }//if (strlen($accountPlan->classification) == 2)
                endforeach;

                if (!empty($classification)) {

                    foreach ($classification as $index => $value):

                        $total[$index] = 0;
                        foreach ($accountPlans as $accountPlan):
                            $pos = strpos($accountPlan->classification, $value);
                            if ($accountPlan->valor > 0 && $pos === 0) {
                                $total[$index] += $accountPlan->valor;
                            }
                        endforeach;

                    endforeach;

                    foreach ($classification as $index => $value): ?>
                        <span class="text-bold"><?= mb_strtoupper($title[$index].' em aberto'); ?></span>
                        <span class="pull-right text-bold"><?= '  '.$this->Number->precision($total[$index], 2); ?></span>
                        <table class="table no-margin font-12" style="margin-bottom: 0">
                            <tbody>
                                <?php 
                                foreach ($accountPlans as $accountPlan):

                                    $pos = strpos($accountPlan->classification, $value);
                                    if ($accountPlan->valor > 0 && $pos === 0) { ?>
                                        <tr>
                                            <td>
                                                <?= $accountPlan->classification.' - '.$accountPlan->title; ?>
                                            </td>
                                            <td class="text-right"> <?= $this->Number->precision($accountPlan->valor, 2); ?></td>
                                        </tr>
                                        <?php
                                    }//if ($accountPlan->valor > 0 && $pos === 0)

                                endforeach; ?>
                            </tbody>
                        </table>
                        <?php
                    endforeach;

                }//if (!empty($classification)) ?>
            </div>
        </div>
        <?php
    }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)?>
    
    <!-- /////////////////////////////////////////////////////////////////// -->
    
    <?php 
    if ($plannings->toArray()) { ?>
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header" style="background-color: #fcf8e3">
                <span class="text-bold"><?= __('Planejamentos & Metas'); ?>*</span>
                <h5><small>(*) <?= __('Vencimentos até'); ?> <?= date('t/m/Y', strtotime('+ 60 days')); ?></small></h5>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus-square-o"></i>
                    </button>
                </div>
            </div>
            <?php 
            if (!empty($moviment_plannings->toArray())) { ?>
                <div class="box-body panel-body">
                    <div class="table-responsive" style="max-height: 300px; overflow-x: hidden;">
                        <table class="table no-margin font-12" style="margin-bottom: 0;">
                            <thead>
                                <tr>
                                    <th class="text-left"><?= __('Data'); ?></th>
                                    <th class="text-left"><?= __('Descrição'); ?></th>
                                    <th class="text-center"><?= __('Valor'); ?></th>
                                    <th class="text-center col-xs-1"><?= __('Ações'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($moviment_plannings as $mov_planning): ?>
                                    <tr>
                                        <td><?= date('d/m', strtotime($mov_planning->vencimento)); ?></td>
                                        <td><?= $mov_planning->historico; ?></td>
                                        <td class="text-right"><?= $this->Number->precision($mov_planning->valor, 2); ?></td>
                                        <td class="btn-actions-group">
                                            <?php 
                                            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?php
                                            } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $mov_planning->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?php
                                            }//elseif ($this->request->Session()->read('sessionPlan') == 1)?>
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
                    <h5><small><?= __('Todos os lançamentos para este período já foram pagos') ?></small></h5>
                </div>
                <?php
            }//else if (!empty($moviment_plannings->toArray())) ?>
        </div>
    <?php
    }//if ($plannings->toArray()) ?>
</div>

<!-- /////////////////////////////////////////////////////////////////////// -->

<div class="col-xs-12 col-sm-3 pull-right">
    
    <?php 
    if (!empty($knowledges)) {
        ?>
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header" id="numero6" style="background-color: #dff0d8;">
                <span class="text-bold"><i class="fa fa-bell-o"></i> <?= __('Você Sabia?'); ?></span>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus-square-o"></i>
                    </button>
                </div>
            </div>
            <div class="box-body panel-body"><!--  style="color: #777;" -->
                <div class="table-responsive no-margin text-justify font-10" style="border:0;">
                    <?= '"'.$knowledges.'"'; ?>
                </div>
            </div>
        </div>
        <?php
    }//if (!empty($knowledges)) ?>
    
    <!-- /////////////////////////////////////////////////////////////////// -->
    
    <div class="box panel panel-default box-shadow" style="padding:0;">
        <div class="panel-heading box-header" id="numero5" style="background-color:#fcf8e3">
            <span class="text-bold"><i class="fa fa-bolt"></i> <?= __('Atalhos'); ?></span>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus-square-o"></i>
                </button>
            </div>
        </div>
        <div class="box-body panel-group bottom-0" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <?= $this->Html->link(__(' Lançamentos'), '#collapseOne', ['class' => 'btn fa fa-list-ul fa-fw font-14', 'style' => 'width:100%;height:100%;', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseOne', 'aria-expanded' => true, 'aria-controls' => 'collapseOne', 'escape' => false]); ?>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <ul class="list-unstyled top_profiles scroll-view">
                        <?php 
                        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CONTAS P/R'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Conta a Pagar/Receber'), 'title' => __('Incluir Registro')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos Financeiros'), 'title' => __('Movimentos Financeiros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CAIXAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBoxes', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Movimento de Caixa'), 'title' => __('Incluir Registro')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBoxes', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBoxes', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Caixa'), 'title' => __('Movimentos de Caixa')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('BANCOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBanks', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Movimento de Banco'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBanks', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBanks', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Banco'), 'title' => 'Movimentos de Banco']); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CHEQUES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentChecks', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentChecks', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Cheques'), 'title' => __('Movimentos de Cheques')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTÕES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Novo Movimento de Cartões', 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Cartões'), 'title' => __('Movimentos de Cartões')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('TRANSFERÊNCIAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Nova Transferência', 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'report_form'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Transferência'), 'title' => __('Movimentos de Transferências')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('PLANEJAMENTOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Plannings', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Incluir Registros'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Plannings', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('REL. DE PAGAMENTOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'report_rp'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => 'Relatório - Relação de Pagamentos', 'title' => __('Relação de Pagamentos')]); ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CONTAS P/R'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Conta a Pagar/Receber'), 'title' => __('Incluir Registro')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos Financeiros'), 'title' => __('Movimentos Financeiros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTEIRAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBoxes', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Movimento de Carteira'), 'title' => __('Incluir Registro')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBoxes', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBoxes', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Carteira'), 'title' => __('Movimentos de Carteira')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('BANCOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBanks', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Movimento de Banco'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBanks', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentBanks', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Banco'), 'title' => 'Movimentos de Banco']); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTÕES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Novo Movimento de Cartões', 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Cartões'), 'title' => __('Movimentos de Cartões')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('TRANSFERÊNCIAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Nova Transferência', 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Transferência'), 'title' => __('Movimentos de Transferências')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('PLANEJAMENTOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Plannings', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Incluir Registros'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Plannings', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CONTAS P/R'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Conta a Pagar/Receber'), 'title' => __('Incluir Registro')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Moviments', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'btn btn-actions btn_modal fa fa-usd', 'title' => __('Disponível na versão completa'), 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos Financeiros'), 'title' => __('Movimentos Financeiros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTÕES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => 'Novo Movimento de Cartões', 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'MovimentCards', 'action' => 'report_form_simple'], ['class' => 'btn btn-actions btn_modal fa fa-file-text-o', 'data-loading-text' => '', 'data-title' => __('Relatório - Movimentos de Cartões'), 'title' => __('Movimentos de Cartões')]); ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }//elseif ($this->request->Session()->read('sessionPlan') == 4)?>
                    </ul>
                </div>
            </div>

            <div class="panel panel-default top-0">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <?= $this->Html->link(__(' Cadastros'), '#collapseTwo', ['class' => 'btn collapsed fa fa-pencil-square-o fa-fw font-14', 'style' => 'width:100%;height:100%;', 'style' => 'width:100%;height:100%;', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseTwo', 'aria-expanded' => false, 'aria-controls' => 'collapseTwo', 'escape' => false]); ?>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <ul class="list-unstyled top_profiles scroll-view">
                        <?php 
                        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('FORNECEDORES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Providers', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Fornecedor'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Providers', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CLIENTES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Cliente'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Customers', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('BANCOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Banks', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Banco'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Banks', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CAIXAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Boxes', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Caixa'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Boxes', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTÕES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Cards', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Cartão'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Cards', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('P. CONTAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'AccountPlans', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Plano de Contas'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'AccountPlans', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('C. CUSTOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Costs', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Centro de Custos'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Costs', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('T. DOCUMENTOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'DocumentTypes', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Tipo de Documento'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'DocumentTypes', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('T. EVENTOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'EventTypes', 'action' => 'add'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Tipo de Evento'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'EventTypes', 'action' => 'index'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('BANCOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Banks', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Banco'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Banks', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTEIRAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Boxes', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Nova Carteira'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Boxes', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTÕES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Cards', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Cartão'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Cards', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CATEGORIAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Costs', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Centro de Custos'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTEIRAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Boxes', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Nova Carteira'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Boxes', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('BANCOS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Banks', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Banco'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Banks', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CARTÕES'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Cards', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-size' => 'sm', 'data-title' => __('Novo Cartão'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Cards', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <li class="media event">
                                <a class="pull-left border-blue profile_thumb">
                                    <i class="fa fa-folder-open-o blue"></i>
                                </a>
                                <div class="row media-body">
                                    <div class="media-title"><?= __('CATEGORIAS'); ?></div>
                                    <div>
                                        <?= $this->Html->link('', ['controller' => 'Costs', 'action' => 'add_simple'], ['class' => 'btn btn-actions btn_modal fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Centro de Custos'), 'title' => __('Incluir Registros')]); ?>
                                        <?= $this->Html->link('', ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'btn btn-actions fa fa-search', 'data-loading-text' => '', 'title' => __('Listar Registros')]); ?>
                                    </div>
                                </div>
                            </li>
                            <?php
                        }//elseif ($this->request->Session()->read('sessionPlan') == 4)?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
</div>

<!-- /////////////////////////////////////////////////////////////////////// -->

<?php 
if ($transfers) { ?>
    <div class="col-xs-12">
        <div class="box panel panel-default box-shadow" style="padding:0;">
        <div class="panel-heading box-header">
            <span class="text-bold"><i class="fa fa-clock-o"></i> <?= __('Transferências Programadas'); ?></span>
            <h5><small><?= __('Agendamentos de Resgates/Aplicações (Transferências)'); ?></small></h5>

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
                            <th class="text-left col-xs-1"><?= __('Ordem'); ?></th>
                            <th class="text-left col-xs-1"><?= __('Programação'); ?></th>
                            <th class="text-left"><?= __('Histórico'); ?></th>
                            <th class="text-left col-xs-1"><?= __('Origem'); ?></th>
                            <th class="text-left col-xs-1"><?= __('Destino'); ?></th>
                            <th></th>
                            <th class="text-center"><?= __('Valor'); ?></th>
                            <th class="text-center col-xs-1"><?= __('Ações'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($transfers as $transfer): ?>
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
                                    if (isset($transfer->banks_id)) {
                                        echo $transfer->Banks['title'];
                                    }//if (isset($transfer->banks_id))
                                    if (isset($transfer->boxes_id)) {
                                        echo $transfer->Boxes['title'];
                                    }//if (isset($transfer->boxes_id)) ?>
                                </td>
                                <td class="text-left">
                                    <?php
                                    if (isset($transfer->banks_dest)) {
                                        echo $transfer->BankDest['title'];
                                    }//if (isset($transfer->banks_dest))
                                    if (isset($transfer->boxes_dest)) {
                                        echo $transfer->BoxDest['title'];
                                    }//if (isset($transfer->boxes_dest)) ?>
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
                                    <?php 
                                    if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'view', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                        <?php 
                                        if ($transfer->status == 'P') { ?>
                                            <?= $this->Form->postLink('', ['controller' => 'Transfers', 'action' => 'confirm', $transfer->id], ['confirm' => __('Você tem certeza que deseja confimar a transferência na data programada?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => __('Carregando...'), 'title' => 'Confirmar']); ?>
                                            <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'edit', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Editar')]); ?>
                                            <?php
                                        } else { ?>
                                            <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'edit_baixado', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Editar')]); ?>
                                            <?php
                                        }//else if ($transfer->status == 'P') ?>
                                        <?= $this->Form->postLink('', ['controller' => 'Transfers', 'action' => 'delete', $transfer->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                        <?php
                                    } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
                                        <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'view_simple', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                        <?php 
                                        if ($transfer->status == 'P') { ?>
                                            <?= $this->Form->postLink('', ['controller' => 'Transfers', 'action' => 'confirm', $transfer->id], ['confirm' => __('Você tem certeza que deseja confimar a transferência na data programada?'), 'class' => 'btn btn-actions fa fa-check', 'data-loading-text' => __('Carregando...'), 'title' => 'Confirmar']); ?>
                                            <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'edit_simple', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Editar')]); ?>
                                            <?php
                                        } else { ?>
                                            <?= $this->Html->link('', ['controller' => 'Transfers', 'action' => 'edit_baixado_simple', $transfer->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Editar')]); ?>
                                            <?php
                                        }//else if ($transfer->status == 'P') ?>
                                        <?= $this->Form->postLink('', ['controller' => 'Transfers', 'action' => 'delete', $transfer->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                        <?php
                                    }//elseif ($this->request->Session()->read('sessionPlan') == 1)?>
                                </td>
                            </tr>
                            <?php 
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-heading" style="font-size: 11px;">
            <span class="text-bold"><?= __('Legenda:'); ?></span><br />
            <span style="color: #ce8483"><?= __('Datas de Agendamentos Vencidos,'); ?> </span>
            <span style="color: #0a0"><?= __('Agendamentos que Vencem Hoje e'); ?> </span>
            <span style="color: #2aabd2"><?= __('Agendamentos a Vencer.'); ?></span>
        </div>
    </div>
    <?php
}//if ($transfers) ?>

<!-- /////////////////////////////////////////////////////////////////////// -->

<div class="col-xs-12" id="relacaoReceitas">
    <?php 
    $count = 0;
    if (isset($creditos)) {
        foreach ($creditos as $moviment):
            ++$count;
        endforeach;
    }//if (isset($creditos))
    if ($count > 0) { ?>
        <div class="box panel panel-default bg-info box-shadow" style="padding:0;">
            <div class="panel-heading box-header" style="background-color:  #d9edf7;">
                <span class="text-bold"><?= __('CONTAS A RECEBER').' ('.$count.')'; ?></span>
                <h5><small>(*) <?= __('Com vencimento até'); ?> <?= date('t/m/Y'); ?></small></h5>

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
                                <th class="text-left"><?= __('Ordem'); ?></th>
                                <th class="text-left"><?= __('Vencimento'); ?></th>
                                <?php 
                                if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo?>
                                    <th class="text-left"><?= __('Documento'); ?></th>
                                    <th class="text-left"><?= __('Cliente/Fornecedor'); ?></th>
                                    <?php
                                }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)?>
                                <th class="text-left"><?= __('Histórico'); ?></th>
                                <th class="text-right"><?= __('Valor'); ?></th>
                                <th class="text-center"></th>
                                <th class="text-center col-xs-1"><?= __('Status'); ?></th>
                                <th class="text-center col-xs-1"><?= __('Ações'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($creditos as $moviment): ?>
                                <tr>
                                    <td class="text-left"><?= ($moviment->ordem); ?></td>
                                    <td class="text-left">
                                        <?php 
                                        if ($moviment->vencimento < date('Y-m-d')) { ?>
                                            <span style="color: #ce8483">
                                                <?= date('d/m/Y', strtotime($moviment->vencimento)); ?>
                                            </span>    
                                            <?php
                                        } elseif ($moviment->vencimento > date('Y-m-d')) { ?>
                                            <span style="color: #2aabd2">
                                                <?= date('d/m/Y', strtotime($moviment->vencimento)); ?>
                                            </span>
                                            <?php
                                        } elseif ($moviment->vencimento == date('Y-m-d')) { ?>
                                            <span style="color: #0a0">
                                                <?= date('d/m/Y', strtotime($moviment->vencimento)); ?>
                                            </span>
                                            <?php
                                        }//elseif ($moviment->vencimento == date('Y-m-d')) ?>
                                    </td>
                                    <?php 
                                    if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo?>
                                        <td class="text-left"><?= ($moviment->documento); ?></td>
                                        <td class="text-left">
                                            <?= h($moviment->Providers['title']); ?>
                                            <?= h($moviment->Customers['title']); ?>
                                        </td>
                                        <?php
                                    }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)?>
                                    <td class="text-left"><?= ($moviment->historico); ?></td>
                                    <td class="text-right text-nowrap">
                                        <?php
                                        $valorpago = 0;
                                        if ($moviment->status == 'P') {
                                            if (!empty($movimentMergeds->toArray())) {
                                                foreach ($movimentMergeds as $merged):
                                                    if ($merged->moviments_id == $moviment->id) {
                                                        if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                            $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                        } else {
                                                            $valorpago += $merged->Moviment_Mergeds['valor'];
                                                        }
                                                    }//if ($merged->moviments_id == $moviment->id)
                                                endforeach;
                                            }//if (!empty($movimentMergeds->toArray()))
                                        }//if ($moviment->status == 'P')
                                        echo $this->Number->precision($moviment->valor - $valorpago, 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        if ($moviment->creditodebito == 'C') { ?>
                                            <i class="fa fa-plus-circle" style="color: lightblue" title="<?= __('Crédito'); ?>"></i>
                                            <?php
                                        } elseif ($moviment->creditodebito == 'D') { ?>
                                            <i class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito'); ?>"></i>
                                            <?php
                                        }//elseif ($moviment->creditodebito == 'D')

                                        //Lista os movimentos recorrentes
                                        if ($movimentRecurrents) {
                                            foreach ($movimentRecurrents as $movimentRecurrent):
                                                if ($moviment->id == $movimentRecurrent->id) { ?>
                                                    <i class="fa fa-repeat" style="color: lightblue" title="<?= __('Recorrente'); ?>"></i>
                                                    <?php
                                                }//if ($moviment->id == $movimentRecurrent->id)
                                            endforeach;
                                        }//if ($movimentRecurrents) ?>
                                    </td>
                                    <td class="text-center col-xs-1">
                                        <?php 
                                        switch ($moviment->status) {
                                            case 'A': echo __('Aberto'); break;
                                            case 'B': echo __('Baixado'); break;
                                            case 'C': echo __('Cancelado'); break;
                                            case 'G': echo __('Agrupado'); break;
                                            case 'V': echo __('Vinculado'); break;
                                            case 'O': echo __('B.Parcial'); break;
                                            case 'P': echo __('Parcial'); break;
                                        }//switch ($moviment->status) ?>
                                    </td>
                                    <td class="btn-actions-group">
                                        <?php 
                                        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { 
                                            if ($moviment->status == 'A') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?php 
                                                if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Agrupar Lançamentos'), 'title' => __('Agrupar'), 'escape' => false]); ?>
                                                    <?php
                                                }//if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) ?>
                                                <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'B') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]); ?>
                                                <?php
                                            }// elseif ($moviment->status == 'B')
                                            if ($moviment->status == 'C') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'C') {
                                            if ($moviment->status == 'V') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'O') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'O') 
                                            if ($moviment->status == 'P') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'P') 
                                            if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Agrupar Lançamentos'), 'title' => __('Agrupar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) 
                                        } elseif ($this->request->Session()->read('sessionPlan') == 1) { 
                                            if ($moviment->status == 'A') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'B') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'B')
                                            if ($moviment->status == 'C') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'C')
                                            if ($moviment->status == 'V') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'O') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'O')
                                            if ($moviment->status == 'P') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                            <?php
                                            }//if ($moviment->status == 'P')
                                            if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'G' && empty($moviment['cards_id']))
                                        } elseif ($this->request->Session()->read('sessionPlan') == 4) { 
                                            if ($moviment->status == 'A') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'B') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'B')
                                            if ($moviment->status == 'C') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'C')
                                            if ($moviment->status == 'V') {
                                                ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'O') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'O')
                                            if ($moviment->status == 'P') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'P')
                                            if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]); ?>
                                                <?php
                                            }//if ($moviment->status == 'G' && empty($moviment['cards_id']))
                                        }//elseif ($this->request->Session()->read('sessionPlan') == 4)?>
                                    </td>
                                </tr>
                                <?php 
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-heading" style="font-size: 11px;">
                <span class="text-bold"><?= __('Legenda:') ?></span><br />
                <span style="color: #ce8483"><?= __('Datas de Contas Vencidas,'); ?> </span>
                <span style="color: #0a0"><?= __('Contas que Vencem Hoje e'); ?> </span>
                <span style="color: #2aabd2"><?= __('Contas a Vencer.'); ?></span>
            </div>
        </div>
        <?php
    }//if ($count > 0) ?>
</div>
<br />

<!-- /////////////////////////////////////////////////////////////////////// -->

<br />
<div class="col-xs-12" id="relacaoDespesas">
    <?php 
    $count = 0;
    if (isset($debitos)) {
        foreach ($debitos as $moviment):
            ++$count;
        endforeach;
    }//if (isset($debitos))
    if ($count > 0) { ?>
        <div class="box panel panel-default bg-danger box-shadow" style="padding:0;">
            <div class="panel-heading box-header" style="background-color: #f2dede;">
                <span class="text-bold"><?= __('CONTAS A PAGAR').' ('.$count.')'; ?></span>
                <h5><small>(*) <?= __('Com vencimento até') ?> <?= date('t/m/Y'); ?></small></h5>

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
                                <th class="text-left col-xs-1"><?= __('Ordem'); ?></th>
                                <th class="text-left col-xs-1"><?= __('Vencimento'); ?></th>
                                <?php 
                                if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo?>
                                    <th class="text-left col-xs-1"><?= __('Documento'); ?></th>
                                    <th class="text-left"><?= __('Cliente/Fornecedor'); ?></th>
                                    <?php
                                }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)?>
                                <th class="text-left"><?= __('Histórico'); ?></th>
                                <th class="text-right"><?= __('Valor'); ?></th>
                                <th class="text-center"></th>
                                <th class="text-center"><?= __('Status'); ?></th>
                                <th class="text-center col-xs-1"><?= __('Ações'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($debitos as $moviment): ?>
                                <tr>
                                    <td class="text-left"><?= ($moviment->ordem); ?></td>
                                    <td class="text-left">
                                        <?php 
                                        if ($moviment->vencimento < date('Y-m-d')) { ?>
                                            <span style="color: #ce8483">
                                                <?= date('d/m/Y', strtotime($moviment->vencimento)); ?>
                                            </span>    
                                            <?php
                                        } elseif ($moviment->vencimento > date('Y-m-d')) { ?>
                                            <span style="color: #2aabd2">
                                                <?= date('d/m/Y', strtotime($moviment->vencimento)); ?>
                                            </span>
                                            <?php
                                        } elseif ($moviment->vencimento == date('Y-m-d')) { ?>
                                            <span style="color: #0a0">
                                                <?= date('d/m/Y', strtotime($moviment->vencimento)); ?>
                                            </span>
                                            <?php
                                        }//elseif ($moviment->vencimento == date('Y-m-d'))?>
                                    </td>
                                    <?php 
                                    if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo?>
                                        <td class="text-left"><?= ($moviment->documento); ?></td>
                                        <td class="text-left">
                                            <?= h($moviment->Providers['title']); ?>
                                            <?= h($moviment->Customers['title']); ?>
                                        </td>
                                        <?php
                                    }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3)?>
                                    <td class="text-left"><?= ($moviment->historico); ?></td>
                                    <td class="text-right text-nowrap">
                                        <?php
                                        $valorpago = 0;
                                        if ($moviment->status == 'P') {
                                            if (!empty($movimentMergeds->toArray())) {
                                                foreach ($movimentMergeds as $merged): 
                                                    if ($merged->moviments_id == $moviment->id) {
                                                        if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                            $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                        }
                                                    }//if ($merged->moviments_id == $moviment->id)
                                                endforeach;
                                            }//if (!empty($movimentMergeds->toArray()))
                                        }//if ($moviment->status == 'P')
                                        echo $this->Number->precision($moviment->valor - $valorpago, 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                        if ($moviment->creditodebito == 'C') { ?>
                                            <i class="fa fa-plus-circle" style="color: lightblue" title="<?= __('Crédito'); ?>"></i>
                                            <?php
                                        } elseif ($moviment->creditodebito == 'D') { ?>
                                            <i class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito'); ?>"></i>
                                            <?php
                                        }//elseif ($moviment->creditodebito == 'D')
                                        //Lista os movimentos recorrentes
                                        if ($movimentRecurrents) {
                                            foreach ($movimentRecurrents as $movimentRecurrent):
                                                if ($moviment->id == $movimentRecurrent->id) { ?>
                                                    <i class="fa fa-repeat" style="color: lightblue" title="<?= __('Recorrente'); ?>"></i>
                                                    <?php
                                                }//if ($moviment->id == $movimentRecurrent->id)
                                            endforeach;
                                        }//if ($movimentRecurrents) ?>
                                    </td>
                                    <td class="text-center col-xs-1">
                                        <?php if ($moviment->status == 'A') {
                                            echo __('Aberto');
                                        } ?>
                                        <?php if ($moviment->status == 'B') {
                                            echo __('Baixado');
                                        } ?>
                                        <?php if ($moviment->status == 'C') {
                                            echo __('Cancelado');
                                        } ?>
                                        <?php if ($moviment->status == 'G') {
                                            echo __('Agrupado');
                                        } ?>
                                        <?php if ($moviment->status == 'V') {
                                            echo __('Vinculado');
                                        } ?>
                                        <?php if ($moviment->status == 'O') {
                                            echo __('B.Parcial');
                                        } ?>
                                        <?php if ($moviment->status == 'P') {
                                            echo __('Parcial');
                                        } ?>
                                    </td>
                                    <td class="btn-actions-group">
                                        <?php 
                                        if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo 
                                            if ($moviment->status == 'A') { ?>
                                                <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?php 
                                                if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Agrupar Lançamentos'), 'title' => __('Agrupar')]); ?>
                                                    <?php
                                                }//if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id']))?>
                                                <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                                <?php
                                            } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'B') 
                                                if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                                <?php
                                            }//if ($moviment->status == 'C') 
                                                if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'O') 
                                                if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                    <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?php
                                            }//if ($moviment->status == 'P') 
                                            if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Agrupar Lançamentos'), 'title' => __('Agrupar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?php
                                            }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) 
                                        } elseif ($this->request->Session()->read('sessionPlan') == 1) { //Plano Simples 
                                            if ($moviment->status == 'A') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                                <?php
                                            } elseif ($moviment->status == 'B') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'B') 
                                            if ($moviment->status == 'C') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                                <?php
                                            }//if ($moviment->status == 'C')
                                            if ($moviment->status == 'V') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'O') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'O')
                                            if ($moviment->status == 'P') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?php
                                            }//if ($moviment->status == 'P') 
                                            if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?php
                                            }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) 
                                        } elseif ($this->request->Session()->read('sessionPlan') == 4) { //Plano Simples 
                                            if ($moviment->status == 'A') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                                <?php
                                            } elseif ($moviment->status == 'B') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'B') 
                                            if ($moviment->status == 'C') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']); ?>
                                                <?php
                                            }//if ($moviment->status == 'C') 
                                            if ($moviment->status == 'V') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?php
                                            } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]); ?>
                                                <?php
                                            }//elseif ($moviment->status == 'O') 
                                            if ($moviment->status == 'P') { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?php
                                            }//if ($moviment->status == 'P') 
                                            if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]); ?>
                                                <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]); ?>
                                                <?php
                                            }//if ($moviment->status == 'G' && empty($moviment['cards_id']))?>
                                            <?php
                                        }//elseif ($this->request->Session()->read('sessionPlan') == 4)?>
                                    </td>
                                </tr>
                            <?php 
                        endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-heading" style="font-size: 11px;">
                <span class="text-bold"><?= __('Legenda:') ?></span><br />
                <span style="color: #ce8483"><?= __('Datas de Contas Vencidas,'); ?> </span>
                <span style="color: #0a0"><?= __('Contas que Vencem Hoje e'); ?> </span>
                <span style="color: #2aabd2"><?= __('Contas a Vencer.'); ?></span>
            </div>
        </div>
        <?php
    }//if ($count > 0) ?>
</div>

<div class="col-xs-12 bottom-40">
    &nbsp;<!-- /////////////////////////////////////////////////////////////////// -->
</div>

<div class="pull-left">
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function() {
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/581b78fde808d60cd0786f70/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</div>

<!-- /////////////////////////////////////////////////////////////////////// -->

<!-- Tip Content -->
<?php 
if ($tutorial != '0') { ?>
    <form method="post" action="#">
        <ol id="joyRideTipContent">
            <?php 
            if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) {
                ?>
                <li data-id="numero1" data-class="so-awesome" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:right; tipAnimation:pop;" class="custom">
                    <h2><?= __('Saldos e Limites'); ?></h2>
                    <p><?= __('Aqui você visualiza os saldos dos bancos e caixas e limite dos cartões de créditos.'); ?></p>
                </li>
                <li data-id="numero2" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:right; tipAnimation:fade;">
                    <h2><?= __('Extratos Financeiros'); ?></h2>
                    <p><?= __('Aqui você encontra o resumo de suas receitas e despesas, subdivididas por vencimento.'); ?></p>
                </li>
                <li data-id="numero3" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Gráficos Finaceiros'); ?></h2>
                    <p><?= __('Aqui você encontra um resumo do ano, com informações sobre sua saúde financeira, cruzando os dados de receitas e despesas do período.'); ?></p>
                </li>
                <li data-id="numero4" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Resumo das Contas'); ?></h2>
                    <p><?= __('Aqui você encontra um resumo de suas receitas e despesas, agrupadas pelo Plano de Contas cadastrado.'); ?></p>
                </li>
                <li data-id="numero5" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Atalhos'); ?></h2>
                    <p><?= __('Aqui você encontra para efetuar Lançamentos e também listá-los, além de gerar Relatórios.'); ?></p>
                </li>
                <li data-id="numero6" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Dicas de Uso'); ?></h2>
                    <p><?= __('Aqui você encontra dicas aleatórias para um melhor proveito dos recursos disponibilizados no sistema.'); ?></p>
                </li>
                <li data-button="<?= __('Fechar'); ?>">
                    <h2><?= __('Bem Vindo!'); ?></h2>
                    <p><?= __('Você também poderá visualizar um resumo das faturas dos cartões de crédito, agendamentos de transferências e muito mais...'); ?></p>
                    <div style="float: left;">
                        <?= $this->Form->checkbox('dismiss', ['hiddenField' => false]); ?>
                        <label class="font-9"><?= __('Não exibir novamente'); ?> &nbsp;&nbsp;</label>
                    </div>
                </li>
                <?php
            } elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) { ?>
                <li data-id="numero1" data-class="so-awesome" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:right; tipAnimation:pop;" class="custom">
                    <h2><?= __('Saldos e Limites'); ?></h2>
                    <p><?= __('Aqui você visualiza os saldos dos bancos e carteiras e limite dos cartões de créditos.'); ?></p>
                </li>
                <li data-id="numero2" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:right; tipAnimation:fade;">
                    <h2><?= __('Extratos Financeiros'); ?></h2>
                    <p><?= __('Aqui você encontra o resumo de suas receitas e despesas, subdivididas por vencimento.'); ?></p>
                </li>
                <li data-id="numero3" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Gráficos Finaceiros'); ?></h2>
                    <p><?= __('Aqui você encontra um resumo do ano, com informações sobre sua saúde financeira, cruzando os dados de receitas e despesas do período.'); ?></p>
                </li>
                <li data-id="numero4" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Resumo das Contas'); ?></h2>
                    <p><?= __('Aqui você encontra um resumo de suas receitas e despesas, agrupadas pelo Plano de Contas cadastrado.'); ?></p>
                </li>
                <li data-id="numero5" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Atalhos'); ?></h2>
                    <p><?= __('Aqui você encontra para efetuar Lançamentos e também listá-los, além de gerar Relatórios.'); ?></p>
                </li>
                <li data-id="numero6" data-button="<?= __('Próximo'); ?>" data-options="tipLocation:left; tipAnimation:fade;">
                    <h2><?= __('Dicas de Uso'); ?></h2>
                    <p><?= __('Aqui você encontra dicas aleatórias para um melhor proveito dos recursos disponibilizados no sistema.'); ?></p>
                </li>
                <li data-button="<?= __('Fechar'); ?>">
                    <h2><?= __('Bem Vindo!'); ?></h2>
                    <p><?= __('Você também poderá visualizar um resumo das faturas dos cartões de crédito, agendamentos de transferências e muito mais...'); ?></p>
                    <div style="float: left;">
                        <?= $this->Form->checkbox('dismiss', ['hiddenField' => false]); ?>
                        <label class="font-9"><?= __('Não exibir novamente'); ?> &nbsp;&nbsp;</label>
                    </div>
                </li>
            <?php
            } //if ($this->request->Session()->read('sessionPlan') == 4)?>
        </ol>
    </form>
    <?php
}//if ($tutorial != '0') ?>