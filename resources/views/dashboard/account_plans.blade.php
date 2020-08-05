<div class="box panel panel-default box-shadow" style="padding:0;">
    <div class="panel-heading box-header" id="numero4">
        <span class="text-bold"><i class="fa fa-newspaper-o"></i> {{ __('Títulos por Plano de Contas') }}*</span>
        <h5><small>(*) {{ __('Vencimentos em ') }}<?= utf8_encode(strftime('%B de %Y', strtotime('today'))); ?></small></h5>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus-square-o"></i>
            </button>
        </div>
    </div>
    <div class="box-body panel-body table-responsive" style="max-height: 277px;">
        <?php 

        foreach ($AccountPlan as $index => $accountPlan):
            if (strlen($accountPlan->classification) == 2) {
                $classification[$index] = $accountPlan->classification;
                $title[$index] = $accountPlan->title;
            }//if (strlen($accountPlan->classification) == 2)
        endforeach;

        if (!empty($classification)) {

            foreach ($classification as $index => $value):

                $total[$index] = 0;
                foreach ($AccountPlan as $accountPlan):
                    $pos = strpos($accountPlan->classification, $value);
                    if ($accountPlan->valor > 0 && $pos === 0) {
                        $total[$index] += $accountPlan->valor;
                    }
                endforeach;

            endforeach;

            foreach ($classification as $index => $value): ?>
                <span class="text-bold"><?= mb_strtoupper($title[$index].' em aberto') }}</span>
                <span class="pull-right text-bold"><?= '  '.$this->Number->precision($total[$index], 2); ?></span>
                <table class="table no-margin font-12" style="margin-bottom: 0">
                    <tbody>
                        <?php 
                        foreach ($AccountPlan as $accountPlan):

                            $pos = strpos($accountPlan->classification, $value);
                            if ($accountPlan->valor > 0 && $pos === 0) { ?>
                                <tr>
                                    <td>
                                        <?= $accountPlan->classification.' - '.$accountPlan->title; ?>
                                    </td>
                                    <td class="text-right"> <?= $this->Number->precision($accountPlan->valor, 2); ?></td>
                                </tr>
                                <?php
                            }//if ($accountPlan->valor > 0 && $pos === 0)

                        endforeach; ?>
                    </tbody>
                </table>
                <?php
            endforeach;

        }//if (!empty($classification)) ?>
    </div>
</div>