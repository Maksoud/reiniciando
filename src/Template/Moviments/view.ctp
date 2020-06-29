<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Moviments */
/* File: src/Template/Moviments/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9 col-xs-12">
        <div class="box panel panel-default box-shadow" style="padding:0;">
            <div class="panel-heading box-header">
                <span class="text-bold"><?= __('Detalhes do Lançamento') ?></span>
            </div>
            <div class="box-body panel-body">
                <?php 
                if (!empty($moviment->providers_id)) { ?>
                    <div class="form-group borderRowBottom">
                        <label><?= __('Fornecedor') ?></label><br>
                        <?= h($moviment->Providers['title']) ?>
                    </div>
                    <?php 
                }//if (!empty($moviment->providers_id))
                if (!empty($moviment->customers_id)) { ?>
                    <div class="form-group borderRowBottom">
                        <label><?= __('Cliente') ?></label><br>
                        <?= h($moviment->Customers['title']) ?>
                    </div>
                    <?php 
                }//if (!empty($moviment->customers_id)) ?>
                <div class="form-group">
                    <label><?= __('Histórico') ?></label><br>
                    <?= h($moviment->historico) ?>
                </div>
                <?php 
                if ($moviment->obs != null) { ?>
                    <div class="form-group">
                        <label><?= __('Observações') ?></label><br>
                        <?= h($moviment->obs) ?>
                    </div>
                    <?php 
                }//if ($moviment->obs != null) ?>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 no-padding-lat" style="padding-right: 5px!important;">
            <div class="box panel panel-default box-shadow" style="padding:0;">
                <?php $moviment->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                    <span class="text-bold"><?= __('Informações Financeiras') ?>*</span>
                </div>
                <div class="box-body panel-body">
                    <div class="form-group">
                        <label><?= __('Valor do Título') ?></label><br>
                        <?= $this->Number->precision($moviment->valor, 2) ?>
                    </div>
                    <div class="form-group">
                    <?php
                    //AGRUPAMENTOS
                    if ($moviment->status == 'G') {
                        $total = 0;
                        foreach ($movimentMergeds as $merged): 
                            if ($merged->Moviment_Mergeds['status'] == 'V') {
                                if ($merged->Moviment_Mergeds['status'] == 'B') {
                                    $total += $merged->Moviment_Mergeds['valorbaixa'];
                                } else {
                                    $total += $merged->Moviment_Mergeds['valor'];
                                }
                            }
                        endforeach;

                        //CALCULA SE HÁ DIFERENÇA NO VALOR COM DUAS CASAS DECIMAIS
                        $diferenca = number_format($moviment->valor, 2, '.', '') - number_format($total, 2, '.', '');

                        if ($diferenca != 0) {
                            ?>
                            <label><?= __('Em Desacordo com Vínculos') ?></label><br>
                            <?= $this->Number->precision($diferenca, 2) ?>
                            <?php   
                        }//if ($diferenca != 0)
                    }//if ($moviment->status == 'G')
                    ?>

                    <?php
                    //BAIXAS PARCIAIS
                    if ($moviment->status == 'P') {
                        $total = 0;
                        foreach ($movimentMergeds as $merged):
                            if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                $total += $merged->Moviment_Mergeds['valorbaixa'];
                            }
                        endforeach;
                        ?>
                        <label><?= __('Valor em Aberto') ?></label><br>
                        <?= $this->Number->precision($moviment->valor - $total, 2) ?>
                        <?php        
                    }//if ($moviment->status == 'P') ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Emissão') ?></label><br>
                        <?= $this->MyHtml->date($moviment->data) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Vencimento') ?></label><br>
                        <?= $this->MyHtml->date($moviment->vencimento) ?>
                    </div>
                    <div class="form-group">
                        <label><?= __('Tipo') ?></label><br>
                        <?= $moviment->creditodebito == 'C' ? __('Receita') : __('Despesa') ?>
                    </div>
                    <?php 
                    if (isset($moviment->document_types_id)) { ?>
                        <div class="form-group">
                            <label><?= __('Tipo de Documento') ?></label><br>
                            <?= h($moviment->DocumentTypes['title']) ?>
                        </div>
                        <?php 
                    }//if (isset($moviment->document_types_id))
                    if (!empty($moviment->account_plans_id)) { ?>
                        <div class="form-group">
                            <label><?= __('Plano de Contas') ?></label><br>
                            <?= h($moviment->AccountPlans['classification'].' - '.$moviment->AccountPlans['title']) ?>
                        </div>
                        <?php 
                    }//if (!empty($moviment->account_plans_id))
                    if (!empty($moviment->costs_id)) { ?>
                        <div class="form-group">
                            <label><?= __('Centro de Custos') ?></label><br>
                            <?= h($moviment->Costs['title']) ?>
                        </div>
                        <?php 
                    }//if (!empty($moviment->costs_id)) ?>
                </div>
            </div>
        </div>
        
        <?php 
        $vinculados = $bvinculada = $bvinculados = $totalbvinculados = null;

        foreach ($movimentMergeds as $merged):
            if ($merged->Moviment_Mergeds['status'] == 'V') {
                $vinculados += 1;
            } elseif ($merged->Moviment_Mergeds['status'] == 'O') {
                $bvinculados      += 1;
                $totalbvinculados += $merged->Moviment_Mergeds['valorbaixa'];
            }
        endforeach;

        if (!empty($moviment->dtbaixa)) { ?>
            <div class="col-md-6 col-xs-12 no-padding-lat">
                <div class="box panel panel-default box-shadow" style="padding:0;">
                    <?php $moviment->creditodebito == 'C' ? $bg = '#d9edf7' : $bg = '#f2dede'; ?>
                    <div class="panel-heading box-header" style="background-color:<?= $bg ?>">
                        <span class="text-bold"><?= __('Dados do Pagamento') ?></span>
                    </div>
                    <div class="box-body panel-body">
                        <div class="form-group">
                            <label><?= __('Valor') ?></label><br>
                            <?= $this->Number->precision($moviment->valorbaixa, 2) ?>
                        </div>
                        <?php 
                        if (!empty($bvinculados)) { ?>
                            <div class="form-group">
                                <label><?= __('Valor do Pgto Parcial') ?></label><br>
                                <?= $this->Number->precision($totalbvinculados, 2) ?>
                            </div>
                            <?php 
                        } 
                        if ($moviment->valor != $moviment->valorbaixa) { ?>
                            <div class="form-group">
                                <?php 
                                if ($moviment->status == 'O') { ?>

                                    <label><?= __('Registro Pago Parcialmente'); ?></label><br>

                                    <?php
                                } elseif ($moviment->status == 'B' && empty($bvinculados)) {

                                    $diferenca = $moviment->valorbaixa - $moviment->valor;
                                    $percentual = $diferenca / $moviment->valor * 100;
                                    if ($diferenca > 0) { ?>
                                        <label><?= __('Acréscimo Aplicado'); ?></label><br>
                                        <?php 
                                    } else { ?>
                                        <label><?= __('Desconto Aplicado'); ?></label><br>
                                        <?php 
                                    } ?>
                                    <?= $this->Number->precision($diferenca, 2).' ('.$this->Number->toPercentage($percentual, 2).')'; ?> 
                                    <?php 

                                } ?>
                            </div>
                            <?php 
                        } ?>
                        <div class="form-group">
                            <label><?= __('Pagamento') ?></label><br>
                            <?= $this->MyHtml->date($moviment->dtbaixa) ?>
                        </div> 
                        <?php 
                        if (!empty($moviment->boxes_id)) { ?>
                            <div class="form-group">
                                <label><?= __('Caixa') ?></label><br>
                                <?= h($moviment->Boxes['title']) ?>
                            </div>
                            <?php 
                        }
                        if (!empty($moviment->banks_id)) { ?>
                            <div class="form-group">
                                <label><?= __('Banco') ?></label><br>
                                <?= h($moviment->Banks['title']) ?>
                            </div>
                            <?php 
                        }
                        if (!empty($moviment->event_types_id)) { ?>
                            <div class="form-group">
                                <label><?= __('Tipo de Evento') ?></label><br>
                                <?= h($moviment->EventTypes['title']) ?>
                            </div>
                            <?php 
                        }
                        if (!empty($moviment->userbaixa)) { ?>
                            <div class="form-group">
                                <label><?= __('Usuário') ?></label><br>
                                <?= h($moviment->userbaixa) ?>
                            </div>
                            <?php 
                        }//if (!empty($moviment->userbaixa)) ?>
                    </div>
                </div>
            </div>
            <?php 
        }//if (!empty($moviment->dtbaixa)) 
        if (isset($moviment->MovimentChecks['cheque'])) { ?>
            <div class="col-md-6 col-xs-12 no-padding-lat">
                <div class="col-md-offset-1 col-md-5 bg-success box">
                    <div class="bloco-cabecalho box-header">
                        <?= __('Dados do Cheque') ?>
                    </div>
                    <div class="box-body panel-body">
                        <div class="form-group">
                            <label><?= __('Nº Cheque: ') ?></label>
                            <?= h($moviment->MovimentChecks['cheque']) ?>
                        </div>
                        <div class="form-group">
                            <label><?= __('Nominal: ') ?></label>
                            <?= h($moviment->MovimentChecks['nominal']) ?>
                        </div>
                        <div class="form-group">
                            <label><?= __('Emissão: ') ?></label>
                            <?= $this->MyHtml->date($moviment->MovimentChecks['data']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
        }//if (isset($moviment->MovimentChecks['cheque'])) ?>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($moviment->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Documento') ?></label><br>
                <span class="label label-primary documento"><?= h($moviment->documento) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-success">
                <label><?= __('Situação') ?></label><br>
                <?= $moviment->contabil == 'S' ? '<span class="label label-primary">'.__('Contábil').'</span>' : '<span class="label label-danger">'.__('Não Contábil').'</span>' ?>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Moviments->status($moviment->status) ?><br>
            </div>
            <?php if ($moviment->status == 'V') { ?>
                <div class="form-group box bottom-5 bg-primary">
                    <label><?= __('Ordem de Vínculo') ?></label><br>
                    <span class="label label-danger"><?= str_pad($mergeds->Moviments['ordem'], 6, '0', STR_PAD_LEFT); ?></span>
                </div>
            <?php } ?>

            <?php if ($moviment->status == 'O') { ?>
                <div class="form-group box bottom-5 bg-primary">
                    <label><?= __('Ordem de Vínculo') ?></label><br>
                    <span class="label label-danger"><?= str_pad($mergeds->Moviments['ordem'], 6, '0', STR_PAD_LEFT); ?></span>
                </div>
            <?php } ?>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($moviment->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($moviment->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($moviment->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //MOVIMENTOS BANCO/CAIXA
    if (!empty($movimentos)) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('MOVIMENTOS') ?> (<?= count((array)$movimentos) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Movimento') ?></th>
                            <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                            <th class="text-left col-xs-1"><?= __('Data Lançamento') ?></th>
                            <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                            <th class="text-left"><?= __('Histórico') ?></th>
                            <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $total = 0;
                        foreach ($movimentos as $movimento): 
                            foreach($movimento as $value):
                                ?>
                                <tr>
                                    <td class="text-left">
                                    <?php 
                                        switch($value->source()):
                                            case 'MovimentBanks':
                                                echo __('Mov. Banco');
                                                $controller = 'MovimentBanks';
                                                break;
                                            case 'MovimentBoxes':
                                                echo __('Mov. Caixa');
                                                $controller = 'MovimentBoxes';
                                                break;
                                            case 'MovimentChecks':
                                                echo __('Mov. Cheque');
                                                $controller = 'MovimentChecks';
                                                break;
                                        endswitch;
                                    ?>
                                    </td>
                                    <td class="text-left"><?= $this->Html->link(str_pad($value->ordem, 6, '0', STR_PAD_LEFT), ['controller' => $controller, 'action' => 'view', $value->id], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($value->data) ?></td>
                                    <td class="text-left"><?= h($value->documento) ?></td>
                                    <td class="text-left"><?= h($value->historico) ?></td>
                                    <td class="text-right text-nowrap">
                                        <?php if ($value->source() != 'MovimentChecks') { ?>
                                            <?= $this->Number->precision($value->valorbaixa, 2); ?>
                                        <?php } else { ?>
                                            <?= $this->Number->precision($value->valor, 2); ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php 
                            endforeach; 
                        endforeach; 
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
    }//if (!empty($movimentos))
    //MOVIMENTOS BANCO/CAIXA

    ////////////////////////////////////////////////////////////////////
    
    //LANÇAMENTOS VINCULADOS (AGRUPAMENTOS)
    if ($moviment->status == 'G' || $moviment->status == 'B') {
        if (!empty($vinculados)) {
            ?>
            <div class="col-xs-12 box box-shadow bg-success panel-group">
                <div class="sub-header"><h5><label><?= __('LANÇAMENTOS VINCULADOS') ?> (<?= h($vinculados) ?>)</label></h5></div>
                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                <th class="text-left col-xs-1"><?= __('Data') ?></th>
                                <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                <th class="text-left"><?= __('Histórico') ?></th>
                                <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            foreach ($movimentMergeds as $merged): 
                                
                                if ($merged->Moviment_Mergeds['status'] == 'V') { ?>
                                    <tr>
                                        <td class="text-left"><?= $this->Html->link(str_pad($merged->Moviment_Mergeds['ordem'], 6, '0', STR_PAD_LEFT), ['action' => 'view', $merged->Moviment_Mergeds['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                        <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['data']) ?></td>
                                        <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['vencimento']) ?></td>
                                        <td class="text-left"><?= h($merged->Moviment_Mergeds['documento']) ?></td>
                                        <td class="text-left"><?= h($merged->Moviment_Mergeds['historico']) ?></td>
                                        <td class="text-right text-nowrap">
                                        <?php 
                                            if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                echo $this->Number->precision($merged->Moviment_Mergeds['valorbaixa'], 2); $total += $merged->Moviment_Mergeds['valorbaixa'];
                                            } else {
                                                echo $this->Number->precision($merged->Moviment_Mergeds['valor'], 2); $total += $merged->Moviment_Mergeds['valor'];
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                    <?php 
                                }//if ($merged->Moviment_Mergeds['status'] == 'V')
                                
                            endforeach; 
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-right"><?= __('Total') ?></th>
                                <th class="text-center"><?= $this->Number->precision($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php 
        }//if (!empty($vinculados))
    }//if ($moviment->status == 'G' || $moviment->status == 'B')
    //LANÇAMENTOS VINCULADOS (AGRUPAMENTOS)

    ////////////////////////////////////////////////////////////////////

    //PAGAMENTOS VINCULADOS VINCULADOS
    if (($moviment->status == 'P') || ($moviment->status == 'O') || ($moviment->status == 'B')) {
        
        if (!empty($bvinculados)) {
            ?>
            <div class="col-xs-12 box box-shadow bg-warning panel-group">
                <div class="sub-header"><h5><label><?= __('PAGAMENTOS PARCIAIS VINCULADOS') ?> (<?= h($bvinculados) ?>)</label></h5></div>

                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                <th class="text-left col-xs-1"><?= __('Data') ?></th>
                                <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Pagamento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                <th class="text-left"><?= __('Histórico') ?></th>
                                <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            foreach ($movimentMergeds as $merged): 
                                if ($merged->Moviment_Mergeds['status'] == 'O') { ?>
                                <tr>
                                    <td class="text-left"><?= $this->Html->link(str_pad($merged->Moviment_Mergeds['ordem'], 6, '0', STR_PAD_LEFT), ['action' => 'view', $merged->Moviment_Mergeds['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['data']) ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['vencimento']) ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['dtbaixa']) ?></td>
                                    <td class="text-left"><?= h($merged->Moviment_Mergeds['documento']) ?></td>
                                    <td class="text-left"><?= h($merged->Moviment_Mergeds['historico']) ?></td>
                                    <td class="text-right text-nowrap">
                                    <?php 
                                        if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                            echo $this->Number->precision($merged->Moviment_Mergeds['valorbaixa'], 2); $total += $merged->Moviment_Mergeds['valorbaixa'];
                                        } else {
                                            echo $this->Number->precision($merged->Moviment_Mergeds['valor'], 2); $total += $merged->Moviment_Mergeds['valor'];
                                        }
                                    ?>
                                    </td>
                                </tr>
                                <?php 
                                }
                            endforeach; 
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right"><?= __('Total') ?></th>
                                <th class="text-center"><?= $this->Number->precision($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php 
        }//if (!empty($bvinculados))
        elseif (isset($mergeds->Moviments['status']) && $mergeds->Moviments['status'] == 'B') {
            foreach ($mmergeds as $merged):
                if ($merged->Moviments['status'] == 'B') {
                    $bvinculada       += 1;
                    $totalbvinculados += $merged->Moviments['valorbaixa'];
                }
            endforeach;
        }//elseif ($mergeds->Moviments['status'] == 'B')
        
        if (!empty($bvinculada)) {
            ?>
            <div class="col-xs-12 box box-shadow bg-info panel-group">
                <div class="sub-header"><h5><label><?= __('LANÇAMENTO PRINCIPAL VINCULADOR') ?></label></h5></div>

                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                <th class="text-left col-xs-1"><?= __('Data') ?></th>
                                <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Pagamento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                <th class="text-left"><?= __('Histórico') ?></th>
                                <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            foreach ($mmergeds as $value):
                                $moviments_main = $value->Moviments;
                            endforeach;
                            
                            foreach (array($moviments_main) as $merged): ?>
                                <tr>
                                    <td class="text-left"><?= $this->Html->link(str_pad($merged['ordem'], 6, '0', STR_PAD_LEFT), ['action' => 'view', $merged['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($merged['data']) ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($merged['vencimento']) ?></td>
                                    <td class="text-left"><?= $merged['dtbaixa'] ? $this->MyHtml->tinyDate($merged['dtbaixa']) : __('Em Aberto'); ?></td>
                                    <td class="text-left"><?= h($merged['documento']) ?></td>
                                    <td class="text-left"><?= h($merged['historico']) ?></td>
                                    <td class="text-right text-nowrap">
                                    <?php 
                                        if (!empty($merged['valorbaixa'])) { echo $this->Number->precision($merged['valorbaixa'], 2); $total += $merged['valorbaixa']; }  
                                        else { echo $this->Number->precision($merged['valor'], 2); $total += $merged['valor']; }
                                    ?>
                                    </td>
                                </tr>
                                <?php 
                            endforeach; 
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right"><?= __('Total') ?></th>
                                <th class="text-center"><?= $this->Number->precision($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <!-- ////////////// -->
            <div class="col-xs-12 box box-shadow bg-warning panel-group">
                <div class="sub-header"><h5><label><?= __('OUTROS PAGAMENTOS PARCIAIS VINCULADOS') ?> (<?= h($bvinculada) ?>)</label></h5></div>
                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                <th class="text-left col-xs-1"><?= __('Data') ?></th>
                                <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Pagamento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                <th class="text-left"><?= __('Histórico') ?></th>
                                <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            foreach ($mmergeds as $merged): 
                                
                                if ($merged->Moviments['status'] == 'B') { ?>
                                    <tr>
                                        <td class="text-left"><?= $this->Html->link(str_pad($merged->Moviment_Mergeds['ordem'], 6, '0', STR_PAD_LEFT), ['action' => 'view', $merged->Moviment_Mergeds['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                        <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['data']) ?></td>
                                        <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['vencimento']) ?></td>
                                        <td class="text-left"><?= $this->MyHtml->tinyDate($merged->Moviment_Mergeds['dtbaixa']) ?></td>
                                        <td class="text-left"><?= h($merged->Moviment_Mergeds['documento']) ?></td>
                                        <td class="text-left"><?= h($merged->Moviment_Mergeds['historico']) ?></td>
                                        <td class="text-right text-nowrap"><?= $this->Number->precision($merged->Moviment_Mergeds['valorbaixa'], 2); $total += $merged->Moviment_Mergeds['valorbaixa']; ?></td>
                                    </tr>
                                    <?php 
                                }//if ($merged->Moviments['status'] == 'B')
                                
                            endforeach; 
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6" class="text-right"><?= __('Total') ?></th>
                                <th class="text-center"><?= $this->Number->precision($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php 
        }//if (!empty($bvinculada))
        
        
    }//if (($moviment->status == 'P') || ($moviment->status == 'B'))
    //BAIXAS VINCULADOS VINCULADAS 
    
    ////////////////////////////////////////////////////////////////////
    
    //LANÇAMENTOS DE CARTÕES
    if (($moviment->cards_id)) {
        if (!empty($movimentCards->toArray())) { ?>
            <div class="col-xs-12 box box-shadow bg-blue panel-group">
                <div class="sub-header"><h5><label><?= __('MOVIMENTOS DE CARTÕES') ?></label></h5></div>
                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                <th class="text-left col-xs-1"><?= __('Data') ?></th>
                                <th class="text-left"><?= __('Histórico') ?></th>
                                <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            foreach ($movimentCards as $movimentCard): ?>
                                <tr>
                                    <td class="col-xs-1 text-left"><?= $this->Html->link(str_pad($movimentCard->ordem, 6, '0', STR_PAD_LEFT), ['controller' => 'MovimentCards', 'action' => 'view', $movimentCard->id], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                    <td class="col-xs-1 text-nowrap"><?= $movimentCard->documento ? $movimentCard->documento : '-'; ?></td>
                                    <td class="col-xs-1 text-left"><?= $this->MyHtml->tinyDate($movimentCard->data) ?></td>
                                    <td class="text-left"><?= h($movimentCard->title) ?></td>
                                    <td class="col-xs-1 text-right text-nowrap">
                                        <?php 
                                        if ($movimentCard->creditodebito == 'D') {
                                            $total += $movimentCard->valor;
                                        } elseif ($movimentCard->creditodebito == 'C') {
                                            $total -= $movimentCard->valor;
                                            echo '-';
                                        }
                                        ?>
                                        <?= $this->Number->precision($movimentCard->valor, 2) ?>
                                    </td>
                                </tr>
                                <?php 
                            endforeach; 
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right"><?= __('Total') ?></th>
                                <th class="text-center"><?= $this->Number->precision($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <?php 
        }//if (!empty($movimentCards->toArray()))
    }//if (($moviment->cards_id))
    //LANÇAMENTOS DE CARTÕES
    ?>
</div>