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
/* File: src/Template/Moviments/group.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Moviment') ?>

<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script(['bootstrap-multiselect.min',
                         'maksoud-radiooptions.min'
                        ]) ?>

<?php 
    $single = 'col-xs-12 form-group';
    $double = 'col-xs-12 col-sm-6 form-group';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>
    <div class="container-fluid">
        <?php 
        if ($moviment->DocumentTypes['vinculapgto'] == 'S') { ?>
            <div class="panel panel-default">
                <div class="panel-heading text-bold"><?= __('SELECIONE OS TÍTULOS PARA VÍNCULO NESTA FATURA') ?></div>
                <div class="panel-body" style="max-height: 400px; overflow-x: hidden; overflow-y: scroll;">                    
                    <div class="col-xs-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left col-xs-1"><?= __('Ordem') ?></th>
                                    <th class="text-left col-xs-1"><?= __('Emissão') ?></th>
                                    <th class="text-left col-xs-1"><?= __('Vencimento') ?></th>
                                    <th class="text-left col-xs-1"><?= __('Documento') ?></th>
                                    <th class="text-left"><?= __('Histórico') ?></th>
                                    <th class="text-right col-xs-1"><?= __('Valor') ?></th>
                                    <th class="text-center col-xs-1"><?= __('Status') ?></th>
                                    <th class="text-center col-xs-1"><?= __('Ações') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($moviments as $moviment): 
                                    if ($moviment->DocumentTypes['vinculapgto'] != 'S') {?>
                                        <tr>
                                            <td class="text-left"><?= h($moviment->ordem) ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($moviment->data)) ?></td>
                                            <td class="text-left"><?= date("d/m/Y", strtotime($moviment->vencimento)) ?></td>
                                            <td class="text-left"><?= h($moviment->documento) ?></td>
                                            <td class="text-left"><?= h($moviment->historico) ?></td>
                                            <td class="text-right text-nowrap"><?= $this->Number->precision($moviment->valor, 2) ?></td>
                                            <td class="text-center"><?= $this->Moviments->status($moviment->status) ?></td>
                                            <td class="text-center">
                                                <div class="row btn-group text-center width-actions-1">
                                                    <?php 
                                                        $checked = $hidden = false;
                                                        foreach ($movimentMergeds as $merged):
                                                            if ($merged->moviments_merged == $moviment->id) {
                                                                $checked = true;
                                                                $hidden = false;
                                                            } else {
                                                                if ($checked == false) { $hidden = true;}
                                                            }
                                                            if ($moviment->status == 'A') { $hidden = false;}
                                                        endforeach;
                                                        if (empty($movimentMergeds)) {
                                                            if ($moviment->status == 'V') { $hidden = true;}
                                                        }

                                                        echo $this->Form->checkbox('vinculapgto.'.$moviment->id, ['value'       => $moviment->id,
                                                                                                                  'hiddenField' => false,
                                                                                                                  'checked'     => $checked,
                                                                                                                  'hidden'      => $hidden
                                                                                                                 ]
                                                                                  );
                                                    ?>                                                                
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }//if ($moviment->DocumentTypes['vinculapgto'] != 'S')
                                endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php 
        } //if ($moviment->DocumentType]['vinculapgto'] == 'S')
        ?>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>