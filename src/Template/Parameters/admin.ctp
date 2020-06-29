<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Parameters */
/* File: src/Template/Parameters/admin.ctp */
?>

<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create($parameter, ['type' => 'file']) ?>

<?= $this->Html->script(['validaCpfCnpj']) ?>

<?php 
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';
?>

    <div class="container-fluid" id="planos">
        <div class="row">
            <?php 
            if (!isset($parameter['cpfcnpj'])) { 
                $link = '<a href="Parameters/edit_novo/' . $parameter['id'] . '/" data-loading-text="Carregando..." data-title="Complete seu Cadastro">Complete Agora!</a>';
                ?>
                <div class="<?= $single ?> well text-center">
                    <h3><?= __('Seu cadastro ainda está incompleto') ?></h3>
                </div>
            <?php } ?>
            
            <div class="<?= $single ?> well">
                <div class="<?= $double ?>">
                    <?php if (!empty($parameter['logomarca'])) { ?>
                    <div class="form-group">
                        <?= $this->Html->image($parameter['logomarca'], ['alt' => 'Logomarca', 'width' => '150px']) ?>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <h4><?= h($parameter['razao']) ?></h4>
                    </div>
                    <div class="form-group">
                        <span class="text-bold"><?= __('CPF/CNPJ:') ?></span>
                        <?= h($parameter['cpfcnpj']) ?>
                    </div>
                    <div class="form-group">
                        <span class="text-bold"><?= __('Telefone de Contato:') ?></span>
                        <?= h($parameter['telefone']) ?>
                    </div>
                    <div class="row">
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Data de Validade') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('O sistema será permitirá o acesso até a data informada.') ?>"></i>
                            </label>
                            <?php if ($this->request->Session()->read('sessionRule') == 'super') { ?>
                                <?= $this->Form->control('dtvalidade', ['label' => false, 'autocomplete' => 'off', 'type' => 'text', 'class' => $input.' datepicker datemask', 'placeholder' => 'Ex. 01/01/2020']) ?>
                            <?php } else { ?>
                                <?= date("d/m/Y", strtotime($parameter['dtvalidade'])) ?>
                            <?php } ?>
                        </div>
                        <div class="<?= $double ?>">
                            <label class="<?= $label ?>">
                                <?= __('Plano Selecionado') ?>
                                <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Qual é o plano selecionado e quais serão as limitações impostas.') ?>"></i>
                            </label>
                            <?= $this->Form->control('plans_id', ['class' => $input, 'empty' => false, 'label' => false, 'type' => 'select', 'title' => 'Planos', 'options' => $plans]) ?>
                        </div>
                    </div>
                </div>
                <div class="<?= $double ?>">
                    <div class="form-group">
                        <span class="text-bold"><?= __('Cidade/Estado: ') ?></span>
                        <?= h($parameter['cidade']) ?>
                        <?= h(' / ') ?>
                        <?= h($parameter['estado']) ?>
                    </div>
                    <div class="form-group">
                        <span class="text-bold"><?= __('CEP: ') ?></span>
                        <?= h($parameter['cep']) ?>
                    </div>
                    <div class="form-group">
                        <span class="text-bold"><?= __('E-mail de Cobrança:') ?></span>
                        <?= h($parameter['email_cobranca']) ?>
                    </div>
                </div>
            </div>
            
            <div class="<?= $single ?>">
                <div class="row">
                    <div class="col-sm-offset-1 col-xs-9 scrolling" style="background-color: #d2d9e5; margin-bottom: 20px; font-size: 12px;">
                        <table class="table table-hover table-condensed text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th style="text-align: center"><?= __('Limitado') ?></th>
                                    <th style="text-align: center"><?= __('Pessoal') ?></th>
                                    <th style="text-align: center"><?= __('Simples') ?></th>
                                    <th style="text-align: center"><?= __('Completo') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th style="text-align: right"><?= __('Mensalidades') ?>*</th>
                                    <th style="background-color: white; text-align: center">0,00</th>
                                    <th style="background-color: white; text-align: center">39,90</th>
                                    <th style="background-color: white; text-align: center">69,90</th>
                                    <th style="background-color: white; text-align: center">119,90</th>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Taxa de Instalação') ?></th>
                                    <td style="background-color: white">-</td>
                                    <td style="background-color: white">-</td>
                                    <td style="background-color: white">-</td>
                                    <td style="background-color: white">-</td>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Controle Financeiro') ?></th>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Controle de Estoque') ?></th>
                                    <td style="background-color: white">-</td>
                                    <td style="background-color: white">-</td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Cadastros de Empresas/Perfis') ?></th>
                                    <td style="background-color: white">1</td>
                                    <td style="background-color: white">1</td>
                                    <td style="background-color: white">1</td>
                                    <td style="background-color: white"><?= __('Ilimitado') ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Contas de Usuários') ?></th>
                                    <td style="background-color: white">1</td>
                                    <td style="background-color: white">1</td>
                                    <td style="background-color: white">3</td>
                                    <td style="background-color: white"><?= __('Ilimitado') ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Relatórios') ?></th>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                    <td style="background-color: white"><?= __('Sim') ?></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right"><?= __('Ideal Para') ?></th>
                                    <td style="font-size: 9px; background-color: white"><?= __('Controle Pessoal - Com limitações') ?></td>
                                    <td style="font-size: 9px; background-color: white"><?= __('Controle Pessoal') ?></td>
                                    <td style="font-size: 9px; background-color: white"><?= __('MEI e Micro Empresas') ?></td>
                                    <td style="font-size: 9px; background-color: white"><?= __('Demais Empresas') ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <span style="font-size: 10px">*<?= __('Planos comercializados nas modalidades trimestral, semestral e anual.') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- É para encerrar o corpo do modal e poder iniciar o rodape do modal aqui -->

<div class="modal-footer">
    <?= $this->Form->button(__('Gravar'), ['type' => 'submit', 'class' => 'ajax_submit btn btn-primary scroll-modal', 'div' => false]) ?>
    <?= $this->Form->button(__('Cancelar'), ['type' => 'cancel', 'class' => 'btn btn-default', 'data-dismiss' => 'modal', 'div' => false]) ?>
    <?= $this->Form->end() ?>
</div>