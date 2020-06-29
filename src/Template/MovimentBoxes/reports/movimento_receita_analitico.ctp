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
    
    <h4 class="page-header text-bold"><?= __('MOVIMENTOS DE CAIXAS - RECEITAS - ANALÍTICO') ?></h4>
    <div class="pull-4 prt-report bottom-20">
        <?= $this->element('report-filter-moviment-boxes'); ?>
    <?php
    if (empty($movimentBoxes)) {
        if ($this->request->data['boxes_id']) {
            foreach ($balances as $index => $value):
                if ($index == $this->request->data['boxes_id']) {
                    echo '<span class="text-bold">'.$boxes->Boxes['title'].'</span><br />';
                    echo '<span class="text-bold">'.__('Saldo Atual: ').'</span>'.$this->Number->currency($value, 'BRL');
                } 
            endforeach;
        }
        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
    } else { ?>
    </div>
        <?php    
        foreach ($movimentBoxes as $box => $movimentBox):
            if ($movimentBox['creditodebito'] == 'C') { //RELATÓRIO DE RECEITAS
                $boxesid[$box]    = $movimentBox['boxes_id'];
                $boxestitle[$box] = $movimentBox['Boxes']['title'];
            } else {
                echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
                die();
            }
        endforeach;
        $somatitulostotal = $somadesctotal = $saldototal = 0;
        foreach (array_unique($boxesid) as $box => $boxid): 
            $saldo = $titulo = $descacresc = $creditob = 0;
            ?>
            <div class="pull-right text-bold">
                <?php
                $isset = NULL; //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                foreach ($balances as $balance => $movimentBox):
                    if ($balance == $boxesid[$box]) {
                        $saldo = $movimentBox;
                        $isset = $saldo;
                        echo __('Saldo Inicial: ') . $this->Number->currency($saldo, 'BRL');
                    } 
                endforeach;
                //BANCOS NOVOS QUE NÃO POSSUEM SALDO ANTERIOR A DATA INCIAL DA CONSULTA 22/09/2016
                if (empty($isset)) {
                    $saldo = '0.00';
                    echo __('Saldo Inicial: ') . $this->Number->currency($saldo, 'BRL');
                }//if (empty($isset))
                ?> 
            </div>
            <span class="text-bold"><?= $boxestitle[$box] ?></span>
            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-center text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                            <th class="text-center text-nowrap col-xs-1 hidden-print"><?= __('Emissão') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Vencimento') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Baixa') ?></th>
                            <th class="text-center text-nowrap col-xs-1 hidden-print"><?= __('Documento') ?></th>
                            <th class="text-left"><?= __('Históricos') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acresc.') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Baixa') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($movimentBoxes as $movimentBox => $value) :
                            if ($value['boxes_id'] == $boxesid[$box] && $value['creditodebito'] == 'C') { ?>
                                <tr>
                                    <td class="text-left text-nowrap col-xs-1"><?= ($value['ordem'] ? str_pad($value['ordem'], 6, '0', STR_PAD_LEFT) : '') ?></td>
                                    <td class="text-left text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($value['data'])) ?></td>
                                    <td class="text-left text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($value['vencimento'])) ?></td>
                                    <td class="text-left text-nowrap col-xs-1"><?= date("d/m/Y", strtotime($value['dtbaixa'])) ?></td>
                                    <td class="text-left text-nowrap col-xs-1 hidden-print"><?= $value['documento'] ?></td>
                                    <td class="text-left"><?= $value['historico'] ?></td>
                                    <td class="text-right text-nowrap col-xs-1"><?php $titulo += $value['valor']; echo $this->Number->currency($value['valor'],'BRL'); ?></td>
                                    <td class="text-right text-nowrap text-danger"><?php $descacresc += $value['valorbaixa'] - $value['valor']; echo $this->Number->currency($value['valorbaixa'] - $value['valor'],'BRL'); ?></td>
                                    <td class="text-right text-nowrap text-success"><?php $creditob += $value['valorbaixa']; echo $this->Number->currency($value['valorbaixa'],'BRL'); ?></td>
                                </tr>
                        <?php }
                        endforeach; ?>
                    </tbody>  
                    <tfoot>
                        <tr class="bg-blue">
                            <th colspan="4"><?= ($boxestitle[$box]) ?></th>
                            <th colspan="2" class="hidden-print"></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($titulo, 'BRL'); $somatitulostotal += $titulo; ?></th>
                            <th class="text-right text-nowrap text-danger"><?= $this->Number->currency($descacresc, 'BRL'); $somadesctotal += $descacresc; ?></th>
                            <th class="text-right text-nowrap text-success"><?= $this->Number->currency($creditob, 'BRL'); $saldototal += $creditob; ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
        endforeach; ?>
        <div class="col-xs-12 no-padding-lat table-responsive">
            <table class="table table-striped table-condensed prt-report">
                <tfoot>
                    <tr class="bg-blue">
                        <th colspan="4"></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Desc./Acresc.') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Valor Baixa') ?></th>
                    </tr>
                    <tr class="bg-blue">
                        <th colspan="4"><?= __('TOTAL GERAL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somatitulostotal, 'BRL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($somadesctotal, 'BRL') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldototal, 'BRL') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
    }//if (empty($movimentBoxes))?>
</div>