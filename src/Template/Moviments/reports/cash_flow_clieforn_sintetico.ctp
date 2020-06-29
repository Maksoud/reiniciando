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
    
    //CALCULA A DIFERENÇA ENTRE AS DATAS
    $partes  = explode('/', $dtinicial);
    $inicial = mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    $partes  = explode('/', $dtfinal);
    $final   = mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
    $dias    = (int)floor(($final - $inicial) / (60 * 60 * 24));
    
?>

<div class="col-xs-12 main bottom-50">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h4 class="page-header text-bold"><?= __('FLUXO DE CAIXA - SINTÉTICO - POR CLIENTES/FORNECEDORES') ?></h4>
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
                
            }//if (!empty($balance))
            
            echo __('Saldo Inicial: ') . $this->Number->currency($saldo, 'BRL');
            
        ?>
    </div>
    
    <?php
    $geral_credito = $geral_debito = 0;
    $clieforns = null;

    //Lista todos os clientes
    foreach ($customers as $customer):
        $clieforns[] = $customer;
    endforeach;

    //Lista todos os fornecedores
    foreach ($providers as $provider):
        $clieforns[] = $provider;
    endforeach;
    
    
    foreach ($clieforns as $clieforn):
        
        $total_credito = $total_debito = 0; 
        $reg = $reg_sp = NULL;
        
        /**********************************************************************/
        
//        if (is_object($moviments)) {
//            debug($moviments->toArray());
//        }
//        if (is_object($movimentBanks)) {
//            debug($movimentBanks->toArray());
//        }
//        if (is_object($movimentBoxes)) {
//            debug($movimentBoxes->toArray());
//        }
    
        /**********************************************************************/
        
        //MOVIMENTOS FINANCEIROS
        if (!empty($moviments)) {
            
            foreach ($moviments as $value):
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if ($clieforn->id == $value->customers_id || $clieforn->id == $value->providers_id) {
                        
                        if (empty($value->dtbaixa)) { //SOMENTE TÍTULOS NÃO PAGOS

                            $dt = explode('-', $value->vencimento);//DATA DE VENCIMENTO (ORÇADO)
                            $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                            
                            if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                                
                                if (!empty($reg[$indice])) {
                                    if ($value->creditodebito == 'C') {
                                        $reg[$indice]['credito'] += $value->valor;
                                    }
                                } else {
                                    if ($value->creditodebito == 'C') {
                                        $reg[$indice]['credito'] = $value->valor;
                                    }
                                }
                                
                            } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                                
                                if (!empty($reg[$indice])) {
                                    if ($value->creditodebito == 'D') {
                                        $reg[$indice]['debito']  += $value->valor;
                                    }
                                } else {
                                    if ($value->creditodebito == 'D') {
                                        $reg[$indice]['debito']  = $value->valor;
                                    }
                                }
                                
                            } else { //CRÉDITOS E DÉBITOS
                                
                                if (!empty($reg[$indice])) {
                                    if ($value->creditodebito == 'C') {
                                        $reg[$indice]['credito'] += $value->valor;
                                    } elseif ($value->creditodebito == 'D') {
                                        $reg[$indice]['debito']  += $value->valor;
                                    }
                                } else {
                                    if ($value->creditodebito == 'C') {
                                        $reg[$indice]['credito'] = $value->valor;
                                    } elseif ($value->creditodebito == 'D') {
                                        $reg[$indice]['debito']  = $value->valor;
                                    }
                                }
                                
                            }

                        }//if (empty($value['dtbaixa']))
                        
                    }//
                    
                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            endforeach;
            
            //REGISTROS SEM PLANO DE CONTAS
            foreach ($moviments as $value):
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if (empty($value->customers_id) && empty($value->providers_id)) {
                        
                        if (empty($value->dtbaixa)) { //SOMENTE TÍTULOS NÃO PAGOS

                            $dt = explode('-', $value->vencimento);//DATA DE VENCIMENTO (ORÇADO)
                            $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                            
                            if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                                
                                if (!empty($reg_sp[$indice])) {
                                    if ($value->creditodebito == 'C') {
                                        $reg_sp[$indice]['credito'] += $value->valor;
                                    }
                                } else {
                                    if ($value->creditodebito == 'C') {
                                        $reg_sp[$indice]['credito'] = $value->valor;
                                    }
                                }
                                
                            } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                                
                                if (!empty($reg_sp[$indice])) {
                                    if ($value->creditodebito == 'D') {
                                        $reg_sp[$indice]['debito']  += $value->valor;
                                    }
                                } else {
                                    if ($value->creditodebito == 'D') {
                                        $reg_sp[$indice]['debito']  = $value->valor;
                                    }
                                }
                                
                            } else { //CRÉDITOS E DÉBITOS
                                
                                if (!empty($reg_sp[$indice])) {
                                    if ($value->creditodebito == 'C') {
                                        $reg_sp[$indice]['credito'] += $value->valor;
                                    } elseif ($value->creditodebito == 'D') {
                                        $reg_sp[$indice]['debito']  += $value->valor;
                                    }
                                } else {
                                    if ($value->creditodebito == 'C') {
                                        $reg_sp[$indice]['credito'] = $value->valor;
                                    } elseif ($value->creditodebito == 'D') {
                                        $reg_sp[$indice]['debito']  = $value->valor;
                                    }
                                }
                                
                            }

                        }//if (empty($value['dtbaixa']))
                        
                    }//
                    
                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            endforeach;
            //REGISTROS SEM PLANO DE CONTAS
            
        }//if (!empty($moviments))
    
        /**********************************************************************/

        //MOVIMENTOS DE BANCOS
        if (!empty($movimentBanks)) {
            
            foreach ($movimentBanks as $value):
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if ($clieforn->id == $value->customers_id || $clieforn->id == $value->providers_id) {
                        
                        $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                        
                        if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                            
                            if (!empty($reg[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] = $value->valorbaixa;
                                }
                            }
                            
                        } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                            
                            if (!empty($reg[$indice])) {
                                if ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                            
                        } else { //CRÉDITOS E DÉBITOS
                            
                            if (!empty($reg[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] += $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] = $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                            
                        }
                        
                    }//

                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            endforeach;
            
            //REGISTROS SEM CLIENTE E FORNECEDOR
            foreach ($movimentBanks as $value):
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if (empty($value->customers_id) && empty($value->providers_id)) {
                        
                        $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                        
                        if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                            
                            if (!empty($reg_sp[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] = $value->valorbaixa;
                                }
                            }
                            
                        } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                            
                            if (!empty($reg_sp[$indice])) {
                                if ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                            
                        } else { //CRÉDITOS E DÉBITOS
                            
                            if (!empty($reg_sp[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    @$reg_sp[$indice]['credito'] += $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    @$reg_sp[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] = $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                            
                        }
                        
                    }//

                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            endforeach;
            //REGISTROS SEM CLIENTE E FORNECEDOR
            
        }//if (!empty($movimentBanks))
    
        /**********************************************************************/

        //MOVIMENTOS DE CAIXAS
        if (!empty($movimentBoxes)) {
            
            foreach ($movimentBoxes as $value):
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if ($clieforn->id == $value->customers_id || $clieforn->id == $value->providers_id) {
                        
                        $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                        if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                            if (!empty($reg[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] = $value->valorbaixa;
                                }
                            }
                        } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                            if (!empty($reg[$indice])) {
                                if ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                        } else { //CRÉDITOS E DÉBITOS
                            if (!empty($reg[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] += $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg[$indice]['credito'] = $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                        }

                    }//
                    
                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            endforeach;
            
            //REGISTROS SEM CLIENTE E FORNECEDOR
            foreach ($movimentBoxes as $value):
                
                if ($value->creditodebito == 'C' || $value->creditodebito == 'D') {
                    
                    if (empty($value->customers_id) && empty($value->providers_id)) {
                        
                        $dt = explode('-', $value->dtbaixa);//DATA DE PAGAMENTO (REALIZADO)
                        $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];

                        if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
                            if (!empty($reg_sp[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] = $value->valorbaixa;
                                }
                            }
                        } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
                            if (!empty($reg_sp[$indice])) {
                                if ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                        } else { //CRÉDITOS E DÉBITOS
                            if (!empty($reg_sp[$indice])) {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] += $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  += $value->valorbaixa;
                                }
                            } else {
                                if ($value->creditodebito == 'C') {
                                    $reg_sp[$indice]['credito'] = $value->valorbaixa;
                                } elseif ($value->creditodebito == 'D') {
                                    $reg_sp[$indice]['debito']  = $value->valorbaixa;
                                }
                            }
                        }

                    }//
                    
                }//if ($value->creditodebito == 'C' || $value->creditodebito == 'D')
                
            endforeach;
            //REGISTROS SEM CLIENTE E FORNECEDOR
            
        }//if (!empty($movimentBoxes))
    
        /**********************************************************************/
        
        if (!empty($reg)) {
            $some_reg = true;
            //ORDENA DATAS
            ksort($reg);
            ?>
            
            <div class="text-bold"><?= $clieforn->title ?></div>
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
                                <td class="text-left text-nowrap col-xs-1"><?= $dt[2] . '/' . $dt[1] . '/' . $dt[0] ?></td>
                                <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($value['credito'], 'BRL'); ?></td>
                                <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($value['debito'], 'BRL'); ?></td>
                                <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo += ($value['credito']-$value['debito']), 'BRL'); ?></td>
                            </tr>
                            <?php
                        endforeach;
                        ?> 
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue">
                            <th class="text-left text-nowrap col-xs-1"><?= $clieforn->title ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($total_credito, 'BRL'); ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($total_debito, 'BRL'); ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
        }//if (!empty($reg))
        
    endforeach; //foreach ($plans as $clieforn)
    
    //REGISTROS SEM CLIENTE E FORNECEDOR
    if (!empty($reg_sp)) {
        
        $some_reg = true;
        $total_credito = $total_debito = 0; 
        //ORDENA DATAS
        ksort($reg_sp);
        ?>

        <div class="text-bold"><?= __('REGISTROS SEM CLIENTE/FORNECEDOR') ?></div>
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
                    foreach ($reg_sp as $index => $value):
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
                            <td class="text-left text-nowrap col-xs-1"><?= $dt[2] . '/' . $dt[1] . '/' . $dt[0] ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($value['credito'], 'BRL'); ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($value['debito'], 'BRL'); ?></td>
                            <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo += ($value['credito']-$value['debito']), 'BRL'); ?></td>
                        </tr>
                        <?php
                    endforeach;
                    ?> 
                </tbody>
                <tfoot>
                    <tr class="bg-blue">
                        <th class="text-left text-nowrap col-xs-1"><?= $clieforn->razao ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($total_credito, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($total_debito, 'BRL'); ?></th>
                        <th class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php
    }//if (!empty($reg_sp))
    //REGISTROS SEM CLIENTE E FORNECEDOR
    
    if (isset($some_reg)) { ?>
        <table class="col-xs-12 table table-striped table-condensed prt-report">
            <thead>
                <tr class="bg-blue">
                    <th></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('CRÉDITOS') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('DÉBITOS') ?></th>
                    <th class="text-right text-nowrap col-xs-1"><?= __('SALDO FINAL') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="text-left"><?= __('TOTAIS') ?></th>
                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($geral_credito, 'BRL'); ?></td>
                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($geral_debito, 'BRL'); ?></td>
                    <td class="text-right text-nowrap col-xs-1"><?= $this->Number->currency($saldo, 'BRL'); ?></td>
                </tr>
            </tbody>
        </table>
        
        <?php
        echo __('*Valores de títulos baixados consideram o desconto.');
        
    } else {
        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
    } ?>
</div>
<?= $this->element('report-footer'); ?>