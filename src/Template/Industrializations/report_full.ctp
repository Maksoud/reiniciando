<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Report */
/* File: src/Template/Industrializations/reportFull.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('Industrializations', ['target' => '_blank']) ?>

<?= $this->Html->css('bootstrap-multiselect.min') ?>
<?= $this->Html->script('bootstrap-multiselect.min') ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid">
        <div class="row">
            
            <div class="<?= $single ?> well">
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#industrializations').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 300,
                                    dropUp: false,
                                    includeSelectAllOption: false,
                                    selectAllText: 'Selecionar Todos',
                                    allSelectedText: 'Todos Selecionados',
                                    nonSelectedText: 'Lista de Ordens',
                                    nSelectedText: 'selecionados',
                                });
                            });
                        </script>
                        <label class="<?= $label ?>" style="font-weight: normal">
                            <?= __('Ordens de Fabricação') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Selecione a ordem de fabricação que você deseja rastrear.') ?>"></i>
                        </label>
                        <?= $this->Form->control('industrializations_id', ['label' => false, 'type' => 'select', 'id' => 'industrializations', 'class' => $input, 'empty' => false, 'options' => $industrializations]) ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gerar Relatório'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>