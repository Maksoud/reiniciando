<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Products */
/* File: src/Template/Products/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Título') ?></label><br>
                <?= $product->title ?>
            </div>
            <div class="form-group">
                <label><?= __('Código Interno') ?></label><br>
                <?= str_pad($product->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="form-group">
                <label><?= __('Código EAN') ?></label><br>
                <?= $product->ean ? $product->ean : '-' ?>
            </div>
            <div class="form-group">
                <label><?= __('Código NCM') ?></label><br>
                <?= $product->ncm ? $product->ncm : '-' ?>
            </div>
            <?php if ($product->product_types_id) { ?>
            <div class="form-group">
                <label><?= __('Tipo de Produto') ?></label><br>
                <?= $product->ProductTypes['title'] ?>
            </div>
            <?php }//if ($product->product_types_id) ?>
            <?php if ($product->product_groups_id) { ?>
            <div class="form-group">
                <label><?= __('Grupo de Produto') ?></label><br>
                <?= $product->ProductGroups['title'] ?>
            </div>
            <?php }//if ($product->product_groups_id) ?>
            <?php if ($product->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $product->obs ?>
            </div>
            <?php }//if ($product->obs) ?>
        </div>

    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($product->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($product->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($product->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //Itens
    if (!empty($productTitles->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('DESCRIÇÕES SECUNDÁRIAS') ?> (<?= count((array)$productTitles->toArray()) ?>)</label></h5></div>
            <div class="sub-header">
                <span class="text-danger small">*<?= __('Antes de inserir descrições e códigos secundários, certifique-se que o NCM e EAN dos produtos são os mesmos.') ?></span>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Código') ?></th>
                            <th class="text-left text-nowrap"><?= __('Descrição Secundária') ?></th>
                            <th class="text-left text-nowrap col-xs-4"><?= __('Observações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($productTitles as $productTitle): ?>
                            <tr>
                                <td class="text-center text-nowrap"><?= h($productTitle->code) ?></td>
                                <td class="text-left text-nowrap"><?= h($productTitle->title) ?></td>
                                <td class="text-left text-nowrap"><?= $productTitle->obs ? h($productTitle->obs) : "-"; ?></td>
                            </tr>
                            <?php 
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
    }//if (!empty($productTitles))
    //Itens
    ?>
    
</div>