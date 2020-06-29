<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>

<?php 
    $this->layout = 'layout-clean';
?>

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('DESPESAS A PAGAR - POR PLANO DE CONTAS - SINTÉTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviments'); ?>
        <?php
        if (empty($moviments)) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else {
            $total = 0;
            ?>
    </div>
            <table class="col-xs-12 table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                        <th class="text-left text-nowrap col-xs-1"><?= __('Conta') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor do Título') ?></th>
                    </tr>
                </thead>
                <tbody>   
                    <?php 
                    foreach ($moviments as $index => $value):
                        if ($value['creditodebito'] == 'D') {
                            if ($value['status'] == 'A' || //ABERTO
                               $value['status'] == 'P' || //PARCIAL
                               $value['status'] == 'G') {  //AGRUPADO
                                $accountPlan_id[$index]    = $value['AccountPlans']['id'];
                                $accountPlan_title[$index] = $value['AccountPlans']['title'];
                                $accountPlan_order[$index] = $value['AccountPlans']['order'];
                            }
                        }
                    endforeach;
                    
                    if (!empty($accountPlan_id)) {
                        foreach (array_unique($accountPlan_title) as $index => $value):
                            $soma = 0;
                                ?>
                                <tr>
                                    <td class="text-left text-nowrap col-xs-1"><?= $accountPlan_order[$index] ?></td>
                                    <td class="text-left text-nowrap col-xs-1"><?= $accountPlan_title[$index] ?></td>
                                    <?php
                                        foreach ($moviments as $moviment): 
                                            //LOCALIZA PAGAMENTOS PARCIAIS
                                            $valorpago = 0;
                                            if (isset($movimentMergeds)) {
                                               foreach ($movimentMergeds as $merged):
                                                    if ($merged['moviments_id'] == $moviment['id']) { //TÍTULOS COM VINCULADOS
                                                        if ($merged->Moviments['status'] == 'B' || //BAIXADO
                                                           $merged->Moviments['status'] == 'O') {  //BAIXA PARCIAL
                                                            $valorpago += $merged->Moviments['valorbaixa'];
                                                        }
                                                    } 
                                                endforeach; 
                                            }
                                            
                                            if ($moviment['account_plans_id'] == $accountPlan_id[$index] && 
                                               $moviment['creditodebito'] == 'D') {
                                                if ($moviment['status'] == 'A' || 
                                                   $moviment['status'] == 'P' || //PARCIAL
                                                   $moviment['status'] == 'G') {  //AGRUPADO
                                                    $soma += $moviment['valor'] - $valorpago;
                                                }
                                            }
                                        endforeach;
                                    ?>
                                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($soma, 'BRL'); $total += $soma; ?></td>
                                </tr>
                                <?php
                        endforeach;
                    } else {
                        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
                    }
                ?> 
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <th colspan="2"><?= __('TOTAIS') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($total, 'BRL') ?></th>
                    </tr>
                </tfoot>
            </table>
            <?php
        } //if (empty($moviments)) ?>
</div>
<?= $this->element('report-footer'); ?>