<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/report-header.ctp */
?>

<div class="header_report hidden-print">
    Reiniciando Sistemas - Controle Financeiro
</div>

<div class="cabecalho_report">
    <?php if (!empty($parameter['logomarca'])) { ?>
    <div class="logomarca_report">
        <?= $this->Html->image($parameter['logomarca'], ['alt' => 'Logomarca', 'height' => '45px']) ?>
    </div>
    <?php } ?>
    <?= $parameter['razao'] ?>
    <?= $parameter['cpfcnpj'] ? ' - ' . $parameter['cpfcnpj'] . '<br>' : ''; ?>
    <?= $parameter['endereco'] ? $parameter['endereco'] . '<br>' : ''; ?>
    <?= $parameter['bairro'] ? $parameter['bairro']: '';  ?>
    <?= $parameter['cidade'] ? ' - ' . $parameter['cidade'] . '/' . $parameter['estado'] : ''; ?>
    <?= $parameter['cep'] ? ' - ' . $parameter['cep'] : ''; ?>
</div>

<div class="right-return hidden-print">
    <?= $this->Html->link(__(' Imprimir'), '#', ['onClick' => 'window.print()', 'class' => 'btn btn-primary fa fa-print']) ?>
</div>