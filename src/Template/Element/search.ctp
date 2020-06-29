<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* File: src/Template/Element/search.ctp */

if ($this->request->url == '') { //providers ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('provider', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''         => 'Nenhum',
                                                                          'title'    => 'Nome/Razão Social',
                                                                          'fantasia' => 'Nome Fantasia',
                                                                          'cpf'      => 'CPF',
                                                                          'cnpj'     => 'CNPJ',
                                                                          'inativo'  => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //customers ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('customer', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''         => 'Nenhum',
                                                                          'title'    => 'Nome/Razão Social',
                                                                          'fantasia' => 'Nome Fantasia',
                                                                          'cpf'      => 'CPF',
                                                                          'cnpj'     => 'CNPJ',
                                                                          'inativo'  => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //transporters ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('transporter', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''         => 'Nenhum',
                                                                          'title'    => 'Nome/Razão Social',
                                                                          'fantasia' => 'Nome Fantasia',
                                                                          'cpf'      => 'CPF',
                                                                          'cnpj'     => 'CNPJ',
                                                                          'inativo'  => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //banks ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('bank', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''            => 'Nenhum',
                                                                          'title'       => 'Descrição',
                                                                          'agencia'     => 'Agência',
                                                                          'conta'       => 'Conta',
                                                                          'numbanco'    => 'Nº do Banco',
                                                                          'emitecheque' => 'Emite Cheque',
                                                                          'inativo'     => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //boxes ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('box', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''        => 'Nenhum',
                                                                          'title'   => 'Descrição',
                                                                          'inativo' => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php }
/******************************************************************************/
if ($this->request->url == '') { //cards ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('card', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''         => 'Nenhum',
                                                                          'title'    => 'Descrição',
                                                                          'bandeira' => 'Bandeira',
                                                                          'inativo'  => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //account-plans ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('accountPlan', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''        => 'Nenhum',
                                                                          'title'   => 'Conta',
                                                                          'inativo' => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //costs ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('cost', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''        => 'Nenhum',
                                                                          'title'   => 'Descrição',
                                                                          'inativo' => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //document-types ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('documentType', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''        => 'Nenhum',
                                                                          'title'   => 'Descrição',
                                                                          'inativo' => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //event-types ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('eventType', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''        => 'Nenhum',
                                                                          'title'   => 'Descrição',
                                                                          'inativo' => 'Inativos e Automáticos'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //moviments ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('moviment', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''           => 'Nenhum',
                                                                          'ordem'      => 'Nº de Ordem',
                                                                          'documento'  => 'Documento',
                                                                          'cpf'        => 'CPF',
                                                                          'cnpj'       => 'CNPJ',
                                                                          'custprov'   => 'Cliente/Fornecedor',
                                                                          'data'       => 'Data de Lançamento',
                                                                          'vencimento' => 'Data de Vencimento',
                                                                          'dtbaixa'    => 'Data de Pagamento',
                                                                          'valor'      => 'Valor do Título',
                                                                          'valorbaixa' => 'Valor do Pagamento',
                                                                          'cheque'     => 'Nº do Cheque',
                                                                          'historico'  => __('Histórico')
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //moviment-boxes ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('movimentBox', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''           => 'Nenhum',
                                                                          'ordem'      => 'Nº de Ordem',
                                                                          'documento'  => 'Documento',
                                                                          'boxes'      => __('Caixa'),
                                                                          'cheque'     => 'Nº do Cheque',
                                                                          'dtbaixa'    => 'Data de Pagamento',
                                                                          'valorbaixa' => 'Valor do Pagamento',
                                                                          'historico'  => __('Histórico')
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //moviment-banks ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('movimentBank', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''           => 'Nenhum',
                                                                          'ordem'      => 'Nº de Ordem',
                                                                          'documento'  => 'Documento',
                                                                          'banks'      => __('Banco'),
                                                                          'cheque'     => 'Nº do Cheque',
                                                                          'dtbaixa'    => 'Data de Pagamento',
                                                                          'valorbaixa' => 'Valor do Pagamento',
                                                                          'historico'  => __('Histórico')
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //moviment-checks ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('movimentCheck', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''          => 'Nenhum',
                                                                          'ordem'     => 'Nº de Ordem',
                                                                          'documento' => 'Documento',
                                                                          'banks'     => __('Banco'),
                                                                          'boxes'     => __('Caixa'),
                                                                          'providers' => 'Fornecedor',
                                                                          'cheque'    => 'Nº do Cheque',
                                                                          'nominal'   => 'Nominal',
                                                                          'data'      => 'Data do Cheque',
                                                                          'valor'     => 'Valor do Cheque',
                                                                          'historico' => __('Histórico')
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //moviment-cards ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('movimentCard', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''           => 'Nenhum',
                                                                          'ordem'      => 'Nº de Ordem',
                                                                          'documento'  => 'Documento',
                                                                          'title'      => 'Descrição',
                                                                          'cards'      => 'Cartão',
                                                                          'data'       => 'Data de Lançamento',
                                                                          'vencimento' => 'Data de Vencimento',
                                                                          'dtbaixa'    => 'Data de Pagamento',
                                                                          'valorbaixa' => 'Valor do Pagamento'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //transfers ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('transfer', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''          => 'Nenhum',
                                                                          'ordem'     => 'Nº de Ordem',
                                                                          'documento' => 'Documento',
                                                                          'banks'     => __('Banco'),
                                                                          'boxes'     => __('Caixa'),
                                                                          'data'      => 'Data de Lançamento',
                                                                          'valor'     => 'Valor da Operação',
                                                                          'historico' => __('Histórico')
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //plannings ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('planning', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''          => 'Nenhum',
                                                                          'descricao' => 'Descrição',
                                                                          'data'      => 'Data de Lançamento',
                                                                          'valor'     => 'Valor Total',
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //regs ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('reg', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''         => 'Nenhum',
                                                                          'data'     => 'Data de Cadastro',
                                                                          'log_type' => 'Tipo de LOG',
                                                                          'reftable' => 'Tabela',
                                                                          'username' => 'Usuário'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //users-parameters ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -5px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('usersParameter', ['type' => 'get', 'style' => 'margin-bottom: 9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''          => 'Nenhum',
                                                                          'user'      => 'Usuário',
                                                                          'parameter' => 'Empresa'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } 
/******************************************************************************/
if ($this->request->url == '') { //payments ?>
    <div class="panel panel-body box" style="margin-left: -10px; margin-top: -12px; padding-bottom: 0px; padding-top: 5px; width: 190px;">
        <?= $this->Form->create('payment', ['type' => 'get', 'style' => 'margin-bottom:9px']) ?>
        <div class="panel-heading" role="tab" id="headingFilter" style="text-align: left; font-size: 11px;">
            <?= $this->Html->link(__(' Selecione os Filtros'), '#collapseFilter', ['class' => 'btn collapsed fa fa-filter', 'role' => 'button', 'data-toggle' => 'collapse', 'data-parent' => '#accordion', 'href' => '#collapseFilter', 'aria-expanded' => false, 'aria-controls' => 'collapseFilter', 'escape' => false]) ?>
        </div>
        <div id="collapseFilter" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFilter">
            <div class="btn-link" style="text-align: left; font-size: 11px;">
                <?php if (isset($_GET['radio_search'])) { $default = $_GET['radio_search'];} else {$default = '';} ?>
                <?= $this->Form->control('radio_search', ['label'     => false,
                                                          'type'      => 'radio',
                                                          'style'     => 'margin-top: 1px',
                                                          'default'   => $default,
                                                          'templates' => ['radioWrapper' => '{{label}}<br />'],
                                                          'options'   => [''        => 'Nenhum',
                                                                          'data'    => 'Data de Vencimento',
                                                                          'razao'   => 'Empresa',
                                                                          'periodo' => 'Período de Ativação',
                                                                          'valor'   => 'Valor da Fatura'
                                                                         ]
                                                         ]) ?>
            </div>
        </div>
        <div style="margin-top: -27px;">
            <span class="fa fa-search" style="top: 30px; left: 140px; color: gray; position: relative; top: 27px;"></span>
            <?= $this->Form->control('keywords', ['label'       => false, 
                                                  'div'         => false, 
                                                  'value'       => @$_GET['keywords'], 
                                                  'placeholder' => 'Pesquisar', 
                                                  'class'       => 'form-control width-175', 
                                                  'style'       => 'margin-left: -10px;'
                                                 ]) ?>
            <?= $this->Form->control('search', ['label' => false, 'class' => 'hidden', 'value' => true]) ?>
            <?= $this->Form->button('Pesquisar', ['label' => false, 'type'  => 'submit', 'class' => 'hidden']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php } ?>