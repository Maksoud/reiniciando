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
/* File: src/Template/Pages/cadastrar.ctp */
?>


<?php $this->layout = 'cadastrar'; ?>
<?= $this->Form->create('Cadastrar') ?>

<?php 
    $double = 'col-xs-12 col-sm-6';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

<script>
    (function($){
        $(document).ready(function($){

            $('input:radio[name=radio]').on('change', function(){
                if ($(this).val() == 'F') {
                    $('.F').addClass('show').removeClass('hidden');
                    $('.J').addClass('hidden').removeClass('show');
                    $('#cnpj').removeAttr('required');
                    $('#razao').removeAttr('required');
                    $('#main-div').addClass('col-xs-12');
                    $('#main-div').removeClass('col-xs-6');
                } else {
                    $('.F').addClass('hidden').removeClass('show');
                    $('.J').addClass('show').removeClass('hidden');
                    $('#cnpj').attr('required', 'required');
                    $('#razao').attr('required', 'required');
                    $('#main-div').removeClass('col-xs-12');
                    $('#main-div').addClass('col-xs-6');
                }
            });
            
            //Máscara de telefone
            var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
            
            $('.cnpjmask').mask('00.000.000/0000-00');
            $('.cepmask').mask('00000-000');
            $('.phonemask').mask(SPMaskBehavior, spOptions);
        });
    })(jQuery);
</script>

<div class="estrutura" style="font-family: 'Roboto Condensed', sans-serif; font-size: 15px;">
    <div class="container">
        
        <div class="col-xs-12">
            <div class="padding-15 top-10 col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 form_login text-center">
                <div class="text-nowrap font-36" style="font-weight: 500; margin-top: 10px; margin-bottom: -10px; color: #286090;">
                    <?= __('É Prático, Rápido e Gratuito!') ?>
                </div>
                <div class="text-nowrap font-20 bottom-20" style="font-weight: 500; color: #286090;">
                    <?= __('Reiniciando Sua Organização do Jeito Certo') ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12">
            <div class="top30 bottom-20 col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 form_login">

                <div id="form_entrar" class="top10 bottom30">
                    <?= $this->Flash->render() ?>
                    
                    <h3 style="color: #286090;">
                        <i class="fa fa-sign-in font-24"></i> <?= __('Cadastre-se Grátis') ?>
                    </h3>
                    <!-- //// -->
                    <div class="col-xs-12" id="main-div">
                        <div class="form-group top20">
                            <label class="<?= $label ?>">
                                <?= __('Como deseja ser chamado?') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Informe seu nome.') ?>"></i>
                            </label>
                            <?= $this->Form->control('name', ['label' => false, 'type' => 'text', 'class' => $input, 'placeholder' => 'Ex: João Silva', 'required' => true]) ?>
                        </div>
                        <div class="form-group top20">
                            <label class="<?= $label ?>">
                                <?= __('Qual é o seu e-mail?') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('O seu e-mail será utilizado como login para acesso ao sistema.') ?>"></i>
                            </label>
                            <?= $this->Form->control('username', ['label' => false, 'type' => 'email', 'class' => $input, 'placeholder' => 'Ex: joao@dominio.com', 'aria-describedby' => 'emailHelp', 'required' => true]) ?>
                            <small id="emailHelp" class="form-text text-muted"><?= __('Nós nunca compartilharemos seu e-mail com outras empresas ou pessoas.') ?></small>
                        </div>
                        <div class="form-group top20">
                            <label class="<?= $label ?>">
                                <?= __('Crie uma senha') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Crie uma senha com no mínimo 5 caracteres, usando letras minúsculas e maiúsculas, caracteres especiais e números.') ?>"></i>
                            </label>
                            <?= $this->Form->control('password', ['label' => false, 'type' => 'password', 'id' => 'login_senha', 'class' => 'form-control', 'type' => 'password', 'minlength' => '5', 'placeholder' => 'Ex: a1b2c3', 'required' => true]) ?>
                        </div>
                    </div>
                    <!-- //// -->
                    <div class="col-xs-12 text-center top-20 bottom-20">
                        <?= $this->Form->button(__('Entrar'), ['type' => 'submit', 'class' => 'width-150 btn btn-primary font-18', 'style' => 'height: 42px;', 'div' => false]) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="padding-15 top-10 col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 form_login text-center bottom-20">
            <div class="text-nowrap font-18 top-20 bottom-10" style="font-weight:500;color:#286090;">
                <?= __('Já anotou nosso e-mail de suporte?') ?>
            </div>
            <div class="text-nowrap font-30 bottom-20" style="font-weight:500;margin-top:10px;color:#286090;">
                <?= __('Suporte@Reiniciando.com.br') ?>
            </div>
        </div>
    </div>
</div>

<div class="pull-right text-center right-20 bottom-10 font-9" style="color: #777777; bottom: 0; color: #777777; position: fixed; right: 0;">
    <?= $this->Html->image("Reiniciando.png", ['style' => 'width: 80px;']) ?> <br/>
    @2015-<?= date('Y') ?> Reiniciando®
</div>