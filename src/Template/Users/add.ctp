<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Users */
/* File: src/Template/Users/add.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('user') ?>

<?= $this->Html->script(['maksoud-radiooptions.min']) ?>

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
                        <div class="row box text-center" style="padding-top:0px; padding-bottom:0px; display:block; margin:auto; width:260px; height:35px; margin-top:0px; margin-bottom:4px; margin-left:-16px;">
                            <div class="btn btn-link" style="margin-top:-7px;">
                                <?= $this->Form->radio('buscausuario', ['N' => __('Novo Usuário'), 'S' => __('Localizar')],
                                                                       ['legend'      => false,
                                                                        'default'     => 'N',
                                                                        'hiddenField' => false,
                                                                        'label'       => ['class' => 'radio-inline btn']
                                                                       ]) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('E-mail') ?>*
                        </label>
                        <?= $this->Form->control('username', ['label' => false, 'type' => 'text', 'maxlength' => '100', 'class' => $input . ' focus']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Permissão') ?>
                        </label>
                        <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                        <?= $this->Form->control('rule', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['super'   => __('Super-Administrador'),
                                                                                                                                 'admin'    => __('Administrador'),
                                                                                                                                 'user'     => __('Usuário'),
                                                                                                                                 'limited'  => __('Limitado'),
                                                                                                                                 'visit'    => __('Visitante'),
                                                                                                                                 'cont'     => __('Contador'),
                                                                                                                                 'especial' => __('Especial')
                                                                                                                                ],'default' => 'user']); ?>
                        <?php } else { ?>
                        <?= $this->Form->control('rule', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['admin'   => __('Administrador'),
                                                                                                                                 'user'    => __('Usuário'),
                                                                                                                                 'cont'    => __('Contador')
                                                                                                                                ],'default' => 'user']); ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Resumos por E-mail') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Você poderá receber e-mails semanais com o resumo das contas e alertas no dia do vencimento.') ?>"></i>
                        </label>
                        <?= $this->Form->control('sendmail', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => ['S' => __('Sim'), 
                                                                                                                                        'N' => __('Não')
                                                                                                                                    ]])?>
                    </div>
                </div>
                <div class="N">
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>">
                                <?= __('Nome Completo') ?>*
                            </label>
                            <?= $this->Form->control('name', ['label' => false, 'type' => 'text', 'maxlength' => '100', 'class' => $input]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="<?= $single ?>">
                            <label class="<?= $label ?>">
                                <?= __('Senha') ?>*
                                <small>(<?= __('Pelo menos 6 caracteres') ?>)</small>
                            </label>
                            <?= $this->Form->control('password', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                        </div>
                    </div>
                </div>
                <div class="S hidden">
                    <!-- -->
                </div>
                <div class="row">
                    <div class="<?= $single ?> font-9 text-bold">
                        <?= __('Administrador') ?> - <?= __('Acesso Administrativo') ?><br />
                        <?= __('Usuário') ?> - <?= __('Acesso Completo') ?><br />
                        <?= __('Contador') ?> - <?= __('Visualiza Relatórios e Lançamentos') ?>
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