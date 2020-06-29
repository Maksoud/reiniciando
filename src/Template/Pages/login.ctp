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
/* File: src/Template/Pages/login.ctp */
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
                    <i class="fa fa-sign-in font-24"></i> <?= __('Entrar no sistema') ?>
                </h3>
                
                <div class="col-xs-12 col-sm-12 col-md-offset-2 col-md-8 semPadding ">
                    <?= $this->Form->create('User') ?>
                        <?= $this->Form->control('username', ['label' => false, 'type' => 'email', 'class' => 'top20 form-control', 'placeholder' => 'E-mail do usuário']) ?>
                        <div class="form-group top20">
                            <?= $this->Form->control('password', ['label' => false, 'type' => 'password', 'id' => 'login_senha', 'class' => 'form-control', 'placeholder' => 'Senha', 'div' => ['class' => 'input-group'], 'after' => '<span class="add-on input-group-addon"><i class="fa fa-eye"></i></span>']) ?>
                        </div>

                        <a id="btn_esqueci_senha" class="top5 bottom20 pull-right btn btn-link semPadding">
                            <?= __('Esqueci minha senha') ?>
                        </a>
                        <hr class="bottom10 alt2 hidden-xs">
                        <?= $this->Form->button('Entrar', ['type' => 'submit', 'class' => 'top5 bottom20 col-xs-12 col-sm-6 col-md-5 btn btn-primary', 'style' => 'height: 42px; font-size: 18px;']) ?>
                    <?= $this->Form->end() ?>
                    
                    <div class="col-xs-12 col-sm-offset-1 col-sm-5 col-md-6 font-12 text-center">
                        <?= __('Ainda não tem uma conta?') ?> <br/>
                        <?= __('Aproveite 30 dias grátis!') ?> 
                        <a href="https://reiniciando.com.br/financeirov2/pages/cadastrar" class="btn btn-link"><?= __('cadastre-se agora') ?></a>
                    </div>
                </div>
            </div>
            
            <div id="form_recuperar_senha" class="top10 bottom30 col-xs-12 collapse">
                <h3>
                    <i class="fa fa-sign-in font-24"></i>
                    <?= __('Não consegue entrar?') ?>
                </h3>
                <p>
                    <?= __('Para recuperar sua senha, preencha o campo abaixo com seu e-mail cadastrado. Você irá receber um link para criar uma nova senha.') ?>
                </p>
                
                <?= $this->Form->create('User', ['url' => ['controller' => 'pages', 'action' => 'reenviaSenha']]) ?>
                <?= $this->Form->control('username', ['label' => false, 'type' => 'email', 'class' => 'top20 form-control', 'placeholder' => "E-mail do usuário"]) ?>
                <?= $this->Form->button(__('Obter nova senha'), ['type' => 'submit', 'class' => 'top35 col-xs-12 col-sm-6 col-md-5 btn btn-primary pull-left', 'div' => false]) ?>
                <?= $this->Form->end() ?>

                <div class="top30 col-xs-12 col-sm-offset-1 col-sm-5 col-md-6">
                    <a id="btn_voltar_login" class="top10 bottom20 pull-right btn btn-link semPadding pull-rigth">
                        <?= __('Voltar para login') ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->element('modal') ?>