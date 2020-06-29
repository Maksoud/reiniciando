<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/msg-alert.ctp */

    if ( !isset($class) ) $class = ''; //evitar erro por nao ter sido passado o valor da class
    if ( isset($icon) )
        $icon = "<i class=\"glyphicon {$icon}\"></i>&nbsp;"; //completar html do icone com seu nome
    else
        $icon = ''; //evitar erro por nao ter sido passado o valor do icone
?>

<div class="alert <?php echo $class; ?>" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span>&times;</span>
    </button>
    <?php echo $icon . ($message); ?>
</div>