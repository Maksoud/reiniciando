<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Parameters */
/* File: src/Template/Parameters/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9 col-xs-12">
        
        <div class="col-md-12 panel-group well">
            <?php if (!empty($parameter->logomarca)) { ?>
                <div class="form-group">
                    <?= $this->Html->image($parameter->logomarca, ['alt' => 'Logomarca', 'width' => '150px']) ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <h4><?= h($parameter->razao) ?></h4>
            </div>
            <div class="form-group">
                <span class="text-bold"><?= __('Telefone de Contato') ?></span>
                <?= $parameter->telefone ? $parameter->telefone : 'Não informado'; ?>
            </div>
            <div class="form-group">
                <span class="text-bold"><?= __('E-mail de Cobrança') ?></span>
                <?= h($parameter->email_cobranca) ?>
            </div>
        </div>
        
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <span class="text-bold"><?= __('CPF/CNPJ') ?></span>
                <?= h($parameter->cpfcnpj) ?>
            </div>
            <?php if (!empty($parameter->ie)) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('Identidade/Insc. Estadual') ?></span>
                <?= h($parameter->ie) ?>  
            </div>
            <?php } ?>
            <?php if (!empty($parameter->fundacao)) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('Data de Fundação/Nascimento') ?></span>
                <?= date("d/m/Y", strtotime($parameter->fundacao)) ?>
            </div>
            <?php } ?>
        </div>
        
        <div class="col-md-12 box bg-info panel-form">
            <div class="sub-header"><h5><span class="text-bold"><?= __('ENDEREÇO') ?></span></h5></div>
            <?php if ($parameter->endereco) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('Logradouro: ') ?></span>
                <?= h($parameter->endereco) ?>
            </div>
            <?php } ?>
            <?php if ($parameter->bairro) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('Bairro: ') ?></span>
                <?= h($parameter->bairro) ?>
            </div>
            <?php } ?>
            <?php if ($parameter->cidade) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('Cidade: ') ?></span>
                <?= h($parameter->cidade) ?>
            </div>
            <?php } ?>
            <?php if ($parameter->estado) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('Estado: ') ?></span>
                <?= h($parameter->estado) ?>
            </div>
            <?php } ?>
            <?php if ($parameter->cep) { ?>
            <div class="form-group">
                <span class="text-bold"><?= __('CEP: ') ?></span>
                <?= h($parameter->cep) ?>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Id') ?></label><br>
                <?= str_pad($parameter->id, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($parameter->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($parameter->modified) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //USUÁRIOS CADASTRADOS
    if (!empty($usersParameters->toArray())) {
    ?>
        <div class="form-group col-xs-12 box bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('USUÁRIOS CADASTRADOS') ?></label></h5></div>
            <div class="table-responsive">
                <table class="table no-margin table-striped">
                    <thead>
                        <tr>
                            <th class="text-left"><?= __('Dt Cadastro') ?></th>
                            <th class="text-left"><?= __('Nome') ?></th>
                            <th class="text-left"><?= __('Usuário') ?></th>
                            <th class="text-left"><?= __('Permissão') ?></th>
                            <th class="text-left"><?= __('Último Acesso') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach ($usersParameters as $usersParameter): ?>
                            <tr>
                                <td class="text-left"><?= date("d/m/Y", strtotime($usersParameter->Users['created'])) ?></td>
                                <td class="text-left"><?= h($usersParameter->Users['name']) ?></td>
                                <td class="text-left"><?= h($usersParameter->Users['username']) ?></td>
                                <td class="text-left"><?= $this->UsersParameters->rules($usersParameter->rules_id) ?></td>
                                <td class="text-left"><?= $usersParameter->last_login ? $usersParameter->last_login : '-'; ?></td>
                            </tr>
                            <?php 
                        endforeach; 
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    <?php 
    }//if (isset($vinculados))
    //USUÁRIOS CADASTRADOS
    ?>
</div>