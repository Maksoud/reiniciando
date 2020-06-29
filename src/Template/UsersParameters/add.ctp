<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* UsersParameters */
/* File: src/Template/UsersParameters/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('UsersParameter') ?>

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
                        <label class="<?= $label ?>">
                            <?= __('Empresa') ?>
                        </label>
                        <?= $this->Form->control('parameters_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $parameters]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Usuário') ?>
                        </label>
                        <?= $this->Form->control('users_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $users]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Permissão') ?>
                        </label>
                        <?= $this->Form->control('rule', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['super'    => __('Super-Administrador'),
                                                                                                                                 'admin'    => __('Administrador'),
                                                                                                                                 'user'     => __('Usuário'),
                                                                                                                                 'limited'  => __('Limitado'),
                                                                                                                                 'visit'    => __('Visitante'),
                                                                                                                                 'cont'     => __('Contador'),
                                                                                                                                 'especial' => __('Especial')
                                                                                                                                ],'default' => 'user']); ?> 
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Resumos por E-mail') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Você poderá receber e-mails semanais com o resumo das contas e alertas no dia do vencimento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('sendmail', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => 'Sim',
                                                                                                                                     'N' => 'Não'
                                                                                                                                    ]]) ?>
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