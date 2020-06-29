<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/Flash/d.ctp */

$class = 'message';

if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}

if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>

<div class="<?= h($class) ?>" onclick="this.classList.add('hidden');">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span>&times;</span>
    </button>
    <?= $message ?>
</div>
