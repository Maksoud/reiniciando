<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Balances */
/* File: src/Template/Balances/check_balance_boxes.ctp */
?>

<?php $this->layout = 'ajax'; ?>

    <div class="container-fluid">

        <div class="col-xs-12 col-md-12 col-sm-12 container top-20">

            <div class="col-xs-12 panel" style="float: none;">
                <h3 class="page-header top-20"><?= __('Relatório de Movimentos de Caixas e Balanços') ?></h3>
            </div>

            <?php
            foreach ($mov_bal_boxes as $parameters_id => $mov_bal_box): 

                //Lista de perfis
                foreach ($list_parameters as $parameter_id => $parameter_razao): 
                    if ($parameter_id == $parameters_id) { ?>
                        <div class="text-bold bg-primary padding-15"><?= __('Perfil: ') . $parameter_id . ' - ' . $parameter_razao; ?></div>
                        <?php 
                    }//if ($parameter_id == $parameters_id) 
                endforeach;
            
                foreach ($mov_bal_box as $index => $value): ?>

                    <div class="box bottom-20">
                        <?php 
                        //Lista de caixas
                        foreach ($list_boxes as $box_id => $box_title): 
                            if ($box_id == $index) { ?>
                                <div class="text-bold bg-gray"><?= __('Caixa: ') . $box_id . ' - ' . $box_title; ?></div>
                                <?php 
                            }//if ($box_id == $index) 
                        endforeach;
                        ?>
                        
                        <div class="box-body table-responsive" style="height:300px;">
                            <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
                                <thead>
                                    <tr>
                                        <th class="text-center col-xs-1"><?= __('Data') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Movimento') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Balanço') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($value as $idx => $val): ?>
                                        <tr class="initialism">
                                            <td class="text-center"><?= date("d/m/Y", strtotime($idx)) ?></td>
                                            <td class="text-right">
                                            <?php
                                                if (!empty($val['movimentBoxes'])) {
                                                    echo $this->Number->currency($val['movimentBoxes'], 'BRL');
                                                    $mval = (float) number_format(floatval($val['movimentBoxes']), 2, ".", "");
                                                } else {
                                                    echo '-';
                                                }//else if (!empty($val['movimentBoxes']))
                                            ?>
                                            </td>
                                            <td class="text-right">
                                            <?php
                                                if (!empty($val['balanceBoxes'])) {
                                                    echo $this->Number->currency($val['balanceBoxes'], 'BRL');
                                                    $bval = (float) number_format(floatval($val['balanceBoxes']), 2, ".", "");
                                                } else {
                                                    echo '-';
                                                }//else if (!empty($val['balanceBoxes']))
                                            ?>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                if (!empty($mval) && !empty($bval)) { 
                                                    if ($mval == $bval) { ?>
                                                        <span class="label label-success"><?= __('OK') ?></span>
                                                        <?php
                                                    } else { ?>
                                                        <span class="label label-danger"><?= __('Erro') ?></span>
                                                        <?php
                                                    }//else if ($mval == $bval)
                                                }//if (!empty($val['movimentBoxes']) && !empty($val['balanceBoxes']))
                                                ?>
                                            </td>
                                        </tr>
                                        <?php 
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <?php 
                endforeach; ?>
                <?php 
            endforeach; ?>

        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->