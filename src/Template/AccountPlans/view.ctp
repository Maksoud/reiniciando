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
    
    <div class="col-xs-12 panel-group box">
        <div class="form-group">
            <label><?= __('Plano de Contas') ?></label><br>
            <?= $accountPlan->classification.' - '.$accountPlan->title ?>
        </div>
        <?php if (!empty($accountPlan->plangroup)) {?>
        <div class="form-group">
            <label><?= __('Grupo') ?></label><br>
            <?php 
            foreach ($plangroups as $plangroup): 
                if ($accountPlan->plangroup == $plangroup->id) {
                    echo $plangroup->classification.' - '.$plangroup->title;
                }
            endforeach; ?>
        </div>
        <?php }?>
        <div class="form-group">
            <label><?= __('Tipo') ?></label><br>
            <?= $this->AccountPlans->receitadespesa($accountPlan->receitadespesa) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-primary initialism text-center">
        <div class="form-group">
            <label><?= __('Status') ?></label><br>
            <?= $this->Banks->status($accountPlan->status) ?>
        </div>
    </div>
    
    <div class="col-xs-12 box bg-warning initialism text-center">
        <div class="form-group">
            <label><?= __('Data do Cadastro') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($accountPlan->created) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Última Alteração') ?></label><br>
            <span class="label label-default"><?= $this->MyHtml->date($accountPlan->modified) ?></span>
        </div>
        <div class="form-group">
            <label><?= __('Usuário da Alteração') ?></label><br>
            <span class="label label-default"><?= h($accountPlan->username) ?></span>
        </div>
    </div>
</div>