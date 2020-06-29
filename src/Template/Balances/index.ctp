<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
/* Balances */
/* File: src/Template/Balances/index.ctp */
?>

<div class="col-xs-12 col-md-12 col-sm-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <h3 class="page-header top-20"><?= __('Saldos Financeiros') ?></h3>
        <?php
        if (isset($this->request->data['dtinicial']) && isset($this->request->data['dtfinal'])) {
            ?>
            <h4 class="text-bold"><?= __('FILTROS') ?></h4>
            <span class="text-bold"><?= __('Período selecionado: ') ?></span>
            <?= $this->request->data['dtinicial'] ?><?= __(' até ') ?><?= $this->request->data['dtfinal'] ?><br />
            <?php
            /******************************************************************/

            if (!empty($this->request->data['banks_id'])) {

                //Identifica todos os bancos
                foreach ($balances as $balance):
                    $banks[] = $balance->Banks['title'];
                endforeach;

                if (!empty($banks)) {

                    echo '<span class="text-bold">Banco(s):</span> ';

                    //Exbibe apenas os registros distintos
                    foreach (array_unique($banks) as $bank):
                        $list_of_banks[] = $bank;
                    endforeach;

                    echo implode(", ", $list_of_banks);

                }//if (!empty($banks))

            }//if (!empty($this->request->data['banks_id']))

            /******************************************************************/

            if (!empty($this->request->data['boxes_id'])) {

                //Identifica todos os caixas
                foreach ($balances as $balance):
                    $boxes[] = $balance->Boxes['title'];
                endforeach;

                if (!empty($boxes)) {

                    echo '<span class="text-bold">Caixa(s):</span> ';

                    //Exbibe apenas os registros distintos
                    foreach (array_unique($boxes) as $box):
                        $list_of_boxes[] = $box;
                    endforeach;

                    echo implode(", ", $list_of_boxes);

                }//if (!empty($boxes))

            }//if (!empty($this->request->data['boxes_id']))

            /******************************************************************/

            if (!empty($this->request->data['cards_id'])) {

                //Identifica todos os cartões
                foreach ($balances as $balance):
                    $cards[] = $balance->Cards['title'];
                endforeach;

                if (!empty($cards)) {

                    echo '<span class="text-bold">Cartão(ões)</span> ';

                    //Exbibe apenas os registros distintos
                    foreach (array_unique($cards) as $card):
                        $list_of_cards[] = $card;
                    endforeach;

                    echo implode(", ", $list_of_cards);

                }//if (!empty($cards)) 

            }//if (!empty($this->request->data['cards_id']))
            
        }//if (!empty($this->request->data['dtinicial']) && !empty($this->request->data['dtfinal']))
        ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#banks_id').multiselect({
                enableFiltering: true,
                enableClickableOptGroups: true,
                enableCaseInsensitiveFiltering: true,
                inheritClass: true,
                buttonContainer: '<div />',
                maxHeight: 300,
                maxWidth: 317,
                dropUp: false,
                includeSelectAllOption: true,
                selectAllText: 'Selecionar Todos',
                allSelectedText: 'Todos Selecionados',
                nonSelectedText: 'Selecione uma opção',
                nSelectedText: 'selecionados',
            });
            $('#boxes_id').multiselect({
                enableFiltering: true,
                enableClickableOptGroups: true,
                enableCaseInsensitiveFiltering: true,
                inheritClass: true,
                buttonContainer: '<div />',
                maxHeight: 300,
                maxWidth: 317,
                dropUp: false,
                includeSelectAllOption: true,
                selectAllText: 'Selecionar Todos',
                allSelectedText: 'Todos Selecionados',
                nonSelectedText: 'Selecione uma opção',
                nSelectedText: 'selecionados',
            });
            $('#cards_id').multiselect({
                enableFiltering: true,
                enableClickableOptGroups: true,
                enableCaseInsensitiveFiltering: true,
                inheritClass: true,
                buttonContainer: '<div />',
                maxHeight: 300,
                maxWidth: 317,
                dropUp: false,
                includeSelectAllOption: true,
                selectAllText: 'Selecionar Todos',
                allSelectedText: 'Todos Selecionados',
                nonSelectedText: 'Selecione uma opção',
                nSelectedText: 'selecionados',
            });
            $('#planning_id').multiselect({
                enableFiltering: true,
                enableClickableOptGroups: true,
                enableCaseInsensitiveFiltering: true,
                inheritClass: true,
                buttonContainer: '<div />',
                maxHeight: 300,
                maxWidth: 317,
                dropUp: false,
                includeSelectAllOption: true,
                selectAllText: 'Selecionar Todos',
                allSelectedText: 'Todos Selecionados',
                nonSelectedText: 'Selecione uma opção',
                nSelectedText: 'selecionados',
            });
        });
    </script>

    <div class="row form-busca bottom-10">
        <div class="col-xs-12 box box-body">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
                <?= $this->Form->control('dtinicial', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'dtinicial', 'autocomplete' => 'off', 'class' => 'form-control datepicker datemask', 'label' => false, 'placeholder' => 'Data Incial', 'value' => @$this->request->query['dtinicial']]) ?>
                <?= $this->Form->control('dtfinal', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'dtfinal', 'autocomplete' => 'off', 'class' => 'form-control datepicker datemask', 'label' => false, 'placeholder' => 'Data Final', 'value' => @$this->request->query['dtfinal']]) ?>
                <?= $this->Form->control('banks_id', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'banks_id', 'class' => 'form-control', 'label' => false, 'empty' => '- banco -', 'options' => $banks, 'value' => @$this->request->query['banks_id']]); ?>
                <?= $this->Form->control('boxes_id', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'boxes_id', 'class' => 'form-control', 'label' => false, 'empty' => '- caixa -', 'options' => $boxes, 'value' => @$this->request->query['boxes_id']]); ?>
                <?= $this->Form->control('cards_id', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'cards_id', 'class' => 'form-control', 'label' => false, 'empty' => '- cartão -', 'options' => $cards, 'value' => @$this->request->query['cards_id']]); ?>
                <?= $this->Form->control('plannings_id', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'plannings_id', 'class' => 'form-control', 'label' => false, 'empty' => '- planejamento -', 'options' => $plannings, 'value' => @$this->request->query['plannings_id']]); ?>
                <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                <input type="hidden" name="iniciar_busca" value="true">
                <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <?= $this->Form->create('Balance'); ?>

    <div class="col-xs-12 panel" style="float: none;">
        <div class="bottom-20"><?= $this->Form->button(' Excluir Selecionados', ['type' => 'submit', 'class' => 'btn btn-primary top-20 right-10 fa fa-trash-o', 'div' => false]) ?></div>
    </div>

    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-center hidden-print col-xs-1"><?= h('#') ?></th>
                    <th class="text-center"><?= __('Empresa') ?></th>
                    <th class="text-center col-xs-1"><?= __('Data') ?></th>
                    <th class="col-xs-1"><?= __('Origem') ?></th>
                    <th><?= __('Descrição') ?></th>
                    <th class="text-center col-xs-1"><?= __('Valor') ?></th>
                    <th class="text-center col-xs-1 hidden-print"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($balances as $balance): ?>
                    <tr>
                        <td class="text-center hidden-print">
                        <?=
                        $this->Form->control('record[' . $balance->id . ']', ['type' => 'checkbox',
                            'id' => 'listRecord_' . $balance->id,
                            'multiple' => true,
                            'label' => false,
                            'templates' => ['inputContainer' => '{{content}}'],
                            'hiddenField' => false,
                            'class' => 'btn btn-actions',
                            'value' => $balance->id
                        ])
                        ?>
                        </td>
                        <td class="text-left"><?= ($balance->Parameters['razao']) ?></td>
                        <td class="text-center"><?= date("d/m/Y", strtotime($balance->date)) ?></td>
                        <td class="text-left">
                            <?php
                            if ($balance->banks_id)
                                echo __('Banco');
                            if ($balance->boxes_id)
                                echo __('Caixa');
                            if ($balance->cards_id)
                                echo __('Cartão');
                            if ($balance->plannings_id)
                                echo __('Planejamento');
                            ?>
                        </td>
                        <td class="text-left">
                            <?= h($balance->Banks['title']) ?>
                            <?= h($balance->Boxes['title']) ?>
                            <?= h($balance->Cards['title']) ?>
                            <?= h($balance->Plannings['title']) ?>
                        </td>
                        <td class="text-right"><?= $this->Number->precision($balance->value, 2) ?></td>
                        <td class="text-center hidden-print">
                        <?= $this->Form->postLink('', ['action' => 'delete', $balance->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'escape' => false]) ?>
                        </td>
                    </tr>
                    <?php 
                endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="col-xs-12 panel" style="float: none;">
        <div class="bottom-20"><?= $this->Form->button(__(' Excluir Selecionados'), ['type' => 'submit', 'class' => 'btn btn-primary top-20 right-10 fa fa-trash-o', 'div' => false]) ?></div>
    </div>

<?= $this->Form->end() ?>

    <?= $this->element('pagination') ?>
    
</div>

<div class="col-xs-12">
    <hr>
</div>

<div class="col-xs-12 col-md-10 col-md-offset-2 col-sm-9 col-sm-offset-3 container">
    <div class="col-xs-12 panel" style="float: none;">
        <h3 class="page-header top-20"><?= __('Todos os Últimos Saldos') ?></h3>
    </div>
    <div class="well">
        <table class="table table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-center col-xs-1"><?= __('Empresa') ?></th>
                    <th class="text-center col-xs-1"><?= __('Data') ?></th>
                    <th class="text-left col-xs-1"><?= __('Origem') ?></th>
                    <th><?= __('Descrição') ?></th>
                    <th class="text-center col-xs-1"><?= __('Valor') ?></th>
                    <th class="text-center col-xs-1 hidden-print"><?= __('Ações') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($balances_today as $today): ?>
                    <tr>
                        <td class="text-left"><?= ($today['Parameters']['razao']) ?></td>
                        <td class="text-center">
                            <?php 
                            if ($today->date < date('Y-m-d')) {
                                echo '<span style="color: #ce8483">';
                            } else {
                                echo '<span>';
                            } ?>
                            <?= date("d/m/Y", strtotime($today->date)) ?></span></td>
                        <td class="text-left">
                            <?php
                            if ($today->banks_id)
                                echo __('Banco');
                            if ($today->boxes_id)
                                echo __('Caixa');
                            if ($today->cards_id)
                                echo __('Cartão');
                            if ($today->plannings_id)
                                echo __('Planejamento');
                            ?>
                        </td>
                        <td class="text-left">
                            <?= h($today->Banks['title']) ?>
                            <?= h($today->Boxes['title']) ?>
                            <?= h($today->Cards['title']) ?>
                            <?= h($today->Plannings['title']) ?>
                        </td>
                        <td class="text-right"><?= $this->Number->precision($today->value, 2) ?></td>
                        <td class="text-center hidden-print">
                            <?= $this->Form->postLink('', ['action' => 'delete', $today->id], ['confirm' => __('Você tem certeza que deseja EXCLUIR o registro?'), 'class' => 'btn btn-actions fa fa-trash-o', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>