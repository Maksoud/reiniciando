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
use Cake\Log\Log;

class SystemFunctionsComponent extends Component 
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->Users           = TableRegistry::get('Users');
        $this->Rules           = TableRegistry::get('Rules');
    }
    
    public function validaUsuariosPerfis($users_id, $parameters_id)
    {
        //VALIDA SE O USUÁRIO ATUAL PERTENCE A LISTA DE ACESSO À EMPRESA DO PARÂMETRO
        $usersParameters = $this->listaPerfis($users_id);
        
        foreach ($usersParameters as $usersParameter):
            
            if ($usersParameter == $parameters_id) { 
                return true;
            }//if ($usersParameter == $parameters_id)
            
        endforeach;
        
        return false;
    }
    
    public function listaPerfis($users_id)
    {
        $usersParameters = $this->UsersParameters->findByUsersId($users_id);
        $parameters = [];
        
        if (!empty($usersParameters->toArray())) {
            
            foreach ($usersParameters as $usersParameter):
                $parameters[] = $usersParameter->parameters_id;
            endforeach;
            
        }//if (!empty($usersParameters->toArray()))
        
        return $parameters;
    }
    
    public function listaUsuarios($parameters_id = null)
    {
        $list_users = [];

        if (!empty($parameters_id)) {
            
            //Consulta a tabela de vículo de usuários e perfis
            $usersParameters = $this->UsersParameters->findByParametersId($parameters_id);

            if (!empty($usersParameters->toArray())) {

                //Lista vínculos
                foreach ($usersParameters as $usersParameter):

                    //Guarda usuários
                    $list_users[] = $usersParameter->users_id;

                endforeach;

            }//if (!empty($usersParameters->toArray()))
            
        } else {
            
            //Consulta a tabela de vículo de usuários e perfis
            $usersParameters = $this->UsersParameters->find('all');

            //Consulta a tabela de usuários
            $users = $this->Users->find('all');

            if (!empty($users->toArray())) {

                //Lista usuários
                foreach ($users as $user):

                    //Guarda usuários
                    $list_users[] = $user->id;

                endforeach;

            }//if (!empty($users->toArray()))

        }//else if (!empty($parameters_id))

        return $list_users;
    }
    
    public function validaCadastros($item, $parameters_id)
    {
        $this->Banks = TableRegistry::get('Banks');
        $this->Boxes = TableRegistry::get('Boxes');
        $this->Cards = TableRegistry::get('Cards');
            
        /******************************************************************/
        
        if ($item == "banco") {
            
            //VERIFICA SE HÁ BANCOS CADASTRADOS
            $bank = $this->Banks->findByParametersId($parameters_id)
                                ->first();
            
            if (empty($bank)) {
                $link = '<a href="Banks/Add" class="btn_modal text-bold" data-loading-text="Carregando...", data-size = "sm", data-title="Novo Banco">Clique Aqui!</a>';
                $message = "Ainda não há bancos cadastrados. Vamos criar um agora? $link";
                return $message;
            }//if (empty($bank))
            
        } elseif ($item == "caixa") {
            
            //VERIFICA SE HÁ BANCOS CADASTRADOS
            $box = $this->Boxes->findByParametersId($parameters_id)
                               ->first();
            
            if (empty($box)) {
                $link = '<a href="Boxes/Add" class="btn_modal text-bold" data-loading-text="Carregando...", data-size = "sm", data-title="Novo Caixa">Clique Aqui!</a>';
                $message = "Ainda não há caixas cadastrados. Vamos criar um agora? $link";
                return $message;
            }//if (empty($box))
            
        } elseif ($item == "cartão") {
            
            //VERIFICA SE HÁ BANCOS CADASTRADOS
            $card = $this->Cards->findByParametersId($parameters_id)
                                ->first();
            
            if (empty($card)) {
                $link = '<a href="Cards/Add" class="btn_modal text-bold" data-loading-text="Carregando...", data-size = "sm", data-title="Novo Cartão">Clique Aqui!</a>';
                $message = "Ainda não há cartões cadastrados. Vamos criar um agora? $link";
                return $message;
            }//if (empty($card))
            
        } elseif ($item == "plano") {
            
            //VERIFICA SE O PLANO NÃO FOI ESCOLHIDO
            $plano = $this->Parameters->findById($parameters_id)
                                      ->where(['Parameters.plans_id IS NULL'])
                                      ->first();

            if (!empty($plano)) {
                $link = '<a href="Parameters/Admin/' . $parameters_id . '/" class="btn_modal text-bold" data-title="Escolha um de Nossos Planos">Clique Aqui!</a>';
                $message = "Você ainda não escolheu um plano, $link";
                return $message;
            }//if (empty($plano))
            
        } elseif ($item == "cadastro") {
            
            //VERIFICA SE O CADASTRO DO USUÁRIO ESTÁ COMPLETO
            $conditions = ['Parameters.id' => $parameters_id,
                           'AND' => ['Parameters.cpfcnpj IS NOT NULL',
                                     'Parameters.razao IS NOT NULL',
                                     'Parameters.endereco IS NOT NULL',
                                     'Parameters.bairro IS NOT NULL',
                                     'Parameters.cidade IS NOT NULL',
                                     'Parameters.estado IS NOT NULL',
                                     'Parameters.cep IS NOT NULL',
                                     'Parameters.telefone IS NOT NULL'
                                    ]
                          ];
            
            $parameter = $this->Parameters->find('all')
                                          ->where($conditions)
                                          ->first();
            
            if (empty($parameter)) {
                $link = '<a href="Parameters/edit_novo/' . $parameters_id . '/" class="btn_modal text-bold" data-loading-text="Carregando..." data-title="Complete seu Cadastro">complete agora!</a>';
                $message = "Seu cadastro ainda está incompleto, $link";
                return $message;
            }//if (empty($parameter))
            
        }
        
        return false;
    }
    
    public function validaAcesso($action, $userid, $parameters_id)
    {
        /*
        TODAS AS FUNCTIONS DE TODOS OS CONTROLLERS DEVEM SER DECLARADAS AQUI 23/07/2018
        */

        //PERMISSÃO DE ACESSO POR USUÁRIO
        if ($this->GETuserRules($userid, $parameters_id) == 'super') {
            
            switch ($action) {
                case 'super':                return true; break;
                case 'add_response':         return true; break;
                case 'editUsersParameter':   return true; break;
                case 'debugMode':            return true; break;
                case 'deleteFTP':            return true; break;
                case 'superAddBalance':      return true; break;
            }//switch ($action)
            
            //Everything can be accessed
            return true;
            
        } elseif ($this->GETuserRules($userid, $parameters_id) == 'admin') {
            
            switch ($action) {
                case 'admin':                return true; break;
                case 'add':                  return true; break;
                case 'addjson':              return true; break;
                case 'addSimple':            return true; break;
                case 'addUsersParameter':    return true; break;
                case 'backupFull':           return true; break;
                case 'backupFTP':            return true; break;
                case 'backup':               return true; break;
                case 'confirm':              return true; break;
                case 'cancel':               return true; break;
                case 'downloadFTP':          return true; break;
                case 'delete':               return true; break;
                case 'deleteUsersParameter': return true; break;
                case 'edit':                 return true; break;
                case 'editjson':             return true; break;
                case 'editSimple':           return true; break;
                case 'editLimit':            return true; break;
                case 'editBaixado':          return true; break;
                case 'editBaixadoSimple':    return true; break;
                case 'editNovo':             return true; break;
                case 'editaVenc':            return true; break;
                case 'index':                return true; break;
                case 'indexSimple':          return true; break;
                case 'low':                  return true; break;
                case 'lowSimple':            return true; break;
                case 'reopen':               return true; break;
                case 'update':               return true; break;
                case 'updateBD':             return true; break;
                case 'view':                 return true; break;
                case 'viewSimple':           return true; break;
                case 'viewSystemLog':        return true; break;
                case 'viewUpdateLog':        return true; break;
            }//switch ($action)
            
        } elseif ($this->GETuserRules($userid, $parameters_id) == 'user') {
            
            switch ($action) {
                case 'add':                  return true; break;
                case 'addjson':              return true; break;
                case 'addSimple':            return true; break;
                case 'addjson':              return true; break;
                case 'confirm':              return true; break;
                case 'cancel':               return true; break;
                case 'delete':               return true; break;
                case 'edit':                 return true; break;
                case 'editjson':             return true; break;
                case 'editSimple':           return true; break;
                case 'editLimit':            return true; break;
                case 'editBaixado':          return true; break;
                case 'editBaixadoSimple':    return true; break;
                case 'editNovo':             return true; break;
                case 'editaVenc':            return true; break;
                case 'index':                return true; break;
                case 'indexSimple':          return true; break;
                case 'low':                  return true; break;
                case 'lowSimple':            return true; break;
                case 'reopen':               return true; break;
                case 'view':                 return true; break;
                case 'viewSimple':           return true; break;
            }//switch ($action)
            
        } elseif ($this->GETuserRules($userid, $parameters_id) == 'cont') {
            
            switch ($action) {
                case 'index':                return true; break;
                case 'indexSimple':          return true; break;
                case 'view':                 return true; break;
                case 'viewSimple':           return true; break;
            }//switch ($action)
            
        }//elseif ($this->GETuserRules($userid, $parameters_id) == 'cont')

        /**********************************************************************/

        //PERMISSÃO DE ACESSO POR PLANO DO PERFIL
        if ($this->GETplans($parameters_id) == '4') {

            switch ($action) {
                case 'avisoGratis':          return true; break;
            }//switch ($action)

        }//if ($this->GETplans($parameters_id) == '4')

        /**********************************************************************/
        
        //Everyone can do it...
        switch ($action) {
            
                case 'alert_mail':           return true; break;
                case 'cadastrar':            return true; break;
                case 'cashFlow':             return true; break;
                case 'cashFlowSimple':       return true; break;
                case 'calculaVencJson':      return true; break;
                case 'contato':              return true; break;
                case 'changeLocale':         return true; break;
                case 'changePass':           return true; break;
                case 'changePassword':       return true; break;
                case 'changeParameter':      return true; break;
                case 'confirm':              return true; break;
                case 'cron':                 return true; break;
                case 'download':             return true; break;
                case 'dismissTutorial':      return true; break;
                case 'extratos':             return true; break;
                case 'faturaCartoes':        return true; break;
                case 'finaliza':             return true; break;
                case 'filter':               return true; break;
                case 'faturaCartoes':        return true; break;
                case 'group':                return true; break;
                case 'home':                 return true; break;
                case 'json':                 return true; break;
                case 'login':                return true; break;
                case 'logout':               return true; break;
                case 'login':                return true; break;
                case 'listPlans':            return true; break;
                case 'new_classification':   return true; break;
                case 'recuperaSenha':        return true; break;
                case 'reenviaSenha':         return true; break;
                case 'rememberPassword':     return true; break;
                case 'reportForm':           return true; break;
                case 'reportRp':             return true; break;
                case 'report':               return true; break;
                case 'recurrent':            return true; break;
                case 'resumo_diario':        return true; break;
                case 'resumo_semanal':       return true; break;
                case 'renew':                return true; break;
                case 'saldosBancarios':      return true; break;
                case 'saldosCartoes':        return true; break;
                case 'saldosPlanejamentos':  return true; break;
                case 'upload':               return true; break;
                
        }//switch ($action)

        /**********************************************************************/

        //Log Details
        $error_log = "\n" . 'SystemFunctionsComponent->validaAcesso($action, $userid, $parameters_id) ' . "\n";
        $error_log .= 'action: ' . $action . "\n";
        $error_log .= 'userid: ' . $userid . "\n";
        $error_log .= 'parameters_id: ' . $parameters_id . "\n";
        $error_log .= 'GETplans: ' . $this->GETplans($parameters_id) . "\n";
        $error_log .= 'GETuserRules: ' . $this->GETuserRules($userid, $parameters_id) . "\n";

        $this->Error->registerError(null, $error_log, true);

        /**********************************************************************/
        
        return false;
    }
    
    public function validatePlans($controller, $action, $session)
    {
        //Define variáveis
        $simplifiedControllers = false;

        /**********************************************************************/

        if (!empty($session['userid']) && !empty($session['sessionParameterControl'])) {

            //Define as variáveis
            $user_id           = $session['userid'];
            $parameters_id     = $session['sessionParameterControl'];

            /******************************************************************/

            // $message = "\n";
            // $message .= 'Controller: ' . $controller . "\n";
            // $message .= 'Action: ' . $action . "\n";
            // $message .= 'userid: ' . $session['userid'] . "\n";
            // $message .= 'sessionParameterControl: ' . $session['sessionParameterControl'] . "\n";
            // $message .= 'GETuserRules: ' . $this->GETuserRules($user_id, $parameters_id) . "\n";
            // $message .= 'GETplans: ' . $this->GETplans($parameters_id) . "\n";
            // Log::write('debug', $message);

            /******************************************************************/
        
            if ($this->GETuserRules($user_id, $parameters_id) == 'super') {
                
                //Não há restrição de usuários

            }//if ($this->GETuserRules($user_id, $parameters_id) == 'super')
            
            /******************************************************************/
            
            //Identifica os controllers que possuem páginas diferentes por planos e funções de usuários e perfis
            switch ($controller) {
                    
                case 'Moviments':
                    $simplifiedControllers = true;
                break;
                case 'MovimentBanks':
                    $simplifiedControllers = true;
                break;
                case 'MovimentBoxes':
                    $simplifiedControllers = true;
                break;
                case 'MovimentCards':
                    $simplifiedControllers = true;
                break;
                case 'Transfers':
                    $simplifiedControllers = true;
                break;
                case 'Costs': //Chamado de categoria no plano simples
                    $simplifiedControllers = true;
                break;
                case 'Banks':
                    $simplifiedControllers = true;
                break;
                case 'Boxes': //Chamado de carteira no plano simples
                    $simplifiedControllers = true;
                break;
                case 'Cards':
                    $simplifiedControllers = true;
                break;
                case 'Users':
                    
                    if ($this->GETplans($parameters_id) == 1) {       //Plano Pessoal

                        if ($action == 'add' || $action == 'edit') {
                        
                            //No Plano Pessoal não é possível criar mais de um usuário
                            $return = ['status'     => 'error',
                                       'message'    => 'No Plano Pessoal não é possível criar mais de um usuário',
                                       'controller' => 'Pages',
                                       'action'     => 'home',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);

                            return $return;

                        }//if ($action == 'add' || $action == 'edit')
                        
                    } elseif ($this->GETplans($parameters_id) == 2) { //Plano Simples

                        if ($action == 'add' || $action == 'edit') {

                            if (count($this->listaUsuarios($parameters_id)) > 3) {
                        
                                //É possível cadastrar até 3 usuários no Plano Simples
                                $return = ['status'     => 'error',
                                           'message'    => 'É possível cadastrar até 3 usuários no Plano Simples',
                                           'controller' => 'Pages',
                                           'action'     => 'home',
                                           'modal'      => true
                                          ];
                                      
                                //Registra no LOG
                                $this->Error->registerError($session, implode(", ", $return), true);

                                return $return;

                            }//if (count($this->listaUsuarios($parameters_id)) > 3)

                        }//if ($action == 'add' || $action == 'edit')

                    } elseif ($this->GETplans($parameters_id) == 3) { //Plano Completo

                        //Não há restrição de usuários

                    }//elseif ($this->GETplans($parameters_id) == 3)
                    
                break;
                case 'Parameters':
                    
                    if ($this->GETplans($parameters_id) == 1) {       //Plano Pessoal

                        if ($action == 'add' || $action == 'edit') {

                            //No Plano Pessoal não é possível criar mais de um perfil
                            $return = ['status'     => 'error',
                                       'message'    => 'No Plano Pessoal não é possível criar mais de um perfil',
                                       'controller' => 'Pages',
                                       'action'     => 'home',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);

                            return $return;

                        }//if ($action == 'add' || $action == 'edit')

                    } elseif ($this->GETplans($parameters_id) == 2) { //Plano Simples

                        if ($action == 'add' || $action == 'edit') {

                            //No Plano Simples não é possível criar mais de um perfil
                            $return = ['status'     => 'error',
                                       'message'    => 'No Plano Simples não é possível criar mais de um perfil',
                                       'controller' => 'Pages',
                                       'action'     => 'home',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;

                        }//if ($action == 'add' || $action == 'edit')
                        
                    } elseif ($this->GETplans($parameters_id) == 3) { //Plano Completo

                        //Não há restrição de empresas

                    }//elseif ($this->GETplans($parameters_id) == 3)
                    
                break;
                    
            }//switch ($controller)
            
            /******************************************************************/
            
            //Redireciona para funções, de acordo com o plano do usuário
            if ($this->GETplans($parameters_id) == 1) { //Plano Pessoal
                
                //Possui diferentes páginas por plano?
                if ($simplifiedControllers) { 
                    
                    switch ($action) {

                        case 'view':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'viewSimple',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'index':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'indexSimple'
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'add':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'addSimple',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'edit':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'editSimple',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'editBaixado':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'editBaixadoSimple',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'low':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'lowSimple',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'reportForm':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'reportFormSimple',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;

                    }//switch ($action)
                    
                }//if ($simplifiedControllers)
                
                switch ($controller) {
                        
                    case 'AccountPlans':
                    case 'DocumentTypes':
                    case 'EventTypes':
                    case 'Customers':
                    case 'Providers':
                    case 'Transporters':
                        $return = ['status'     => 'error',
                                   'message'    => 'Seu plano não permite acesso a essas funções',
                                   'controller' => 'Pages',
                                   'action'     => 'home'
                                  ];
                                      
                        //Registra no LOG
                        $this->Error->registerError($session, implode(", ", $return), true);
                        
                        return $return;
                    break;
                        
                }//switch ($controller)
                
            }//if ($this->GETplans($parameters_id) == 1)
            elseif ($this->GETplans($parameters_id) == 2 || $this->GETplans($parameters_id) == 3) { //Plano Simples e Completo
                
                if ($simplifiedControllers) { 
                
                    switch ($action) {

                        case 'viewSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'view',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'indexSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'index'
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'addSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'add',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'editSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'edit',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'editBaixadoSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'editBaixado',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'lowSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'low',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;
                        case 'reportFormSimple':
                            $return = ['status'     => 'redirect',
                                       'message'    => null,
                                       'controller' => $controller,
                                       'action'     => 'reportForm',
                                       'modal'      => true
                                      ];
                                      
                            //Registra no LOG
                            $this->Error->registerError($session, implode(", ", $return), true);
                            
                            return $return;
                        break;

                    }//switch ($action)
                    
                }//if ($simplifiedControllers)
                
            }//elseif ($this->GETplans($parameters_id) == 2 || $this->GETplans($parameters_id) == 3)
            
            /******************************************************************/

            //Retorno padrão
            $return = ['status'     => 'ok',
                       'message'    => null,
                       'controller' => null,
                       'action'     => null
                      ];
            return $return;

        }//if (!empty($this->Session['userid']) && !empty($this->Session['sessionParameterControl']))
        
    }
    
    public function GETuserRulesId($rule)
    {
        $rules = $this->Rules->find('all')
                             ->select(['Rules.id'])
                             ->where(['Rules.rule' => $rule])
                             ->first();

        if (!empty($rules)) {
            return $rules->id;
        }

        return false;
    }
    
    public function GETuserRules($users_id, $parameters_id)
    {
        $usersParameters = $this->UsersParameters->find('all')
                                                 ->select(['UsersParameters.rules_id'])
                                                 ->where(['UsersParameters.users_id'      => $users_id,
                                                          'UsersParameters.parameters_id' => $parameters_id
                                                         ])
                                                 ->first();
        
        if (!empty($usersParameters)) {
            $rule = $this->Rules->find('all')
                                 ->select(['Rules.rule'])
                                 ->where(['Rules.id' => $usersParameters->rules_id])
                                 ->first();
            return $rule->rule;
        }//if (!empty($usersParameters))
        
        return false;
    }
    
    public function GETplans($parameters_id)
    {
        $plan = $this->Parameters->findById($parameters_id)
                                 ->select(['Parameters.id', 'Parameters.plans_id'])
                                 ->first();
        
        if (!empty($plan)) {
            return $plan->plans_id;
        }//if (!empty($plan))
        
        return false;
    }

    public function GETlastParameter($users_id)
    {
        $user = $this->Users->findById($users_id)
                            ->select(['Users.id', 'Users.last_parameter'])
                            ->first();

        return $user->last_parameter;
    }

    public function SETlastParameter($users_id, $parameters_id)
    {
        $user = $this->Users->findById($users_id)
                            ->select(['Users.id', 'Users.last_parameter'])
                            ->first();

        if (!empty($user)) {

            //Grava no banco o último perfil visitado
            $user->last_parameter = $parameters_id;

            if (!$this->Users->save($user)) {

                //Alerta de erro
                $message = 'SystemFunctionsComponent->SETlastParameter';
                $this->Error->registerError($user, $message, true);

            }//if (!$this->Users->save($user))

        }//if (!empty($user))
        
    }

    public function mesPorExtenso($mes)
    {
        switch ($mes) {
            case 1:
                return 'Janeiro';
            case 2:
                return 'Fevereiro';
            case 3:
                return 'Março';
            case 4:
                return 'Abril';
            case 5:
                return 'Maio';
            case 6:
                return 'Junho';
            case 7:
                return 'Julho';
            case 8:
                return 'Agosto';
            case 9:
                return 'Setembro';
            case 10:
                return 'Outubro';
            case 11:
                return 'Novembro';
            case 12:
                return 'Dezembro';
        }
    }
    
    public function mesAbreviado($mes)
    {
        switch ($mes) {
            case 1:
                return 'Jan';
            case 2:
                return 'Fev';
            case 3:
                return 'Mar';
            case 4:
                return 'Abr';
            case 5:
                return 'Mai';
            case 6:
                return 'Jun';
            case 7:
                return 'Jul';
            case 8:
                return 'Ago';
            case 9:
                return 'Set';
            case 10:
                return 'Out';
            case 11:
                return 'Nov';
            case 12:
                return 'Dez';
        }
    }
    
    public function mesNumeral($mes)
    {
        $mes = strtolower($mes);
        
        if (strlen($mes) <= 3) {
            
            if ($mes == 'jan' || $mes == 'jan') { return '1'; }
            if ($mes == 'fev' || $mes == 'feb') { return '2'; }
            if ($mes == 'mar' || $mes == 'mar') { return '3'; }
            if ($mes == 'abr' || $mes == 'apr') { return '4'; }
            if ($mes == 'mai' || $mes == 'mai') { return '5'; }
            if ($mes == 'jun' || $mes == 'jun') { return '6'; }
            if ($mes == 'jul' || $mes == 'jul') { return '7'; }
            if ($mes == 'ago' || $mes == 'aug') { return '8'; }
            if ($mes == 'set' || $mes == 'sep') { return '9'; }
            if ($mes == 'out' || $mes == 'oct') { return '10'; }
            if ($mes == 'nov' || $mes == 'nov') { return '11'; }
            if ($mes == 'dez' || $mes == 'dec') { return '12'; }
            
        } else {
            
            if ($mes == 'janeiro'   || $mes == 'january') {   return '1'; }
            if ($mes == 'fevereiro' || $mes == 'february') {  return '2'; }
            if ($mes == 'março'     || $mes == 'march') {     return '3'; }
            if ($mes == 'abril'     || $mes == 'april') {     return '4'; }
            if ($mes == 'maio'      || $mes == 'may') {       return '5'; }
            if ($mes == 'junho'     || $mes == 'june') {      return '6'; }
            if ($mes == 'julho'     || $mes == 'july') {      return '7'; }
            if ($mes == 'agosto'    || $mes == 'august') {    return '8'; }
            if ($mes == 'setembro'  || $mes == 'september') { return '9'; }
            if ($mes == 'outubro'   || $mes == 'octuber') {   return '10'; }
            if ($mes == 'novembro'  || $mes == 'november') {  return '11'; }
            if ($mes == 'dezembro'  || $mes == 'december') {  return '12'; }
            
        }
    }
    
}