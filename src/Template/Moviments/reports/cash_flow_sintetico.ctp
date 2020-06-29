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
    
    $dtinicial = $this->request->data['dtinicial'];
    $dtfinal   = $this->request->data['dtfinal'];
?>

<div class="col-xs-12 main bottom-50">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('FLUXO DE CAIXA - SINTÉTICO') ?></h4>
    <div class="pull-4 bottom-20">
        <?= $this->element('report-filter-cashflow'); ?>
    </div>
    
    <div class="pull-right text-bold">
        <?php 
            
            $saldo = '0.00';
            
            if (!empty($balance)) {
                
                foreach($balance as $value):
                    $saldo += $value['value'];
                endforeach;
                
            }
            
            echo 'Saldo Inicial: ' . $this->Number->currency($saldo, 'BRL');
            
        ?>
    </div>
    
    <?php
    
    $geral_credito = $geral_debito = 0;
    $total_credito = $total_debito = 0;
    
    /**************************************************************************/
    
    $reg = NULL;

    //MOVIMENTOS FINANCEIROS RECORRENTES
    if (!empty($movimentRecurrents)) {
        $inicial = explode("/", $dtinicial);
        $inicial = implode('-', array_reverse($inicial));
        $final   = explode("/", $dtfinal);
        $final   = implode('-', array_reverse($final));

        $dif   = strtotime($final) - strtotime($inicial);
        $meses = floor($dif / (60 * 60 * 24 * 30));

        //IDENTIFICA OS MOVIMENTOS RECORRENTES
        foreach ($movimentRecurrents as $movimentRecurrent): 
            for($count = 1; $count < $meses; $count++) {
                $movimentRecurrent->vencimento = date("Y-m-d", strtotime("+1 month", strtotime($movimentRecurrent->vencimento)));
                $movimentRecurrent->id         = '0';
                $movimentRecurrent->ordem      = __('RECORRENTE');

                //ADICIONA PROVISIONAMENTO DEVIDO A RECORRÊNCIA
                array_push($moviments, $movimentRecurrent);
            }
        endforeach;
    }
    
    /**************************************************************************/
    
    //MOVIMENTOS FINANCEIROS
    if (!empty($moviments)) {
        
        foreach ($moviments as $value):
            
            if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                
                if ($value->creditodebito == 'C') {
                    
                    if (empty($value->dtbaixa)) { //SOMENTE TÍTULOS NÃO PAGOS
                        $dt = explode('-', $value['vencimento']);//DATA DE VENCIMENTO (ORÇADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                        if (!empty($reg[$indice])) {
                            if ($value->creditodebito == 'C') {
                                if (!empty($reg[$indice]['credito'])) {$reg[$indice]['credito'] += $value->valor;} else
                                                                    {$reg[$indice]['credito']  = $value->valor;}
                            }
                        } else {
                            if ($value->creditodebito == 'C') {
                                $reg[$indice]['credito'] = $value->valor;
                            }
                        }
                        
                    }//if (empty($value->dtbaixa))
                    
                }//if ($value->creditodebito == 'C')
                
            } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                
                if ($value->creditodebito == 'D') {
                    
                    if (empty($value->dtbaixa)) { //SOMENTE TÍTULOS NÃO PAGOS
                        $dt = explode('-', $value['vencimento']);//DATA DE VENCIMENTO (ORÇADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                        if (!empty($reg[$indice])) {
                            if ($value->creditodebito == 'D') {
                                if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito']   += $value->valor;} else
                                                                   {$reg[$indice]['debito']    = $value->valor;}
                            }
                        } else {
                            if ($value->creditodebito == 'D') {
                                $reg[$indice]['debito']  = $value->valor;
                            }
                        }
                    }//if (empty($value->dtbaixa))
                    
                }//if ($value->creditodebito == 'D')
                
            } else { //CRÉDITOS E DÉBITOS
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if (empty($value->dtbaixa)) { //SOMENTE TÍTULOS NÃO PAGOS
                        $dt = explode('-', $value['vencimento']);//DATA DE VENCIMENTO (ORÇADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                        if (!empty($reg[$indice])) {
                            if ($value->creditodebito == 'C') {
                                if (!empty($reg[$indice]['credito'])) {$reg[$indice]['credito'] += $value->valor;} else
                                                                    {$reg[$indice]['credito']  = $value->valor;}
                            } elseif ($value->creditodebito == 'D') {
                                if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito']   += $value->valor;} else
                                                                   {$reg[$indice]['debito']    = $value->valor;}
                            }
                        } else {
                            if ($value->creditodebito == 'C') {
                                $reg[$indice]['credito'] = $value->valor;
                            } elseif ($value->creditodebito == 'D') {
                                $reg[$indice]['debito']  = $value->valor;
                            }
                        }
                    }//if (empty($value->dtbaixa))
                    
                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            }
            
        endforeach;
    }
    
    /**************************************************************************/

    //MOVIMENTOS DE BANCOS
    if (!empty($movimentBanks)) {
        
        foreach ($movimentBanks as $value):
            
            if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                
                if ($value->creditodebito == 'C') {
                    $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                    $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                    if (!empty($reg[$indice])) {
                        if ($value->creditodebito == 'C') {
                            if (!empty($reg[$indice]['credito'])) {$reg[$indice]['credito'] += $value->valorbaixa;} else
                                                                {$reg[$indice]['credito']  = $value->valorbaixa;}
                        }
                    } else {
                        if ($value->creditodebito == 'C') {
                            $reg[$indice]['credito'] = $value->valorbaixa;
                        }
                    }
                    
                }//if ($value->creditodebito == 'C')
                
            } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                
                if ($value->creditodebito == 'D') {
                    
                    $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                    $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                    if (!empty($reg[$indice])) {
                        if ($value->creditodebito == 'D') {
                            if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito']   += $value->valorbaixa;} else
                                                               {$reg[$indice]['debito']    = $value->valorbaixa;}
                        }
                    } else {
                        if ($value->creditodebito == 'D') {
                            $reg[$indice]['debito']  = $value->valorbaixa;
                        }
                    }
                    
                }//if ($value->creditodebito == 'D')
                
            } else { //CRÉDITOS E DÉBITOS
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                    $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                    if (!empty($reg[$indice])) {
                        if ($value->creditodebito == 'C') {
                            if (!empty($reg[$indice]['credito'])) {$reg[$indice]['credito'] += $value->valorbaixa;} else
                                                                {$reg[$indice]['credito']  = $value->valorbaixa;}
                        } elseif ($value->creditodebito == 'D') {
                            if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito']   += $value->valorbaixa;} else
                                                               {$reg[$indice]['debito']    = $value->valorbaixa;}
                        }
                    } else {
                        if ($value->creditodebito == 'C') {
                            $reg[$indice]['credito'] = $value->valorbaixa;
                        } elseif ($value->creditodebito == 'D') {
                            $reg[$indice]['debito']  = $value->valorbaixa;
                        }
                    }
                    
                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            }
            
        endforeach;
        
    }
    
    /**************************************************************************/

    //MOVIMENTOS DE CAIXAS
    if (!empty($movimentBoxes)) {
        
      foreach ($movimentBoxes as $index => $value):
          
            if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                
                $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                    if (!empty($reg[$indice])) {
                        if ($value->creditodebito == 'C') {
                            if (!empty($reg[$indice]['credito'])) {$reg[$indice]['credito'] += $value->valorbaixa;} else
                                                                {$reg[$indice]['credito']  = $value->valorbaixa;}
                        }
                    } else {
                        if ($value->creditodebito == 'C') {
                            $reg[$indice]['credito'] = $value->valorbaixa;
                        }
                    }
                } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                    if (!empty($reg[$indice])) {
                        if ($value->creditodebito == 'D') {
                            if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito']   += $value->valorbaixa;} else
                                                               {$reg[$indice]['debito']    = $value->valorbaixa;}
                        }
                    } else {
                        if ($value->creditodebito == 'D') {
                            $reg[$indice]['debito']  = $value->valorbaixa;
                        }
                    }
                } else { //CRÉDITOS E DÉBITOS
                    if (!empty($reg[$indice])) {
                        if ($value->creditodebito == 'C') {
                            if (!empty($reg[$indice]['credito'])) {$reg[$indice]['credito'] += $value->valorbaixa;} else
                                                                {$reg[$indice]['credito']  = $value->valorbaixa;}
                        } elseif ($value->creditodebito == 'D') {
                            if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito']   += $value->valorbaixa;} else
                                                               {$reg[$indice]['debito']    = $value->valorbaixa;}
                        }
                    } else {
                        if ($value->creditodebito == 'C') {
                            $reg[$indice]['credito'] = $value->valorbaixa;
                        } elseif ($value->creditodebito == 'D') {
                            $reg[$indice]['debito']  = $value->valorbaixa;
                        }
                    }
                }
                
            }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
            
        endforeach;
        
    }//if (!empty($movimentBoxes))
    
    if (!empty($reg)) {
        
        //ORDENA DATAS
        ksort($reg); ?>
        <div class="col-xs-12 no-padding-lat table-responsive">
            <table class="table table-striped table-condensed prt-report">
                <thead>
                    <tr class="bg-blue">
                        <th class="text-left text-nowrap col-xs-1"><?= __('Data') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Crédito') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Débito') ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    //DETALHAMENTO GERAL
                    foreach ($reg as $index => $value):
                        
                        $credito = $debito = 0;
                        $dt      = explode('-', $index);
                        
                        if (isset($value['credito'])) {
                            $geral_credito += $value['credito'];
                            $total_credito += $value['credito'];
                        } else {
                            $value['credito'] = '0.00';
                        }
                        
                        if (isset($value['debito'])) {
                            $geral_debito  += $value['debito'];
                            $total_debito  += $value['debito'];
                        } else {
                            $value['debito'] = '0.00';
                        }
                        ?>
                        <tr>
                            <td class="text-left text-nowrap col-xs-1">
                                <?= $dt[2] . '/' . $dt[1] . '/' . $dt[0] ?>
                            </td>
                            <td class="text-right text-nowrap col-xs-1">
                                <?= $this->Number->currency($value['credito'], 'BRL'); ?>
                            </td>
                            <td class="text-right text-nowrap col-xs-1">
                                <?= $this->Number->currency($value['debito'], 'BRL'); ?>
                            </td>
                            <td class="text-right text-nowrap col-xs-1">
                                <?= $this->Number->currency($saldo += ($value['credito'] - $value['debito']), 'BRL'); ?>
                            </td>
                        </tr>
                        <?php
                        
                    endforeach;
                ?> 
                </tbody>
            </table>
        </div>
    
        <table class="col-xs-12 table table-striped table-condensed prt-report">
            <thead>
                <tr class="bg-blue">
                    <th></th>
                    <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                    <th class="text-right text-nowrap col-xs-1"><?= __('CRÉDITOS') ?></th>
                    <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                    <th class="text-right text-nowrap col-xs-1"><?= __('DÉBITOS') ?></th>
                    <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                    <th class="text-right text-nowrap col-xs-1"><?= __('SALDO FINAL') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-left"><?= __('TOTAIS') ?></th>
                    <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($geral_credito, 'BRL'); ?></td>
                    <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($geral_debito, 'BRL'); ?></td>
                    <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></td>
                </tr>
            </tbody>
        </table>
        
        <?php 
        echo __('*Valores de títulos baixados consideram o desconto.').'<br/>';
        if (!empty($movimentRecurrents)) { echo __('**Valores de títulos recorrentes foram provisionados.').'<br/>'; }
        
    } else { 
        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
    } ?>
</div>
<?= $this->element('report-footer'); ?>