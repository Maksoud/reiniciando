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
        <div class="box panel panel-default bottom-20" style="padding:0;">
            <div class="table-responsive">
                <table class="table no-margin table-condensed" style="margin: -10px 0 -15px -5px;">
                    <thead>
                        <th></th>
                        <th class="text-center text-nowrap">
                            <?= __('Em Atraso') ?>
                        </th>
                        <th class="text-center text-nowrap">
                            <?= __('Hoje') ?>
                        </th>
                        <th class="text-center text-nowrap">
                            <?= __('A Vencer') ?>
                        </th>
                    </thead>
                    <tbody>
                        <!-- RECEITAS-->
                        <tr>
                            <td class="text-left">
                                <?= $this->Html->link(__(' Receitas'), '#collapseReceitas', ['class' => 'scroll btn fa fa-plus-circle', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                            </td>
                            <!-- VENCIDOS-->
                            <td class="text-center padding-15" style="color: #ce8483">
                            <?php
                                $valorpago = $creditosLateC = $totalCreditosLateC = 0;

                                if ($creditos_late) {

                                    foreach ($creditos_late as $value):

                                        $creditosLateC += 1;
                                        if ($value->status == 'P') {

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

                                            endforeach;
                                            $totalCreditosLateC += $value->valor - $valorpago;

                                        } else {
                                            $totalCreditosLateC += $value->valor;

                                        }//if ($value->status == 'P')

                                    endforeach; 

                                }//if ($creditos_late)

                                if ($creditosLateC > 0) { echo $this->Number->precision($totalCreditosLateC, 2).' ('.$creditosLateC.')'; } else { echo '-'; }
                            ?>
                            </td>
                            <!-- VENCEM HOJE-->
                            <td class="text-center padding-15" style="color: #0a0">
                            <?php 
                                $valorpago = $creditosMesC = $totalDiaC = 0;

                                if ($creditos_dia) {

                                    foreach ($creditos_dia as $value):

                                        $creditosMesC += 1;
                                        if ($value->status == 'P') {

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

                                            endforeach;
                                            $totalDiaC += $value->valor - $valorpago;

                                        } else {

                                            $totalDiaC += $value->valor;

                                        }//if ($value->status == 'P') 

                                    endforeach;

                                }//if ($creditos_dia)

                                if ($creditosMesC > 0) { echo $this->Number->precision($totalDiaC, 2).' ('.$creditosMesC.')'; } else { echo '-'; }
                            ?>
                            </td>
                            <!-- A VENCER-->
                            <td class="text-center padding-15" style="color: #2aabd2">
                            <?php 
                                $valorpago = $creditosFuturoC = $totalCreditosFuturoC = 0;

                                if ($creditos_future) {

                                    foreach ($creditos_future as $value):

                                        $creditosFuturoC += 1;
                                        if ($value->status == 'P') {

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

                                            endforeach;
                                            $totalCreditosFuturoC += $value->valor - $valorpago;

                                        } else {

                                            $totalCreditosFuturoC += $value->valor;

                                        }//if ($value->status == 'P')

                                    endforeach;

                                }//if ($creditos_future)

                                if ($creditosFuturoC > 0) { echo $this->Number->precision($totalCreditosFuturoC, 2).' ('.$creditosFuturoC.')'; } else { echo '-'; } 
                            ?>
                            </td>
                        </tr>
                        <!-- DESPESAS-->
                        <tr>
                            <td class="text-left">
                                <?= $this->Html->link(__(' Despesas'), '#collapseDespesas', ['class' => 'scroll btn fa fa-minus-circle', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                            </td>
                            <!-- VENCIDOS-->
                            <td class="text-center padding-15" style="color: #ce8483">
                            <?php 
                                $valorpago = $debitosLateD = $totalDebitosLateD = 0;

                                if ($debitos_late) {

                                    foreach ($debitos_late as $value):

                                        $debitosLateD += 1;
                                        if ($value->status == 'P') {

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

                                            endforeach;
                                            $totalDebitosLateD += $value->valor - $valorpago;

                                        } else {

                                            $totalDebitosLateD += $value->valor;

                                        }//if ($value->status == 'P')

                                    endforeach;

                                }//if ($debitos_late)

                                if ($debitosLateD > 0) { echo $this->Number->precision($totalDebitosLateD, 2).' ('.$debitosLateD.')'; } else { echo '-'; } 
                            ?>
                            </td>
                            <!-- VENCEM HOJE-->
                            <td class="text-center padding-15" style="color: #0a0">
                            <?php 
                                $valorpago = $debitosMesD = $totalDebitosMesD = 0;

                                if ($debitos_dia) {

                                    foreach ($debitos_dia as $value):

                                        $debitosMesD += 1;
                                        if ($value->status == 'P') {

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

                                            endforeach;
                                            $totalDebitosMesD += $value->valor - $valorpago;

                                        } else {

                                            $totalDebitosMesD += $value->valor;

                                        }//if ($value->status == 'P')

                                    endforeach;

                                }//if ($debitos_dia)

                                if ($debitosMesD > 0) { 
                                    echo $this->Number->precision($totalDebitosMesD, 2).' ('.$debitosMesD.')'; 
                                } else { 
                                    echo '-'; 
                                }
                            ?>
                            </td>
                            <!-- A VENCER-->
                            <td class="text-center padding-15" style="color: #2aabd2">
                            <?php 
                                $valorpago = $debitosFuturosD = $totalDebitosFuturoD = 0;

                                if ($debitos_future) {

                                    foreach ($debitos_future as $value):

                                        $debitosFuturosD += 1;
                                        if ($value->status == 'P') {

                                            foreach ($movimentMergeds as $merged):

                                                if ($merged->moviments_id == $value->id) {
                                                    if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                        $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                    }
                                                }//if ($merged->moviments_id == $value->id)

                                            endforeach;
                                            $totalDebitosFuturoD += $value->valor - $valorpago;

                                        } else {

                                            $totalDebitosFuturoD += $value->valor;

                                        }//if ($value->status == 'P')

                                    endforeach; 

                                }//if ($debitos_future)

                                if ($debitosFuturosD > 0) { 
                                    echo $this->Number->precision($totalDebitosFuturoD, 2).' ('.$debitosFuturosD.')'; 
                                } else { 
                                    echo '-'; 
                                } 
                            ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- /////////////////////////////////////////////////////////////////////// -->

        <div class="bottom-20 collapse" id="collapseReceitas">
            <?php 
            $count = 0;
            if (isset($creditos)) {
                foreach ($creditos as $moviment):
                    $count += 1;
                endforeach; 
            }//if (isset($creditos))
            if ($count > 0) { ?>
                <div class="box panel panel-default" style="padding:0;">
                    <div class="panel-heading box-header" style="background-color: #d9edf7;">
                        <span class="text-bold"><?= __('CONTAS A RECEBER').' ('.$count.')' ?></span>
                        <h5><small>(*) Com vencimento até <?= date("t/m/Y");?></small></h5>
                    </div>
                    <div class="box-body panel-body" style="max-height: 500px; overflow-y: scroll;"> 
                        <div class="table-responsive">
                            <table class="table no-margin table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                        <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                        <th class="text-left"><?= __('Cliente/Fornecedor') ?></th>
                                        <?php }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) ?>
                                        <th class="text-left"><?= __('Histórico') ?></th>
                                        <th class="text-right"><?= __('Valor') ?></th>
                                        <th></th>
                                        <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($creditos as $moviment): ?>
                                        <tr>
                                            <td class="text-left"><?= $moviment->ordem ?></td>
                                            <td class="text-left">
                                            <?php if ($moviment->vencimento < date('Y-m-d')) { ?>
                                                <span style="color: #ce8483">
                                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                                </span>    
                                            <?php } elseif ($moviment->vencimento > date('Y-m-d')) { ?>
                                                <span style="color: #2aabd2">
                                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                                </span>
                                            <?php } elseif ($moviment->vencimento == date('Y-m-d')) { ?>
                                                <span style="color: #0a0">
                                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                                </span>
                                            <?php }//elseif ($moviment->vencimento == date('Y-m-d')) ?>
                                            </td>
                                            <td class="text-left"><?= ($moviment->documento) ?></td>
                                            <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                            <td class="text-left">
                                                <?= h($moviment->Providers['title']) ?>
                                                <?= h($moviment->Customers['title']) ?>
                                            </td>
                                            <?php }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) ?>
                                            <td class="text-left"><?= ($moviment->historico) ?></td>
                                            <td class="text-right text-nowrap">
                                            <?php
                                                $valorpago = 0;
                                                if ($moviment->status == 'P') {
                                                    if (!empty($movimentMergeds->toArray())) { 
                                                        foreach ($movimentMergeds as $merged):
                                                            if ($merged->moviments_id == $moviment->id) {
                                                                if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                                    $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                                } else {
                                                                    $valorpago += $merged->Moviment_Mergeds['valor'];
                                                                }
                                                            }//if ($merged->moviments_id == $moviment->id)
                                                        endforeach;
                                                    }
                                                }//if ($moviment->status == 'P')
                                                echo $this->Number->precision($moviment->valor - $valorpago, 2); 
                                            ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($moviment->creditodebito == 'C') { ?>
                                                    <i class="fa fa-plus-circle" style="color: lightblue" title="Crédito"></i>
                                                <?php } elseif ($moviment->creditodebito == 'D') { ?>
                                                    <i class="fa fa-minus-circle" style="color: #e4b9c0" title="Débito"></i>
                                                <?php }//elseif ($moviment->creditodebito == 'D')

                                                //Lista os movimentos recorrentes
                                                if ($movimentRecurrents) {
                                                    foreach($movimentRecurrents as $movimentRecurrent):
                                                        if ($moviment->id == $movimentRecurrent->id) { ?>
                                                            <i class="fa fa-repeat" style="color: lightblue" title="Recorrente"></i>
                                                            <?php 
                                                        }//if ($moviment->id == $movimentRecurrent->id)
                                                    endforeach;
                                                }//if ($movimentRecurrents)
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php 
                                                switch($moviment->status) {
                                                    case 'A': echo h("Aberto"); break;
                                                    case 'B': echo h("Baixado"); break;
                                                    case 'C': echo h("Cancelado"); break;
                                                    case 'G': echo h("Agrupado"); break;
                                                    case 'V': echo h("Vinculado"); break;
                                                    case 'O': echo h("B.Parcial"); break;
                                                    case 'P': echo h("Parcial"); break;
                                                }//switch($moviment->status)
                                                ?>
                                            </td>
                                            <td class="btn-actions-group">
                                                <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                                    <?php if ($moviment->status == 'A') { ?>
                                                        <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                        <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Baixar Lançamento', 'title' => __('Baixar'), 'escape' => false]) ?>
                                                        <?php if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) { ?>
                                                            <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Agrupar Lançamentos', 'title' => 'Agrupar', 'escape' => false]) ?>
                                                        <?php }//if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) ?>
                                                        <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                        <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                                    <?php } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                                    <?php }//elseif ($moviment->status == 'B') ?>
                                                    <?php if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'C') ?>
                                                    <?php if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?php } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                                    <?php }//elseif ($moviment->status == 'O') ?>
                                                    <?php if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => 'Carregando...', 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Baixar Lançamento', 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'P') ?>
                                                    <?php if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Agrupar Lançamentos', 'title' => 'Agrupar', 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Baixar Lançamento', 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) ?>
                                                <?php } elseif ($this->request->Session()->read('sessionPlan') == 1) { //Plano Simples ?>
                                                    <?php if ($moviment->status == 'A') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                                    <?php } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                                    <?php }//elseif ($moviment->status == 'B') ?>
                                                    <?php if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'C') ?>
                                                    <?php if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?php } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                                    <?php }//elseif ($moviment->status == 'O') ?>
                                                    <?php if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'P') ?>
                                                    <?php if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) ?>
                                                <?php } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
                                                    <?php if ($moviment->status == 'A') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                                    <?php } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                                    <?php }//elseif ($moviment->status == 'B') ?>
                                                    <?php if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => __('Excluir'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'C') ?>
                                                    <?php if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?php } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar'), 'escape' => false]) ?>
                                                    <?php }//elseif ($moviment->status == 'O') ?>
                                                    <?php if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'P') ?>
                                                    <?php if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar'), 'escape' => false]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar'), 'escape' => false]) ?>
                                                    <?php }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) ?>
                                                <?php }//elseif ($this->request->Session()->read('sessionPlan') == 4) ?>
                                            </td>
                                        </tr>
                                        <?php 
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading" style="font-size: 11px;">
                        <span class="text-bold">Legenda:</span><br />
                        <span style="color: #ce8483">Datas de Contas Vencidas, </span>
                        <span style="color: #0a0">Contas que Vencem Hoje e </span>
                        <span style="color: #2aabd2">Contas a Vencer.</span>
                    </div>
                </div>
                <?php 
            }//if ($count > 0) ?>
        </div>

        <!-- /////////////////////////////////////////////////////////////////////// -->

        <div class="bottom-20 collapse" id="collapseDespesas">
            <?php 
            $count = 0;
            if (isset($debitos)) {
                foreach ($debitos as $moviment):
                    $count += 1;
                endforeach;
            }
            if ($count > 0) { ?>
                <div class="box panel panel-default" style="padding:0;">
                    <div class="panel-heading box-header" style="background-color: #f2dede;">
                        <span class="text-bold"><?= __('CONTAS A PAGAR').' ('.$count.')' ?></span>
                        <h5><small>(*) Com vencimento até <?= date("t/m/Y");?></small></h5>
                    </div>
                    <div class="box-body panel-body" style="max-height: 500px; overflow-y: scroll;">
                        <div class="table-responsive">
                            <table class="table table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                        <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                        <th class="text-left"><?= __('Cliente/Fornecedor') ?></th>
                                        <?php }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) ?>
                                        <th class="text-left"><?= __('Histórico') ?></th>
                                        <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                                        <th></th>
                                        <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($debitos as $moviment): ?>
                                        <tr>
                                            <td class="text-left"><?= ($moviment->ordem) ?></td>
                                            <td class="text-left">
                                            <?php if ($moviment->vencimento < date('Y-m-d')) { ?>
                                                <span style="color: #ce8483">
                                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                                </span>    
                                            <?php } elseif ($moviment->vencimento > date('Y-m-d')) { ?>
                                                <span style="color: #2aabd2">
                                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                                </span>
                                            <?php } elseif ($moviment->vencimento == date('Y-m-d')) { ?>
                                                <span style="color: #0a0">
                                                    <?= date("d/m/Y", strtotime($moviment->vencimento)) ?>
                                                </span>
                                            <?php } ?>
                                            </td>
                                            <td class="text-left"><?= ($moviment->documento) ?></td>
                                            <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                            <td class="text-left">
                                                <?= h($moviment->Providers['title']) ?>
                                                <?= h($moviment->Customers['title']) ?>
                                            </td>
                                            <?php }//if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) ?>
                                            <td class="text-left"><?= ($moviment->historico) ?></td>
                                            <td class="text-right text-nowrap">
                                            <?php
                                                $valorpago = 0;
                                                if ($moviment->status == 'P') {
                                                    if (!empty($movimentMergeds->toArray())) { 
                                                        foreach ($movimentMergeds as $merged):
                                                            if ($merged->moviments_id == $moviment->id) {
                                                                if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                                    $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                                }
                                                            }
                                                        endforeach;
                                                    }
                                                }//if ($moviment->status == 'P')
                                                echo $this->Number->precision($moviment->valor - $valorpago, 2);
                                            ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($moviment->creditodebito == 'C') { ?>
                                                    <i class="fa fa-plus-circle" style="color: lightblue" title="Crédito"></i>
                                                <?php } elseif ($moviment->creditodebito == 'D') { ?>
                                                    <i class="fa fa-minus-circle" style="color: #e4b9c0" title="Débito"></i>
                                                <?php }
                                                //Lista os movimentos recorrentes
                                                if ($movimentRecurrents) {
                                                    foreach($movimentRecurrents as $movimentRecurrent):
                                                        if ($moviment->id == $movimentRecurrent->id) { ?>
                                                            <i class="fa fa-repeat" style="color: lightblue" title="Recorrente"></i>
                                                <?php }//if ($moviment->id == $movimentRecurrent->id)
                                                    endforeach;
                                                }//if ($movimentRecurrents)
                                                ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($moviment->status == 'A') echo h("Aberto"); ?>
                                                <?php if ($moviment->status == 'B') echo h("Baixado"); ?>
                                                <?php if ($moviment->status == 'C') echo h("Cancelado"); ?>
                                                <?php if ($moviment->status == 'G') echo h("Agrupado"); ?>
                                                <?php if ($moviment->status == 'V') echo h("Vinculado"); ?>
                                                <?php if ($moviment->status == 'O') echo h("B.Parcial"); ?>
                                                <?php if ($moviment->status == 'P') echo h("Parcial"); ?>
                                            </td>
                                            <td class="btn-actions-group">
                                                <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { //Plano Completo ?>
                                                    <?php if ($moviment->status == 'A') { ?>
                                                        <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                        <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Baixar Lançamento', 'title' => __('Baixar')]) ?>
                                                        <?php if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) { ?>
                                                        <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn_modal2 btn btn-actions btn_modal2 fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Agrupar Lançamentos', 'title' => 'Agrupar']) ?>
                                                        <?php }//if ($moviment['vinculapgto'] == 'S' && empty($moviment['cards_id'])) ?>
                                                        <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => 'Editar']) ?>
                                                        <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']) ?>
                                                    <?php } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => 'Editar']) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => 'Cancelar']) ?>
                                                    <?php }//elseif ($moviment->status == 'B') ?>
                                                    <?php if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => 'Editar']) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']) ?>
                                                    <?php }//if ($moviment->status == 'C') ?>
                                                    <?php if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?php } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => 'Editar']) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => 'Cancelar']) ?>
                                                    <?php }//elseif ($moviment->status == 'O') ?>
                                                    <?php if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Baixar Lançamento', 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => 'Editar']) ?>
                                                    <?php }//if ($moviment->status == 'P') ?>
                                                    <?php if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'view', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'group', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-th-list', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Agrupar Lançamentos', 'title' => 'Agrupar']) ?>
                                                    <?= $this->Html->link('', ['action' => 'low', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => 'Baixar Lançamento', 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit', $moviment->id], ['class' => 'btn_modal2 btn btn-actions fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => 'Editar']) ?>
                                                    <?php }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) ?>
                                                <?php } elseif ($this->request->Session()->read('sessionPlan') == 1) { //Plano Simples ?>
                                                    <?php if ($moviment->status == 'A') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']) ?>
                                                    <?php } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]) ?>
                                                    <?php }//elseif ($moviment->status == 'B') ?>
                                                    <?php if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']) ?>
                                                    <?php }//if ($moviment->status == 'C') ?>
                                                    <?php if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?php } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]) ?>
                                                    <?php }//elseif ($moviment->status == 'O') ?>
                                                    <?php if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?php }//if ($moviment->status == 'P') ?>
                                                    <?php if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?php }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) ?>
                                                <?php } elseif ($this->request->Session()->read('sessionPlan') == 4) { //Plano Simples ?>
                                                    <?php if ($moviment->status == 'A') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']) ?>
                                                    <?php } elseif ($moviment->status == 'B') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]) ?>
                                                    <?php }//elseif ($moviment->status == 'B') ?>
                                                    <?php if ($moviment->status == 'C') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'delete', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'title' => 'Excluir']) ?>
                                                    <?php }//if ($moviment->status == 'C') ?>
                                                    <?php if ($moviment->status == 'V') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?php } elseif ($moviment->status == 'O') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_baixado_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?= $this->Form->postLink('', ['action' => 'cancel', 'controller' => 'Moviments', $moviment->id], ['confirm' => __('Você tem certeza que deseja CANCELAR o registro?'), 'class' => 'btn btn-actions fa fa-times', 'title' => __('Cancelar')]) ?>
                                                    <?php }//elseif ($moviment->status == 'O') ?>
                                                    <?php if ($moviment->status == 'P') { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', 'controller' => 'Moviments', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?php }//if ($moviment->status == 'P') ?>
                                                    <?php if ($moviment->status == 'G' && empty($moviment['cards_id'])) { ?>
                                                    <?= $this->Html->link('', ['action' => 'view_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-eye', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'title' => __('Visualizar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'low_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-arrow-circle-o-down', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Baixar Lançamento'), 'title' => __('Baixar')]) ?>
                                                    <?= $this->Html->link('', ['action' => 'edit_simple', $moviment->id], ['class' => 'btn btn-actions btn_modal2 fa fa-pencil', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Editar Cadastro'), 'title' => __('Editar')]) ?>
                                                    <?php }//if ($moviment->status == 'G' && empty($moviment['cards_id'])) ?>
                                                <?php }//elseif ($this->request->Session()->read('sessionPlan') == 4) ?>
                                            </td>
                                        </tr>
                                        <?php 
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-heading" style="font-size: 11px;">
                        <span class="text-bold">Legenda:</span><br />
                        <span style="color: #ce8483">Datas de Contas Vencidas, </span>
                        <span style="color: #0a0">Contas que Vencem Hoje e </span>
                        <span style="color: #2aabd2">Contas a Vencer.</span>
                    </div>
                </div>
                <?php 
            }//if ($count > 0) ?>
        </div>

    </div>
    
</div>