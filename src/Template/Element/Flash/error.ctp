<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/Flash/error.ctp */

if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div class="alert bg-danger box-shadow" onclick="this.classList.add('hidden');">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span>&times;</span>
    </button>
    <i class="fa fa-exclamation-triangle"></i> <?= $message ?>
</div>
