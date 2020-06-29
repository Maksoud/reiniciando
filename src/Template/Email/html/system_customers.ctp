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

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background-color:#E1E1E1;">

    <!-- CENTER THE EMAIL // -->
    <center style="background-color:#E1E1E1;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="max-width:100% !important;width: 100% !important;min-width: 100% !important;">
            <tr>
                <td align="center" valign="top" id="bodyCell">

                    <!-- EMAIL BODY // -->
                    <table border="0" cellpadding="0" cellspacing="0" width="500" id="emailBody" style="background-color:#FFFFFF;">

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
                                                                        OLÁ!
                                                                    </h3>
                                                                    <div style="text-align:center;font-family:Helvetica,Arial,sans-serif;font-size:15px;margin-bottom:0;color:#FFFFFF;line-height:135%;">
                                                                        Aqui está a lista atualizada de clientes ativos
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
                                                                                <h3 style="color:#5F5F5F;line-height:125%;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:normal;margin-top:0;margin-bottom:3px;text-align:left;">
                                                                                    <table class="table table-striped font-11">
                                                                                        <thead>
                                                                                            <tr style="border-bottom:2px solid #000;">
                                                                                                <th class="text-nowrap"><?= __('ID') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Nome') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Usuário/E-mail') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Permissão') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Último Acesso') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Dados do Perfil') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Validade Acesso') ?></th>
                                                                                                <th class="text-nowrap"><?= __('Plano') ?></th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            $count = 0;
                                                                                            foreach ($data as $user): 
                                                                                                
                                                                                                $count++;

                                                                                                switch ($user->Rules['rule']) {
                                                                                                    case 'super':
                                                                                                        $rule = __('Super-Administrador');
                                                                                                        break;
                                                                                                    case 'admin':
                                                                                                        $rule = __('Administrador');
                                                                                                        break;
                                                                                                    case 'user':
                                                                                                        $rule = __('Usuário');
                                                                                                        break;
                                                                                                    case 'limited':
                                                                                                        $rule = __('Limitado');
                                                                                                        break;
                                                                                                    case 'visit':
                                                                                                        $rule = __('Visitante');
                                                                                                        break;
                                                                                                    case 'account':
                                                                                                        $rule = __('Contador');
                                                                                                        break;
                                                                                                    case 'especial':
                                                                                                        $rule = __('Especial');
                                                                                                        break;
                                                                                                }//switch
                                                                                                ?>
                                                                                                <tr <?= $count %2 == 0 ? 'style="background-color:#fff"' : 'style="background-color:#f1f1f1"'?>>
                                                                                                    <td><?= str_pad($user->id, 3, '0', STR_PAD_LEFT) ?></td>
                                                                                                    <td><?= h($user->name) ?></td>
                                                                                                    <td><?= h($user->username) ?></td>
                                                                                                    <td><?= h($rule) ?></td>
                                                                                                    <td class="text-center"><?= $user->last_login ? date("d/m/Y H:i:s", strtotime($user->last_login)) : '-'; ?></td>
                                                                                                    <td><?= h($user->Parameters['cpfcnpj'].' - '.$user->Parameters['razao']) ?></td>
                                                                                                    <td><?= date("d/m/Y", strtotime($user->Parameters['dtvalidade'])) ?></td>
                                                                                                    <td><?= h($user->Plans['title']) ?></td>
                                                                                                </tr>
                                                                                                <?php 
                                                                                            endforeach; ?>
                                                                                        </tbody>   
                                                                                    </table> 
                                                                                </h3>
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
                        
                        <!-- MODULE DIVIDER // -->
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
                                                        <table class="flexibleContainerCellDivider" border="0" cellpadding="30" cellspacing="0" width="100%">
                                                            <tr>
                                                                <td align="center" valign="top" style="padding-top:0px;padding-bottom:0px;">
                                                                    <!-- CONTENT TABLE // -->
                                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tr>
                                                                            <td align="center" valign="top" style="border-top:1px solid #C8C8C8;"></td>
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
                        <!-- // END -->
                        
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
                    <table border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter" style="background-color:#E1E1E1;margin-bottom:20px;margin-top:20px;">

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