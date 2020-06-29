<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Log\Log;

use Cake\I18n\Number;
Number::config('pt_BR', \NumberFormatter::CURRENCY, ['pattern'   => '#.##,##0',
                                                     'places'    => 2,
                                                     'zero'      => __('0,00'),
                                                     'decimals'  => ',',
                                                     'thousands' => '.',
                                                     'negative'  => '-'
                                                    ]);

class LogComponent extends Component 
{
    public $components = ['Auth', 'Session'];
    
    public function gravaLog($registro, $tipo_log, $function = null)
    {
        //Acessa a tabela de Logs
        $this->Regs            = TableRegistry::get('Regs');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Rules           = TableRegistry::get('Rules');
        $this->Registros       = TableRegistry::get('Registros');
        
        /**********************************************************************/
        
        if ($function == null) { $function = 'Login'; }
        
        /**********************************************************************/
        
        if (is_array($registro)) {
            
            $this->Model = 'login';
            
        } elseif (is_object($registro)) {
            
            $this->Model = $registro->source();
            
            $registro = $registro->toArray();
            
        }//elseif (is_object($registro))
        
        /**********************************************************************/
        
        //CONSULTA PERMISSÃO DO USUÁRIO
        $usersParameters = $this->UsersParameters->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['UsersParameters.rules_id'])
                                                 ->where(['UsersParameters.users_id' => $this->request->Session()->read('userid')])
                                                 ->first();
        
        if (!empty($usersParameters)) {

            $rules = $this->Rules->find('all')
                                 ->select(['Rules.rule'])
                                 ->where(['Rules.id' => $usersParameters['rules_id']])
                                 ->first();

        }//if (!empty($usersParameters))

        /**********************************************************************/
        
        $textoLog  = '================================================ ' . '<br>';
        
        if ($tipo_log != 'noLogin') {

            $textoLog = $textoLog.'Data: '    . date('d'.'/'.'m'.'/'.'Y'.' - '.'H'.':'.'i'.':'.'s') . '<br>';
            $textoLog = $textoLog.'Nome: '    . $this->request->Session()->read('user_name') . '<br>';
            $textoLog = $textoLog.'Usuário: ' . $this->request->Session()->read('username') . '<br>';
            
            if (!empty($rules)) {

                //PERMISSÃO DO USUÁRIO
                switch($rules->rule) {
                    case 'super':    $permission = 'Super-Administrador'; break;
                    case 'admin':    $permission = 'Administrador'; break;
                    case 'user':     $permission = 'Usuário'; break;
                    case 'limited':  $permission = 'Limitado'; break;
                    case 'visit':    $permission = 'Visitante'; break;
                    case 'cont':     $permission = 'Contador'; break;
                    case 'especial': $permission = 'Especial'; break;
                }//switch($rules->rule)

            }//if (!empty($rules))
            
            $textoLog = $textoLog.'Nível de Permissão: ' . $permission . '<br>'; 
            
        } else {
            
            foreach($registro as $index => $value):
                $textoLog = $textoLog.$index . ': ' . $value . '<br>';
            endforeach;
            
        }//if ($tipo_log != 'noLogin')
        
        /**********************************************************************/
        
        if ($tipo_log != 'noLogin') {
            
            $perfil = $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))
                                       ->first();

            $textoLog = $textoLog.'Perfil: '  . $perfil['razao'] . '<br>';
            
        }//if ($tipo_log != 'noLogin')
        
        /**********************************************************************/
        
        if ($tipo_log != 'login' && $tipo_log != 'noLogin') {
            
            $textoLog = $textoLog.'=============== ' . '<br>';
            
            //Tipos de tabelas
            switch($function):
                case 'AccountPlans':    $function = 'Dados do Plano de Contas'; break;
                case 'Banks':           $function = 'Dados do Banco'; break;
                case 'Boxes':           $function = 'Dados do Caixa'; break;
                case 'Cards':           $function = 'Dados do Cartão'; break;
                case 'Costs':           $function = 'Dados do Centro de Custos'; break;
                case 'Customers':       $function = 'Dados do Cliente'; break;
                case 'DocumentTypes':   $function = 'Dados do Tipo de Documentos'; break;
                case 'EventTypes':      $function = 'Dados do Tipo de Evento'; break;
                case 'MovimentBanks':   $function = 'Dados do Movimento de Bancos'; break;
                case 'MovimentBoxes':   $function = 'Dados do Movimento de Caixas'; break;
                case 'MovimentCards':   $function = 'Dados do Movimento de Cartões'; break;
                case 'MovimentChecks':  $function = 'Dados do Movimento de Cheques'; break;
                case 'Moviments':       $function = 'Dados do Movimento'; break;
                case 'Plannings':       $function = 'Dados do Planejamento'; break;
                case 'Parameters':      $function = 'Dados do Perfil'; break;
                case 'Providers':       $function = 'Dados do Fornecedor'; break;
                case 'SupportContacts': $function = 'Dados do Contato de Suporte'; break;
                case 'Transfers':       $function = 'Dados da Trasnferência'; break;
                case 'Transporters':    $function = 'Dados da Transportadora'; break;
                case 'Users':           $function = 'Dados do Usuário'; break;
            endswitch;

            $textoLog = $textoLog.$function . ' ' . '<br>';
            
            /******************************************************************/
            
            $textoLog = $textoLog.'=============== ' . '<br>';
            
            if (is_array($registro)) {

                foreach($registro as $index => $value):

                    if (!is_array($value)) {
    
                        //Tipos de valores
                        $index = ucfirst($index);
    
                        switch($index):
                            case 'Account_plans_id':  $index = 'ID do Plano de Contas'; break;
                            case 'Account_plans_dest':$index = 'ID do Plano de Contas de Destino'; break;
                            case 'Agencia':           $index = 'Nº da Agência'; break;
                            case 'Banks_id':          $index = 'ID do Banco'; break;
                            case 'Banks_dest':        $index = 'ID do Banco de Destino'; break;
                            case 'Boxes_id':          $index = 'ID do Caixa'; break;
                            case 'Boxes_dest':        $index = 'ID do Caixa de Destino'; break;
                            case 'Banco':             $index = 'Nome do Banco'; break;
                            case 'Cards_id':          $index = 'ID do Cartão'; break;
                            case 'Cep':               $index = 'CEP'; break;
                            case 'Costs_id':          $index = 'ID do Centro de Custos'; break;
                            case 'Costs_dest':        $index = 'ID do Centro de Custos de Destino'; break;
                            case 'Coins_id':          $index = 'ID da Moeda'; break;
                            case 'Conta':             $index = 'Nº da Conta'; break;
                            case 'Contabil':          $index = 'Contábil'; break;
                            case 'Classification':    $index = 'Classificação'; break;
                            case 'Created':           $index = 'Data de Criação'; break;
                            case 'Cpfcnpj':           $index = 'CPF/CNPJ'; break;
                            case 'Customers_id':      $index = 'ID do Cliente'; break;
                            case 'Data':              $index = 'Data do Lançamento'; break;
                            case 'Documento':         $index = 'Nº do Documento'; break;
                            case 'Dtbaixa':           $index = 'Data do Pagamento'; break;
                            case 'Dtnascimento':      $index = 'Data de Nascimento/Fundação'; break;
                            case 'Dtvalidade':        $index = 'Data da Validade do Sistema'; break;
                            case 'Document_types_id': $index = 'ID do Tipo de Documento'; break;
                            case 'Duplicadoc':        $index = 'Duplica Pagamento'; break;
                            case 'Emitecheque':       $index = 'Emite Cheque'; break;
                            case 'Emissaoch':         $index = 'Data de Emissão do Cheque'; break;
                            case 'Event_types_id':    $index = 'ID do Tipo de Evento'; break;
                            case 'Historico':         $index = 'Histórico/Descrição'; break;
                            case 'Id':                $index = 'Código de Identificação'; break;
                            case 'Ie':                $index = 'Inscrição Estadual'; break;
                            case 'Limite':            $index = 'Limite de Crédito do Cartão'; break;
                            case 'Modified':          $index = 'Data de Modificação'; break;
                            case 'Melhor_dia':        $index = 'Melhor Dia de Pagamento do Cartão'; break;
                            case 'Moviments_id':      $index = 'ID do Movimento de Contas'; break;
                            case 'Numbanco':          $index = 'Nº do Banco'; break;
                            case 'Obs':               $index = 'Observações'; break;
                            case 'Ordem':             $index = 'Nº da Ordem'; break;
                            case 'Parameters_id':     $index = 'ID do Perfil'; break;
                            case 'Plangroup':         $index = 'Grupo do Plano de Contas'; break;
                            case 'Plannings_id':      $index = 'ID do Planejamento'; break;
                            case 'Providers_id':      $index = 'ID do Fornecedor'; break;
                            case 'Programacao':       $index = 'Data de Programação'; break;
                            case 'Radio_destino':     $index = 'Banco/Caixa Destino'; break;
                            case 'Radio_origem':      $index = 'Banco/Caixa Origem'; break;
                            case 'Referencia':        $index = 'Ponto de Referência'; break;
                            case 'Title':             $index = 'Descrição'; break;
                            case 'Username':          $index = 'Usuário do Cadastro'; break;
                            case 'Userbaixa':         $index = 'Usuário da Baixa'; break;
                            case 'Vencimento':        $index = 'Data do Vencimento'; break;
                            case 'Valor':             $index = 'Valor do Lançamento'; break;
                            case 'Valorbaixa':        $index = 'Valor do Pagamento'; break;
                            case 'Vinculapgto':       $index = 'Vincula Pagamento'; break;
                        endswitch;
    
                        /**********************************************************/
                        
                        //Tipos de valores customizados
                        $value = ucfirst($value);
    
                        if ($value == 'S') {            $value = 'Sim'; }
                        if ($value == 'N') {            $value = 'Não'; }
                        if ($value == 'J') {            $value = 'P.Jurídica'; }
                        if ($value == 'F') {            $value = 'P.Física'; }
                        if ($value == 'Banco_origem') { $value = 'Origem Banco'; }
                        if ($value == 'Banco_destino') {$value = 'Destino Banco'; }
                        if ($value == 'Caixa_origem') { $value = 'Origem Caixa'; }
                        if ($value == 'Caixa_destino') {$value = 'Destino Caixa'; }
                        if ($index == 'Creditodebito') {
                                                        $index = 'Crédito/Débito';
                            if ($value == 'C') {        $value = 'Crédito'; }
                            elseif ($value == 'D') {    $value = 'Débito'; }
                        }//if ($index == 'Creditodebito')
    
                        if ($index == 'Receitadespesa') {
                                                        $index = 'Receita/Despesa';
                            if ($value == 'R') {        $value = 'Receita'; }
                            elseif ($value == 'D') {    $value = 'Despesa'; }
                        }//if ($index == 'Receitadespesa')
    
                        if ($index == 'Tipoconta') {
                                                        $index = 'Tipo de Conta';
                            if ($value == 'C') {        $value = 'Corrente'; }
                            elseif ($value == 'P') {    $value = 'Poupança'; }
                            elseif ($value == 'S') {    $value = 'Salário'; }
                            elseif ($value == 'A') {    $value = 'Aplicação'; }
                        }//if ($index == 'Tipoconta')
    
                        if ($index == 'Status') {
                                                        $index = 'Status';
                            if ($value == 'A') {        $value = 'Em Aberto/Ativo'; }
                            elseif ($value == 'B') {    $value = 'Baixado'; }
                            elseif ($value == 'C') {    $value = 'Cancelado'; }
                            elseif ($value == 'P') {    $value = 'Parcial'; }
                            elseif ($value == 'O') {    $value = 'Baixa Parcial'; }
                            elseif ($value == 'I') {    $value = 'Inativo'; }
                        }//if ($index == 'Status')
    
                        $textoLog = $textoLog.$index . ': ' .  $value . '<br>';
                        
                    } else {
                        
                        $textoLog = $textoLog.$index . '<br>';
    
                        foreach($value as $index2 => $value2):
                            if (!empty($value2)) {
                                $index2 = ucfirst($index2);
                                $value2 = json_encode($value2);
                                $textoLog = $textoLog.$index2 . ': ' .  $value2 . '<br>';
                            }//if (!empty($value2))
                        endforeach;
                        
                    }//else if (!is_array($value))
    
                endforeach;

            }//if (is_array($registro))
            
        }//if ($tipo_log != 'login' && $tipo_log != 'noLogin')
        
        $textoLog = $textoLog.'================================================ ' . '<br>';
        
        /**********************************************************************/
        
        switch($tipo_log):
            case 'login':          $tipo_log = 'Login'; break;
            case 'noLogin':        $tipo_log = 'Erro de Login'; break;
            case 'delete':         $tipo_log = 'Exclusão'; break;
            case 'inativate':      $tipo_log = 'Inativação'; break;
            case 'cancel':         $tipo_log = 'Cancelamento'; break;
            case 'edit':           $tipo_log = 'Edição'; break;
            case 'add':            $tipo_log = 'Novo Registro'; break;
            case 'SupportContact': $tipo_log = 'Suporte'; break;
        endswitch;
        
        /**********************************************************************/
        
        //Define campos para gravação
        $save = ['content'       => $textoLog,
                 'log_type'      => $tipo_log,
                 'function'      => $function, //ALTER TABLE `regs` CHANGE `table` `function` VARCHAR(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
                 'username'      => $this->request->Session()->read('user_name'),
                 'users_id'      => $this->request->Session()->read('userid'),
                 'parameters_id' => $this->request->Session()->read('sessionParameterControl')
                ];
        
        //Cria novo registro
        $reg = $this->Regs->newEntity($save);

        //Salva registros
        if ($this->Regs->save($reg)) {

            return true;

        } else {

            //Alerta de erro
            Log::write('debug', 'LogComponent->gravaLog: ' . $reg);

        }//else if ($this->Regs->save($reg))
        
        return false;
        
    }
    
}