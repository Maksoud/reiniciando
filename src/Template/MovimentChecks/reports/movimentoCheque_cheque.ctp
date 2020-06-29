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
    
    <h4 class="page-header text-bold"><?= __('Movimentos de Cheque') ?></h4>
    <div class="pull-4 bottom-20">
        <span class="text-bold"><?= __('FILTROS') ?></span><br>
        <?php
        if ($this->request->data['dtinicial'] && $this->request->data['dtfinal']) {
            echo __('Data: ').$this->request->data['dtinicial'].' até '.$this->request->data['dtfinal'].'<br>';
        }
        if (@$this->request->data['valor']) {
            echo __('Valor: ').$this->Number->currency($this->request->data['valor'],'BRL').'<br>';
        }
        if (@$this->request->data['historico']) {
            echo __('Histórico: ').'%'.$this->request->data['historico'].'%'.'<br>';
        }
        if (@$this->request->data['status']) {
            echo __('Status: ').$this->request->data['status'].'<br>';
        }
        if (@$this->request->data['boxes']) {
            echo __('Caixa: ').$this->request->data['boxes'].'<br>';
        }
        if (@$this->request->data['event_types']) {
            echo __('Tipo de Evento: ').$this->request->data['event_types'].'<br>';
        }
        if (@$this->request->data['costs']) {
            echo __('Centro de Custo: ').$this->request->data['costs'].'<br>';
        }
        if ($this->request->data['contabil'] == 'S') {
            echo __('Contábil: Sim').'<br>';
        } elseif ($this->request->data['contabil'] == 'N') {
            echo __('Contábil: Não').'<br>';
        } else {
            echo __('Contábil: Todos').'<br>';
        }
        if ($this->request->data['Ordem']) {
            if ($this->request->data['Ordem'] == 'ordem') { $ordem = 'Ordem';}
            elseif ($this->request->data['Ordem'] == 'data') { $ordem = 'Data da Emissão';}
            elseif ($this->request->data['Ordem'] == 'historico') { $ordem = 'Histórico';}
            elseif ($this->request->data['Ordem'] == 'costs_id') { $ordem = 'Centro de Custos';}
            elseif ($this->request->data['Ordem'] == 'account_plans_id') { $ordem = 'Plano de Contas';}
            echo __('Ordem: ').$ordem.'<br>';
        }
        if (empty($movimentChecks->toArray())) {
            echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
        } else {
        ?>
    </div>
    <?php 
            foreach ($movimentChecks as $bank => $value) :
                $banksid[$bank]    = $value['banks_id'];
                $bankstitle[$bank] = $value->Banks['title'];
            endforeach;

            foreach (array_unique($banksid) as $bank => $bankid) : ?>
                <span class="text-bold"><?= $bankstitle[$bank] ?></span>
                <?php 
                    $saldo = 0;
                ?>
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-center text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Data') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Cheque') ?></th>
                            <th class="text-left text-nowrap col-xs-2"><?= __('Nominal') ?></th>
                            <th class="text-left text-nowrap col-xs-1 hidden-print"><?= __('Documento') ?></th>
                            <th class="text-left text-nowrap col-xs-2"><?= __('Histórico') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Valor') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($movimentChecks as $movimentCheck => $value): 
                            if ($value['banks_id'] == $bankid[0]) { ?>
                            <tr>
                                <td class="text-center text-nowrap col-xs-1"><?= ($value['ordem'] ? str_pad($value['ordem'], 6, '0', STR_PAD_LEFT) : '') ?></td>
                                <td class="text-center text-nowrap col-xs-1 hidden-print"><?= date("d/m/Y", strtotime($value['data'])) ?></td>
                                <td class="text-left text-nowrap col-xs-1"><?= $value['cheque'] ?></td>
                                <td class="text-left text-nowrap col-xs-2"><?= $value['nominal'] ?></td>
                                <td class="text-left text-nowrap col-xs-1 hidden-print"><?= $value['documento'] ?></td>
                                <td class="text-left text-nowrap col-xs-2"><?= $value['historico'] ?></td>
                                <td class="text-right text-nowrap col-xs-1"><?php echo $this->Number->currency($value['valor']*-1,'BRL'); $saldo += $value['MovimentCheck']['valor']; ?></td>
                            </tr>
                        <?php }
                        endforeach; ?>         
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue">
                            <th colspan="5"><?= ($bankstitle[$bank]) ?></th>
                            <th class="hidden-print"></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo*-1, 'BRL') ?></th>                                
                        </tr>
                    </tfoot>
                </table>
    <?php   endforeach; 
        }?>
</div>