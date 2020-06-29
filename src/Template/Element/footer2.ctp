<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>

<!--<= $this->Html->script('jquery-1.7.1.min') ?>-->
<!--<= $this->Html->script('jquery-1.9.1.min') ?>-->
<!--<= $this->Html->script('jquery-1.10.1.min') ?>-->
<!--<= $this->Html->script('jquery-1.12.4.min') ?>-->
<!--<= $this->Html->script('jquery-2.1.3.min') ?>-->
<!--<= $this->Html->script('jquery-2.2.4.min') ?>-->
<!--<= $this->Html->script('jquery-3.1.1.min') ?>-->
<!--<= $this->Html->script('jquery-3.3.1.min') ?>-->
<?= $this->Html->script([
                         'jquery-2.2.4.min',
                         //Plugin jQuery
                         'jquery.mask',
                         'jquery.maskMoney',
                         'jquery.countdownTimer.min',
                         'jquery.dataTables.min',
                         'jquery.cookie',
                         //Bootstrap
                         'bootstrap.min',
                         'bootstrap-multiselect',
                         'bootstrap-datepicker.min',
                         'bootstrap-datepicker.pt-BR.min',
                         //Tutoriais
                         'modernizr.mq',
                         //Extras
                         'maksoud-custom.min',
                         'maksoud-mask.min',
                         'scripts.min',
                         'typeahead.jquery',
                         'bloodhound',
                         'bootstrap-treeview.min',
	                     'jquery.joyride-2.1',
	                     'maksoud-joyride.min'
                        ]) 
?>

<div class="col-xs-12 bottom-40">
	<div class="pull-bottom-developed hidden-print">
	    <?= $this->Html->image("Reiniciando.png", ['style' => 'width: 80px;']) ?> <br/>
	    ®Reiniciando - Sistemas Empresariais <br/>
	    <?php if (!empty($this->request->Session()->read('version'))) { ?>
	    	<?= __('Versão') ?> <?= $this->request->Session()->read('version'); ?>
	    <?php } ?>
	    <?php if ($this->request->Session()->read('debug') == true) { echo '<i class="fa fa-bug"></i>'; } ?> <br/>
	</div>
</div>
