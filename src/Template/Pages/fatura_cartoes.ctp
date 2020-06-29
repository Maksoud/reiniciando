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
/* File: src/Template/Pages/extratos.ctp */
?>

<?php $this->layout = 'ajax'; ?>


<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
        
        <?php 
        if (!empty($faturas_cartoes->toArray())) {
            ?>
            <div class="row">
                <div class="box panel panel-default" style="padding:0;">
                    <div class="panel-heading box-header" id="numero1">
                        <span class="text-bold"><i class="fa fa-credit-card-alt"></i> <?= __('Relação das Faturas dos Cartões de Crédito') ?>*</span>
                        <h5>
                            <small>(*) <?= __('Vencimentos até') ?> <?= date("t/m/Y", strtotime("+ 60 days"));?></small><br/>
                            <small>(**) <?= __('Títulos recorrentes são gerados após o vencimento.') ?></small>
                        </h5>
                    </div>
                    <div class="box-body panel-body">
                        <div class="table-responsive">
                            <table class="table no-margin font-12">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                        <th class="text-left"><?= __('Cartão') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Venc.') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Valor') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    foreach ($faturas_cartoes as $fatura):

                                        //Valor da fatura
                                        $valor = $fatura->valor;
                                        
                                        //ANALISA BAIXAS PARCIAIS
                                        if ($movimentMergeds->toArray()) {
        
                                            foreach ($movimentMergeds as $movimentMerged):
        
                                                if ($movimentMerged->moviments_id == $fatura->id) {
                                                    if ($movimentMerged->Moviment_Mergeds['status'] == 'O' || $movimentMerged->Moviment_Mergeds['status'] == 'B') {
                                                        //Deduz o valor pago parcial
                                                        $valor -= $movimentMerged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//else if ($movimentMerged->moviments_id == $fatura->id)
        
                                            endforeach;
        
                                        }//if ($movimentMergeds)
                                        ?>
                                        <tr>
                                            <td class="text-left"><?= str_pad($fatura->ordem, 6, '0', STR_PAD_LEFT) ?></td>
                                            <td class="text-left"><?= $fatura->Cards['title']; ?></td>
                                            <td class="text-left">
                                                <?php if ($fatura->vencimento < date('Y-m-d')) { ?>
                                                    <span style="color: #ce8483">
                                                        <?= date("d/m/Y", strtotime($fatura->vencimento)) ?>
                                                    </span>    
                                                <?php } elseif ($fatura->vencimento > date('Y-m-d')) { ?>
                                                    <span style="color: #2aabd2">
                                                        <?= date("d/m/Y", strtotime($fatura->vencimento)) ?>
                                                    </span>
                                                <?php } elseif ($fatura->vencimento == date('Y-m-d')) { ?>
                                                    <span style="color: #0a0">
                                                        <?= date("d/m/Y", strtotime($fatura->vencimento)) ?>
                                                    </span>
                                                <?php }//elseif ($fatura->vencimento == date('Y-m-d')) ?>
                                            </td>
                                            <td class="text-right"> <?= $this->Number->precision($valor, 2) ?></td>
                                            <td class="btn-actions-group">
                                                <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                <?php } elseif ($this->request->Session()->read('sessionPlan') == 1) { //Plano Simples ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $fatura->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                <?php }//elseif ($this->request->Session()->read('sessionPlan') == 1) ?>
                                            </td>
                                        </tr>
                                        <?php

                                    endforeach; 
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } //if (!empty($faturas_cartoes)) { 
        else {
            echo '<h4 class="text-center">Não há registros.</h4>';
        } 
        ?>
    </div>
</div>