<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
/* StockBalances */
/* File: src/Template/StockBalances/index.ctp */
?>

<div class="col-xs-12 container top-20">

    <div class="col-xs-12 panel" style="float: none;">
        <h3 class="page-header top-20"><?= __('Saldos de Estoque') ?>*</h3>
        <h5><small><?= __('(*) Saldo de produtos com quantidade acima de zero.') ?></small></h5>
        <?php
        if (isset($this->request->data['dtinicial']) && isset($this->request->data['dtfinal'])) {
            ?>
            <h4 class="text-bold"><?= __('FILTROS') ?></h4>
            <?php
            echo '<span class="text-bold">Período selecionado: </span>';
            echo $this->request->data['dtinicial'] . ' até ' . $this->request->data['dtfinal'] . '<br />';

            /******************************************************************/

            if (!empty($this->request->data['product_types_id'])) {

                //Identifica todos os tipos
                foreach ($balances as $balance):
                    $types[] = $balance->ProductTypes['title'];
                endforeach;

                if (!empty($types)) {

                    echo '<span class="text-bold">Tipos(s):</span> ';

                    //Exbibe apenas os registros distintos
                    foreach (array_unique($types) as $type):
                        $list_of_types[] = $type;
                    endforeach;

                    echo implode(", ", $list_of_types);

                }//if (!empty($types))

            }//if (!empty($this->request->data['product_types_id']))

            /******************************************************************/

            if (!empty($this->request->data['product_groups_id'])) {

                //Identifica todos os grupos
                foreach ($balances as $balance):
                    $groups[] = $balance->ProductGroups['title'];
                endforeach;

                if (!empty($groups)) {

                    echo '<span class="text-bold">Grupos(s):</span> ';

                    //Exbibe apenas os registros distintos
                    foreach (array_unique($groups) as $group):
                        $list_of_groups[] = $group;
                    endforeach;

                    echo implode(", ", $list_of_groups);

                }//if (!empty($groups))

            }//if (!empty($this->request->data['product_groups_id']))
            
        }//if (!empty($this->request->data['dtinicial']) && !empty($this->request->data['dtfinal']))
        ?>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#product_types_id').multiselect({
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
            $('#product_groups_id').multiselect({
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
                <?= $this->Form->control('dtinicial', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'dtinicial', 'autocomplete' => 'off', 'class' => 'form-control top-5 datepicker datemask', 'label' => false, 'placeholder' => 'Data Incial', 'value' => @$this->request->query['dtinicial']]) ?>
                <?= $this->Form->control('dtfinal', ['type' => 'text', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'dtfinal', 'autocomplete' => 'off', 'class' => 'form-control top-5 datepicker datemask', 'label' => false, 'placeholder' => 'Data Final', 'value' => @$this->request->query['dtfinal']]) ?>
                <?= $this->Form->control('product_types_id', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'product_types_id', 'class' => 'form-control top-5', 'label' => false, 'empty' => '- tipos -', 'options' => $productTypes, 'value' => @$this->request->query['product_types_id']]); ?>
                <?= $this->Form->control('product_groups_id', ['type' => 'select', 'templates' => ['inputContainer' => '{{content}}'], 'id' => 'product_groups_id', 'class' => 'form-control top-5', 'label' => false, 'empty' => '- grupos -', 'options' => $productGroups, 'value' => @$this->request->query['product_groups_id']]); ?>
                <?= $this->Form->button(__('Buscar'), ['type' => 'submit', 'class' => 'btn btn-primary fa fa-search top-5', 'data-loading-text' => __('Buscando...'), 'div' => false]) ?>
                <input type="hidden" name="iniciar_busca" value="true">
                <?= $this->Html->link(__(' Listar Todos'), ['action' => 'index'], ['class'=>'btn btn-default fa fa-list', 'id' => 'btn-resetar-form', 'style' => 'display:none;', 'escape' => false]); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <?= $this->Form->create('Balance'); ?>

    <div class="table-responsive">
        <table class="table no-margin table-striped dataTable no-footer"><!-- id="adjustable" -->
            <thead>
                <tr>
                    <th class="text-center col-xs-1"><?= __('Data') ?></th>
                    <th class="text-center col-xs-1"><?= __('Cód. Interno') ?></th>
                    <th><?= __('Descrição') ?></th>
                    <th class="text-center col-xs-1"><?= __('Unidade') ?></th>
                    <th class="text-center"><?= __('Tipos') ?></th>
                    <th class="text-center"><?= __('Grupos') ?></th>
                    <th class="text-center col-xs-1"><?= __('Estoque Min.') ?></th>
                    <th class="text-center col-xs-1"><?= __('Estoque Max.') ?></th>
                    <th class="text-center col-xs-1"><?= __('Estoque Atual') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($balances as $balance): ?>
                    <tr>
                        <td class="text-center"><?= date("d/m/Y", strtotime($balance->date)) ?></td>
                        <td class="text-right"><?= str_pad($balance->Products['code'], 6, '0', STR_PAD_LEFT) ?></td>
                        <td class="text-left">
                            <?= h($balance->Products['title']) ?>
                        </td>
                        <td class="text-center">
                            <?= h($balance->unity) ?>
                        </td>
                        <td class="text-left">
                            <?= $balance->ProductTypes['title'] ? h($balance->ProductTypes['title']) : '-' ?>
                        </td>
                        <td class="text-left">
                            <?= $balance->ProductGroups['title'] ? h($balance->ProductGroups['title']) : '-' ?>
                        </td>
                        <td class="text-left">
                            <?= $this->Number->precision($balance->Products['minimum'], 4) ?>
                        </td>
                        <td class="text-left">
                            <?= $this->Number->precision($balance->Products['maximum'], 4) ?>
                        </td>
                        <td class="text-right"><?= $this->Number->precision($balance->quantity, 4) ?></td>
                    </tr>
                        <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<?= $this->Form->end() ?>

    <?= $this->element('pagination') ?>
    
</div>