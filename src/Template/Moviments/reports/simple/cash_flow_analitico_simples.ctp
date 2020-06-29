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

    $geral_credito = $geral_debito = 0;
    $total_credito = $total_debito = 0;
    $reg = NULL;
?>

<div class="col-xs-12 main bottom-50">
    
    <?= $this->element('report-header', ['parameter' => $parameter]); ?>
    
    <h3 class="page-header"><span class="text-bold"><?= __('FLUXO DE CAIXA - ANALÍTICO - SIMPLIFICADO') ?></span></h3>
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

            //Soma o saldo inicial ao crédito/débito total
            if ($saldo > 0) { $geral_credito += $saldo;}
            elseif ($saldo < 0) { $geral_debito += $saldo;}
            
            echo 'Saldo Inicial: ' . $this->Number->currency($saldo, 'BRL');
            
            ?>
    </div>
    
    <?php
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
            
            for ($count = 1; $count < $meses; $count++) {
                $movimentRecurrent->vencimento = date("Y-m-d", strtotime("+1 month", strtotime($movimentRecurrent->vencimento)));
                $movimentRecurrent->id         = '0';
                $movimentRecurrent->ordem      = 'RECORRENTE';
                
                //ADICIONA PROVISIONAMENTO DEVIDO A RECORRÊNCIA
                array_push($moviments, $movimentRecurrent);
            }//for($count = 1; $count < $meses; $count++)
            
        endforeach;
    }//if (!empty($movimentRecurrents))
    
    /**************************************************************************/
    
    //MOVIMENTOS FINANCEIROS
    if (!empty($moviments)) {
        
        foreach ($moviments as $value):
            
            if (empty($value->dtbaixa)) { //SOMENTE TÍTULOS NÃO PAGOS

                $dt = explode('-', $value->vencimento);//DATA DE VENCIMENTO (ORÇADO)
                $indice = $dt[0] . '-' . $dt[1] . '-' . $dt[2];
                
                if ($this->request->data['creditodebito'] == 'C') { //SOMENTE CRÉDITOS
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
                } elseif ($this->request->data['creditodebito'] == 'D') { //SOMENTE DÉBITOS
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
                } else { //CRÉDITOS E DÉBITOS
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
                }
            }
            
        endforeach;

    }//if (!empty($moviments))
    //MOVIMENTOS FINANCEIROS
    
    /**************************************************************************/
    
    //MOVIMENTOS DE BANCOS
    if (!empty($movimentBanks)) {
        
        foreach ($movimentBanks as $value):
            
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
                        $reg[$indice]['debito']  = 0;
                    } elseif ($value->creditodebito == 'D') {
                        $reg[$indice]['credito'] = 0;
                        $reg[$indice]['debito']  = $value->valorbaixa;
                    }
                }
            } 
            
        endforeach;
        
    }//if (!empty($movimentBanks))
    //MOVIMENTOS DE BANCOS

    /**************************************************************************/
    
    //MOVIMENTOS DE CAIXAS
    if (!empty($movimentBoxes)) {

        foreach ($movimentBoxes as $value):

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
                        if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito'] += $value->valorbaixa;} else
                                                             {$reg[$indice]['debito']  = $value->valorbaixa;}
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
                        if (!empty($reg[$indice]['debito'])) {$reg[$indice]['debito'] += $value->valorbaixa;} else
                                                             {$reg[$indice]['debito']  = $value->valorbaixa;}
                    }
                } else {
                    if ($value->creditodebito == 'C') {
                        $reg[$indice]['credito'] = $value->valorbaixa;
                        $reg[$indice]['debito']  = 0;
                    } elseif ($value->creditodebito == 'D') {
                        $reg[$indice]['credito'] = 0;
                        $reg[$indice]['debito']  = $value->valorbaixa;
                    }
                }
            }

        endforeach;  
        
    }//if (!empty($movimentBoxes))
    //MOVIMENTOS DE CAIXAS
    
    /**************************************************************************/

    if (!empty($reg)) {

        //ORDENA DATAS
        ksort($reg);

        //DETALHAMENTO GERAL
        //foreach ($reg as $value):
            
            $credito = $debito = 0;
            //$dt      = explode('-', $index);
            $saldoc = $saldod = 0;
            ?>

            <div class="col-xs-12 no-padding-lat table-responsive">
                <table class="table table-striped table-condensed prt-report">
                    <thead>
                        <tr class="bg-blue">
                            <th class="text-left text-nowrap col-xs-1 hidden-print"><?= __('Orig.PGTO') ?></th>
                            <th class="text-left text-nowrap col-xs-1 hidden-print"><?= __('Orig.LCTO') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Ordem') ?></th>
                            <th class="text-left text-nowrap col-xs-1 hidden-print"><?= __('Status') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Vencimento') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Pagamento') ?></th>
                            <th class="text-left text-nowrap col-xs-1"><?= __('Categoria') ?></th>
                            <th class="text-left"><?= __('Histórico') ?></th>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Valor Título') ?></th>
                            <th class="text-center text-nowrap col-xs-1"></th>
                            <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Crédito') ?></th>
                            <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Débito') ?></th>
                            <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                            <th class="text-right text-nowrap col-xs-1"><?= __('Saldo') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
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
                        
                        /**********************************************************/
                        
                        $exists = null;
                        
                        /**********************************************************/

                        //Identifica a ordenação do relatório para conciliar com o período
                        $ordenacao = $this->request->data['Ordem'];

                        //LANÇAMENTOS FINANCEIROS
                        if (!empty($moviments)) {
                            
                            foreach ($moviments as $value):

                                if (empty($value->dtbaixa)) {//SOMENTE TÍTULOS EM ABERTO

                                    if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'D') {
                                        
                                        //CREDITO OU DÉBITO DEFINIDO
                                        $creditodebito = $this->request->data['creditodebito'];
                                        
                                    } else {
                                        
                                        //SELECIONADO A OPÇÃO TODOS
                                        $creditodebito = $value->creditodebito;
                                        
                                    }

                                    if ($value->creditodebito == $creditodebito) { 
                                        
                                        $exists = $value->ordem;
                                        
                                        ?>
                                        <tr>
                                            <td class="text-left text-nowrap col-xs-1 hidden-print">
                                                <?= '-' ?>
                                            </td>
                                            <td class="text-center text-nowrap col-xs-1 hidden-print">
                                                <?= __('Contas P/R') ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1"> 
                                                <?= ($value->ordem ? str_pad($value->ordem, 6, '0', STR_PAD_LEFT) : '-') ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1 hidden-print">
                                                <?php 
                                                if ($value->ordem == 'RECORRENTE') { echo ('PROVISIONADO'); } 
                                                else{ echo ('Em Aberto'); } 
                                                ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= date("d/m/Y", strtotime($value->vencimento)) ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?php 
                                                if ($value->dtbaixa) { 
                                                    echo date("d/m/Y", strtotime($value->dtbaixa));
                                                }
                                                ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= h($value->Costs['title']) ?>
                                            </td>
                                            <td class="text-left">
                                                <?= $value->historico ?>
                                            </td>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($value->valor, 'BRL'); ?>
                                            </td>
                                            <td>
                                            <?php
                                                
                                                $valorpago = $mergeds = 0;
                                                
                                                if (!empty($movimentMergeds->toArray())) {
                                                    
                                                    foreach ($movimentMergeds as $merged):
                                                        
                                                        if ($merged->moviments_id == $value->id) { //TÍTULOS VINCULADOS
                                                            
                                                            if ($merged->Moviment_Mergeds['status'] == 'B' || //BAIXADO
                                                            $merged->Moviment_Mergeds['status'] == 'O') {  //BAIXA PARCIAL
                                                                $mergeds++;
                                                                $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                            }
                                                            
                                                        } elseif ($merged->moviments_merged == $value->id) { //TÍTULOS PARCIAIS
                                                            
                                                            if ($merged->Moviments['status'] == 'B' || //BAIXADO
                                                            $merged->Moviments['status'] == 'P') {  //PARCIAL
                                                                $mergeds++;
                                                            }
                                                            
                                                        }//if ($merged->moviments_id == $value->id)
                                                        
                                                    endforeach; 
                                                    
                                                }//if (!empty($movimentMergeds->toArray()))
                                                
                                                if ($mergeds > 0) {
                                                    echo '<i class="fa fa-paperclip pull-right" title="'.__('Há títulos vinculados a este lançamento.').'"></i> ';
                                                    $showClip = true;
                                                }//if ($mergeds > 0)
                                                
                                            ?>
                                            </td>
                                            <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    if ($value->creditodebito == 'C') {
                                                        if ($value->dtbaixa) { 
                                                            echo $this->Number->currency($value->valorbaixa, 'BRL'); 
                                                            $saldo  += $value->valorbaixa; 
                                                            $saldoc += $value->valorbaixa;
                                                        } else {
                                                            if ($mergeds > 0) {
                                                                echo $this->Number->currency($value->valor - $valorpago, 'BRL'); 
                                                                $saldo  += $value->valor - $valorpago; 
                                                                $saldoc += $value->valor - $valorpago;
                                                            } else {
                                                                echo $this->Number->currency($value->valor, 'BRL'); 
                                                                $saldo  += $value->valor; 
                                                                $saldoc += $value->valor;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                    if ($value->creditodebito == 'D') {
                                                        if ($value->dtbaixa) { 
                                                            echo $this->Number->currency($value->valorbaixa, 'BRL'); 
                                                            $saldo  -= $value->valorbaixa; 
                                                            $saldod += $value->valorbaixa;
                                                        } else {
                                                            if ($mergeds > 0) {
                                                                echo $this->Number->currency($value->valor - $valorpago, 'BRL'); 
                                                                $saldo  -= $value->valor - $valorpago; 
                                                                $saldod += $value->valor - $valorpago;
                                                            } else {
                                                                echo $this->Number->currency($value->valor, 'BRL'); 
                                                                $saldo  -= $value->valor; 
                                                                $saldod += $value->valor;
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($saldo, 'BRL'); ?>
                                            </td>
                                        </tr>

                                        <?php
                                    }//if ($value->creditodebito == $creditodebito)

                                }//if ($value->vencimento == $index && empty($value->dtbaixa))
                            
                            endforeach;
                        
                        }//if (!empty($moviments))
                        
                        /**********************************************************/
                        
                        //MOVIMENTOS DE BANCOS
                        if (!empty($movimentBanks)) {
                            
                            foreach ($movimentBanks as $value):
                                
                                //if ($value->dtbaixa == $index) {
                                    
                                    if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'D') {
                                        //CREDITO OU DÉBITO DEFINIDO
                                        $creditodebito = $this->request->data['creditodebito'];
                                    } else {
                                        //SELECIONADO A OPÇÃO TODOS
                                        $creditodebito = $value->creditodebito;
                                    }

                                    //Identifica o tipo de vínculo
                                    if ($value->Moviments['ordem']) {
                                        $ordem = $value->Moviments['ordem'];
                                        $tipoVinculo = __('Contas P/R');
                                    } elseif ($value->Transfers['ordem']) {
                                        $ordem = $value->Transfers['ordem'];
                                        $tipoVinculo = __('Transferência');
                                    } elseif (!$value->Moviments['ordem'] && !$value->Transfers['ordem']) {
                                        $ordem = $value->ordem;
                                        $tipoVinculo = __('Mov. Banco');
                                    } else {
                                        $ordem = 0;
                                        $tipoVinculo = "-";
                                    }
                                    
                                    if ($value->creditodebito == $creditodebito) {
                                        $exists = $value->ordem;
                                        ?>
                                        <tr>
                                            <td class="text-left text-nowrap col-xs-1 hidden-print">
                                                <?= __('Mov.Banco') ?>
                                            </td>
                                            <td class="text-center text-nowrap col-xs-1 hidden-print">
                                                <?= $tipoVinculo ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= ($ordem ? str_pad($ordem, 6, '0', STR_PAD_LEFT) : '') ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1 hidden-print">
                                                <?= __('Baixado') ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= date("d/m/Y", strtotime($value->dtbaixa)) ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?php 
                                                if ($value->dtbaixa) { 
                                                    echo date("d/m/Y", strtotime($value->dtbaixa));
                                                }
                                                ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= h($value->Costs['title']) ?>
                                            </td>
                                            <td class="text-left">
                                                <?= $value->historico ?>
                                            </td>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($value->valor, 'BRL'); ?>
                                            </td>
                                            <td>
                                            <?php
                                                
                                                $valorpago = $mergeds = 0;
                                                
                                                if (!empty($movimentMergeds->toArray())) {
                                                    
                                                    foreach ($movimentMergeds as $merged):
                                                        
                                                        if ($merged->MovimentBanks['id'] == $value->id) { //Movimento de banco que possui baixas parciais vinculadas a este título
                                                            
                                                            $message = '<i class="fa fa-paperclip pull-right" title="'.__('Há títulos vinculados a este lançamento.').'"></i> ';
                                                            $mergeds++;
                                                            
                                                        } elseif ($merged->MovimentBoxes['id'] == $value->id) { //Movimento de caixa que possui baixas parciais vinculadas a este título
                                                            
                                                            $message = '<i class="fa fa-paperclip pull-right" title="'.__('Há títulos vinculados a este lançamento.').'"></i> ';
                                                            $mergeds++;
                                                            
                                                        }
                                                        
                                                        /**************************/
                                                        
                                                        if ($merged->MovimentBank_Merged['id'] == $value->id) { //Movimento de banco vinculado
                                                            
                                                            $message = '<i class="fa fa-paperclip pull-right" title="'.__('Este título é uma baixa parcial e está vinculado.').'"></i> ';
                                                            $mergeds++;
                                                            
                                                        } elseif ($merged->MovimentBox_Merged['id'] == $value->id) { //Movimento de caixa vinculado
                                                            
                                                            $message = '<i class="fa fa-paperclip pull-right" title="'.__('Este título é uma baixa parcial e está vinculado.').'"></i> ';
                                                            $mergeds++;
                                                            
                                                        }
                                                        
                                                    endforeach;
                                                    
                                                }//if (!empty($movimentMergeds->toArray()))
                                                
                                                if ($mergeds > 0) {
                                                    echo $message;
                                                    $showClip = true;
                                                }//if ($mergeds > 0)
                                                
                                            ?>
                                            </td>
                                            <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                if ($value->creditodebito == 'C') {
                                                    if ($value->dtbaixa) { 
                                                        echo $this->Number->currency($value->valorbaixa, 'BRL'); 
                                                        $saldo  += $value->valorbaixa; 
                                                        $saldoc += $value->valorbaixa;
                                                    } else {
                                                        if ($mergeds > 0) {
                                                            echo $this->Number->currency($value->valor - $valorpago, 'BRL'); 
                                                            $saldo  += $value->valor - $valorpago; 
                                                            $saldoc += $value->valor - $valorpago;
                                                        } else {
                                                            echo $this->Number->currency($value->valor, 'BRL'); 
                                                            $saldo  += $value->valor; 
                                                            $saldoc += $value->valor;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                if ($value->creditodebito == 'D') {
                                                    if ($value->dtbaixa) { 
                                                        echo $this->Number->currency($value->valorbaixa, 'BRL'); 
                                                        $saldo  -= $value->valorbaixa; 
                                                        $saldod += $value->valorbaixa;
                                                    } else {
                                                        if ($mergeds > 0) {
                                                            echo $this->Number->currency($value->valor - $valorpago, 'BRL'); 
                                                            $saldo  -= $value->valor - $valorpago; 
                                                            $saldod += $value->valor - $valorpago;
                                                        } else {
                                                            echo $this->Number->currency($value->valor, 'BRL'); 
                                                            $saldo  -= $value->valor; 
                                                            $saldod += $value->valor;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($saldo, 'BRL'); ?>
                                            </td>
                                        </tr>
                                        
                                        <?php
                                    }//if ($value->creditodebito == $creditodebito)
                                    
                                //}//if ($value->dtbaixa == $index)
                                
                            endforeach;
                            
                        }//if (!empty($movimentBanks))
                        
                        /**********************************************************/
                        
                        //MOVIMENTOS DE CAIXAS
                        if (!empty($movimentBoxes)) {
                            
                            foreach ($movimentBoxes as $value):

                                //if ($value->dtbaixa == $index) {
                                    
                                    if ($this->request->data['creditodebito'] == 'C' || $this->request->data['creditodebito'] == 'D') {
                                        //CREDITO OU DÉBITO DEFINIDO
                                        $creditodebito = $this->request->data['creditodebito'];
                                    } else {
                                        //SELECIONADO A OPÇÃO TODOS
                                        $creditodebito = $value->creditodebito;
                                    }

                                    //Identifica o tipo de vínculo
                                    if ($value->Moviments['ordem']) {
                                        $ordem = $value->Moviments['ordem'];
                                        $tipoVinculo = __('Contas P/R');
                                    } elseif ($value->Transfers['ordem']) {
                                        $ordem = $value->Transfers['ordem'];
                                        $tipoVinculo = __('Transferência');
                                    } elseif (!$value->Moviments['ordem'] && !$value->Transfers['ordem']) {
                                        $ordem = $value->ordem;
                                        $tipoVinculo = __('Mov. Caixa');
                                    } else {
                                        $ordem = 0;
                                        $tipoVinculo = "-";
                                    }
                                    
                                    if ($value->creditodebito == $creditodebito) {
                                        $exists = $value->ordem;
                                        ?>
                                        <tr>
                                            <td class="text-left text-nowrap col-xs-1 hidden-print">
                                                <?= __('Mov.Caixa') ?>
                                            </td>
                                            <td class="text-center text-nowrap col-xs-1 hidden-print">
                                                <?= $tipoVinculo ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= ($ordem ? str_pad($ordem, 6, '0', STR_PAD_LEFT) : '') ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1 hidden-print">
                                                <?= __('Baixado') ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= date("d/m/Y", strtotime($value->dtbaixa)) ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?php 
                                                if ($value->dtbaixa) { 
                                                    echo date("d/m/Y", strtotime($value->dtbaixa));
                                                }
                                                ?>
                                            </td>
                                            <td class="text-left text-nowrap col-xs-1">
                                                <?= h($value->Costs['title']) ?>
                                            </td>
                                            <td class="text-left">
                                                <?= $value->historico ?>
                                            </td>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($value->valor, 'BRL'); ?>
                                            </td>
                                            <td>
                                            <?php
                                            
                                                $valorpago = $mergeds = 0;
                                                
                                                if (!empty($movimentMergeds->toArray())) {
                                                    
                                                    foreach ($movimentMergeds as $merged):
                                                        
                                                        if ($merged->Moviment_Mergeds['ordem'] == $value->moviments_id) { //TÍTULO VINCULADO
                                                            
                                                            $mergeds++;
                                                            
                                                        }
                                                        
                                                    endforeach;
                                                    
                                                }//if (!empty($movimentMergeds->toArray()))
                                                
                                                if ($mergeds > 0) {
                                                    echo '<i class="fa fa-paperclip pull-right" title="'.__('Este título é uma baixa parcial e está vinculado.').'"></i> ';
                                                    $showClip = true;
                                                }//if ($mergeds > 0)
                                                
                                            ?>
                                            </td>
                                            <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                if ($value->creditodebito == 'C') {
                                                    if ($value->dtbaixa) { 
                                                        echo $this->Number->currency($value->valorbaixa, 'BRL'); 
                                                        $saldo  += $value->valorbaixa; 
                                                        $saldoc += $value->valorbaixa;
                                                    } else {
                                                        if ($mergeds > 0) {
                                                            echo $this->Number->currency($value->valor - $valorpago, 'BRL'); 
                                                            $saldo  += $value->valor - $valorpago; 
                                                            $saldoc += $value->valor - $valorpago;
                                                        } else {
                                                            echo $this->Number->currency($value->valor, 'BRL'); 
                                                            $saldo  += $value->valor; 
                                                            $saldoc += $value->valor;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?php
                                                if ($value->creditodebito == 'D') {
                                                    if ($value->dtbaixa) { 
                                                        echo $this->Number->currency($value->valorbaixa, 'BRL'); 
                                                        $saldo  -= $value->valorbaixa; 
                                                        $saldod += $value->valorbaixa;
                                                    } else {
                                                        if ($mergeds > 0) {
                                                            echo $this->Number->currency($value->valor - $valorpago, 'BRL'); 
                                                            $saldo  -= $value->valor - $valorpago; 
                                                            $saldod += $value->valor - $valorpago;
                                                        } else {
                                                            echo $this->Number->currency($value->valor, 'BRL'); 
                                                            $saldo  -= $value->valor; 
                                                            $saldod += $value->valor;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                                            <td class="text-right text-nowrap col-xs-1">
                                                <?= $this->Number->currency($saldo, 'BRL'); ?>
                                            </td>
                                        </tr>
                                        
                                        <?php
                                    }//if ($value->creditodebito == $creditodebito)
                                    
                                //}//if ($consulta == true)
                                
                            endforeach;
                            
                        }//if (!empty($movimentBoxes))
                        
                        ?>
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue">
                            <th colspan="7"></th>
                            <th colspan="3" class="hidden-print"></th>
                            <?php if ($this->request->data['creditodebito'] != 'D') { //SOMENTE CRÉDITOS ?>
                            <th class="text-right text-nowrap col-xs-1">
                                <?= $this->Number->currency($saldoc, 'BRL'); $geral_credito += $saldoc; ?>
                            </th>
                            <?php } if ($this->request->data['creditodebito'] != 'C') { //SOMENTE DÉBITOS ?>
                            <th class="text-right text-nowrap col-xs-1">
                                <?= $this->Number->currency($saldod, 'BRL'); $geral_debito += $saldod; ?>
                            </th>
                            <?php } //CONTROLE DE CRÉDITOS E DÉBITOS ?>
                            <th class="text-right text-nowrap col-xs-1">
                                <?= $this->Number->currency($saldo, 'BRL'); ?>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <?php
        //endforeach; ?>
        
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
        echo '*Valores de títulos baixados consideram o desconto.<br/>';
        if (!empty($movimentRecurrents)) { echo "**Valores de títulos recorrentes foram provisionados.<br/>"; }
        if (isset($showClip)) { echo '<i class="fa fa-paperclip"></i> Há títulos vinculados em faturas, ou baixas parciais, ou o título é uma baixa parcial.'; }
        
    } else { 
        echo '<h4 class="text-center text-nowrap">'.__('Não há registros para o filtro selecionado.').'</h4>';
    } ?>
</div>
<?= $this->element('report-footer'); ?>