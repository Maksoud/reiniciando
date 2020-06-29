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
/* File: src/Template/Invoices/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($invoice) ?>

<?= $this->Html->script(['add-items.min',
                         'maksoud-text.min',
                         'maksoud-radiooptions.min',
                         //Lista de itens
                         'list-customers.min',
                         'list-providers.min',
                         'list-products.min'
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
            <div class="<?= $double ?> well" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data de Emissão') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data da requisição.') ?>"></i>
                        </label>
                        <?= $this->Form->control('dtemissaonf', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input . ' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Nota Fiscal') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o número da nota fiscal com até 8 números.') ?>"></i>
                        </label>
                        <?= $this->Form->control('nf', ['label' => false, 'type' => 'text', 'maxlength' => '8', 'class' => $input, 'required' => false]) ?>
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
                        <?= $this->Form->control('cfop', ['label' => false, 'type' => 'number', 'maxlength' => '6', 'class' => $input, 'required' => false]) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:393px; margin-top:5px !important;  margin-bottom:10px;">
                        <div class="btn btn-link">
                            <?= $this->Form->radio('type', ['S' => __('Venda'), 'P' => __('Compra'), 'DS' => __('Sai. Avulsa'), 'DP' => __('Ent. Avulsa')], 
                                                           ['legend'      => false, 
                                                            'hiddenField' => false,
                                                            'label'       => ['class' => 'radio-inline btn']
                                                           ]) // S - Sell, P - Purchase, DS - detached selling, DP - detached purchasing ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?> S <?= $invoice->type != 'S' ? 'hidden' : '' ?>">
                        <label class="<?= $label ?>">
                            <?= __('Pedidos de Vendas') ?>
                        </label>
                        <?= $this->Form->control('sells_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $sells, 'empty' => false]) ?>
                    </div>
                    <div class="<?= $single ?> P <?= $invoice->type != 'P' ? 'hidden' : '' ?>">
                        <label class="<?= $label ?>">
                            <?= __('Pedidos de Compras') ?>
                        </label>
                        <?= $this->Form->control('purchases_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $purchases, 'empty' => false]) ?>
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
                                <?= $this->Form->control('totalfreight', ['label' => false, 'type' => 'text', 'class' => $input.' valuemask', 'value' => $this->MyForm->decimal($invoice['totalfreight'])]) ?>
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
                                        <?php 
                                        /* (Quantidade X Valor Unitário) - Desconto + IPI + ICMS + ICMS Substituição */
                                        $totalproducts = $invoice->grandtotal + $invoice->totaldiscount - $invoice->totalipi - $invoice->totalicmssubst;
                                        ?>
                                        <input type="hidden" name="totalproducts" id="vltotalproducts" value="<?= $this->Number->format($totalproducts, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                        <span id="totalproducts"><?= $this->Number->precision($totalproducts, 2) ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('Desconto Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totaldiscount" id="vltotaldiscount" value="<?= $this->Number->format($invoice->totaldiscount, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                        <span id="totaldiscount"><?= $this->Number->precision($invoice->totaldiscount, 2) ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('IPI Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalipi" id="vltotalipi" value="<?= $this->Number->format($invoice->totalipi, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                        <span id="totalipi"><?= $this->Number->precision($invoice->totalipi, 2) ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('ICMS Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalicms" id="vltotalicms" value="<?= $this->Number->format($invoice->totalicms, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                        <span id="totalicms"><?= $this->Number->precision($invoice->totalicms, 2) ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('ICMS Subst. Total') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="totalicmssubst" id="vltotalicmssubst" value="<?= $this->Number->format($invoice->totalicmssubst, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                        <span id="totalicmssubst"><?= $this->Number->precision($invoice->totalicmssubst, 2) ?></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th><?= __('Total Geral') ?> <?= __('(Produtos + IPI + Subst)') ?></th>
                                    <th class="text-right">
                                        <input type="hidden" name="grandtotal" id="vlgrandtotal" value="<?= $this->Number->format($invoice->grandtotal, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                        <span id="grandtotal"><?= $this->Number->precision($invoice->grandtotal, 2) ?></span>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> box">
                <h5><strong><?= __('ITENS DO PEDIDO') ?></strong></h5>
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
                        <?php 
                        $idx = 999;
                        foreach ($invoiceItems as $invoiceItem): ?>
                            <tr style="font-size: 11px;">
                                <td colspan="4" class="text-nowrap">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][products_id]" id="list_id_product" value="<?= $invoiceItem->products_id ?>">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][products_title]" id="list_product" value="<?= $invoiceItem->Products['title'] ?>">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][imobilizado]" id="list_imobilizado" value="<?= $invoiceItem->imobilizado ?>">
                                    <?= $invoiceItem->products_id ?> - <?= $invoiceItem->Products['title'] ?>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][unity]" id="list_unity" value="<?= $invoiceItem->unity ?>">
                                    <?= $invoiceItem->unity ?>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][quantity]" id="list_quantity" value="<?= $this->Number->format($invoiceItem->quantity, ['places' => 4, 'pattern' => '####.0000', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->quantity, 4) ?>
                                </td>
                                <td rowspan="2" class="text-center bg-gray" style="padding:12px;">
                                    <button onclick="EditTableRow(this)" type="button" class="btn btn-actions fa fa-pencil" style="vertical-align: middle;" title="Editar"></button>
                                    <button onclick="RemoveTableRow(this)" type="button" class="btn btn-actions fa fa-trash" style="vertical-align: middle;" title="Excluir"></button>
                                </td>
                            </tr>
                            <tr style="font-size: 11px;">
                                <td class="text-right">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][vlunity]" id="list_vlunity" value="<?= $this->Number->format($invoiceItem->vlunity, ['places' => 4, 'pattern' => '####.0000', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->vlunity, 4) ?>
                                </td>
                                <td class="text-right">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][vldiscount]" id="list_vldiscount" value="<?= $this->Number->format($invoiceItem->vldiscount, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->vldiscount, 2) ?>
                                </td>
                                <td class="text-right">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][ipi]" id="list_ipi" value="<?= $this->Number->format($invoiceItem->ipi, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][peripi]" id="list_peripi" value="<?= $this->Number->format($invoiceItem->peripi, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->ipi, 2) ?> (<?= $this->Number->precision($invoiceItem->peripi, 2) ?>)
                                </td>
                                <td class="text-right">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][icms]" id="list_icms" value="<?= $this->Number->format($invoiceItem->icms, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][pericms]" id="list_pericms" value="<?= $this->Number->format($invoiceItem->pericms, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->icms, 2) ?> (<?= $this->Number->precision($invoiceItem->pericms, 2) ?>)
                                </td>
                                <td class="text-right">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][icmssubst]" id="list_icmssubst" value="<?= $this->Number->format($invoiceItem->icmssubst, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][pericmssubst]" id="list_pericmssubst" value="<?= $this->Number->format($invoiceItem->pericmssubst, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->icmssubst, 2) ?> (<?= $this->Number->precision($invoiceItem->pericmssubst, 2) ?>)
                                </td>
                                <td class="text-right">
                                    <input type="hidden" name="ProductList[<?= $idx ?>][vltotal]" id="list_vltotal" value="<?= $this->Number->format($invoiceItem->vltotal, ['places' => 2, 'pattern' => '####.00', 'locale' => 'en_US']) ?>">
                                    <?= $this->Number->precision($invoiceItem->vltotal, 2) ?>
                                </td>
                            </tr>
                            <?php 
                            $idx++;
                        endforeach; ?>
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