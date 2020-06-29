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
/* File: src/Template/Balances/check_balance_banks.ctp */
?>

<?php $this->layout = 'ajax'; ?>

    <div class="container-fluid">

        <div class="col-xs-12 col-md-12 col-sm-12 container top-20">

            <div class="col-xs-12 panel" style="float: none;">
                <h3 class="page-header top-20"><?= __('Relatório de Movimentos de Bancos e Balanços') ?></h3>
            </div>

            <?php
            foreach ($mov_bal_banks as $parameters_id => $mov_bal_bank): 

                //Lista de perfis
                foreach ($list_parameters as $parameter_id => $parameter_razao): 
                    if ($parameter_id == $parameters_id) { ?>
                        <div class="text-bold bg-primary padding-15"><?= __('Perfil: ') . $parameter_id . ' - ' . $parameter_razao; ?></div>
                        <?php 
                    }//if ($parameter_id == $parameters_id) 
                endforeach;
            
                foreach ($mov_bal_bank as $index => $value): ?>

                    <div class="box bottom-20">
                        <?php 
                        //Lista de bancos
                        foreach ($list_banks as $bank_id => $bank_title): 
                            if ($bank_id == $index) { ?>
                                <div class="text-bold bg-gray"><?= __('Banco: ') . $bank_id . ' - ' . $bank_title; ?></div>
                                <?php 
                            }//if ($bank_id == $index) 
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
                                                if (!empty($val['movimentBanks'])) {
                                                    echo $this->Number->currency($val['movimentBanks'], 'BRL');
                                                    $mval = (float) number_format(floatval($val['movimentBanks']), 2, ".", "");
                                                } else {
                                                    echo '-';
                                                }//else if (!empty($val['movimentBanks']))
                                            ?>
                                            </td>
                                            <td class="text-right">
                                            <?php
                                                if (!empty($val['balanceBanks'])) {
                                                    echo $this->Number->currency($val['balanceBanks'], 'BRL');
                                                    $bval = (float) number_format(floatval($val['balanceBanks']), 2, ".", "");
                                                } else {
                                                    echo '-';
                                                }//else if (!empty($val['balanceBanks']))
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
                                                }//if (!empty($val['movimentBanks']) && !empty($val['balanceBanks']))
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