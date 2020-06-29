<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Inventories */
/* File: src/Template/Inventories/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Código') ?></label><br>
                <?= str_pad($inventory->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="form-group">
                <label><?= __('Data do Lançamento') ?></label><br>
                <?= $this->MyHtml->date($inventory->date) ?>
            </div>
            <div class="form-group">
                <label><?= __('Responsável') ?></label><br>
                <?= h($inventory->applicant) ?>
            </div>
            <?php if ($inventory->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $inventory->obs ?>
            </div>
            <?php }//if ($inventory->obs) ?>
        </div>

    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Inventories->status($inventory->status) ?><br>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($inventory->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($inventory->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($inventory->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //Itens
    if (!empty($inventoryItems->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$inventoryItems->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left text-nowrap"><?= __('Descrição') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center text-nowrap col-xs-1"><?= __('Quantidade') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $vltotal = 0;
                        foreach ($inventoryItems as $inventoryItem): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= h($inventoryItem->products_id . ' - ' . $inventoryItem->Products['title']) ?></td>
                                <td class="text-center text-nowrap col-xs-1"><?= h($inventoryItem->unity) ?></td>
                                <td class="text-right text-nowrap col-xs-1"><?= $this->Number->precision($inventoryItem->quantity, 4) ?></td>
                            </tr>
                            <?php 
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
    }//if (!empty($inventoryItems))
    //Itens
    ?>
    
</div>