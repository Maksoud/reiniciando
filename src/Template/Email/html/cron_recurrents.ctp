<?php
/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */
?>

<?= $this->element('mail-header'); ?>

<body style="background-color:#E1E1E1;" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">

    <!-- CENTER THE EMAIL // -->
    <center style="background-color:#E1E1E1;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="max-width:100% !important;width: 100% !important;min-width: 100% !important;">
            <tr>
                <td align="center" valign="top" id="bodyCell">

                    <!-- EMAIL HEADER // -->
                    <table style="background-color:#E1E1E1;" border="0" cellpadding="0" cellspacing="0" width="500" id="emailHeader">

                        <!-- HEADER ROW // -->
                        <tr>
                            <td align="center" valign="top">
                                <!-- CENTERING TABLE // -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" valign="top">
                                            <!-- FLEXIBLE CONTAINER // -->
                                            <table border="0" cellpadding="10" cellspacing="0" width="500" class="flexibleContainer">
                                                <tr>
                                                    <td valign="top" width="500" class="flexibleContainerCell">

                                                        <!-- CONTENT TABLE // -->
                                                        <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td align="right" valign="middle" class="flexibleContainerBox">
                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:100%;">
                                                                        <tr>
                                                                            <td align="left" class="textContent">
                                                                                <!-- CONTENT // -->
                                                                                <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
                                                                                    Mensagem automática através do Sistema Financeiro Reiniciando.com.br.
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // FLEXIBLE CONTAINER -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CENTERING TABLE -->
                            </td>
                        </tr>
                        <!-- // END -->

                    </table>
                    <!-- // END -->

                    <!-- EMAIL BODY // -->
                    <table style="background-color:#FFFFFF;" border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody">

                        <!-- MODULE ROW // -->
                        <tr>
                            <td align="center" valign="top">
                                <!-- CENTERING TABLE // -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="color:#FFFFFF;background-color:#3498db;">
                                    <tr>
                                        <td align="center" valign="top">
                                            <!-- FLEXIBLE CONTAINER // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                <tr>
                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">

                                                        <!-- CONTENT TABLE // -->
                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td align="center" valign="top" class="textContent">
                                                                    <h3 style="color:#FFFFFF;line-height:100%;font-family:Helvetica,Arial,sans-serif;font-size:35px;font-weight:normal;margin-bottom:5px;text-align:center;">
                                                                        Lançamentos Recorrentes <br/>
                                                                        <?= date('d/m/Y'); ?>
                                                                    </h3>
                                                                    <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;">
                                                                        Contas a Pagar e Receber dos Clientes Ativos
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- // CONTENT TABLE -->

                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // FLEXIBLE CONTAINER -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CENTERING TABLE -->
                            </td>
                        </tr>
                        <!-- // MODULE ROW -->
                        
                        <?php 
                        foreach ($recurrent_return AS $perfil => $tipos): ?>
                            
                            <?php
                            foreach ($tipos AS $tipo => $value): //MOVIMENTOS RECORRENTES OU MOVIMENTOS DE CARTÕES RECORRENTES ?>

                                <!-- MODULE ROW // -->
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- CENTERING TABLE // -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F8F8F8;">
                                            <tr>
                                                <td align="center" valign="top">
                                                    <!-- FLEXIBLE CONTAINER // -->
                                                    <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                        <tr>
                                                            <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                    <tr>
                                                                        <td align="center" valign="top">

                                                                            <!-- CONTENT TABLE // -->
                                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                <tr>
                                                                                    <td valign="top" class="textContent">
                                                                                        <span style="color:#5F5F5F;line-height:160%;font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:bolder;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                            <?= $tipo ?>, de <?= $perfil ?>
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                            <!-- // CONTENT TABLE -->

                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- // FLEXIBLE CONTAINER -->
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- // CENTERING TABLE -->
                                    </td>
                                </tr>
                                <!-- // MODULE ROW -->

                                <?php
                                $count = 1;
                                foreach ($value AS $dados): //DADOS DOS MOVIMENTOS ?>
                                
                                    <!-- MODULE ROW // -->
                                    <tr>
                                        <td align="center" valign="top">
                                            <!-- CENTERING TABLE // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#F8F8F8;">
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <!-- FLEXIBLE CONTAINER // -->
                                                        <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                            <tr>
                                                                <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                    <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="center" valign="top">

                                                                                <!-- CONTENT TABLE // -->
                                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-family:Helvetica,Arial,sans-serif;font-size:16px;font-weight:bolder;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Registro #<?= $count++; ?>
                                                                                            </span>
                                                                                            <br>
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:bolder;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Ordem <?= $dados->ordem; ?>
                                                                                            </span>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                                <!-- // CONTENT TABLE -->

                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- // FLEXIBLE CONTAINER -->
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CENTERING TABLE -->
                                        </td>
                                    </tr>
                                    <!-- // MODULE ROW -->

                                    <!-- MODULE ROW // -->
                                    <tr>
                                        <td align="center" valign="top">
                                            <!-- CENTERING TABLE // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <!-- FLEXIBLE CONTAINER // -->
                                                        <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                            <tr>
                                                                <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                                    <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="center" valign="top">
                                                                                <!-- CONTENT TABLE // -->
                                                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                                    <?php if (!empty($dados->documento)) { ?>
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-weight:bolder;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Documento
                                                                                            </span>
                                                                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
                                                                                                <?= $dados->documento ?>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php }//if (!empty($dados->documento)) ?>
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-weight:bolder;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Descrição
                                                                                            </span>
                                                                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
                                                                                                <?= $dados->historico ? $dados->historico : $dados->title; ?>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php if (!empty($dados->customers_id) || !empty($dados->providers_id)) { ?>
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-weight:bolder;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Nome do Cliente/Fornecedor
                                                                                            </span>
                                                                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
                                                                                                <?= $dados->customers_id ? $dados->Customers['title'] : $dados->Providers['title']; ?>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php }//if (!empty($dados->customers_id) || !empty($dados->providers_id)) ?>
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-weight:bolder;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Vencimento do Documento
                                                                                            </span>
                                                                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
                                                                                                <?= date("d/m/Y", strtotime($dados->vencimento)) ?>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-weight:bolder;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Valor do Documento
                                                                                            </span>
                                                                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
                                                                                                R$ <?= $this->Number->precision($dados->valor, 2) ?> (<?= $dados->creditodebito == 'C' ? __('Receita') : __('Despesa') ?>)
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php if (!empty($dados->obs)) { ?>
                                                                                    <tr>
                                                                                        <td valign="top" class="textContent">
                                                                                            <span style="color:#5F5F5F;line-height:160%;font-weight:bolder;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                                Observações Gerais
                                                                                            </span>
                                                                                            <div style="text-align:left;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;margin-top:3px;color:#5F5F5F;line-height:135%;">
                                                                                                <?= $dados->obs ?>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php }//if (!empty($dados->obs)) ?>
                                                                                </table>
                                                                                <!-- // CONTENT TABLE -->

                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- // FLEXIBLE CONTAINER -->
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // CENTERING TABLE -->
                                        </td>
                                    </tr>
                                    <!-- // MODULE ROW -->

                                    <?php
                                endforeach; ?>
                                
                                <?php
                            endforeach; ?>

                            <?php
                        endforeach; ?>
                        
                        <!-- MODULE ROW // -->
                        <tr>
                            <td align="center" valign="top">
                                <!-- CENTERING TABLE // -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" valign="top">
                                            <!-- FLEXIBLE CONTAINER // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                <tr>
                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td valign="top">

                                                                    <!-- CONTENT TABLE // -->
                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="center" valign="top" class="textContent">
                                                                                <div style="font-family:Helvetica,Arial,sans-serif; font-size:15px; margin-bottom:0; margin-top:3px; color:#5F5F5F; line-height:135%;">
                                                                                    <img class="img-responsive" src="https://reiniciando.com.br/wp-content/themes/make2-tema/library/images/logo-reiniciando.png" alt="Logo Reiniciando">
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <!-- // CONTENT TABLE -->

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // FLEXIBLE CONTAINER -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CENTERING TABLE -->
                            </td>
                        </tr>
                        <!-- // MODULE ROW -->

                    </table>
                    <!-- // END -->

                    <!-- EMAIL FOOTER // -->
                    <table style="background-color:#E1E1E1;" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">

                        <!-- FOOTER ROW // -->
                        <tr>
                            <td align="center" valign="top">
                                <!-- CENTERING TABLE // -->
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" valign="top">
                                            <!-- FLEXIBLE CONTAINER // -->
                                            <table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
                                                <tr>
                                                    <td align="center" valign="top" width="500" class="flexibleContainerCell">
                                                        <table border="0" cellpadding="30" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td valign="top" style="background-color:#E1E1E1;">

                                                                    <div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
                                                                        <div>Copyright &#169; 2015-<?= date('Y')?> <a href="http://www.reiniciando.com.br/" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">Reiniciando.com.br</span></a>. Todos os direitos reservados.</div>
                                                                        <div class="bottom-20 top-20">Para cancelar o recebimento deste e-mail, desmarque a opção 'Receber e-mails das contas a pagar/receber' na opção 'Meus Dados'.</div>
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- // FLEXIBLE CONTAINER -->
                                        </td>
                                    </tr>
                                </table>
                                <!-- // CENTERING TABLE -->
                            </td>
                        </tr>

                    </table>
                    <!-- // END -->

                </td>
            </tr>
        </table>
    </center>
</body>