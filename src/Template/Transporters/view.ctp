<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Transporters */
/* File: src/Template/Transporters/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
        
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Nome/Razão Social') ?></label><br>
                <?= h($transporter->title) ?>
            </div>
            <?php if ($transporter->fantasia) { ?>
            <div class="form-group">
                <label><?= __('Nome Fantasia') ?></label><br>
                <?= h($transporter->fantasia) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->contact) { ?>
            <div class="form-group">
                <label><?= __('Representante') ?></label><br>
                <?= h($transporter->contact) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->ie) { ?>
            <div class="form-group">
                <label><?= __('Insc. Estadual') ?></label><br>
                <?= h($transporter->ie) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->im) { ?>
            <div class="form-group">
                <label><?= __('Insc. Municipal') ?></label><br>
                <?= h($transporter->im) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->email) { ?>
            <div class="form-group">
                <label><?= __('E-mail') ?></label><br>
                <?= h($transporter->email) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= h($transporter->obs) ?>
            </div>
            <?php } ?>
        </div>
        
        <div class="col-md-6 col-xs-12 box bg-info">
            <div class="bloco-cabecalho"><?= __('ENDEREÇO') ?></div>
            <?php if ($transporter->endereco) { ?>
            <div class="form-group">
                <label><?= __('Logradouro') ?></label><br>
                <?= h($transporter->endereco) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->bairro) { ?>
            <div class="form-group">
                <label><?= __('Bairro') ?></label><br>
                <?= h($transporter->bairro) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->cidade) { ?>
            <div class="form-group">
                <label><?= __('Cidade') ?></label><br>
                <?= h($transporter->cidade) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->estado) { ?>
            <div class="form-group">
                <label><?= __('Estado') ?></label><br>
                <?= h($transporter->estado) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->cep) { ?>
            <div class="form-group">
                <label><?= __('CEP') ?></label><br>
                <?= h($transporter->cep) ?>
            </div>
            <?php } ?>
        </div>
        
        <?php if ($transporter->telefone1 || $transporter->telefone2 || $transporter->telefone3 || $transporter->telefone4) { ?>
        <div class="col-md-offset-1 col-md-5 col-xs-12 bg-warning box">
            <div class="bloco-cabecalho"><?= __('CONTATO') ?></div>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($transporter->telefone1) ?>
            </div>
            <?php if ($transporter->telefone2) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($transporter->telefone2) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->telefone3) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($transporter->telefone3) ?>
            </div>
            <?php } ?>
            <?php if ($transporter->telefone4) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($transporter->telefone4) ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <?php 
            if (!empty($transporter->cpfcnpj)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('CPF/CNPJ') ?></label><br>
                <span class="label label-default"><?= h($transporter->cpfcnpj) ?></span>
            </div>
            <?php 
            }//if (!empty($transporter->cpfcnpj)) ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Tipo') ?></label><br>
                <?= $this->transporters->type($transporter->type) ?>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->transporters->status($transporter->status) ?>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($transporter->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($transporter->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($transporter->username) ?></span>
            </div>
        </div>
    </div>
    
</div>