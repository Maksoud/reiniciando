<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* AccountPlans */
/* File: src/Template/AccountPlans/view.ctp */
?>

<?php $this->layout = 'ajax'; ?>

<div class="container-fluid">
    
    <div class="row">
        <div class="col-xs-12 list-plans">
            <div class="alert alert-info">
                Clique nos ícones para ver os planos agrupados
            </div>
            
            <div id="tree"></div>
            
        </div>
    </div>
    
    <script type="text/javascript">
        $('#tree').treeview({data: <?= $plansList ?>,
                             showBorder: false,
                             highlightSelected: false,
                             selectable: true
                            });
    </script>
    
</div>