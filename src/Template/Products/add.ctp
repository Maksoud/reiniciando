<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Products */
/* File: src/Template/Products/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('product', ['type' => 'file', 'class' => 'ajax_add', 'data-url' => 'products/addjson']) ?>

<?= $this->Html->script(['add-product-titles.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-product-types.min',
                         'list-product-groups.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $tri    = 'col-xs-12 col-sm-9 bottom-10';
    $quad   = 'col-xs-12 col-sm-3 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
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
                            <?= __('Código Interno') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Defina um código interno para o produto.') ?>"></i>
                        </label>
                        <?= $this->Form->control('code', ['label' => false, 'type' => 'text', 'maxlength' => '20', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Descrição') ?>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'maxlength' => '120', 'class' => $input.' focus', 'required' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Código EAN') ?>
                        </label>
                        <?= $this->Form->control('ean', ['label' => false, 'type' => 'text', 'maxlength' => '13', 'class' => $input]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Código NCM') ?>
                        </label>
                        <?= $this->Form->control('ncm', ['label' => false, 'type' => 'text', 'maxlength' => '10', 'class' => $input]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Estoque Mínimo') ?>
                        </label>
                        <?= $this->Form->control('minimum', ['label' => false, 'type' => 'number', 'value' => '0,00',  'class' => $input]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Estoque Máximo') ?>
                        </label>
                        <?= $this->Form->control('maximum', ['label' => false, 'type' => 'number', 'value' => '0,00', 'class' => $input]) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> box">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Tipos') ?>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'ProductTypes', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Tipo de Produtos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Tipo de Produtos'), 'escape' => false]) ?>
                            </div>
                            <input id="types_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o tipo ou adicione') ?>"><div class="loadingProductTypes"></div>
                        </div>
                        <input name="product_types_id" id="product_types_id" type="hidden">
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Grupos') ?>
                        </label>
                        <div class="input-group">
                            <div class="input-group-addon input-border-left">
                                <?= $this->Html->link('', ['controller' => 'ProductGroups', 'action' => 'add'], ['class' => 'btn_modal2 btn btn-primary btn-custom fa fa-plus', 'data-loading-text' => '', 'data-title' => __('Novo Grupo de Produtos'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'sm', 'title' => __('Adicionar Grupo de Produtos'), 'escape' => false]) ?>
                            </div>
                            <input id="groups_title" class="form-control input-border-right" type="text" autocomplete="off" placeholder="<?= __('Digite o grupo ou adicione') ?>"><div class="loadingProductGroups"></div>
                        </div>
                        <input name="product_groups_id" id="product_groups_id" type="hidden">
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> well">
                <h5><strong><?= __('DESCRIÇÕES SECUNDÁRIAS') ?></strong></h5>
                <div class="row top-10">
                    <div class="<?= $single ?>">
                        <div class="row">
                            <div class="<?= $double ?>">
                                <div class="row">
                                    <div class="<?= $quad ?>">
                                        <label class="<?= $label ?>">
                                            <?= __('Código') ?>
                                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o código secundário do produto com até 20 caracteres.') ?>"></i>
                                        </label>
                                        <?= $this->Form->control('sub_code', ['label' => false, 'id' => 'sub_code', 'type' => 'text', 'maxlength' => '20', 'class' => $input]) ?>
                                    </div>
                                    <div class="<?= $tri ?>">
                                        <label class="<?= $label ?>">
                                            <?= __('Descrição Secundária') ?>
                                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe uma descrição secundária do produto com até 120 caracteres.') ?>"></i>
                                        </label>
                                        <?= $this->Form->control('sub_title', ['label' => false, 'id' => 'sub_title', 'type' => 'text', 'maxlength' => '120', 'class' => $input]) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="<?= $double ?>">
                                <div class="row">
                                    <div class="<?= $tri ?>">
                                        <label class="<?= $label ?>">
                                            <?= __('Observações') ?>
                                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o motivo dessa descrição existir com até 100 caracteres.') ?>"></i>
                                        </label>
                                        <?= $this->Form->control('sub_obs', ['label' => false, 'id' => 'sub_obs', 'type' => 'text', 'maxlength' => '100', 'class' => $input]) ?>
                                    </div>
                                    <div class="<?= $quad ?> box pull-right" style="width:95px;margin-right:10px;">
                                        <div class="row" style="margin:0;">
                                            <button onclick="AddTableRow()" type="button" class="btn btn-default fa fa-plus" style="margin-top: -1px; margin-left: 10px;"> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="<?= $single ?>">
                                <span class="text-danger small">*<?= __('Antes de inserir descrições e códigos secundários, certifique-se que o NCM e EAN dos produtos são os mesmos.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?> box">
                        <div class="row">
                            <table id="product-titles-table" class="table table-hover table-bordered table-condensed table-striped" style="margin-bottom: -1px;">
                                <thead class="bg-gray">
                                    <tr style="font-size: 12px;">
                                        <th class="text-center col-xs-1"><?= __('Código') ?></th>
                                        <th class="text-left"><?= __('Descrição Secundária') ?></th>
                                        <th class="text-center col-xs-3"><?= __('Observações') ?></th>
                                        <th rowspan="2" class="col-xs-1 text-center" style="vertical-align: middle;"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- CONTENT -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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