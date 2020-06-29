<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* AccountPlans */
/* File: src/Template/AccountPlans/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($accountPlan) ?>

<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script(['bootstrap-multiselect.min']) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $single ?> well">
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#plangroup').multiselect({
                                        enableFiltering: true,
                                        enableClickableOptGroups: true,
                                        enableCaseInsensitiveFiltering: true,
                                        inheritClass: true,
                                        buttonContainer: '<div />',
                                        maxHeight: 300,
                                        maxWidth: 317,
                                        dropUp: false
                                    });
                                });
                        </script>
                        <label class="<?= $label ?>">
                            <?= __('Grupo') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Escolha qual é o grupo que o registro irá pertencer.') ?>"></i>
                        </label>
                        <?= $this->Form->control('plangroup', ['id'    => 'plangroup',
                                                               'class' => $input,
                                                               'empty' => false,
                                                               'label' => false,
                                                               'type'  => 'select',
                                                               'title' => __('Plano de Contas')
                                                              ]
                                                ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Classificação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Classificação é o grupo ao qual esse registro pertence. Ex: 01.02.03.04.') ?>"></i>
                        </label>
                        <?= $this->Form->control('classification', ['label' => false, 'type' => 'text', 'class' => $input.' ordermask']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Título') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o título para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'class' => $input . ' focus', 'maxlength' => '100', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Tipo') ?></label>
                        <?= $this->Form->control('receitadespesa', ['label'   => false, 
                                                                    'class'   => $input,
                                                                    'type'    => 'select',
                                                                    'options' => ['R' => __('Receita'), 
                                                                                  'D' => __('Despesa')
                                                                                 ]
                                                                   ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Status') ?></label>
                        <?= $this->Form->control('status', ['label'   => false, 
                                                            'class'   => $input,
                                                            'type'    => 'select',
                                                            'options' => ['A' => __('Ativo'), 
                                                                          'I' => __('Inativo')
                                                                         ]
                                                           ]) ?>
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