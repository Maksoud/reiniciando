<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Payments */
/* File: src/Template/Payments/edit.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($payment) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="col-xs-12 box">
            <div class="<?= $double ?>">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Vencimento da Fatura') ?></label>
                        <?= $this->Form->control('vencimento', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' focus datepicker datemask controldate', 'placeholder' => __('Ex. 01/01/2020'), 'required' => true]) ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Empresa') ?></label>
                        <?= $this->Form->control('parameters_id', ['label' => false, 'type' => 'select', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $double ?>">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Período de Ativação') ?></label>
                        <?= $this->Form->control('periodo', ['label' => false, 'placeholder' => '3, 6 ou 12 meses', 'class' => $input, 'required' => true]) ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Valor da Fatura') ?></label>
                        <?= $this->Form->control('valor', ['label' => false, 'type' => 'text', 'class' => $input . ' valuemask', 'value' => $this->MyForm->decimal($payment->valor), 'placeholder' => __('0,00'), 'required' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-offset-1 col-xs-12 col-sm-10 well">
                <div class="scrolling height-115">
                    <table class="table table-hover table-condensed text-center">
                        <thead>
                            <tr>
                                <th class="text-center"><?= __('Empresa') ?></th>
                                <th class="text-center"><?= __('Status') ?></th>
                                <th class="text-center"><?= __('Validade') ?></th>
                                <th class="text-center"><?= __('Mensaliade') ?></th>
                                <th class="text-center"><?= __('Período') ?></th>
                                <th class="text-center text-nowrap"><?= __('Total Fatura') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($mensalidades as $mensalidade): ?>
                                <tr>
                                    <th><?= $mensalidade->id.' - '.$mensalidade->razao; ?></th>
                                    <td class="text-center"><?= $this->Parameters->status($mensalidade->dtvalidade) ?></td>
                                    <td class="text-center"><?= date("d/m/Y", strtotime($mensalidade->dtvalidade)); ?></td>
                                    <td class="text-right"><?= $this->Number->precision($mensalidade->mensalidade, 2); ?></td>
                                    <td class="text-center"><?= $mensalidade->periodo_ativacao; ?></td>
                                    <td class="text-right"><?= $this->Number->precision($mensalidade->mensalidade * $mensalidade->periodo_ativacao, 2); ?></td>
                                </tr>
                                <?php 
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>