<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/**/
?>

<!-- Banks -->
<!-- File: src/Template/Banks/add.ctp -->
<?php $this->layout = 'ajax'; ?>
<?= $this->Form->create('bank', ['type' => 'file', 'class' => 'ajax_add', 'data-url' => 'banks/addjson']) ?>

<?= $this->Html->css('bootstrap-multiselect') ?>
<?= $this->Html->script(['bootstrap-multiselect']) ?>

<?php
    $single = 'col-xs-12 bottom-10';
    $double = 'col-xs-12 col-sm-6 bottom-10';
    $label  = 'control-label text-nowrap';
    $input  = 'form-control';

    $options = ['654 - Banco A.J.Renner S.A.' => '654 - Banco A.J.Renner S.A.',
                '246 - Banco ABC Brasil S.A.' => '246 - Banco ABC Brasil S.A.',
                '121 - Banco Agiplan S.A.' => '121 - Banco Agiplan S.A.',
                '025 - Banco Alfa S.A.' => '025 - Banco Alfa S.A.',
                '641 - Banco Alvorada S.A.' => '641 - Banco Alvorada S.A.',
                '213 - Banco Arbi S.A.' => '213 - Banco Arbi S.A.',
                '024 - Banco BANDEPE S.A.' => '024 - Banco BANDEPE S.A.',
                '740 - Banco Barclays S.A.' => '740 - Banco Barclays S.A.',
                '107 - Banco BBM S.A.' => '107 - Banco BBM S.A.',
                '318 - Banco BMG S.A.' => '318 - Banco BMG S.A.',
                '752 - Banco BNP Paribas Brasil S.A.' => '752 - Banco BNP Paribas Brasil S.A.',
                '248 - Banco Boavista Interatlântico S.A.' => '248 - Banco Boavista Interatlântico S.A.',
                '218 - Banco Bonsucesso S.A.' => '218 - Banco Bonsucesso S.A.',
                '069 - Banco BPN Brasil S.A.' => '069 - Banco BPN Brasil S.A.',
                '036 - Banco Bradesco BBI S.A.' => '036 - Banco Bradesco BBI S.A.',
                '122 - Banco Bradesco BERJ S.A.' => '122 - Banco Bradesco BERJ S.A.',
                '204 - Banco Bradesco Cartões S.A.' => '204 - Banco Bradesco Cartões S.A.',
                '394 - Banco Bradesco Financiamentos S.A.' => '394 - Banco Bradesco Financiamentos S.A.',
                '237 - Banco Bradesco S.A.' => '237 - Banco Bradesco S.A.',
                '225 - Banco Brascan S.A.' => '225 - Banco Brascan S.A.',
                '208 - Banco BTG Pactual S.A.' => '208 - Banco BTG Pactual S.A.',
                '263 - Banco Cacique S.A.' => '263 - Banco Cacique S.A.',
                '412 - Banco Capital S.A.' => '412 - Banco Capital S.A.',
                '040 - Banco Cargill S.A.' => '040 - Banco Cargill S.A.',
                '266 - Banco Cédula S.A.' => '266 - Banco Cédula S.A.',
                '739 - Banco Cetelem S.A.' => '739 - Banco Cetelem S.A.',
                '233 - Banco Cifra S.A.' => '233 - Banco Cifra S.A.',
                '745 - Banco Citibank S.A.' => '745 - Banco Citibank S.A.',
                '241 - Banco Clássico S.A.' => '241 - Banco Clássico S.A.',
                '095 - Banco Confidence de Câmbio S.A.' => '095 - Banco Confidence de Câmbio S.A.',
                '756 - Banco Cooperativo do Brasil S.A. - BANCOOB' => '756 - Banco Cooperativo do Brasil S.A. - BANCOOB',
                '748 - Banco Cooperativo Sicredi S.A.' => '748 - Banco Cooperativo Sicredi S.A.',
                '075 - Banco CR2 S.A.' => '075 - Banco CR2 S.A.',
                '222 - Banco Credit Agricole Brasil S.A.' => '222 - Banco Credit Agricole Brasil S.A.',
                '505 - Banco Credit Suisse (Brasil) S.A.' => '505 - Banco Credit Suisse (Brasil) S.A.',
                '003 - Banco da Amazônia S.A.' => '003 - Banco da Amazônia S.A.',
                '083 - Banco da China Brasil S.A.' => '083 - Banco da China Brasil S.A.',
                '707 - Banco Daycoval S.A.' => '707 - Banco Daycoval S.A.',
                '300 - Banco de La Nacion Argentina' => '300 - Banco de La Nacion Argentina',
                '495 - Banco de La Provincia de Buenos Aires' => '495 - Banco de La Provincia de Buenos Aires',
                '494 - Banco de La Republica Oriental del Uruguay' => '494 - Banco de La Republica Oriental del Uruguay',
                '456 - Banco de Tokyo-Mitsubishi UFJ Brasil S.A.' => '456 - Banco de Tokyo-Mitsubishi UFJ Brasil S.A.',
                '001 - Banco do Brasil S.A.' => '001 - Banco do Brasil S.A.',
                '047 - Banco do Estado de Sergipe S.A.' => '047 - Banco do Estado de Sergipe S.A.',
                '037 - Banco do Estado do Pará S.A.' => '037 - Banco do Estado do Pará S.A.',
                '041 - Banco do Estado do Rio Grande do Sul S.A.' => '041 - Banco do Estado do Rio Grande do Sul S.A.',
                '004 - Banco do Nordeste do Brasil S.A.' => '004 - Banco do Nordeste do Brasil S.A.',
                '370 - Banco Europeu para a America Latina (BEAL) S.A.' => '370 - Banco Europeu para a America Latina (BEAL) S.A.',
                '265 - Banco Fator S.A.' => '265 - Banco Fator S.A.',
                '224 - Banco Fibra S.A.' => '224 - Banco Fibra S.A.',
                '626 - Banco Ficsa S.A.' => '626 - Banco Ficsa S.A.',
                '473 - Banco Financial Português S.A.' => '473 - Banco Financial Português S.A.',
                '094 - Banco Finaxis S.A.' => '094 - Banco Finaxis S.A.',
                '346 - Banco Francês e Brasileiro S.A.' => '346 - Banco Francês e Brasileiro S.A.',
                '612 - Banco Guanabara S.A.' => '612 - Banco Guanabara S.A.',
                '012 - Banco INBURSA de Investimentos S.A.' => '012 - Banco INBURSA de Investimentos S.A.',
                '258 - Banco Induscred S.A.' => '258 - Banco Induscred S.A.',
                '604 - Banco Industrial do Brasil S.A.' => '604 - Banco Industrial do Brasil S.A.',
                '653 - Banco Indusval S.A.' => '653 - Banco Indusval S.A.',
                '630 - Banco Intercap S.A.' => '630 - Banco Intercap S.A.',
                '249 - Banco Investcred S.A.' => '249 - Banco Investcred S.A.',
                '184 - Banco Itaú BBA S.A.' => '184 - Banco Itaú BBA S.A.',
                '029 - Banco Itaú BMG Consignado S.A.' => '029 - Banco Itaú BMG Consignado S.A.',
                '479 - Banco ItauBank S.A' => '479 - Banco ItauBank S.A',
                '376 - Banco J. P. Morgan S.A.' => '376 - Banco J. P. Morgan S.A.',
                '074 - Banco J. Safra S.A.' => '074 - Banco J. Safra S.A.',
                '217 - Banco John Deere S.A.' => '217 - Banco John Deere S.A.',
                '076 - Banco KDB S.A.' => '076 - Banco KDB S.A.',
                '757 - Banco KEB HANA do Brasil S.A.' => '757 - Banco KEB HANA do Brasil S.A.',
                '600 - Banco Luso Brasileiro S.A.' => '600 - Banco Luso Brasileiro S.A.',
                '243 - Banco Máxima S.A.' => '243 - Banco Máxima S.A.',
                '720 - Banco Maxinvest S.A.' => '720 - Banco Maxinvest S.A.',
                '389 - Banco Mercantil do Brasil S.A.' => '389 - Banco Mercantil do Brasil S.A.',
                '755 - Banco Merrill Lynch S.A.' => '755 - Banco Merrill Lynch S.A.',
                '746 - Banco Modal S.A.' => '746 - Banco Modal S.A.',
                '066 - Banco Morgan Stanley S.A.' => '066 - Banco Morgan Stanley S.A.',
                '007 - Banco Nacional de Desenvolvimento Econômico e Social' => '007 - Banco Nacional de Desenvolvimento Econômico e Social',
                '079 - Banco Original do Agronegócio S.A.' => '079 - Banco Original do Agronegócio S.A.',
                '212 - Banco Original S.A.' => '212 - Banco Original S.A.',
                '712 - Banco Ourinvest S.A.' => '712 - Banco Ourinvest S.A.',
                '623 - Banco PAN S.A.' => '623 - Banco PAN S.A.',
                '065 - Banco Patagon S.A.' => '065 - Banco Patagon S.A.',
                '611 - Banco Paulista S.A.' => '611 - Banco Paulista S.A.',
                '613 - Banco Pecúnia S.A.' => '613 - Banco Pecúnia S.A.',
                '643 - Banco Pine S.A.' => '643 - Banco Pine S.A.',
                '658 - Banco Porto Real S.A.' => '658 - Banco Porto Real S.A.',
                '747 - Banco Rabobank International Brasil S.A.' => '747 - Banco Rabobank International Brasil S.A.',
                '088 - Banco Randon S.A.' => '088 - Banco Randon S.A.',
                '633 - Banco Rendimento S.A.' => '633 - Banco Rendimento S.A.',
                '120 - Banco Rodobens S.A.' => '120 - Banco Rodobens S.A.',
                '422 - Banco Safra S.A.' => '422 - Banco Safra S.A.',
                '033 - Banco Santander (Brasil) S.A.' => '033 - Banco Santander (Brasil) S.A.',
                '743 - Banco Semear S.A.' => '743 - Banco Semear S.A.',
                '211 - Banco Sistema S.A.' => '211 - Banco Sistema S.A.',
                '637 - Banco Sofisa S.A.' => '637 - Banco Sofisa S.A.',
                '464 - Banco Sumitomo Mitsui Brasileiro S.A.' => '464 - Banco Sumitomo Mitsui Brasileiro S.A.',
                '737 - Banco Theca S.A.' => '737 - Banco Theca S.A.',
                '082 - Banco Topázio S.A.' => '082 - Banco Topázio S.A.',
                '634 - Banco Triângulo S.A.' => '634 - Banco Triângulo S.A.',
                '018 - Banco Tricury S.A.' => '018 - Banco Tricury S.A.',
                '496 - Banco Uno - E Brasil S.A.' => '496 - Banco Uno - E Brasil S.A.',
                '655 - Banco Votorantim S.A.' => '655 - Banco Votorantim S.A.',
                '610 - Banco VR S.A.' => '610 - Banco VR S.A.',
                '119 - Banco Western Union do Brasil S.A.' => '119 - Banco Western Union do Brasil S.A.',
                '124 - Banco Woori Bank do Brasil S.A.' => '124 - Banco Woori Bank do Brasil S.A.',
                '021 - BANESTES S.A. Banco do Estado do Espírito Santo' => '021 - BANESTES S.A. Banco do Estado do Espírito Santo',
                '719 - Banif-Banco Internacional do Funchal (Brasil)S.A.' => '719 - Banif-Banco Internacional do Funchal (Brasil)S.A.',
                '081 - BBN Banco Brasileiro de Negócios S.A.' => '081 - BBN Banco Brasileiro de Negócios S.A.',
                '250 - BCV - Banco de Crédito e Varejo S.A.' => '250 - BCV - Banco de Crédito e Varejo S.A.',
                '017 - BNY Mellon Banco S.A.' => '017 - BNY Mellon Banco S.A.',
                '070 - BRB - Banco de Brasília S.A.' => '070 - BRB - Banco de Brasília S.A.',
                '104 - Caixa Econômica Federal' => '104 - Caixa Econômica Federal',
                '320 - China Construction Bank (Brasil) Banco Múltiplo S.A.' => '320 - China Construction Bank (Brasil) Banco Múltiplo S.A.',
                '477 - Citibank N.A.' => '477 - Citibank N.A.',
                '487 - Deutsche Bank S.A. - Banco Alemão' => '487 - Deutsche Bank S.A. - Banco Alemão',
                '140 - Easynvest - Título CV S.A.' => '140 - Easynvest - Título CV S.A.',
                '725 - Finansinos S.A. - Crédito, Financ. e Investimento' => '725 - Finansinos S.A. - Crédito, Financ. e Investimento',
                '064 - Goldman Sachs do Brasil Banco Múltiplo S.A.' => '064 - Goldman Sachs do Brasil Banco Múltiplo S.A.',
                '078 - Haitong Banco de Investimento do Brasil S.A.' => '078 - Haitong Banco de Investimento do Brasil S.A.',
                '062 - Hipercard Banco Múltiplo S.A.' => '062 - Hipercard Banco Múltiplo S.A.',
                '399 - HSBC Bank Brasil S.A. - Banco Múltiplo' => '399 - HSBC Bank Brasil S.A. - Banco Múltiplo',
                '063 - Ibibank S.A. - Banco Múltiplo' => '063 - Ibibank S.A. - Banco Múltiplo',
                '132 - ICBC do Brasil Banco Múltiplo S.A.' => '132 - ICBC do Brasil Banco Múltiplo S.A.',
                '492 - ING Bank N.V.' => '492 - ING Bank N.V.',
                '341 - Itaú Unibanco S.A.' => '341 - Itaú Unibanco S.A.',
                '488 - JPMorgan Chase Bank, National Association' => '488 - JPMorgan Chase Bank, National Association',
                '014 - Natixis Brasil S.A. Banco Múltiplo' => '014 - Natixis Brasil S.A. Banco Múltiplo',
                '753 - Novo Banco Continental S.A. - Banco Múltiplo' => '753 - Novo Banco Continental S.A. - Banco Múltiplo',
                '260 - Nu Pagamentos S.A.' => '260 - Nu Pagamentos S.A.',
                '254 - Paraná Banco S.A.' => '254 - Paraná Banco S.A.',
                '751 - Scotiabank Brasil S.A. Banco Múltiplo' => '751 - Scotiabank Brasil S.A. Banco Múltiplo',
                '129 - UBS Brasil Banco de Investimento S.A.' => '129 - UBS Brasil Banco de Investimento S.A.'
               ];
?>

    <div class="container-fluid">
        <div class="row">
            <div class="<?= $single ?> well">
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>">
                            <?= __('Título') ?>
                            <i class="fa fa-info-circle" data-toggle="tooltip" title="<?= __('Insira o título para identificação do registro.') ?>"></i>
                        </label>
                        <?= $this->Form->control('title', ['label' => false, 'type' => 'text', 'class' => $input. ' focus', 'maxlength' => '100', 'required' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Tipo de Conta') ?></label>
                        <?= $this->Form->control('tipoconta', ['label'   => false, 
                                                               'class'   => $input, 
                                                               'type'    => 'select', 
                                                               'options' => ['C' => __('Corrente'), 
                                                                             'P' => __('Poupança'), 
                                                                             'A' => __('Aplicação'), 
                                                                             'S' => __('Salário')
                                                                            ]
                                                              ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <label class="<?= $label ?>"><?= __('Emite Cheque') ?></label>
                        <?= $this->Form->control('emitecheque', ['label' => false, 
                                                                 'class' => $input, 
                                                                 'type'  => 'select', 
                                                                 'options' => ['S' => __('Sim'), 'N' => __('Não')]
                                                                ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $single ?>">
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('#banco').multiselect({
                                    enableFiltering: true,
                                    enableClickableOptGroups: true,
                                    enableCaseInsensitiveFiltering: true,
                                    inheritClass: true,
                                    buttonContainer: '<div />',
                                    maxHeight: 300,
                                    maxWidth: 317,
                                    dropUp: false
                                });
                            });
                        </script>
                        <label class="<?= $label ?>"><?= __('Banco') ?></label>
                        <?= $this->Form->control('banco', ['class' => $input,
                                                           'id'    => __('Banco'),
                                                           'type'  => 'select',
                                                           'empty' => __('Selecione uma opção'),
                                                           'label' => false, 
                                                           'title' => __('Bancos'),
                                                           'options' => $options
                                                          ]
                                                 ) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('Agência') ?></label>
                        <?= $this->Form->control('agencia', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '20', 'required' => true]) ?>
                    </div>
                    <div class="<?= $double ?>">
                        <label class="<?= $label ?>"><?= __('Conta') ?></label>
                        <?= $this->Form->control('conta', ['label' => false, 'type' => 'text', 'class' => $input, 'maxlength' => '20', 'required' => true]) ?>
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