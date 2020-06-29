<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-foot.ctp */
?>

<div class="col-xs-12 bottom-100 font-12 text-right">
    <?= __('Relatório emitido pelo usuário ').$this->request->Session()->read('username') ?>
    <?= __(' em ').date('d/m/Y').' às '.date('H:i:s') ?><br />
</div>