<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Transfers */
/* File: src/Template/Transfers/edit_baixado_simple.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($transfer) ?>

<?= $this->Html->script([//Extras
                         'maksoud-radiooptions.min',
                         'maksoud-text.min',
                         //Lista de itens
                         'list-boxes.min',
                         'list-banks.min',
                         'list-costs.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?> well" style="min-height: 190px;">
                <div class="row top-10">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Data do Lançamento') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório e necessário para o lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'value' => date('d/m/Y'), 'class' => $input.' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'disabled' => true]) ?>
                    </div>
                    <?php if ($transfer['status'] == 'P') { ?>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Programação') ?>*
                        </label>
                        <?= $this->Form->control('prog', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => false]) ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Valor') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe o valor da transferência.') ?>"></i>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon input-border-left"><?= __('R$') ?></span>
                            <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input.' input-border-right valuemask', 'value' => $this->MyForm->decimal($transfer['valor']), 'placeholder' => __('0,00'), 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="min-height: 190px;">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>">
                            <?= __('Contábil') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Não contábil: Não atualiza o saldo do banco/caixa, mas registra o lançamento. É possível filtrar em relatórios.') ?>"></i>
                        </label>
                        <?= $this->Form->control('contabil', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 'N' => __('Não')], 'disabled' => true]) ?>
                    </div>
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Descrição') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Este campo é obrigatório. Nele você deverá informar a descrição do lançamento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('historico', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '100', 'required' => true]) ?>
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
            
            <div class="<?= $double ?> well" style="min-height: 294px;">
                <div class="row">
                    <div class="<?= $double ?> top-10">
                        <h5 class="text-center">
                            <span class="text-bold"><?= __('DADOS DE ORIGEM') ?></span>
                        </h5>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="radio-inline btn btn-link">
                            <?= $this->Form->radio('radio_origem', ['banco_origem' => __('Banco'), 'caixa_origem' => __('Carteira')], 
                                                                   ['legend'      => false, 
                                                                    'label'       => ['class' => 'radio-inline btn'],
                                                                    'hiddenField' => false,
                                                                    'disabled'    => true
                                                                   ]) ?>
                        </div>
                    </div>
                    <div class="<?= $single ?>">
                        <div class="banco_origem <?php if (empty($transfer['banks_id'])) {echo 'hidden';} ?>">
                            <label class="<?= $label ?>">
                                <?= __('Banco') ?>
                            </label>
                            <?= $this->Form->control('banks_id', ['label' => false, 'type' => 'select', 'class' => $input, 'disabled' => true]) ?>
                        </div>
                        <div class="caixa_origem <?php if (empty($transfer['boxes_id'])) {echo 'hidden';} ?>">
                            <label class="<?= $label ?>">
                                <?= __('Carteira') ?>
                            </label>
                            <?= $this->Form->control('boxes_id', ['label' => false, 'type' => 'select', 'class' => $input, 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?> top-10">
                        <h5 class="text-center">
                            <span class="text-bold"><?= __('DADOS DE DESTINO') ?></span>
                        </h5>
                    </div>
                    <div class="<?= $double ?>">
                        <div class="radio-inline btn btn-link">
                            <?= $this->Form->radio('radio_destino', ['banco_destino' => __('Banco'), 'caixa_destino' => __('Carteira')], 
                                                                    ['legend'      => false, 
                                                                     'label'       => ['class' => 'radio-inline btn'],
                                                                     'hiddenField' => false,
                                                                     'disabled'    => true
                                                                    ]) ?>
                        </div>
                    </div>
                    <div class="<?= $single ?>">
                        <div class="banco_destino <?php if (empty($transfer['banks_dest'])) {echo 'hidden';} ?>">
                            <label class="<?= $label ?>">
                                <?= __('Banco') ?>
                            </label>
                            <?= $this->Form->control('banks_dest', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $banks_dest, 'disabled' => true]) ?>
                        </div>
                        <div class="caixa_destino <?php if (empty($transfer['boxes_dest'])) {echo 'hidden';} ?>">
                            <label class="<?= $label ?>">
                                <?= __('Carteira') ?>
                            </label>
                            <?= $this->Form->control('boxes_dest', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $boxes_dest, 'disabled' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?> box" style="min-height: 294px;">
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#costs_id').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 317,
                                    dropUp: true
                                });
                            });
                        </script>
                        <label class="<?= $label ?>">
                            <?= __('Categoria') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Utilize a categoria para agrupar despesas e receitas por fonte. Ex: Energia, alimentação, impostos.') ?>"></i>
                        </label>
                        <?= $this->Form->control('costs_id', ['label' => false, 'class' => $input, 'type' => 'select', 'id' => 'costs_id', 'options' => $costs]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Observações') ?>
                        </label>
                        <?= $this->Form->textarea('obs', ['label' => false, 'type' => 'textarea', 'id' => 'text', 'maxlength' => '300', 'class' => 'form-control form-group']) ?>
                        <h6 class="pull-right" id="count_message" style="margin-top:-12px;"></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="col-xs-12 box text-left">
    <?= $this->Html->link(__(' Saldos Bancos/Caixas'), ['controller' => 'pages', 'action' => 'saldosBancarios'], ['class' => 'btn_modal2 box-shadow btn btn-warning btn-shortcut fa fa-usd', 'role' => 'button', 'data-loading-text' => __('Carregando...'), 'data-title' => __('Saldos de Bancos e Caixas'), 'data-toggle' => 'modal', 'data-target' => '#myModal2', 'data-size' => 'lg', 'title' => __('Visualizar'), 'escape' => false]) ?>
</div>

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>