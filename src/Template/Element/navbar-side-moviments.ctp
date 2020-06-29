<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/navbar-up.ctp */

$m = $mc = $mb = $ma = $mh = $tr = $pl = 'list-group-item box-shadow right-5 ';
if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) {
    if ($this->request->url == 'moviments')                        $m  .= 'active';
    elseif ($this->request->url == 'moviment-cards')               $mc .= 'active';
    elseif ($this->request->url == 'moviment-boxes')               $mb .= 'active';
    elseif ($this->request->url == 'moviment-banks')               $ma .= 'active';
    elseif ($this->request->url == 'moviment-checks')              $mh .= 'active';
    elseif ($this->request->url == 'transfers')                    $tr .= 'active';
    elseif ($this->request->url == 'plannings')                    $pl .= 'active';
} elseif ($this->request->Session()->read('sessionPlan') == 1) { 
    if ($this->request->url == 'moviments/index-simple')           $m  .= 'active';
    elseif ($this->request->url == 'moviment-cards/index-simple')  $mc .= 'active';
    elseif ($this->request->url == 'moviment-boxes/index-simple')  $mb .= 'active';
    elseif ($this->request->url == 'moviment-banks/index-simple')  $ma .= 'active';
    elseif ($this->request->url == 'transfers/index-simple')       $tr .= 'active';
    elseif ($this->request->url == 'plannings/index-simple')       $pl .= 'active';
} elseif ($this->request->Session()->read('sessionPlan') == 4) { 
    if ($this->request->url == 'moviments/index-simple')           $m  .= 'active';
    elseif ($this->request->url == 'moviment-boxes/index-simple')  $mb .= 'active';
    elseif ($this->request->url == 'moviment-banks/index-simple')  $ma .= 'active';
}
?>

<div class="col-sm-3 col-md-2 sidebar">
    <div style="min-width: 195px;">
        <?php if ($this->request->Session()->read('sessionPlan') == 2 || $this->request->Session()->read('sessionPlan') == 3) { ?>
        <div class="list-group fa " style="display: inline">
            <?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index'], ['class' => 'fa-folder-open-o '.$m, 'escape' => false]) ?> 
            <?= $this->Html->link(__(' Movimentos de Caixa'), ['controller' => 'MovimentBoxes', 'action' => 'index'], ['class' => 'fa-money '.$mb, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index'], ['class' => 'fa-university '.$ma, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Cheque'), ['controller' => 'MovimentChecks', 'action' => 'index'], ['class' => 'fa-cc '.$mh, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index'], ['class' => 'fa-credit-card-alt '.$mc, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Transferências'), ['controller' => 'Transfers', 'action' => 'index'], ['class' => 'fa-exchange '.$tr, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Planejamentos & Metas'), ['controller' => 'Plannings', 'action' => 'index'], ['class' => 'fa-trophy '.$pl, 'escape' => false]) ?>
        </div>
        <?php } elseif ($this->request->Session()->read('sessionPlan') == 1) { ?>
        <div class="list-group fa" style="display: inline">
            <?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'fa-folder-open-o '.$m, 'escape' => false]) ?> 
            <?= $this->Html->link(__(' Movimentos de Carteira'), ['controller' => 'MovimentBoxes', 'action' => 'index_simple'], ['class' => 'fa-money '.$mb, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index_simple'], ['class' => 'fa-university '.$ma, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'MovimentCards', 'action' => 'index_simple'], ['class' => 'fa-credit-card-alt '.$mc, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Transferências'), ['controller' => 'Transfers', 'action' => 'index_simple'], ['class' => 'fa-exchange '.$tr, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Planejamentos & Metas'), ['controller' => 'Plannings', 'action' => 'index_simple'], ['class' => 'fa-trophy '.$pl, 'escape' => false]) ?>
        </div>
        <?php } elseif ($this->request->Session()->read('sessionPlan') == 4) { ?>
        <div class="list-group fa" style="display: inline">
            <?= $this->Html->link(__(' Contas a Pagar/Receber'), ['controller' => 'Moviments', 'action' => 'index_simple'], ['class' => 'fa-folder-open-o '.$m, 'escape' => false]) ?> 
            <?= $this->Html->link(__(' Movimentos de Caixa'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-money btn_modal list-group-item box-shadow right-5 text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Carteira'), ['controller' => 'MovimentBoxes', 'action' => 'index_simple'], ['class' => 'fa-money '.$mb, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Banco'), ['controller' => 'MovimentBanks', 'action' => 'index_simple'], ['class' => 'fa-university '.$ma, 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Cheque'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-cc btn_modal list-group-item box-shadow right-5 text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Movimentos de Cartão'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-credit-card-alt btn_modal list-group-item box-shadow right-5 text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Transferências'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-exchange btn_modal list-group-item box-shadow right-5 text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?>
            <?= $this->Html->link(__(' Planejamentos & Metas'), ['controller' => 'Pages', 'action' => 'aviso_gratis'], ['class' => 'fa-trophy btn_modal list-group-item box-shadow right-5 text-inactive', 'title' => __('Disponível na versão completa'), 'escape' => false]) ?>
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
    