<div class="box panel panel-default box-shadow" style="padding:0;">
    <div class="panel-heading box-header" id="numero3" style="background-color: #fcf8e3">
        <span class="text-bold"><i class="fa fa-line-chart"></i> {{ __('Receitas x Despesas') }}*</span>
        <h5><small>(*) {{ __('Vencimentos contábeis em ') }}<?= date('Y'); ?>{{ __(', provisionando os Movementos recorrentes.') }}</small></h5>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus-square-o"></i>
            </button>
        </div>
    </div>
    <div class="box-body panel-body">
        <div class="text-center"><span class="text-bold">{{ __('Saúde Financeira ') }} <?= date('Y'); ?></span></div>
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
                            <td class="text-right" title="{{ __('Não considera transferências ou lançamentos que não estejam no CPR.') }}">{{ __('Orçado') }}</td>
                            <td class="text-right" title="{{ __('Despesas e Receitas contábeis que já foram finalizadas.') }}">{{ __('Realizado') }}</td>
                            <td class="text-right" title="{{ __('Despesas e Receitas que ainda não foram pagas.') }}">{{ __('Em aberto') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{{ __('RECEITAS') }}</th>
                            <th class="text-right"><label><?= $this->Number->precision($receitas_mes_orcado, 2); ?></label></th>
                            <th class="text-right"><label><?= $this->Number->precision($receitas_mes_realizado, 2); ?></label></th>
                            <th class="text-right"><label><?= $this->Number->precision($receitas_mes_aberto, 2); ?></label></th>
                        </tr>
                        <tr>
                            <th>{{ __('DESPESAS') }}</th>
                            <th class="text-right"><label><?= $this->Number->precision($despesas_mes_orcado, 2); ?></label></th>
                            <th class="text-right"><label><?= $this->Number->precision($despesas_mes_realizado, 2); ?></label></th>
                            <th class="text-right"><label><?= $this->Number->precision($despesas_mes_aberto, 2); ?></label></th>
                        </tr>
                        <tr style="color: #777;">
                            <th>{{ __('RESULTADOS') }}</th>
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