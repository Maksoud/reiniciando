<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Providers */
/* File: src/Template/Providers/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9 col-xs-12">
        
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Nome/Razão Social') ?></label><br>
                <?= h($provider->title) ?>
            </div>
            <?php if ($provider->fantasia) { ?>
            <div class="form-group">
                <label><?= __('Nome Fantasia') ?></label><br>
                <?= h($provider->fantasia) ?>
            </div>
            <?php } ?>
            <?php if ($provider->ie) { ?>
            <div class="form-group">
                <label><?= __('RG/Insc. Estadual') ?></label><br>
                <?= h($provider->ie) ?>
            </div>
            <?php } ?>
            <?php if ($provider->email) { ?>
            <div class="form-group">
                <label><?= __('E-mail') ?></label><br>
                <?= h($provider->email) ?>
            </div>
            <?php } ?>
            <?php if ($provider->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= h($provider->obs) ?>
            </div>
            <?php } ?>
        </div>
        
        <div class="col-md-6 col-xs-12 box bg-info">
            <div class="bloco-cabecalho"><?= __('ENDEREÇO') ?></div>
            <?php if ($provider->endereco) { ?>
            <div class="form-group">
                <label><?= __('Logradouro') ?></label><br>
                <?= h($provider->endereco) ?>
            </div>
            <?php } ?>
            <?php if ($provider->bairro) { ?>
            <div class="form-group">
                <label><?= __('Bairro') ?></label><br>
                <?= h($provider->bairro) ?>
            </div>
            <?php } ?>
            <?php if ($provider->cidade) { ?>
            <div class="form-group">
                <label><?= __('Cidade') ?></label><br>
                <?= h($provider->cidade) ?>
            </div>
            <?php } ?>
            <?php if ($provider->estado) { ?>
            <div class="form-group">
                <label><?= __('Estado') ?></label><br>
                <?= h($provider->estado) ?>
            </div>
            <?php } ?>
            <?php if ($provider->cep) { ?>
            <div class="form-group">
                <label><?= __('CEP') ?></label><br>
                <?= h($provider->cep) ?>
            </div>
            <?php } ?>
        </div>
        
        <?php if ($provider->telefone1 || $provider->telefone2 || $provider->telefone3 || $provider->telefone4) { ?>
        <div class="col-md-offset-1 col-md-5 col-xs-12 bg-warning box">
            <div class="bloco-cabecalho">CONTATO</div>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($provider->telefone1) ?>
            </div>
            <?php if ($provider->telefone2) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($provider->telefone2) ?>
            </div>
            <?php } ?>
            <?php if ($provider->telefone3) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($provider->telefone3) ?>
            </div>
            <?php } ?>
            <?php if ($provider->telefone4) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($provider->telefone4) ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <?php 
            if (!empty($provider->cpfcnpj)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('CPF/CNPJ') ?></label><br>
                <span class="label label-default"><?= h($provider->cpfcnpj) ?></span>
            </div>
            <?php 
            }//if (!empty($provider->cpfcnpj)) ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Tipo') ?></label><br>
                <?= $this->Providers->tipo($provider->tipo) ?>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Providers->status($provider->status) ?>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($provider->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($provider->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($provider->username) ?></span>
            </div>
        </div>
    </div>
    
</div>