<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Industrializations */
/* File: src/Template/Industrializations/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="col-md-9 col-xs-12">
            
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Código') ?></label><br>
                <?= str_pad($industrialization->code, 6, '0', STR_PAD_LEFT) ?>
            </div>
            <div class="form-group">
                <label><?= __('Data do Lançamento') ?></label><br>
                <?= $this->MyHtml->date($industrialization->date) ?>
            </div>
            <div class="form-group">
                <label><?= __('Cliente') ?></label><br>
                <?= $industrialization->Customers['cpfcnpj'] ?> - <?= $industrialization->Customers['title'] ?>
            </div>
            <div class="form-group">
                <label><?= __('Data de Embarque') ?></label><br>
                <?= $this->MyHtml->date($industrialization->Sells['shipment']) ?>
            </div>
            <div class="form-group">
                <label><?= __('Prazo de Entrega') ?></label><br>
                <?= $this->MyHtml->date($industrialization->Sells['deadline']) ?>
            </div>

            <div class="row bottom-20">
                <table class="col-xs-12">
                    <tr>
                        <td class="form-group padding-15">
                            <span class="text-bold"><?= __('Emitente') ?></span><br>
                            <?= $industrialization->emitente ? $industrialization->emitente : '-' ?>
                        </td>
                        <td class="form-group padding-15">
                            <span class="text-bold"><?= __('Autorização 1') ?></span><br>
                            <?= $industrialization->autorizacao1 ? $industrialization->autorizacao1 : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-group padding-15">
                            <span class="text-bold"><?= __('Controle da Qualidade') ?></span><br>
                            <?= $industrialization->qualidade ? $industrialization->qualidade : '-' ?>
                        </td>
                        <td class="form-group padding-15">
                            <span class="text-bold"><?= __('Autorização 2') ?></span><br>
                            <?= $industrialization->autorizacao2 ? $industrialization->autorizacao2 : '-' ?>
                        </td>
                    </tr>
                </table>
            </div>

            <?php if ($industrialization->obs) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= $industrialization->obs ?>
            </div>
            <?php }//if ($industrialization->obs) ?>
        </div>

    </div>

    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-10 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Industrializations->status($industrialization->status) ?><br>
            </div>
            <div class="form-group box bottom-10 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($industrialization->created) ?></span>
            </div>
            <div class="form-group box bottom-10 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($industrialization->modified) ?></span>
            </div>
            <div class="form-group box bottom-10 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($industrialization->username) ?></span>
            </div>

            <div class="form-group box bottom-10 bg-info">
                <label><?= __('Pedido de Venda') ?></label><br>
                <?= $this->Html->link(str_pad($industrialization->Sells['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Sells', 'action' => 'view', $industrialization->Sells['id']], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Pedido de Venda']) ?><br>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-xs-12 box box-shadow bg-warning panel-group">
        <div class="table-responsive">
            <table class="col-xs-12">
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Inspeção: ') ?></span>
                        <?= $industrialization->inspecao == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Databook: ') ?></span>
                        <?= $industrialization->databook == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Aditivo de RE: ') ?></span>
                        <?= $industrialization->are == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('F. de Emergência: ') ?></span>
                        <?= $industrialization->fichaEmergencia == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Multa: ') ?></span>
                        <?= $industrialization->multa == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('PIT: ') ?></span>
                        <?= $industrialization->pit == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Projeto: ') ?></span>
                        <?= $industrialization->projeto == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Pós Cura: ') ?></span>
                        <?= $industrialization->posCura == 'S' ? 'Sim' : 'Não' ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-xs-12 box box-shadow bg-info panel-group">
        <div class="table-responsive">
            <table class="col-xs-12">
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Flúido: ') ?></span><br>
                        <?= $industrialization->fluido ? $industrialization->fluido : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Certificado: ') ?></span><br>
                        <?= $industrialization->certificado ? $industrialization->certificado : '-' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Temperatura: ') ?></span><br>
                        <?= $industrialization->temperatura ? $industrialization->temperatura : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Duração: ') ?></span><br>
                        <?= $industrialization->duracao ? $industrialization->duracao : '-' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Instalação: ') ?></span><br>
                        <?= $industrialization->instalacao ? $industrialization->instalacao : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Pintura: ') ?></span><br>
                        <?= $industrialization->pintura ? $industrialization->pintura : '-' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Local de Entrega: ') ?></span><br>
                        <?= $industrialization->localEntrega ? $industrialization->localEntrega : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Compra de Terceiros: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->compraTerceiros : '-' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Resina B.Q.: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->resinabq : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Resina R.E.: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->resinare : '-' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Catalizador B.Q.: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->catalizadorbq : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Catalizador R.E.: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->catalizadorre : '-' ?>
                    </td>
                </tr>
                <tr>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Espessura B.Q.: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->espessurabq : '-' ?>
                    </td>
                    <td class="form-group padding-15">
                        <span class="text-bold"><?= __('Espessura R.E.: ') ?></span><br>
                        <?= $industrialization->compraTerceiros ? $industrialization->espessurare : '-' ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="col-xs-12 box box-shadow bg-success panel-group">
        <div class="sub-header"><h5><label><?= __('ITENS') ?> (<?= count((array)$industrializationItems->toArray()) ?>)</label></h5></div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="bg-gray">
                        <th class="text-left col-xs-1"><?= __('Código') ?></th>
                        <th class="text-left"><?= __('Descrição') ?></th>
                        <th class="text-left col-xs-1"><?= __('Unidade') ?></th>
                        <th class="text-left col-xs-1"><?= __('Quantidade') ?></th>
                    </tr>
                    <tr class="bg-gray">
                        <th colspan="3" class="text-left text-nowrap"><?= __('Observações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($industrializationItems as $industrializationItem): ?>
                        <tr>
                            <td class="text-left text-nowrap"><?= $this->Html->link(str_pad($industrializationItem->Products['code'], 6, '0', STR_PAD_LEFT), ['controller' => 'Products', 'action' => 'view', $industrializationItem->products_id], ['class' => 'btn_modal2 label label-primary', 'data-title' => 'Visualizar Produto']) ?></td>
                            <td class="text-left text-nowrap"><?= h($industrializationItem->Products['title']) ?></td>
                            <td class="text-left text-nowrap"><?= h($industrializationItem->unity) ?></td>
                            <td class="text-left text-nowrap"><?= $this->Number->format($industrializationItem->quantity, ['places' => 4, 'pattern' => '####.0000', 'locale' => 'en_US']) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-left text-nowrap"><?= $industrializationItem->obs ? h($industrializationItem->obs) : '-' ?></td>
                        </tr>
                        <?php 
                    endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>