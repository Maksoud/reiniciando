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
/* File: src/Template/Pages/reenvia_senha.ctp */
?>

<?php $this->layout = 'layout-clean'; ?>
<?= $this->Html->css('login') ?>

<div class="estrutura bg_login">
    <div class="container">

        <div class="top20 col-xs-10 col-sm-12">
            <a id="logo" class="pull-right" href="https://reiniciando.com.br/">
                <?= $this->Html->image("Reiniciando.png", ['class' => 'img-responsive', 'style' => 'width: 200px; margin-bottom: 10px; margin-left:-15px;', 'alt' => 'Logo Reiniciando.com.br']) ?>
            </a>
        </div>

        <div class="top40 col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 form_login">
            <div id="form_entrar" class="top10 bottom30 col-xs-12 collapse in">
                <?= $this->Flash->render() ?>
                
                <h3 style="color: #286090;">
                    <i class="fa fa-key font-24"></i> <?= __('Recuperação de senha') ?>
                </h3>
                
                <div class="col-xs-12 col-sm-12 col-md-offset-2 col-md-8 semPadding ">
                    
                    <?= $this->Form->create('User') ?>

                    <div class="row">
                        <div class="col-xs-12 bottom-10 top-20">
                            <div class="row">
                                <div class="col-xs-12">
                                    <label class="control-label text-nowrap"><?= __('Digite o seu e-mail') ?></label>
                                    <?= $this->Form->control('username', ['label' => false, 'type' => 'email', 'class' => 'form-control form-group width-x317', 'required' => true]) ?>
                                </div>
                            </div>
                            <hr class="bottom10 alt2 hidden-xs">
                            <?= $this->Form->button('Enviar', ['type' => 'submit', 'class' => 'top5 bottom20 col-xs-12 col-sm-6 col-md-5 btn btn-primary', 'style' => 'height: 42px; font-size: 18px;']) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>

                </div>
            </div>            
        </div>

    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>