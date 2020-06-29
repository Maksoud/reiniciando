<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Invoices */
/* File: src/Template/Invoices/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('invoice', ['type' => 'file', 'class' => 'ajax_add', 'data-url' => 'invoices/addjson']) ?>

<?= $this->Html->script(['add-items.min',
                         'maksoud-text.min',
                         'maksoud-radiooptions.min',
                         //Lista de itens
                         'list-customers.min',
                         'list-providers.min',
                         'list-products.min',
                         'list-invoice-items.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $quad   = 'col-xs-12 col-sm-3 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
    
    //Ordenado por importância
    $unidades = ['UN' => 'UN',  //Unidade
                 'PÇ' => 'PÇ',  //Peça
                 'PR' => 'PR',  //Par
                 'RL' => 'RL',  //Rolo
                 'PT' => 'PT',  //Pacote
                 'CT' => 'CT',  //Cartela
                 'CX' => 'CX',  //Caixa
                 'ML' => 'ML',  //Mililitro
                 'L'  => 'L',   //Litros
                 'TN' => 'TN',  //Toneladas
                 'KG' => 'KG',  //Kilograma
                 'G'  => 'G',   //Grama
                 'MM' => 'MM',  //Milímetro
                 'CM' => 'CM',  //Centímetro
                 'M'  => 'M',   //Metro
                 'KM' => 'KM',  //Kilômetro
                 'MM²'=> 'MM²', //Milímetro quadrado
                 'CM²'=> 'CM²', //Centímetro quadrado
                 'M²' => 'M²',  //Metro quadrado
                 'MM³'=> 'MM³', //Milímetro cúbico
                 'CM³'=> 'CM³', //Centímetro cúbico
                 'M³' => 'M³',  //Metro cúbico
                ];
?>

    <div class="container-fluid">
        <div class="row">
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>
        
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data de Emissão') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data da emissão da nota fiscal.') ?>"></i>
                        </label>
                        <?= $this->Form->control('dtemissaonf', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input . ' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nº da NF') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o número da nota fiscal com até 8 números.') ?>"></i>
                        </label>
                        <?= $this->Form->control('nf', ['label' => false, 'type' => 'text', 'maxlength' => '8', 'class' => $input, 'required' => false, 'disabled' => 'disabled']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Forma de Pagamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Esolha a forma de pagamento acertado ou adicione nas observações.') ?>"></i>
                        </label>
                        <?= $this->Form->control('paymenttype', ['label' => false, 'type' => 'text', 'maxlenght' => '60', 'class' => $input]) ?>
                        
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('CFOP') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o CFOP da nota fiscal com até 6 números.') ?>"></i>
                        </label>
                        <?= $this->Form->control('cfop', ['label' => false, 'type' => 'number', 'maxlength' => '6', 'class' => $input, 'required' => false, 'disabled' => 'disabled']) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:393px; margin-top:5px !important;  margin-bottom:10px;">
                        <div class="btn btn-link">
                            <?= $this->Form->radio('type', ['DP' => __('Ent. Avulsa'), 'DS' => __('Sai. Avulsa'), 'P' => __('Compra'), 'S' => __('Venda')], 
                                                           ['legend'      => false, 
                                                            'hiddenField' => false,
                                                            'label'       => ['class' => 'radio-inline btn'],
                                                            'default'     => 'DP'
                                                           ]) // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?> S hidden">
                        <label class="<?= $label ?>">
                            <?= __('Pedidos de Vendas') ?>
                        </label>
                        <?= $this->Form->control('sells_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $sells, 'empty' => __('Selecione um pedido'), 'id' => 'sells_id']) ?>
                    </div>
                    <div class="<?= $single ?> P hidden">
                        <label class="<?= $label ?>">
                            <?= __('Pedidos de Compras') ?>
                        </label>
                        <?= $this->Form->control('purchases_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $purchases, 'empty' => __('Selecione um pedido'), 'id' => 'purchases_id']) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> box">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $single ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Transportadoras') ?>
                                </label>
                                <?= $this->Form->control('transporters_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $transporters, 'empty' => 'Outros']) ?>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Tipo do Frete') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('CIF - Pago pelo fornecedor, FOB - Pago pelo cliente.') ?>"></i>
                                </label>
                                <?= $this->Form->control('freighttype', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['C' => __('CIF'), 'F' => __('FOB')]]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Valor do Frete') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor do frete.') ?>"></i>
                                </label>
                                <?= $this->Form->control('totalfreight', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask']) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Previsão de Entrega') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data prevista para entrega no destino.') ?>"></i>
                                </label>
                                <?= $this->Form->control('dtdelivery', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input . ' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> well" style="height: 365px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">

                        <div class="bottom-10" style="float: left;">
                            <div style="float: left;">
                                <label class="<?= $label ?>">
                                    <?= __('Produtos') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe ao menos 3 caracteres do nome do produto para listar os itens.') ?>"></i>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-addon input-border-left">
                                        <?= $this->Html->link('', ['controller' => 'Products', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Produto'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Adicionar Produto'), 'escape' => false]) ?>
                                    </div>
                                    <input id="products_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do produto ou adicione') ?>"><div class="loadingProducts" style="right:37px;"></div>
                                    <div style="padding:6px 16px; font-size:14px; font-weight:400; line-height:1; color:#555; text-align:center; border:1px solid #ccc; width:1%; white-space:nowrap; vertical-align:middle; display:table-cell; margin:0;">
                                        <i data-toggle="tooltip" title="<?= __('Uso e Consumo/Imobilizado: Estes produtos não consideram o valor do IPI para base de cálculo do ICMS.') ?>">
                                            <?= $this->Form->control('imobilizado', ['label' => false, 'type' => 'checkbox', 'hiddenField' => false, 'style' => 'margin:-9px;left:3px;', 'id' => 'edt_imobilizado']) ?>
                                        </i>
                                    </div>
                                </div>
                                <input name="products_id" id="products_id" type="hidden"><!-- 'id' => 'edt_product' -->
                            </div>
                        </div>

                        <div class="<?= $single ?>">
                            <div class="row">
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('Unidade') ?>
                                        </label>
                                        <?= $this->Form->control('unity', ['label' => false, 'type' => 'select', 'class' => $input, 'id' => 'edt_unity', 'options' => $unidades]) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('Quantidade') ?>
                                        </label>
                                        <?= $this->Form->control('quantity', ['label' => false, 'type' => 'text', 'class' => $input.' fourdecimals', 'id' => 'edt_quantity']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('Vl. Unit.') ?>(<?= __('R$') ?>)
                                        </label>
                                        <?= $this->Form->control('vlunity', ['label' => false, 'type' => 'text', 'class' => $input.' fourdecimals', 'id' => 'edt_vlunity']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('Desconto') ?>(<?= __('R$') ?>)
                                        </label>
                                        <?= $this->Form->control('vldiscount', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_vldiscount']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('IPI') ?> (%)
                                        </label>
                                        <?= $this->Form->control('peripi', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_peripi']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('IPI') ?> (<?= __('R$') ?>)
                                        </label>
                                        <?= $this->Form->control('ipi', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_ipi']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('ICMS') ?> (%)
                                        </label>
                                        <?= $this->Form->control('pericms', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_pericms']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('ICMS') ?> (<?= __('R$') ?>)
                                        </label>
                                        <?= $this->Form->control('icms', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_icms']) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('ICMS Subst') ?>(%)
                                        </label>
                                        <?= $this->Form->control('pericmssubst', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_pericmssubst']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('ICMS Subst') ?>(<?= __('R$') ?>)
                                        </label>
                                        <?= $this->Form->control('icmssubst', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'id' => 'edt_icmssubst']) ?>
                                    </div>
                                </div>
                                <div class="<?= $quad ?>">
                                    <div class="row">
                                    </div>
                                </div>
                                <div class="<?= $quad ?> box">
                                    <div class="row" style="margin:0;">
                                        <button onclick="AddTableRow()" type="button" class="btn btn-default fa fa-plus" style="margin-top: -1px; margin-left: 10px;"> </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="<?= $double ?> box" style="height: 294px;">
                        <label class="text-center bottom-20"><?= __('TOTAIS') ?></label>
                        <table class="table table-hover" style="margin-bottom: -1px; font-size: 13px;">
                            <tbody class="bg-gray">
                                <tr>
                                    <th><?= __('Total Produtos') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalproducts" id="vltotalproducts" value="0.00">
                                        <span id="totalproducts"><?= __('0,00') ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('Desconto Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totaldiscount" id="vltotaldiscount" value="0.00">
                                        <span id="totaldiscount"><?= __('0,00') ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('IPI Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalipi" id="vltotalipi" value="0.00">
                                        <span id="totalipi"><?= __('0,00') ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('ICMS Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalicms" id="vltotalicms" value="0.00">
                                        <span id="totalicms"><?= __('0,00') ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('ICMS Subst. Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalicmssubst" id="vltotalicmssubst" value="0.00">
                                        <span id="totalicmssubst"><?= __('0,00') ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('Total Geral') ?> <?= __('(Produtos + IPI + Subst)') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="grandtotal" id="vlgrandtotal" value="0.00">
                                        <span id="grandtotal"><?= __('0,00') ?></span>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> box">
                <h5><strong><?= __('ITENS DA NOTA') ?></strong></h5>
                <table id="products-table" class="table table-hover table-bordered table-condensed table-striped" style="margin-bottom: -1px;">
                    <thead class="bg-gray">
                        <tr style="font-size: 12px;">
                            <th colspan="4" class="text-nowrap"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Quantidade') ?></th>
                            <th rowspan="2" class="col-xs-1 text-center" style="vertical-align: middle;"><?= __('Ações') ?></th>
                        </tr>
                        <tr style="font-size: 12px;">
                            <th class="text-center text-nowrap col-xs-1"><?= __('Unitário') ?> (<?= __('R$') ?>)</th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Desconto') ?> (<?= __('R$') ?>)</th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('IPI') ?> (<?= __('R$') ?>)/(%)</th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('ICMS') ?> (<?= __('R$') ?>)/(%)</th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('ICMS Subs.') ?> (<?= __('R$') ?>)/(%)</th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Total') ?> (<?= __('R$') ?>)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CONTENT -->
                    </tbody>
                </table>
            </div>
            
            <div class="<?= $single ?> box">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Observações') ?></label>
                        <?= $this->Form->textarea('obs', ['label' => false, 'id' => 'text', 'maxlength' => '300', 'type' => 'textarea', 'class' => 'form-control form-group']) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
    <?= $this->Html->link(__(' Relação de Pedidos'), ['controller' => 'pages', 'action' => 'pedidos'], ['class' => 'btn_modal2 box-shadow scroll-modal btn btn-warning btn-shortcut fa fa-eye ', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Relação de Pedidos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Relação de Pedidos'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>