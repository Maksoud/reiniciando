<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Industrializations */
/* File: src/Template/Industrializations/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('industrialization', ['type' => 'file', 'class' => 'ajax_add', 'data-url' => 'industrializations/addjson']) ?>

<?= $this->Html->script(['add-items-industrializations.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-customers.min',
                         'list-industrialization-items.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $triple = 'col-xs-12 col-sm-4 bottom-10';
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
                            <?= __('Código') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Código única com 6 dígitos para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('code', ['label' => false, 'type' => 'text', 'maxlength' => '6', 'class' => $input . ' focus', 'value' => str_pad($code, 6, '0', STR_PAD_LEFT), 'disabled' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a data da ordem de fabricação.') ?>"></i>
                        </label>
                        <?= $this->Form->control('date', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input . ' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Pedidos de Vendas') ?>
                        </label>
                        <?= $this->Form->control('sells_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $sells, 'id' => 'sells_id']) ?>
                    </div>
                </div>
            </div>

            <div class="<?= $double ?> box" style="min-height: 188px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Inspeção') ?>
                                </label>
                                <?= $this->Form->control('inspecao', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Databook') ?>
                                </label>
                                <?= $this->Form->control('databook', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Aditivo de RE') ?>
                                </label>
                                <?= $this->Form->control('are', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Ficha Emerg.') ?>
                                </label>
                                <?= $this->Form->control('fichaEmergencia', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Multa') ?>
                                </label>
                                <?= $this->Form->control('multa', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('PIT') ?>
                                </label>
                                <?= $this->Form->control('pit', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="row">
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Projeto') ?>
                                </label>
                                <?= $this->Form->control('projeto', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                            <div class="<?= $double ?> bottom-0">
                                <label class="<?= $label ?>">
                                    <?= __('Pós Cura') ?>
                                </label>
                                <?= $this->Form->control('posCura', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')]]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="<?= $single ?> well">
                <div class="row top-10">

                    <div class="<?= $double ?>">

                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Flúido') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o tipo de flúido que será utilizado no produto.') ?>"></i>
                                </label>
                                <?= $this->Form->control('fluido', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Certificado') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe os certificados que serão necessários na entrega do pedido.') ?>"></i>
                                </label>
                                <?= $this->Form->control('certificado', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Temperatura') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a temperatura que o produto poderá atingir.') ?>"></i>
                                </label>
                                <?= $this->Form->control('temperatura', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Duração') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a duração de desenvolvimento do produto.') ?>"></i>
                                </label>
                                <?= $this->Form->control('duracao', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="<?= $single ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Instalação') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe os dados de instalação do produto.') ?>"></i>
                                </label>
                                <?= $this->Form->control('instalacao', ['label' => false, 'type' => 'text', 'maxlength' => '255', 'class' => $input]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="<?= $single ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Pintura') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe as características da pintura do produto.') ?>"></i>
                                </label>
                                <?= $this->Form->control('pintura', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                        </div>

                    </div>

                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Local de Entrega') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o local de entrega do pedido.') ?>"></i>
                        </label>
                        <?= $this->Form->control('localEntrega', ['label' => false, 'type' => 'text', 'maxlength' => '255', 'class' => $input]) ?>
                    </div>

                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Compra de Terceiros') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe os materiais que serão comprados de terceiros.') ?>"></i>
                        </label>
                        <?= $this->Form->control('compraTerceiros', ['label' => false, 'type' => 'text', 'maxlength' => '255', 'class' => $input]) ?>
                    </div>

                    <div class="<?= $double ?>">

                        <div class="row">
                            <div class="<?= $triple ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Resina B.Q.') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a resina da barreira química.') ?>"></i>
                                </label>
                                <?= $this->Form->control('resinabq', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $triple ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Catalizador B.Q.') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o catalizador utilizado na barreira química.') ?>"></i>
                                </label>
                                <?= $this->Form->control('catalizadorbq', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $triple ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Espessura B.Q.') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a espessura da barreira química.') ?>"></i>
                                </label>
                                <?= $this->Form->control('espessurabq', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="<?= $triple ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Ref. Estrut.+Liner') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a resina do reforço estrutural e liner.') ?>"></i>
                                </label>
                                <?= $this->Form->control('resinare', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $triple ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Catalizador Ref.') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o catalizado utilizado no reforço estrutural.') ?>"></i>
                                </label>
                                <?= $this->Form->control('catalizadorre', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $triple ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Espessura Ref.') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe a espessura do reforço estrutural.') ?>"></i>
                                </label>
                                <?= $this->Form->control('espessurare', ['label' => false, 'type' => 'text', 'maxlength' => '80', 'class' => $input]) ?>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="<?= $single ?> box">
                <h5><strong><?= __('ITENS DO PEDIDO') ?></strong></h5>
                <table id="products-table" class="table table-hover table-bordered table-condensed table-striped" style="margin-bottom: -1px;">
                    <thead class="bg-gray">
                        <tr style="font-size: 12px;">
                            <th class="text-nowrap"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Quantidade') ?></th>
                            <th class="text-center col-xs-1" style="vertical-align: middle;"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CONTENT -->
                    </tbody>
                </table>
            </div>

            <div class="<?= $single ?> well">
                <div class="row top-10">

                    <div class="<?= $double ?>">

                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Emitente') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe.') ?>"></i>
                                </label>
                                <?= $this->Form->control('emitente', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Controle de Qualidade') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe.') ?>"></i>
                                </label>
                                <?= $this->Form->control('qualidade', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                            </div>
                        </div>

                    </div>

                    <div class="<?= $double ?>">

                        <div class="row">
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Autorização 1') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe.') ?>"></i>
                                </label>
                                <?= $this->Form->control('autorizacao1', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                            </div>
                            <div class="<?= $double ?>">
                                <label class="<?= $label ?>">
                                    <?= __('Autorização 2') ?>
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe.') ?>"></i>
                                </label>
                                <?= $this->Form->control('autorizacao2', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                            </div>
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
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'data-loading-text' => __('Gravando...'), 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>