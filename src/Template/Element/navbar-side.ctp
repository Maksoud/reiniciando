<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/navbar-side.ctp */

$pr = $cu = $tr = $ba = $bo = $ca = $ap = $co = $dt = $et = 'list-group-item box-shadow right-5 ';
if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) {
	if ($this->request->url == 'providers')              $pr .= 'active';
	elseif ($this->request->url == 'customers')          $cu .= 'active';
	elseif ($this->request->url == 'banks')              $ba .= 'active';
	elseif ($this->request->url == 'boxes')              $bo .= 'active';
	elseif ($this->request->url == 'cards')              $ca .= 'active';
	elseif ($this->request->url == 'account-plans')      $ap .= 'active';
	elseif ($this->request->url == 'costs')              $co .= 'active';
	elseif ($this->request->url == 'document-types')     $dt .= 'active';
	elseif ($this->request->url == 'event-types')        $et .= 'active';
} elseif ($this->request->Session()->read('sessionPlan') == 1) {
	if ($this->request->url == 'banks/index-simple')     $ba .= 'active';
	elseif ($this->request->url == 'boxes/index-simple') $bo .= 'active';
	elseif ($this->request->url == 'cards/index-simple') $ca .= 'active';
	elseif ($this->request->url == 'costs/index-simple') $co .= 'active';
} elseif ($this->request->Session()->read('sessionPlan') == 4) {
	if ($this->request->url == 'banks/index-simple')     $ba .= 'active';
	elseif ($this->request->url == 'boxes/index-simple') $bo .= 'active';
	elseif ($this->request->url == 'costs/index-simple') $co .= 'active';
}
?>

<div class="col-sm-3 col-md-2 sidebar">
    <div>
        <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
        <div class="list-group fa" style="display: inline">
            <?= $this->Html->link(__(' Clientes'), ['controller' => 'Customers', 'action' => 'index'], ['class' => 'fa-briefcase '.$cu, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Fornecedores'), ['controller' => 'Providers', 'action' => 'index'], ['class' => 'fa-shopping-cart '.$pr, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Caixas'), ['controller' => 'Boxes', 'action' => 'index'], ['class' => 'fa-money '.$bo, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Bancos'), ['controller' => 'Banks', 'action' => 'index'], ['class' => 'fa-university '.$ba, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Cartões'), ['controller' => 'Cards', 'action' => 'index'], ['class' => 'fa-credit-card-alt '.$ca, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Planos de Contas'), ['controller' => 'AccountPlans', 'action' => 'index'], ['class' => 'fa-sort-amount-asc '.$ap, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Centros de Custos'), ['controller' => 'Costs', 'action' => 'index'], ['class' => 'fa-arrows-alt '.$co, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Tipos de Documentos'), ['controller' => 'DocumentTypes', 'action' => 'index'], ['class' => 'fa-files-o '.$dt, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Tipos de Eventos'), ['controller' => 'EventTypes', 'action' => 'index'], ['class' => 'fa-random '.$et, 'escape' => false]) ?>
        </div>
        <?php } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
        <div class="list-group fa" style="display: inline">
            <?= $this->Html->link(__(' Carteiras'), ['controller' => 'Boxes', 'action' => 'index-simple'], ['class' => 'fa-money '.$bo, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Bancos'), ['controller' => 'Banks', 'action' => 'index-simple'], ['class' => 'fa-university '.$ba, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Cartões'), ['controller' => 'Cards', 'action' => 'index-simple'], ['class' => 'fa-credit-card-alt '.$ca, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Categorias'), ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'fa-arrows-alt '.$co, 'escape' => false]) ?>
        </div>
        <?php } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
        <div class="list-group fa" style="display: inline">
            <?= $this->Html->link(__(' Clientes'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-briefcase btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Fornecedores'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-shopping-cart btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Caixas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-money btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Carteiras'), ['controller' => 'Boxes', 'action' => 'index-simple'], ['class' => 'fa-money '.$bo, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Bancos'), ['controller' => 'Banks', 'action' => 'index-simple'], ['class' => 'fa-university '.$ba, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Cartões'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-credit-card-alt btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Categorias'), ['controller' => 'Costs', 'action' => 'index_simple'], ['class' => 'fa-arrows-alt '.$co, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Planos de Contas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-sort-amount-asc btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Centros de Custos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-arrows-alt btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Tipos de Documentos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-files-o btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
            <?= $this->Html->link(__(' Tipos de Eventos'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-random btn_modal list-group-item box-shadow right-5 text-inactive', 'escape' => false]) ?>
        </div>
        <?php }//elseif ($this->request->Session()->read('sessionPlan') == 4) ?>
    </div>
    
    <div class="row text-center text-nowrap top-10" id="footer_hora">
        <span style="color: #27559C"><?= date('d/m/Y ') ?></span>
        <span id="timer"><?= date('H:i:s') ?></span>
        <br>
        <h5>
            <small>
                <?= $this->Html->image("Reiniciando.png", ['style' => 'width: 90px;']) ?> <br/>
                <?= __('Validade do Sistema:') ?> <?= $this->request->Session()->read('validade') ?> <br/>
                <?= __('Versão do Sistema:') ?> <?= $this->request->Session()->read('version') ?><?php if ($this->request->Session()->read('debug') == true) {echo '<i class="fa fa-bug"></i>';} ?> <br/>
                <?= __('Plano Atual:') ?> <?= $this->request->Session()->read('plano') ?> <br/>
                <?= __('Nível de Acesso:') ?> <?= $this->UsersParameters->rules($this->request->Session()->read('sessionRuleId')) ?>
            </small>
        </h5>
    </div>
</div>