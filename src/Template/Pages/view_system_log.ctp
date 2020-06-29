<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Pages */ 
/* File: src/Template/Pages/view_system_log.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    <div class="col-md-12 no-padding-lat">
    	
    	<?= $this->Html->link(__(' Limpar LOG'), ['controller' => 'Pages', 'action' => 'view-system-log', 'clearLog' => true], ['class' => 'fa fa-trash-o', 'escape' => false]) ?><br><br>
    	
    	
    	<h3 class="page-header box-header top-20"><?= __('SYSTEM LOG') ?></h3>
    	<div class="table-responsive">
	        <table class="table table-striped dataTable no-footer"><!-- id="adjustable" -->
	            <thead>
	                <tr>
	                    <th class="text-nowrap"><?= __('Content') ?></th>
	                </tr>
	            </thead>
	            <tbody>
					<?php 
					foreach ($viewSystemLog['system'] as $value): ?>
	                    <tr>
	                        <td style="white-space: pre-wrap;"><?= $value ?></td>
	                    </tr>
						<?php 
					endforeach; ?>
	            </tbody>
	        </table>
	    </div>
	    
    	<div class="col-xs-12"></div>
    	
    	<h3 class="page-header box-header top-20"><?= __('DEBUG LOG') ?></h3>
    	<div class="table-responsive">
	        <table class="table table-striped dataTable no-footer"><!-- id="adjustable" -->
	            <thead>
	                <tr>
	                    <th class="text-nowrap"><?= __('Content') ?></th>
	                </tr>
	            </thead>
	            <tbody>
					<?php 
					foreach ($viewSystemLog['debug'] as $value): ?>
	                    <tr>
	                        <td style="white-space: pre-wrap;"><?= $value ?></td>
	                    </tr>
						<?php 
					endforeach; ?>
	            </tbody>
	        </table>
	    </div>

    </div>
</div>