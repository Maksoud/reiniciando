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
/* File: src/Template/Moviments/low.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($moviment) ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         'maksoud-moviments.min',
                         //Lista de itens
                         'list-boxes.min',
                         'list-banks.min',
                         'list-event-types.min',
                        ]) ?>

<?php 
    $single = 'col-xs-12 form-group';
    $double = 'col-xs-12 col-sm-6 form-group';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> box" style="min-height:262px;">
                
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Pagamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data do pagamento desse lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('dtbaixa', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Vencimento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Em caso de não informar o vencimento, este será preenchido considerando a periodicidade e a data do documento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor do Pagamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor do pago, considerando juros ou descontos.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valorbaixa', ['label' => false, 'type' => 'text', 'class' => $input.' input-border-right valuemask', 'value' => $this->MyForm->decimal($moviment->valor - $moviment->valorpago), 'placeholder' => __('0,00'), 'id' => 'valorbaixa', 'required' => true]) ?><div class="dataLoading"></div>
                        </div>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Tipo de Evento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório, facilitará em caso de relatório por tipo de eventos. Ex: Dinheiro, Cheque, Cartão, etc.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'event_types', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Evento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Evento'), 'escape' => false]) ?>
                            </div>
                            <input id="event_types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Ex. Dinheiro') ?>"><div class="loadingEvents"></div>
                        </div>
                        <input name="event_types_id" id="event_types_id" type="hidden">
                    </div>
                </div>
                
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Histórico') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não é obrigatório a alteração da descrição do lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> well" style="min-height:262px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <div class="text-center bottom-10 font-16"><label><?= __('RESUMO')?></label></div>
                        
                        <label><?= __('Total da Fatura: ')?></label>
                        <div class="pull-right" id="valor">
                            <?= $this->Number->precision($moviment->valor - $moviment->valorpago, 2) ?>
                        </div>
                        
                        <br/>
                        
                        <?php if ($moviment->status == 'P') { ?>
                        <label><span id="vlrparcial"><?= __('Total dos Pagamentos Anteriores: ')?></span></label>
                        <div class="pull-right" id="vlrparcial">
                            <?= $this->Number->precision($moviment->valorpago, 2) ?>
                        </div>
                        
                        <br/>
                        <?php } ?>
                        
                        <label><span id="text-vlrdesc"><?= __('Desconto/Juros Aplicado: ')?></span></label>
                        <div class="pull-right" id="vlrdesc">
                            <?= $this->Number->precision(0.00, 2) ?>
                        </div>
                        
                        <br/>
                        
                        <?php if ($moviment->DocumentTypes['vinculapgto'] == 'S') {?>
                            <label><?= __('Total dos Títulos Vinculados: ')?></label>
                            <div class="pull-right" id="vinculapgto">
                                <?= $this->Number->precision($moviment->valor, 2) ?>
                            </div>
                            <br/>
                        <?php }?>
                            
                        <label><span id="text-diferenca"></span></label>
                        <div class="pull-right" id="vlrdiferenca"></div>
                    </div>
                </div>
                
                <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:250px; margin-top:15px; margin-bottom:4px;">
                    <div class="btn btn-link">
                        <?php 
                            //TITULOS AGRUPADOS NÃO PERMITEM BAIXAS PARCIAIS
                            if ($moviment->status == 'G' || !empty($moviment->plannings_id)) {
                                $options = [null => __('Baixa Total')];
                            } else {
                                $options = [null => __('Baixa Total'), 'P' => __('Baixa Parcial')];
                            }
                        ?>
                        <?= $this->Form->radio('parcial', $options, 
                                                          ['legend'      => false, 
                                                           'label'       => ['class' => 'radio-inline btn'], 
                                                           'hiddenField' => false,
                                                           'value'       => ''
                                                          ]) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $single ?>"></div>
            
            <div class="<?= $double ?> well" style="min-height:220px;">
                <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:250px; margin-top:15px; margin-bottom:4px;">
                    <div class="btn btn-link">
                        <?= $this->Form->radio('radio_bc', ['banco'   => __('Banco'), 'caixa' => __('Caixa')], 
                                                           ['legend'      => false, 
                                                            'default'     => 'banco', 
                                                            'hiddenField' => false,
                                                            'label'       => ['class' => 'radio-inline btn']
                                                           ]) ?>
                    </div>
                </div>
                
                <div class="row">
                        
                    <div class="<?= $single ?> banco">
                        <label class="<?= $label ?>">
                            <?= __('Banco') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Esse campo é obrigatório, caso o pagamento tenha sido realizado através de um dos bancos cadastrados.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'banks', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Banco'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Banco'), 'escape' => false]) ?>
                            </div>
                            <input id="banks_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do banco ou adicione') ?>"><div class="loadingBanks"></div>
                        </div>
                        <input name="banks_id" id="banks_id" type="hidden">
                        
                        <div class="<?= $double ?> bottom-0">
                            <div class="row top-5">
                                <div class="<?= $double ?>">
                                    <?= $this->Html->link(__(' Informar Cheque'), '#collapseCheck', ['class' => 'btn btn-primary fa fa-cc scroll-modal', 'role' => 'button', 'data-toggle' => 'collapse', 'escape' => false]) ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="collapse" id="collapseCheck">
                            <div class="<?= $single ?>">
                                <div class="box">
                                    <div class="row">
                                        <div class="<?= $double ?>">
                                            <label class="<?= $label ?>">
                                                <?= __('Nº do Cheque') ?>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o número do cheque se a movimentação for realizada com cheque.') ?>"></i>
                                            </label>
                                            <?= $this->Form->control('cheque', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                                        </div>
                                        <div class="<?= $double ?>">
                                            <label class="<?= $label ?>">
                                                <?= __('Data de Emissão') ?>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data de emissão do cheque.') ?>"></i>
                                            </label>
                                            <?= $this->Form->control('emissaoch', ['label' => false, 'type' => 'text', 'autocomplete' => 'off', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'type' => 'text']) ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="<?= $single ?>">
                                            <label class="<?= $label ?>">
                                                <?= __('Nominal à') ?>
                                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o nome da pessoa ou empresa em que o cheque está nominado.') ?>"></i>
                                            </label>
                                            <?= $this->Form->control('nominal', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
                    </div>
                    
                    <div class="<?= $single ?> caixa hidden">
                        <label class="<?= $label ?>">
                            <?= __('Caixa') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Esse campo é obrigatório, caso o pagamento tenha sido realizado através de um dos caixas cadastrados.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'boxes', 'action' => 'add'], ['class' => 'btn_modal2 scroll-modal btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Caixa'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Caixa'), 'escape' => false]) ?>
                            </div>
                            <input id="boxes_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do caixa ou adicione') ?>"><div class="loadingBoxes"></div>
                        </div>
                        <input name="boxes_id" id="boxes_id" type="hidden">
                    </div>
                    
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="height:220px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Observações') ?></label>
                        <?= $this->Form->control('obs', ['label'     => false, 
                                                         'type'      => 'textarea', 
                                                         'id'        => 'text', 
                                                         'maxlength' => '300', 
                                                         'class'     => 'form-control form-group'
                                                        ]) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top: -12px;"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
    <?= $this->Html->link(__(' Visualizar Lançamento'), ['action' => 'view', $moviment->id], ['class' => 'btn_modal2 box-shadow scroll-modal btn btn-warning btn-shortcut fa fa-eye ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Dados do Cadastro'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
    <?= $this->Html->link(__(' Saldos Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow scroll-modal btn btn-warning btn-shortcut fa fa-usd ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos Financeiros'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>