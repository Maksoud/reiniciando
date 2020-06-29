<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Aviso_Gratis */
/* File: src/Template/Pages/aviso_gratis.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<!-- DESENVOLVIMENTO -->
<script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://sandbox.gerencianet.com.br/v1/cdn/2e8f549dd42f5a547f51910f11f297d2/'+v;s.async=false;s.id='2e8f549dd42f5a547f51910f11f297d2';if (!document.getElementById('2e8f549dd42f5a547f51910f11f297d2')) {document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn) {$gn.done=fn;}};</script>

<!-- PRODUÇÃO 
<script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://api.gerencianet.com.br/v1/cdn/2e8f549dd42f5a547f51910f11f297d2/'+v;s.async=false;s.id='2e8f549dd42f5a547f51910f11f297d2';if (!document.getElementById('2e8f549dd42f5a547f51910f11f297d2')) {document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn) {$gn.done=fn;}};</script>
-->

<div class="container-fluid">
    
    <div class="col-xs-12">
        <div class="text-center">
            <h2>A função selecionada não está disponível nessa versão</h2><br>
            <h4>Consulte na lista abaixo as funções permitidas para cada versão do sistema:</h4><br>

            <div class="row">
                <div class="col-sm-offset-1 col-xs-9 scrolling" style="background-color: #d2d9e5; margin-bottom: 20px; font-size: 12px;">
                    <table class="table table-hover table-condensed text-center">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="text-align: center">Limitado</th>
                                <th style="text-align: center">Pessoal</th>
                                <th style="text-align: center">Simples</th>
                                <th style="text-align: center">Completo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th style="text-align: right">Mensalidades*</th>
                                <th style="background-color: white; text-align: center">0,00</th>
                                <th style="background-color: white; text-align: center">39,90*</th>
                                <th style="background-color: white; text-align: center">69,90*</th>
                                <th style="background-color: white; text-align: center">119,90*</th>
                            </tr>
                            <tr>
                                <th style="text-align: right">Taxa de Instalação</th>
                                <td style="background-color: white">-</td>
                                <td style="background-color: white">-</td>
                                <td style="background-color: white">-</td>
                                <td style="background-color: white">-</td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Backup completo automático</th>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Controle das contas a pagar e receber</th>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Pagamento parcial das contas a pagar/receber</th>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Relatórios Detalhados</th>
                                <td style="background-color: white"><?= $this->Html->image('on_off_alert.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Alertas por e-mail com resumo das contas</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Controle de cartão de crédito</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Acompanhamento de planejamentos e Metas</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Transferências entre contas</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Agrupamento de lançamentos em faturas</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Controle de Cheques Emitidos</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Múltiplos Usuários</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on_off_alert.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Múltiplas Empresas/Perfis (multifilial)</th>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('off.png', ['width' => '10px']) ?></td>
                                <td style="background-color: white"><?= $this->Html->image('on.png', ['width' => '10px']) ?></td>
                            </tr>
                            <tr>
                                <th style="text-align: right">Ideal Para</th>
                                <td style="font-size: 9px; background-color: white">Controle Pessoal (limitado)</td>
                                <td style="font-size: 9px; background-color: white">Controle Pessoal</td>
                                <td style="font-size: 9px; background-color: white">Micro e Pequenas Empresas</td>
                                <td style="font-size: 9px; background-color: white">Empresas de Médio Porte</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="text-left font-10">
                        *Planos comercializados nas modalidades trimestral, semestral e anual.<br>
                        <?= $this->Html->image('on.png', ['width' => '10px']) ?> Função disponível<br>
                        <?= $this->Html->image('on_off_alert.png', ['width' => '10px']) ?> Função disponível com limitações<br>
                        <?= $this->Html->image('off.png', ['width' => '10px']) ?> Função não disponível
                    </div>
                </div>

            </div>

            <h4>Para migrar para outra versão, entre em contato através do e-mail Suporte@Reiniciando.com.br</h4>
        </div>


        <div class="col-xs-12">

            <!-- STEP 4 -->
            <div id="step-4" class="" style="margin-bottom: 60px;">
                
                <style>
                div.clear {
                    clear: both;
                }

                div.escolher-planos.disabled div.escolher-planos-item {
                    zoom: 1;
                    filter: alpha(opacity=60);
                    opacity: 0.6;
                    cursor: default;
                }

                div.escolher-planos div.escolher-planos-item {
                    padding: 11px;
                    border-radius: 6px;
                    cursor: pointer;
                    position: relative;
                    border: 4px solid #efefef;
                    margin-bottom: 10px;
                    margin-right: 10px;
                    height: 200px;
                    overflow: hidden;
                }
                div.escolher-planos-item .valor-plano {
                    margin-top: 15px;
                    font-weight: bold; 
                    font-size: 23px; 
                    color: #d82729;
                }
                div.escolher-planos div.escolher-planos-item:hover {
                    border: 4px solid #e2e2e2;
                    background: #f9f9f9;
                } 

                div.escolher-planos div.escolher-planos-item.selected {
                    border: 4px solid #909090;
                    background: #efefef;
                    padding: 8px;
                    filter: alpha(opacity=100);
                    opacity: 1;
                }
                
                div.escolher-planos div.escolher-planos-item img {
                    padding: 0;
                }
                
                div.escolher-planos div.escolher-planos-item span.title {
                    display: block;
                    margin: 10px 0 5px 0;
                    font-weight: bold;
                    font-size: 12px;
                }
                
                div.escolher-planos div.escolher-planos-item span.description {
                    font-size: 12px;
                }
                
                div.escolher-planos div.escolher-planos-item input {
                    position: absolute;
                    left: 0;
                    top: 0;
                    visibility:hidden;
                }
                </style>

                <script>
                $(function() {
                    $('div.escolher-planos').not('.disabled').find('div.escolher-planos-item').on('click', function() {

                        $(this).parent().parent().find('div.escolher-planos-item').removeClass('selected');
                        $(this).addClass('selected');
                        $(this).find('input[type="radio"]').prop("checked", true);
                        
                        $('.valor-pagar').html($('.escolher-planos-item.selected').find('div.valor-plano').html());

                    });

                    $('.valor-pagar').html($('.escolher-planos-item.selected').find('div.valor-plano').html());

                });

                </script>

                <!-- Plano do Anuncio -->
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-titulo titulo"><i class="fa fa-shopping-cart"></i> Selecione um plano <span class="hidden-xs"></span></h4>
                    </div>
                </div>

                <div class="row form-group escolher-planos">
                    <?php foreach ($plans as $key => $plano): ?>
                        <div class="col-xs-12 col-md-3">
                            <div class="escolher-planos-item text-center <?php if ($key == 0) { echo "selected";}?>">
                            
                                <div><?= $plano->title;?></div>
                                <?= $this->Form->hidden('fatura.nome');?>
                                <div style="font-weight: bold; font-size:32px;">
                                    <?php 
                                    if ($plano->description) {
                                        echo "descricao";
                                    }
                                    ?>
                                </div>
                                
                                <div class="valor-plano">
                                    <?= $plano->value ? 'R$ '.$this->Number->precision($plano->value, 2) : 'Grátis'; ?>
                                    <?= $this->Form->hidden('fatura.valor');?>
                                </div>

                                <div class="clear"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                                                                                

                </div>
                <!-- Plano do Anuncio -->

                <!-- Dados da Fatura -->
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="font-titulo titulo">
                            <i class="fa fa-money"></i> 
                            Forma de pagamento
                        </h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist" id="tipo-pagamento-tab">
                                <li role="presentation">
                                    <a href="#cartao-credito" aria-controls="CC" role="tab" data-toggle="tab">
                                        <i class="fa fa-credit-card-alt"></i> 
                                        Cartão de Crédito
                                    </a>
                                </li>
                                <li role="presentation" class="active">
                                    <a href="#boleto-bancario" aria-controls="BO" role="tab" data-toggle="tab">
                                        <i class="fa fa-barcode"></i> 
                                        Boleto Bancário
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content panel panel-default" style="padding:14px 14px;padding-top:20px;border-top: none;">
                                <?= $this->Form->hidden('pagamento.tipo', ['value' => 'BO']);?>
                                <?php //$this->Form->hidden('pagamento.token'); //Utilizado apenas para cartão de crédito?>

                                <div role="tabpanel" class="tab-pane" id="cartao-credito">
                                    <div class="row">
                                        <style>
                                            .cartoes img {
                                                height: 20px;
                                                margin-right: 5px; 
                                                margin-bottom: 6px;
                                            }
                                            #cartao-bandeira {
                                                position: absolute; 
                                                top: 34px;
                                                left: 24px;
                                            }
                                            #cartao-bandeira img {
                                                height: 20px;
                                            }
                                        </style>

                                        <div class="col-md-12">
                                            <!-- DADOS DO CARTÃO -->
                                            <div class="panel panel-default">

                                                <div class="panel-heading strong">
                                                    Dados do Cartão de Crédito
                                                </div>

                                                <!-- CC -->
                                                <div class="panel-body">
                                                    <div class="row"> 
                                                        <div class="col-md-12 cartoes text-center">
                                                            <img src="img/visa.png" title="Visa" alt=""/>
                                                            <img src="img/mastercard.png" title="MasterCard" alt=""/>
                                                            <img src="img/jcb.png" title="JCB" alt=""/>
                                                            <img src="img/diners.png" title="Dinners" alt=""/>
                                                            <img src="img/amex.png" title="American Express" alt=""/>
                                                            <img src="img/discover.png" title="Discover" alt=""/>
                                                            <img src="img/elo.png" title="Elo" alt=""/>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="pagamento.nome">Nome no Cartão</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.nome', ['type'  => 'text',
                                                                                                                       'class' => 'form-control',
                                                                                                                       'id'    => 'pagamento.nome',
                                                                                                                       'label' => false
                                                                                                                      ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label for="pagamento.cartao_numero">Nº do Cartão</label>
                                                                    <?= $this->Form->control('pagamento.cc.cliente.cartao_numero', ['type'      => 'text',
                                                                                                                                  'class'     => 'form-control js_cartao_numero',
                                                                                                                                  'id'        => 'pagamento.cartao_numero',
                                                                                                                                  'label'     => false, 
                                                                                                                                  //'style'    => 'padding-left:56px;'
                                                                                                                                 ]); ?>

                                                                <div id="cartao-bandeira">
                                                                    <img src="/img/icones/cartao/credit.png" alt=""/>
                                                                </div> 
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="pagamento.cartao_vencimento">Vencimento</label>
                                                                <?= $this->Form->control('pagamento.cc.cliente.cartao_vencimento', ['type'        => 'text',
                                                                                                                                  'class'       => 'form-control js_cartao_vencimento',
                                                                                                                                  'id'          => 'pagamento.cartao_vencimento',
                                                                                                                                  'placeholder' => 'MM/AA',
                                                                                                                                  'label'       => false
                                                                                                                                 ]); ?> 
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="pagamento.cartao_cvv">CVV</label>
                                                                <?= $this->Form->control('pagamento.cc.cliente.cartao_cvv', ['type'        => 'text',
                                                                                                                           'class'       => 'form-control js_cartao_cvv',
                                                                                                                           'id'          => 'pagamento.cartao_cvv',
                                                                                                                           'placeholder' => 'CVV',
                                                                                                                           'label'       => false
                                                                                                                          ]); ?> 
                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <!-- DADOS DO CARTÃO -->

                                            <!-- DADOS PESSOAIS -->
                                            <div class="panel panel-default">

                                                <div class="panel-heading strong">
                                                    Dados Pessoais
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="pagamento.nome">Nome Completo</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.nome', ['type'  => 'text',
                                                                                                                       'class' => 'form-control',
                                                                                                                       'id'    => 'pagamento.nome',
                                                                                                                       'label' => false,
                                                                                                                       'value' => $parameter->name
                                                                                                                      ]);?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.cpf">CPF/CNPJ</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.cpf', ['type'  => 'text',
                                                                                                                      'class' => 'form-control js_cpf',
                                                                                                                      'id'    => 'pagamento.cpf',
                                                                                                                      'label' => false,
                                                                                                                      'value' => $parameter->cpfcnpj ? $parameter->cpfcnpj : ''
                                                                                                                     ]); ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.data_nascimento">Nascimento</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.data_nascimento', ['type'  => 'text',
                                                                                                                                  'class' => 'form-control js_data',
                                                                                                                                  'id'    => 'pagamento.data_nascimento',
                                                                                                                                  'label' => false,
                                                                                                                                  'value' => $parameter->fundacao ? date("d/m/Y", strtotime($parameter->fundacao)) : ''
                                                                                                                                 ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                            </div>
                                            <!-- DADOS PESSOAIS -->

                                            <!-- DADOS DE CONTATO -->
                                            <div class="panel panel-default">

                                                <div class="panel-heading strong">
                                                    Dados de Contato
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.email">Email</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.email', ['type'  => 'text',
                                                                                                                        'class' => 'form-control',
                                                                                                                        'id'    => 'pagamento.email',
                                                                                                                        'label' => false,
                                                                                                                        'value' => $parameter->username
                                                                                                                       ]); ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.telefone">Telefone</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.telefone', ['type'  => 'text',
                                                                                                                           'class' => 'form-control',
                                                                                                                           'id'    => 'pagamento.telefone',
                                                                                                                           'label' => false,
                                                                                                                           'value' => $parameter->telefone ? $parameter->telefone : ''
                                                                                                                          ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- DADOS DE CONTATO -->

                                            <!-- ENDEREÇO -->
                                            <div class="panel panel-default">

                                                <div class="panel-heading strong">
                                                    Dados de Cobrança
                                                </div>

                                                <div class="panel-body">

                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <div class="form-group">
                                                                <label for="pagamento.endereco">Logradouro</label>
                                                                <?= $this->Form->control('pagamento.cc.cliente.endereco', ['type'        => 'text',
                                                                                                                         'class'       => 'form-control',
                                                                                                                         'id'          => 'pagamento.endereco',
                                                                                                                         'placeholder' => 'Informe o nome da rua',
                                                                                                                         'label'       => false,
                                                                                                                         'value'       => $parameter->endereco ? $parameter->endereco : ''
                                                                                                                        ]);?> 
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="pagamento.numero">Nº</label>
                                                                <?= $this->Form->control('pagamento.cc.cliente.numero', ['type'  => 'text',
                                                                                                                       'class' => 'form-control',
                                                                                                                       'id'    => 'pagamento.numero',
                                                                                                                       'label' => false
                                                                                                                      ]);?> 
                                                                
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <label for="pagamento.complemento">Complemento</label>
                                                                <?= $this->Form->control('pagamento.cc.cliente.complemento', ['type'        => 'text',
                                                                                                                            'class'       => 'form-control',
                                                                                                                            'id'          => 'pagamento.complemento',
                                                                                                                            'placeholder' => 'Informe o complemento',
                                                                                                                            'label'       => false
                                                                                                                           ]); ?> 
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="pagamento.cep">CEP</label>
                                                                <?= $this->Form->control('pagamento.cc.cliente.cep', ['type'  => 'text',
                                                                                                                    'class' => 'form-control js_cep',
                                                                                                                    'id'    => 'pagamento.cep',
                                                                                                                    'label' => false,
                                                                                                                    'value' => $parameter->cep ? $parameter->cep : ''
                                                                                                                   ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="estado">Estado</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.geo_estado_id', ['type'    => 'select',
                                                                                                                              'class'   => 'form-control',
                                                                                                                              'id'      => 'estado',
                                                                                                                              'label'   => false,
                                                                                                                              'options' => $estados,
                                                                                                                              'default' => $parameter->estado ? $parameter->estado : ''
                                                                                                                             ]); ?>
                                                            </div>
                                                        </div>  

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="cidade">Cidade</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.geo_cidade_id', ['type'  => 'text',
                                                                                                                              'class' => 'form-control',
                                                                                                                              'id'    => 'cidade',
                                                                                                                              'label' => false,
                                                                                                                              'value' => $parameter->cidade ? $parameter->cidade : ''
                                                                                                                             ]); ?>
                                                            </div>
                                                        </div> 

                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="bairro">Bairro</label>   
                                                                <?= $this->Form->control('pagamento.cc.cliente.geo_bairro_id', ['type'  => 'text',    
                                                                                                                              'class' => 'form-control',
                                                                                                                              'id'    => 'bairro',
                                                                                                                              'label' => false,
                                                                                                                              'value' => $parameter->bairro ? $parameter->bairro : ''
                                                                                                                             ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <!-- ENDEREÇO -->

                                        </div> 
                                        
                                        <!--
                                        <div class="col-md-6 text-center box" style="margin-top: 50px;"> 
                                            <h4 style="margin-bottom: 10px;">Valor a pagar</h4>
                                            <h2 style="font-size: 50px;" class="valor-pagar">R$ 0,00</h2>
                                        </div>
                                        -->

                                    </div>

                                </div>

                                <div role="tabpanel" class="tab-pane active" id="boleto-bancario">
                                
                                    <div class="row">
                                        <div class="col-md-12"> 

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert alert-info" role="alert">
                                                        <div style="margin-bottom:15px;"><span class="text-bold">Atenção!</span></div>
                                                        <ul>
                                                            <li>Os pagamentos efetuados por boleto bancário serão identificados em até 3 dias úteis.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- DADOS PESSOAIS -->
                                            <div class="panel panel-default">

                                                <div class="panel-heading text-bold">
                                                    Dados Pessoais
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="pagamento.nome">Nome Completo</label>   
                                                                <?= $this->Form->control('pagamento.bo.cliente.nome', ['type'  => 'text',
                                                                                                                       'class' => 'form-control',
                                                                                                                       'id'    => 'pagamento.nome',
                                                                                                                       'label' => false,
                                                                                                                       'value' => $parameter->name
                                                                                                                      ]);?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.cpf">CPF/CNPJ</label>   
                                                                <?= $this->Form->control('pagamento.bo.cliente.cpf', ['type'  => 'text',
                                                                                                                      'class' => 'form-control js_cpf',
                                                                                                                      'id'    => 'pagamento.cpf',
                                                                                                                      'label' => false,
                                                                                                                      'value' => $parameter->cpfcnpj ? $parameter->cpfcnpj : ''
                                                                                                                     ]); ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.data_nascimento">Nascimento</label>   
                                                                <?= $this->Form->control('pagamento.bo.cliente.data_nascimento', ['type'  => 'text',
                                                                                                                                  'class' => 'form-control js_data',
                                                                                                                                  'id'    => 'pagamento.data_nascimento',
                                                                                                                                  'label' => false,
                                                                                                                                  'value' => $parameter->fundacao ? date("d/m/Y", strtotime($parameter->fundacao)) : ''
                                                                                                                                 ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- DADOS PESSOAIS -->

                                            <!-- DADOS DE CONTATO -->
                                            <div class="panel panel-default">

                                                <div class="panel-heading strong">
                                                    Dados de Contato
                                                </div>

                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.email">Email</label>   
                                                                <?= $this->Form->control('pagamento.bo.cliente.email', ['type'  => 'text',
                                                                                                                        'class' => 'form-control',
                                                                                                                        'id'    => 'pagamento.email',
                                                                                                                        'label' => false,
                                                                                                                        'value' => $parameter->username
                                                                                                                       ]); ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="pagamento.telefone">Telefone</label>   
                                                                <?= $this->Form->control('pagamento.bo.cliente.telefone', ['type'  => 'text',
                                                                                                                           'class' => 'form-control',
                                                                                                                           'id'    => 'pagamento.telefone',
                                                                                                                           'label' => false,
                                                                                                                           'value' => $parameter->telefone ? $parameter->telefone : ''
                                                                                                                          ]); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- DADOS DE CONTATO -->

                                        </div>

                                        <!--
                                        <div class="col-md-6 text-center box" style="margin-top: 50px;"> 
                                            <h4 style="margin-bottom: 10px;">Valor a pagar</h4>
                                            <h2 style="font-size: 50px;" class="valor-pagar">R$ 0,00</h2>
                                        </div>
                                        -->

                                    </div>
                                        
                                </div>

                            </div>

                        </div>

                    </div>      
                </div>
            
            </div>
            
            <!-- STEP 4 -->

        </div>

    </div>
    
</div>