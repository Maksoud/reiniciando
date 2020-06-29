<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Moviments */
/* File: src/Template/Moviments/report_rp.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Moviment', ['target' => '_blank']) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $double ?>">
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('Data de Emissão') ?>*</label>
                        <?= $this->Form->control('data', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' focus datepicker datemask', 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>" style="font-weight: normal"><?= __('Nº do Cheque') ?></label>
                        <?= $this->Form->control('cheque', ['label' => false, 'type' => 'number', 'class' => $input]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Banco') ?>*</label>
                        <?= $this->Form->control('banks_id', ['label' => false, 'type' => 'select', 'class' => $input, 'options' => $banks, 'required' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="<?= $double ?>">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>" style="font-weight: normal"><?= __('Nominal à') ?></label>
                        <?= $this->Form->control('nominal', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>" style="font-weight: normal"><?= __('Descriçao') ?></label>
                        <?= $this->Form->control('descrp', ['label' => false, 'type' => 'text', 'class' => $input]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <?= $this->Form->checkbox('cost', ['hiddenField' => false])?>
                        <label class="<?= $label ?>" style="font-weight: normal"><?= __('Centro de Custos') ?></label>
                    </div>
                </div>
            </div>
            <div class="<?= $single ?>">
                <!-- DÉBITOS NO MÊS -->
                <?php 
                    $count = 0;
                    foreach ($debitos as $moviment):
                        $count += 1;
                    endforeach;

                    if ($count > 0) {
                        ?>
                        <h4 class="page-header text-bold"><?= __('Contas a Pagar').' ('.$count.')' ?></h4>
                        <div style="max-height: 400px; overflow-y: scroll;">
                            <table class="table table-condensed table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                        <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                        <th class="text-left"><?= __('Cliente/Fornecedor') ?></th>
                                        <th class="text-left"><?= __('Histórico') ?></th>
                                        <th class="text-center col-xs-1"><?= __('Valor') ?></th>
                                        <th class="col-xs-1"></th>
                                        <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    foreach ($debitos as $moviment): ?>
                                        <tr>
                                            <td class="text-left"><?= $moviment->ordem ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($moviment->vencimento)) ?></td>
                                            <td class="text-left"><?= $moviment->documento ?></td>
                                            <td class="text-left">
                                                <?= $moviment->Providers['title'] ?>
                                                <?= $moviment->Customers['title'] ?>
                                            </td>
                                            <td class="text-left"><?= $moviment->historico ?></td>
                                            <td class="text-right text-nowrap">
                                                <?php
                                                    $valorpago = 0;
                                                    if ($moviment->status == 'P') {
                                                        foreach ($movimentMergeds as $merged):
                                                            if ($merged->MovimentMerged['moviments_id'] == $moviment->id) {
                                                                if ($merged->Moviment_Mergeds['status'] == 'O' || $merged->Moviment_Mergeds['status'] == 'B') {
                                                                    $valorpago += $merged->Moviment_Mergeds['valorbaixa'];
                                                                } else {
                                                                    $valorpago += $merged->Moviment_Mergeds['valor'];
                                                                }
                                                            }                                    
                                                        endforeach;
                                                    }//if ($moviment->status == 'P')
                                                ?>
                                                <?php if ($moviment->creditodebito == 'C') { ?>
                                                <span style="color: #2aabd2">
                                                    <?= $this->Number->precision($moviment->valor - $valorpago, 2) ?>
                                                </span>
                                                <?php } elseif ($moviment->creditodebito == 'D') { ?>
                                                <span style="color: #ce8483">
                                                    <?= $this->Number->precision($moviment->valor - $valorpago, 2) ?>
                                                </span>
                                                <?php }?>
                                            </td>
                                            <td class="text-center">
                                                <?php if ($moviment->creditodebito == 'C') { ?>
                                                    <span class="fa fa-plus-circle" style="color: #2aabd2" title="<?= __('Crédito') ?>"></span>
                                                <?php } elseif ($moviment->creditodebito == 'D') { ?>
                                                    <span class="fa fa-minus-circle" style="color: #e4b9c0" title="<?= __('Débito') ?>"></span>
                                                <?php }?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <?= $this->Form->checkbox('rp[]', ['value' => $moviment->ordem, 'hiddenField' => false])?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php 
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                <?php } ?>
                <!-- DÉBITOS NO MÊS -->
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gerar Relatório'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>