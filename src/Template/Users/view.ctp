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
/* File: src/Template/Users/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
        
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Nome') ?></label><br>
            <?= h($user->name) ?>
        </div>
        <div class="form-group">
            <label><?= __('Usuário') ?></label><br>
            <?= h($user->username) ?>
        </div>
        <div class="form-group">
            <label><?= __('Permissão') ?></label><br>
            <?= $this->UsersParameters->rules($user->UsersParameters['rules_id']) ?>
        </div>
        <div class="form-group">
            <label><?= __('Último Acesso') ?></label><br>
            <?= $user->last_login ? date("d/m/Y H:i:s", strtotime($user->last_login)) : '-'; ?>
        </div>
        <div class="form-group">
            <label><?= __('Resumo de contas por e-mail:') ?></label><br>
            <?= $user->UsersParameters['sendmail'] == 'S' ? 'Sim' : 'Não'; ?>
        </div>
    </div>

    <div class="col-xs-12 no-padding-lat">
        <div class="box-shadow bg-success box">
            <div class="sub-header"><h5><label><?= __('PERFIS VINCULADOS') ?></label></h5></div>
                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left"><?= __('Código') ?></th>
                                <th class="text-left"><?= __('Razão') ?></th>
                                <th class="text-left"><?= __('CPF/CNPJ') ?></th>
                                <th class="text-left"><?= __('Validade') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            foreach ($parameters as $value): ?>
                                <tr>
                                    <td class="text-left"><?= str_pad($value->id, 6, '0', STR_PAD_LEFT) ?></td>
                                    <td class="text-left"><?= h($value->razao) ?>/td>
                                    <td class="text-left"><?= h($value->cpfcnpj) ?></td>
                                    <td class="text-left"><?= $this->MyHtml->tinyDate($value->dtvalidade) ?></td>
                                </tr>
                                <?php 
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <div class="col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($user->created) ?></span>
            </div>
        </div>
    </div>
</div>  