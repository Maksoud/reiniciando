<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Regs */
/* File: src/Template/Regs/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-8">
        <div class="form-group">
            <h4><?= __('Tipo de LOG') ?></h4>
            <?= h($reg->log_type) ?>
        </div>
        <div class="form-group">
            <h4><?= __('Função') ?></h4>
            <?= h($reg->function) ?>
        </div>
        <div class="form-group scrolling">
            <h4><?= __('Conteúdo do LOG') ?></h4>
            <?= ($reg->content) ?>
        </div>
    </div>
    <div class="col-md-offset-1 col-md-3 box bg-warning">
        <div class="form-group">
            <h4><?= __('Data da Criação') ?></h4>
            <?= h($reg->created) ?>
        </div>
        <div class="form-group">
            <h4><?= __('Usuário do Registro') ?></h4>
            <?= h($reg->username) ?>
        </div>
    </div>
</div>