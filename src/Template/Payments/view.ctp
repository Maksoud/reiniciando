<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Payments */
/* File: src/Template/Payments/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9">
        
        <div class="col-md-12 panel-group box">
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= __('Razão Social') ?></label><br>
                    <?= h($payment->Parameters['razao']) ?>
                </div>
                <div class="form-group">
                    <label><?= __('E-mail de Cobrança') ?></label><br>
                    <?= h($payment->Parameters['email_cobranca']) ?>
                </div>
                <div class="form-group">
                    <label><?= __('Plano Atual') ?></label><br>
                    <?= $this->Parameters->planos($payment->Parameters['plano']) ?>
                </div>
                <div class="form-group">
                    <label><?= __('Validade') ?></label><br>
                    <?= date("d/m/Y", strtotime($payment->Parameters['dtvalidade'])) ?>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group">
                    <label><?= __('Valor da Fatura') ?></label><br>
                    <?= $this->Number->precision($payment->valor, 2) ?>
                </div>
                <div class="form-group">
                    <label><?= __('Vencimento') ?></label><br>
                    <?= date("d/m/Y", strtotime($payment->vencimento)) ?>
                </div>
                <div class="form-group">
                    <label><?= __('Período') ?></label><br>
                    <?= h($payment->periodo . ' Meses') ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 panel-group bg-info box">
            <div class="text-center"><h4><span class="text-bold">NOSSOS PLANOS</span></h4></div>
            <table class="table table-hover table-condensed text-center">
                <thead>
                    <tr>
                        <th></th>
                        <th style="text-align: center">Pessoal</th>
                        <th style="text-align: center">Simples</th>
                        <th style="text-align: center">Completo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="text-align: right">Mensalidades*</th>
                        <th style="background-color: white; text-align: center">29,90</th>
                        <th style="background-color: white; text-align: center">69,90</th>
                        <th style="background-color: white; text-align: center">129,90</th>
                    </tr>
                    <tr>
                        <th style="text-align: right">Taxa de Instalação</th>
                        <td style="background-color: white">-</td>
                        <td style="background-color: white">-</td>
                        <td style="background-color: white">-</td>
                    </tr>
                    <tr>
                        <th style="text-align: right">Controle Financeiro</th>
                        <td style="background-color: white">Sim</td>
                        <td style="background-color: white">Sim</td>
                        <td style="background-color: white">Sim</td>
                    </tr>
                    <tr>
                        <th style="text-align: right">Controle de Estoque</th>
                        <td style="background-color: white">-</td>
                        <td style="background-color: white">-</td>
                        <td style="background-color: white">Sim</td>
                    </tr>
                    <tr>
                        <th style="text-align: right">Cadastros de Empresas</th>
                        <td style="background-color: white">1</td>
                        <td style="background-color: white">Ilimitado</td>
                        <td style="background-color: white">Ilimitado</td>
                    </tr>
                    <tr>
                        <th style="text-align: right">Contas de Usuários</th>
                        <td style="background-color: white">1</td>
                        <td style="background-color: white">5</td>
                        <td style="background-color: white">Ilimitado</td>
                    </tr>
                    <tr>
                        <th style="text-align: right">Relatórios</th>
                        <td style="background-color: white">Sim</td>
                        <td style="background-color: white">Sim</td>
                        <td style="background-color: white">Sim</td>
                    </tr>
                </tbody>
            </table>
            <span style="font-size: 10px">*Planos comercializados nas modalidades trimestral, semestral e anual.</span>
        </div>
    </div>
    
    <div class="col-md-3 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Cód.Cobrança') ?></label><br>
            <?= '#'.str_pad($payment->id, 6, '0', STR_PAD_LEFT) ?>
        </div>
    </div>
    
    <div class="col-md-3 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Payments->status($payment->status) ?>
        </div>
    </div>
    
    <div class="col-md-3 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($payment->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($payment->modified) ?></span>
        </div>
    </div>
    
        
</div>