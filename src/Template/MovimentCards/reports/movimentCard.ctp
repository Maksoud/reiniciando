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

<?php $this->layout = 'layout-clean'; ?>

<div class="col-xs-12 main">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('Movimentos de Cartão') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-moviment-cards'); ?>
	<?php
        if (empty($movimentCards->toArray())) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else {
	?>
    </div>
        <?php 
            foreach ($movimentCards as $index => $value) :
                $cardsid[$index]    = $value->cards_id;
                $cardstitle[$index] = $value->Cards['title'];
            endforeach;
			
            foreach (array_unique($cardsid) as $card => $cardid) : ?>
                <span class="text-bold"><?= $cardstitle[$card] ?></span>
                <?php 
                    $saldo = 0;
                ?>
                <div class="col-xs-12 no-padding-lat table-responsive">
                    <table class="table table-striped table-condensed prt-report">
                        <thead>
                            <tr class="bg-blue">
                                <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                                <th class="text-left text-nowrap col-xs-1"><?= __('Data') ?></th>
                                <th class="text-left text-nowrap col-xs-1"><?= __('Compra/Estorno') ?></th>
                                <th class="text-left text-nowrap col-xs-1"><?= __('Vencimento') ?></th>
                                <th class="text-left text-nowrap col-xs-1"><?= __('Cartão') ?></th>
                                <th class="text-left"><?= __('Descrição') ?></th>
                                <th class="text-center text-nowrap col-xs-1"><?= __('Status') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= __('Valor') ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($movimentCards as $value):
                                
                                if ($value->cards_id == $cardid) { ?>
                                    <tr>
                                        <td><?= ($value->ordem) ?></td>
                                        <td><?= date("d/m/Y", strtotime($value->data)) ?></td>
                                        <td class="text-left text-nowrap col-xs-1">
                                            <?php 
                                            if ($value->creditodebito == 'D') {  
                                                echo __('Compra');
                                            } elseif ($value->creditodebito == 'C') { 
                                                echo __('Estorno');
                                            } ?>
                                        </td>
                                        <td><?= date("d/m/Y", strtotime($value->vencimento)) ?></td>
                                        <td class="text-left text-nowrap col-xs-1"><?= ($value->Cards['title']) ?></td>
                                        <td class="text-left"><?= ($value->title) ?></td>
                                        <td class="text-nowrap text-center">
                                            <?php 
                                            if ($value->status == 'A') { 
                                                echo __('Aberto');
                                            } elseif ($value->status == 'B') { 
                                                echo __('Pago');
                                            }
                                            ?>
                                        </td>
                                        <td class="text-right text-nowrap col-xs-1">
                                            <?php 
                                            if ($value->creditodebito == 'D') {  
                                                echo $this->Number->precision($value->valor, 2); $saldo += $value->valor;
                                            } elseif ($value->creditodebito == 'C') { 
                                                echo $this->Number->precision($value->valor *-1, 2); $saldo -= $value->valor;
                                            }
                                            ?>
                                        </td>
                                        <td class="text-right text-nowrap col-xs-1"><?= $this->Number->precision($saldo, 2) ?></td>
                                    </tr>
                                    <?php 
                                }//if ($value->cards_id == $cardid)
                            endforeach; ?>         
                        </tbody>
                        <tfoot>
                            <tr class="bg-blue">
                                <th colspan="8"><?= ($cardstitle[$card]) ?></th>
                                <th class="text-right text-nowrap col-xs-1"><?= $this->Number->precision($saldo, 2) ?></th>                                
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <?php   
            endforeach; 
        } ?>
</div>