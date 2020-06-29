<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Plannings */
/* File: src/Template/Plannings/view_simple.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-9 col-xs-12">
        
        <div class="col-md-12 panel-group box">
            <div class="form-group">
                <label><?= __('Descrição') ?></label><br>
                <?= h($planning->title) ?>
            </div>
            <?php if ($planning->obs != null) { ?>
            <div class="form-group">
                <label><?= __('Observações') ?></label><br>
                <?= h($planning->obs) ?>
            </div>
            <?php } ?>
        </div>
        <?php
            $planning->creditodebito == 'C' ? $bg = 'bg-info' : $bg = 'bg-danger';
        ?>
        <div class="<?= $bg ?> col-md-6 box">
            <div class="bloco-cabecalho"><?= __('Informações Financeiras') ?></div>
            <div class="form-group">
                <label><?= __('Data do lançamento') ?></label><br>
                <?= h(date("d/m/Y", strtotime($planning->data))) ?>
            </div>
            <div class="form-group">
                <label><?= __('Vencimento da primeira parcela') ?></label><br>
                <?= h(date("d/m/Y", strtotime($planning->vencimento))) ?>
            </div>
            <div class="form-group">
                <label><?= __('Número de Parcelas') ?></label><br>
                <?= h($planning->parcelas) ?>
            </div>
            <div class="form-group">
                <label><?= __('Valor Planejado') ?></label><br>
                <?= $this->Number->precision($planning->valor * $planning->parcelas, 2); ?>
            </div>
            <div class="form-group">
                <label><?= __('Percentual Concluído') ?></label><br>
                <?php
                    $valorPago = 0;
                    foreach ($moviments as $moviment):
                        if (!empty($moviment->dtbaixa)) { 
                            $valorPago += $moviment->valorbaixa;
                        }
                    endforeach;
                    echo round($valorPago / ($planning->valor * $planning->parcelas) * 100).'%';
                    echo ' (R$ '.$this->Number->precision($valorPago, 2).')';
                ?>
            </div>
            <?php if (isset($planning->costs_id)) { ?>
            <div class="form-group">
                <label><?= __('Categoria') ?></label><br>
                <?= h($planning->Costs['title']) ?>
            </div>
            <?php } ?>
        </div>
    </div>
    
    <div class="col-md-3 col-xs-12 initialism text-center top-0">
        <div class="row">
            <div class="form-group box bottom-5 bg-info">
                <label><?= __('Ordem') ?></label><br>
                <span class="label label-primary"><?= str_pad($planning->ordem, 6, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-primary">
                <label><?= __('Status') ?></label><br>
                <?= $this->Plannings->status($planning->status) ?>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Data do Cadastro') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($planning->created) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Última Alteração') ?></label><br>
                <span class="label label-default"><?= $this->MyHtml->date($planning->modified) ?></span>
            </div>
            <div class="form-group box bottom-5 bg-warning">
                <label><?= __('Usuário da Alteração') ?></label><br>
                <span class="label label-default"><?= h($planning->username) ?></span>
            </div>
        </div>
    </div>
    
    <?php
    //LANÇAMENTOS VINCULADOS (AGRUPAMENTOS)
    if ($planning->status == 'A' || $planning->status == 'F') {
        if (!empty($moviments)) {
            ?>
            <div class="form-group col-xs-12 box bg-success panel-group">
                <div class="sub-header"><h5><label><?= __('LANÇAMENTOS FINANCEIROS') ?></label></h5></div>
                <div class="table-responsive">
                    <table class="table no-margin table-striped">
                        <thead>
                            <tr>
                                <th class="text-left"><?= __('Ordem') ?></th>
                                <th class="text-left"><?= __('Vencimento') ?></th>
                                <th class="text-left"><?= __('Pagamento') ?></th>
                                <th class="text-left"><?= __('Descrição') ?></th>
                                <th class="text-right"><?= __('Parcela') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total = 0;
                            if (isset($moviments)) {
                                foreach ($moviments as $moviment): ?>
                                    <tr>
                                        <td class="text-left"><?= $this->Html->link(str_pad($moviment->ordem, 6, '0', STR_PAD_LEFT), ['controller' => 'Moviments', 'action' => 'view', $moviment->id], ['class' => 'btn_modal2 label label-primary', 'data-title' => __('Visualizar Lançamento'), 'data-toggle' => 'modal', 'data-target' => '#myModal2']); ?></td>
                                        <td class="text-left"><?= $this->MyHtml->date($moviment->vencimento) ?></td>
                                        <td class="text-left"><?= $moviment->dtbaixa ? $this->MyHtml->date($moviment->dtbaixa) : '-'; ?></td>
                                        <td class="text-left"><?= h($moviment->historico) ?></td>
                                        <td class="text-right text-nowrap">
                                            <?= $this->Number->precision($moviment->valor, 2); $total += $moviment->valor; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                endforeach; 
                            }
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right"><?= __('Total') ?></th>
                                <th class="text-center"><?= $this->Number->precision($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <?php 
        }//if (isset($vinculados))
    }//if ($moviment->status == 'G' || $moviment->status == 'B')
    ?>
</div>