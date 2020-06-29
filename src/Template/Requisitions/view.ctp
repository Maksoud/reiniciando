<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Requisitions */
/* File: src/Template/Requisitions/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Código') ?></label><br>
                <?= str_pad($requisition->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <?php if (!empty($requisition->industrializations_id)) { ?>
            <div class="form-group">
                <label><?= __('Cliente') ?></label><br>
                <?= $requisition->Industrializations->Sells->Customers['cpfcnpj'] ?> - <?= $requisition->Industrializations->Sells->Customers['title'] ?>
            </div>
            <?php }//if (!empty($requisition->industrializations_id)) ?>
            <div class="form-group">
                <label><?= __('Tipo') ?></label><br>
                <?= $this->Requisitions->type($requisition->type) ?>
            </div>
            <div class="form-group">
                <label><?= __('Responsável') ?></label><br>
                <?= $requisition->applicant ?>
            </div>
            <div class="form-group">
                <label><?= __('Data do Lançamento') ?></label><br>
                <?= $this->MyHtml->date($requisition->date) ?>
            </div>
            <?php if ($requisition->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $requisition->obs ?>
            </div>
            <?php }//if ($requisition->obs) ?>
        </div>

    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Requisitions->status($requisition->status) ?><br>
            </div>
            <?php if (!empty($requisition->industrializations_id)) { ?>
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem de Fabricação') ?></label><br>
                <?= $this->Html->link(str_pad($requisition->Industrializations['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Industrializations', 'action' => 'view', $requisition->Industrializations['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Ordem de Fabricação']) ?><br>
            </div>
            <?php }//if (!empty($requisition->industrializations_id)) ?>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($requisition->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($requisition->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($requisition->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //Itens
    if (!empty($requisitionItems->toArray())) {
        ?>
        <div class="col-xs-12 box box-shadow bg-success panel-group">
            <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$requisitionItems->toArray()) ?>)</label></h5></div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-left col-xs-1"><?= __('Código') ?></th>
                            <th class="text-left"><?= __('Descrição') ?></th>
                            <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                            <th class="text-center col-xs-1"><?= __('Quantidade') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($requisitionItems as $requisitionItem): ?>
                            <tr>
                                <td class="text-left text-nowrap"><?= $this->Html->link(str_pad($requisitionItem->Products['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Products', 'action' => 'view', $requisitionItem->products_id], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Produto']) ?></td>
                                <td class="text-left text-nowrap"><?= h($requisitionItem->Products['title']) ?></td>
                                <td class="text-center text-nowrap"><?= h($requisitionItem->unity) ?></td>
                                <td class="text-right text-nowrap"><?= $this->Number->precision($requisitionItem->quantity, 4) ?></td>
                            </tr>
                            <?php 
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php 
    }//if (!empty($requisitionItems))
    //Itens
    ?>
    
</div>