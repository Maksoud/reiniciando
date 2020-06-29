<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/navbar-side-syste.ctp */

$pr = $ur = $pg = $vu = $vs = $bl = $bk = $re = $sc = $ot = 'list-group-item box-shadow right-5 ';
if ($this->request->url == 'parameters')           $pr .= 'active';
elseif ($this->request->url == 'users')            $ur .= 'active';
elseif ($this->request->url == 'payments')         $pg .= 'active';
elseif ($this->request->url == 'users-parameters') $vu .= 'active';
elseif ($this->request->url == 'knowledges')       $vs .= 'active';
elseif ($this->request->url == 'balances')         $bl .= 'active';
elseif ($this->request->url == 'backups')          $bk .= 'active';
elseif ($this->request->url == 'regs')             $re .= 'active';
elseif ($this->request->url == 'support-contacts') $sc .= 'active';
?>

<div class="col-sm-3 col-md-2 sidebar">
    <div style="min-width: 195px;">
        <div class="list-group fa" style="display: inline">
            <?= $this->Html->link(__(' Meus Dados'), ['controller' => 'Parameters', 'action' => 'index'], ['class' => 'fa-database '.$pr, 'escape' => false]) ?>
            <?php if ($this->request->Session()->read('sessionRule') != 'cont') { ?>
                <?= $this->Html->link(__(' Usuários'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'fa-user-plus '.$ur, 'escape' => false]) ?>
                <?= $this->Html->link(__(' Pagamentos do Sistema'), ['controller' => 'Payments', 'action' => 'index'], ['class' => 'fa-usd '.$pg, 'escape' => false]) ?>
            <?php } ?>
            <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                <?= $this->Html->link(__(' Vínculo de Usuários'), ['controller' => 'UsersParameters', 'action' => 'index'], ['class' => 'fa-users '.$vu, 'escape' => false]) ?>
                <?= $this->Html->link(__(' Você Sabia?'), ['controller' => 'Knowledges', 'action' => 'index'], ['class' => 'fa-bell-o '.$vs, 'escape' => false]) ?>
                <?= $this->Html->link(__(' Relatório de Saldos'), ['controller' => 'Balances', 'action' => 'index'], ['class' => 'fa-usd '.$bl, 'escape' => false]) ?></li>
                <?= $this->Html->link(__(' Lista de Backups'), ['controller' => 'Backups', 'action' => 'index'], ['class' => 'fa-archive '.$bk, 'escape' => false]) ?>
                <?= $this->Html->link(__(' Log de Registros'), ['controller' => 'Regs', 'action' => 'index'], ['class' => 'fa-file-text-o '.$re, 'escape' => false]) ?>
                <?= $this->Html->link(__(' System Logs'), ['controller' => 'Pages', 'action' => 'viewSystemLog'], ['class' => 'fa-file-text-o '.$ot.'list-group-item btn_modal', 'data-loading-text' => __('Loading...'), 'data-title' => __('System and Debug Logs'), 'escape' => false]) ?>
                <?= $this->Html->link(__(' Update Logs'), ['controller' => 'Pages', 'action' => 'viewUpdateLog'], ['class' => 'fa-file-text-o '.$ot.'list-group-item btn_modal', 'data-loading-text' => __('Loading...'), 'data-title' => __('Update Logs'), 'escape' => false]) ?>
            <?php } ?>
            <?php if ($this->request->Session()->read('sessionRule') == 'admin' || $this->request->Session()->read('sessionRule') == 'super') { ?>
                <?= $this->Html->link(__(' Backup Local'), ['controller' => 'Backups', 'action' => 'backupFull'], ['class' => 'btn_modal fa-download '.$ot.'list-group-item', 'escape' => false]) ?>
                <?= $this->Html->link(__(' Backup Remoto'), ['controller' => 'Backups', 'action' => 'backupFTP'], ['class' => 'btn_modal fa-download '.$ot.'list-group-item', 'escape' => false]) ?>
                <?= $this->Html->link(__(' Atualizar Sistema'), ['controller' => 'Pages', 'action' => 'update?token=y5eehc123avse6463asd35k3cb6'], ['class' => 'fa-cloud-download '.$ot.'list-group-item', 'escape' => false]) ?>
            <?php } ?>
            <?= $this->Html->link(__(' Chamado de Suporte'), ['controller' => 'SupportContacts', 'action' => 'index'], ['class' => 'fa-comments-o '.$sc, 'escape' => false]) ?>
        </div>
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