<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Pages */
/* File: src/Template/Pages/saldos_bancarios.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
        <?php 
        if (!empty($saldos)) { ?>
            <div class="row">
                <div class="box panel panel-default box-shadow" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold">
                            <i class="fa fa-university"></i>
                            <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
                                <?= __('Saldos de Bancos e Caixas') ?>
                            <?php } elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) { ?>
                                <?= __('Saldos de Bancos e Carteiras') ?>
                            <?php }//elseif ($this->request->Session()->read('sessionPlan') == 1 || $this->request->Session()->read('sessionPlan') == 4) ?>
                            *
                        </span>
                        <h5><small>(*) Saldos atualizados em <?= date("d/m/Y");?></small></h5>
                    </div>

                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left"><?= __('Descrição') ?></th>
                                        <th class="text-right"><?= __('Valor') ?></th>
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
                                                        echo ('<i class="fa fa-university"></i> '.$balance->Banks['title']);
                                                    }
                                                    elseif (!empty($balance->boxes_id)) { 
                                                        echo ('<i class="fa fa-money"></i> '.$balance->Boxes['title']);
                                                    }
                                                ?>
                                                </th>
                                                <td class="text-right"> 
                                                <?php 
                                                    echo $this->Number->precision($balance->value, 2); 
                                                    if (empty($balance->cards_id)) {
                                                        $saldo_total += $balance->value; 
                                                    }
                                                ?>
                                                </td>
                                            </tr>
                                    <?php }
                                    endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray">
                                        <th>SALDO TOTAL</th>
                                        <th class="text-right">
                                            <?= $this->Number->precision($saldo_total, 2) ?>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            
            foreach ($saldos as $balance): 
                if (isset($balance->plannings_id)) {
                    $plannings_id = true;
                }//if (isset($balance->plannings_id))
            endforeach;
            
        }//if (!empty($saldos)) { 
        else {
            echo '<h4 class="text-center">Não há registros.</h4>';
        } 
        ?>
        
    </div>
</div>