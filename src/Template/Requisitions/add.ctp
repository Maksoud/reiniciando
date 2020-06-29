<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Requisitions */
/* File: src/Template/Requisitions/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('requisition', ['type' => 'file', 'class' => 'ajax_add', 'data-url' => 'requisitions/addjson']) ?>

<?= $this->Html->script(['add-items-single.min',
                         'maksoud-text.min',
                         //Lista de itens
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
            <div id="ajax-retorno" class="col-xs-12"></div>
        </div>
        
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Código') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Código única com 6 dígitos para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('code', ['label' => false, 'type' => 'text', 'maxlength' => '6', 'class' => $input, 'value' => str_pad($code, 6, '0', STR_PAD_LEFT), 'disabled' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data da requisição.') ?>"></i>
                        </label>
                        <?= $this->Form->control('date', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input . ' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Responsável') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe quem foi o solicitante da requisição.') ?>"></i>
                        </label>
                        <?= $this->Form->control('applicant', ['label' => false, 'type' => 'text', 'maxlength' => '60', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="row box text-center" style="padding:0 0 0 15px; display:block; margin:auto; width:180px; margin-bottom:18px;">
                        <div class="btn btn-link">
                            <?= $this->Form->radio('type', ['I' => __('Entrada'), 'O' => __('Saída')], 
                                                           ['legend'      => false, 
                                                            'hiddenField' => false,
                                                            'label'       => ['class' => 'radio-inline btn'],
                                                            'default'     => 'O'
                                                           ]) // I - in, O - out ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Ordem de Fabricação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Número da Ordem de Fabricação.') ?>"></i>
                        </label>
                        <?= $this->Form->control('industrializations_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $industrializations, 'empty' => 'Avulso']) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> well" style="height: 125px;">
                <div class="row top-10">
                    <div class="<?= $single ?>">

                        <div class="bottom-10" style="float: left;">
                            <div style="float: left;">
                                
                            </div>
                        </div>

                        <div class="<?= $single ?>">
                            <div class="row">
                                <div class="<?= $double ?>">
                                    <div class="row">
                                        <label class="<?= $label ?>">
                                            <?= __('Produtos') ?>
                                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe ao menos 3 caracteres do nome do produto para listar os itens.') ?>"></i>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-addon input-border-left">
                                                <?= $this->Html->link('', ['controller' => 'Products', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Produto'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Adicionar Produto'), 'escape' => false]) ?>
                                            </div>
                                            <input id="products_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o nome do produto ou adicione') ?>"><div class="loadingProducts"></div>
                                        </div>
                                        <input name="products_id" id="products_id" type="hidden"><!-- 'id' => 'edt_product' -->
                                    </div>
                                </div>

                                <div class="<?= $double ?>">
                                    <div class="row">
                                        <div class="<?= $quad ?>">
                                            <label class="<?= $label ?>">
                                                <?= __('Unidade') ?>
                                            </label>
                                            <?= $this->Form->control('unity', ['label' => false, 'type' => 'select', 'class' => $input, 'id' => 'edt_unity', 'options' => $unidades]) ?>
                                        </div>
                                        <div class="<?= $quad ?>">
                                            <label class="<?= $label ?>">
                                                <?= __('Quantidade') ?>
                                            </label>
                                            <?= $this->Form->control('quantity', ['label' => false, 'type' => 'text', 'class' => $input.' fourdecimals col-xs-1', 'id' => 'edt_quantity']) ?>
                                        </div>
                                        <div class="<?= $quad ?> box pull-right">
                                            <div class="row" style="margin:0;">
                                                <button onclick="AddTableRow()" type="button" class="btn btn-default fa fa-plus" style="margin-top: -1px; margin-left: 10px;"> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="<?= $single ?> box">
                <h5><strong><?= __('ITENS DA REQUISIÇÃO') ?></strong></h5>
                <table id="products-table" class="table table-hover table-bordered table-condensed table-striped" style="margin-bottom: -1px;">
                    <thead class="bg-gray">
                        <tr style="font-size: 12px;">
                            <th colspan="4" class="text-left"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Quantidade') ?></th>
                            <th rowspan="2" class="col-xs-1 text-center" style="vertical-align: middle;"><?= __('Ações') ?></th>
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

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>