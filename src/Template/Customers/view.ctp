<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Customers */
/* File: src/Template/Customers/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9">
        
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Nome/Razão Social') ?></label><br>
                <?= h($customer->title) ?>
            </div>
            <?php if ($customer->fantasia) { ?>
            <div class="form-group">
                <label><?= __('Nome Fantasia') ?></label><br>
                <?= h($customer->fantasia) ?>
            </div>
            <?php } ?>
            <?php if ($customer->ie) { ?>
            <div class="form-group">
                <label><?= __('RG/Insc. Estadual: ') ?></label><br>
                <?= h($customer->ie) ?>
            </div>
            <?php } ?>
            <?php if ($customer->email) { ?>
            <div class="form-group">
                <label><?= __('E-mail: ') ?></label><br>
                <?= h($customer->email) ?>
            </div>
            <?php } ?>
            <?php if ($customer->obs) { ?>
            </br>
            <div class="form-group">
                <label><?= __('Observações: ') ?></label><br>
                <?= h($customer->obs) ?>
            </div>
            <?php } ?>
        </div>
        
        <div class="col-md-6 box bg-info">
            <div class="bloco-cabecalho"><?= __('ENDEREÇO') ?></div>
            <?php if ($customer->endereco) { ?>
            <div class="form-group">
                <label><?= __('Logradouro') ?></label><br>
                <?= h($customer->endereco) ?>
            </div>
            <?php } ?>
            <?php if ($customer->referencia) { ?>
            <div class="form-group">
                <label><?= __('Ponto de Referência') ?></label><br>
                <?= h($customer->referencia) ?>
            </div>
            <?php } ?>
            <?php if ($customer->bairro) { ?>
            <div class="form-group">
                <label><?= __('Bairro') ?></label><br>
                <?= h($customer->bairro) ?>
            </div>
            <?php } ?>
            <?php if ($customer->cidade) { ?>
            <div class="form-group">
                <label><?= __('Cidade') ?></label><br>
                <?= h($customer->cidade) ?>
            </div>
            <?php } ?>
            <?php if ($customer->estado) { ?>
            <div class="form-group">
                <label><?= __('Estado') ?></label><br>
                <?= h($customer->estado) ?>
            </div>
            <?php } ?>
            <?php if ($customer->cep) { ?>
            <div class="form-group">
                <label><?= __('CEP') ?></label><br>
                <?= h($customer->cep) ?>
            </div>
            <?php } ?>
        </div>
        
        <?php if ($customer->telefone1 || $customer->telefone2 || $customer->telefone3 || $customer->telefone4) { ?>
        <div class="col-md-offset-1 col-md-5 bg-warning box">
            <div class="bloco-cabecalho"><?= __('CONTATO') ?></div>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($customer->telefone1) ?>
            </div>
            <?php if ($customer->telefone2) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($customer->telefone2) ?>
            </div>
            <?php } ?>
            <?php if ($customer->telefone3) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($customer->telefone3) ?>
            </div>
            <?php } ?>
            <?php if ($customer->telefone4) { ?>
            <div class="form-group">
                <label><?= __('Telefone') ?></label><br>
                <?= h($customer->telefone4) ?>
            </div>
            <?php } ?>
        </div>
        <?php } ?>       
    </div>
    
    <div class="col-md-3 box bg-info initialism text-center">
        <?php if (!empty($customer->cpfcnpj)) { ?>
        <div class="form-group">
            <label><?= __('CPF/CNPJ') ?></label><br>
            <span class="label label-default"><?= h($customer->cpfcnpj) ?></span>
        </div>
        <?php } ?>
        <div class="form-group">
            <label><?= __('Tipo') ?></label><br>
            <?= $this->Customers->tipo($customer->tipo) ?>
        </div>
    </div>
    
    <div class="col-md-3 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Customers->status($customer->status) ?>
        </div>
    </div>
    
    <div class="col-md-3 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($customer->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($customer->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($customer->username) ?></span>
        </div>
    </div>
</div>