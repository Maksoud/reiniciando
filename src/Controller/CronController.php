<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Cron */
/* File: src/Controller/CronController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Core\Exception\Exception;
use Cake\Log\Log;

class CronController extends AppController 
{
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('MovimentRecurrentsFunctions');
        $this->loadComponent('BackupsFunctions');
        $this->loadComponent('EmailFunctions');
    }
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['cron', 'recurrent', 'resumoDiario', 'resumoSemanal', 'resumoAtrasados']);
    }
    
    public function cron()
    {
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        $this->Backups = TableRegistry::get('Backups');
        
        /**********************************************************************/
            
        if ($this->request->query['token'] == 'Y5eEHC208Q2kcbfRhiNC0pxAAPtk3CB6') {
            
            // GERA MOVIMENTOS RECORRENTES
            $this->recurrent(); 
        
            /******************************************************************/
            
            // GERA RESUMO MENSAL
            $this->resumoAtrasados();
        
            /******************************************************************/
            
            // GERA RESUMO SEMANAL
            $this->resumoSemanal();
        
            /******************************************************************/
            
            // GERA RESUMO DIÁRIO
            $this->resumoDiario();
        
            /******************************************************************/
            
            // GERA BACKUP COMPLETO
            if (!$this->BackupsFunctions->backupFTP()) {

                //Alerta de erro
                $message = 'Cron->cron, BackupFunctions->backupFTP(): Houve um erro na gravação do backup via FTP.';
                $this->Error->registerError(null, $message, true);

            }//if ($this->BackupsFunctions->backupFTP())
            
        } else {
            echo "YOU DON'T HAVE PERMISSION TO ACCESS THIS PAGE!";
        }
        
        /**********************************************************************/
        
        //NÃO BUSCA A VIEW
        $this->autoRender = false;
    }
            
    public function recurrent()
    {
        $this->Users              = TableRegistry::get('Users');
        $this->Parameters         = TableRegistry::get('Parameters');
        $this->UsersParameters    = TableRegistry::get('UsersParameters');
        $this->MovimentRecurrents = TableRegistry::get('MovimentRecurrents');
        
        /**********************************************************************/
        
        //IDENTIFICA TODAS AS EMPRESAS
        $parameters = $this->Parameters->find('all');
        
        /**********************************************************************/
        
        //ACESSA A TABELA DE MOVIMENTOS RECORRENTES
        
        //RESPOSTA DE EXECUÇÃO
        $recurrent_return = null;
        
        /**********************************************************************/
        
        //EXECUTA COMANDO PARA TODAS AS EMPRESAS
        foreach ($parameters as $parameter):

            //VERIFICA SE O PERFIL ESTÁ DENTRO DA VALIDADE
            if ($parameter->dtvalidade > date('Y-m-d')) {

                //LOCALIZA OS REGISTROS COM DATA INFERIOR A DATA DE HOJE NA TABELA MOVIMENT RECURRENT E...
                $recurrents = $this->MovimentRecurrents->find('all')
                                                       ->where(['MovimentRecurrents.parameters_id' => $parameter->id]);

                //GERA UM NOVO MOVIMENTO E...
                if (!empty($recurrents)) {
                    
                    //CRIA MOVIMENTOS FINACEIROS RECORRENTES
                    $moviments_return = $this->MovimentRecurrentsFunctions->makeMovimentRecurrents($recurrents, $parameter->id); 
                    
                    //CRIA MOVIMENTOS DE CARTÕES RECORRENTES
                    $cards_return     = $this->MovimentRecurrentsFunctions->makeCardRecurrents($recurrents, $parameter->id); 

                    //RESPOSTA DE EXECUÇÃO
                    if (!empty($moviments_return)) {
                        
                        $recurrent_return[$parameter->razao]['Movimentos de Contas a Pagar/Receber'] = $moviments_return;
                        
                    }//if (!empty($moviments_return))
                    
                    if (!empty($cards_return)) {
                        
                        $recurrent_return[$parameter->razao]['Movimentos de Cartões de Crédito'] = $cards_return;
                        
                    }//if (!empty($cards_return))
                    
                }//if (!empty($recurrents))

            }//if ($parameter->dtvalidade > date('Y-m-d'))
            
        endforeach;//foreach($parameters as $parameter)

        /**********************************************************************/
        
        if (!empty($recurrent_return)) {

            //Envia alerta de lançamentos recorrentes criados com sucesso
            $sendMail = ['subject'  => 'SISTEMA R2: Lançamentos recorrentes criados com sucesso',
                         'template' => 'cron_recurrents',
                         'vars'     => ['recurrent_return' => $recurrent_return],
                         'toEmail'  => null
                        ];

            $this->EmailFunctions->sendMail($sendMail);
                
        }//if (!empty($recurrent_return))
        
        /**********************************************************************/

        //NÃO BUSCA A VIEW
        $this->autoRender = false;
        
    }
    
    public function resumoDiario()
    {
        $this->Users           = TableRegistry::get('Users');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Moviments       = TableRegistry::get('Moviments');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        $this->Customers       = TableRegistry::get('Customers');
        $this->Providers       = TableRegistry::get('Providers');

        /**********************************************************************/

        //LISTA OS USUÁRIOS DO SISTEMA
        $usuarios = $this->Users->find('all')
                                ->select(['Users.id', 'Users.username', 'UsersParameters.sendmail'])
                                ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                              'type'       => 'LEFT',
                                                              'conditions' => ['UsersParameters.users_id = Users.id',
                                                                               //'UsersParameters.parameters_id = ' . $this->request->Session()->read('sessionParameterControl')
                                                                              ]
                                                             ]
                                       ]);

        /**********************************************************************/
        
        if (!empty($usuarios->toArray())) {

            foreach ($usuarios as $usuario):
            
                if ($usuario->sendmail == 'S') {
                    
                    //LISTA DE VÍNCULO DE USUÁRIOS E PERFIS
                    $empusuarios = $this->UsersParameters->find('all')
                                                         ->select(['UsersParameters.parameters_id', 'UsersParameters.users_id', 
                                                                   'UsersParameters.rules_id' 
                                                                  ])
                                                         ->where(['UsersParameters.users_id' => $usuario->id]);
                    
                    foreach ($empusuarios as $empusuario):
                        
                        //LISTA DE PERFIS
                        $empresas = $this->Parameters->find('all')
                                                     ->select(['Parameters.id', 'Parameters.razao', 'Parameters.dtvalidade', 
                                                               'Parameters.plans_id'
                                                              ])
                                                     ->where(['Parameters.id' => $empusuario->parameters_id]);
                        
                        foreach ($empresas as $perfil):
                
                            $return = [];
                    
                            /**************************************************/
                            
                            //VERIFICA SE O PERFIL ESTÁ DENTRO DA VALIDADE E VERIFICA SE O PLANO NÃO É O GRATUITO
                            if ($perfil->dtvalidade > date('Y-m-d') && $perfil->plans_id != '4') {
                                
                                //ACESSA A TABELA MOVIMENTS
                                $movimentos = $this->Moviments->find('all')
                                                              ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id', 
                                                                        'Moviments.boxes_id', 'Moviments.cards_id', 'Moviments.plannings_id', 'Moviments.costs_id', 
                                                                        'Moviments.account_plans_id', 'Moviments.event_types_id', 'Moviments.document_types_id', 
                                                                        'Moviments.customers_id', 'Moviments.providers_id',  'Moviments.documento', 'Moviments.cheque', 
                                                                        'Moviments.nominal', 'Moviments.emissaoch', 'Moviments.creditodebito', 'Moviments.data', 
                                                                        'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.historico', 'Moviments.contabil', 
                                                                        'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.status', 'Moviments.username', 'Moviments.obs',
                                                                        'EventTypes.id', 'EventTypes.title', 
                                                                        'DocumentTypes.id', 'DocumentTypes.title', 
                                                                        'Customers.id', 'Customers.cpfcnpj', 'Customers.title', 'Customers.fantasia', 
                                                                        'Providers.id', 'Providers.cpfcnpj', 'Providers.title', 'Providers.fantasia', 
                                                                        'Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj'
                                                                      ])
                                                              ->where(['Moviments.vencimento'    => date('Y-m-d'),
                                                                       'Moviments.parameters_id' => $perfil->id,
                                                                       'Moviments.status IN '    => ['A', 'P']
                                                                      ])
                                                              ->contain(['DocumentTypes', 'EventTypes', 'Parameters', 'Customers', 'Providers']);
                                
                                if (!empty($movimentos->toArray())) {
                                    
                                    $count = 0;
                                    
                                    foreach ($movimentos as $movimento):
                                        
                                        //Consulta de títulos parciais pelo id do vínculo
                                        $mergeds = $this->MovimentMergeds->find('all')
                                                                         ->select(['MovimentMergeds.moviments_merged'])
                                                                         ->where(['MovimentMergeds.moviments_id'  => $movimento->id,
                                                                                  'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                                                                                 ]);
                                        
                                        /******************************************/
                                        
                                        if (!empty($mergeds->toArray())) {
                                            foreach ($mergeds as $merged):
                                                $vinculado = $this->Moviments->find('all')
                                                                            ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.dtbaixa',
                                                                                    'Moviments.valorbaixa', 'Moviments.status'
                                                                                    ])
                                                                            ->where(['Moviments.id'            => $merged->moviments_merged,
                                                                                    'Moviments.parameters_id' => $perfil->id
                                                                                    ]);
                                            
                                                if (!empty($vinculado->toArray())) {
                                                    foreach ($vinculado as $value):
                                                        $return[$count]['parcial'] = "Valor Parcial Pago/Recebido em " . 
                                                                                    implode('/', array_reverse(explode("-", $value->dtbaixa))) . 
                                                                                    ": " . 
                                                                                    str_replace('.', ',', $value->valorbaixa);
                                                    endforeach;
                                                }//if (!empty($vinculado))
                                                
                                            endforeach;
                                        }//if (!empty($mergeds->toArray()))
                                        
                                        /******************************************/
                                        
                                        if (!isset($return[$count]['parcial'])) { $return[$count]['parcial'] = ""; }
                                        
                                        /******************************************/
                                        
                                        if ($movimento->creditodebito == 'C') {
    
                                            //Complemento do cadastro de fornecedores
                                            if (!empty($movimento->customers_id)) {
    
                                                $return[$count]['Customers'] = $this->Customers->find('all')
                                                                                               ->select(['Customers.id', 'Customers.title'])
                                                                                               ->where(['Customers.id' => $movimento->customers_id])
                                                                                               ->first();
    
                                            }//if (!empty($movimento->customers_id))
    
                                        } elseif ($movimento->creditodebito == 'D') {
    
                                            //Complemento do cadastro de fornecedores
                                            if (!empty($movimento->providers_id)) {
    
                                                $return[$count]['Providers'] = $this->Providers->find('all')
                                                                                               ->select(['Providers.id', 'Providers.title'])
                                                                                               ->where(['Providers.id' => $movimento->providers_id])
                                                                                               ->first();
    
                                            }//if (!empty($movimento->providers_id))
                                            
                                        }//elseif ($movimento->creditodebito == 'D')
                                        
                                        /******************************************/
                                        
                                        $return[$count]['ordem']                  = $movimento->ordem;
                                        $return[$count]['creditodebito']          = $movimento->creditodebito;
                                        $return[$count]['Parameters']['id']       = $movimento->Parameters['id'];
                                        $return[$count]['Parameters']['razao']    = $movimento->Parameters['razao'];
                                        $return[$count]['document_types_id']      = $movimento->document_types_id;
                                        $return[$count]['DocumentTypes']['id']    = $movimento->DocumentTypes['id'];
                                        $return[$count]['DocumentTypes']['title'] = $movimento->DocumentTypes['title'];
                                        $return[$count]['event_types_id']         = $movimento->event_types_id;
                                        $return[$count]['EventTypes']['id']       = $movimento->EventTypes['id'];
                                        $return[$count]['EventTypes']['title']    = $movimento->EventTypes['title'];
                                        $return[$count]['valor']                  = $movimento->valor;
    
                                        if ($movimento->historico) {
                                            $return[$count]['historico']  = $movimento->historico;
                                        } elseif ($movimento->title) {
                                            $return[$count]['title']      = $movimento->title;
                                        }
                                        
                                        $vencimento = explode("-", $movimento->vencimento);
                                        $return[$count]['vencimento'] = implode('/', array_reverse($vencimento));
                                        
                                        /******************************************/
                                        
                                        if (!empty($movimento->documento)) { 
                                            $return[$count]['documento'] = $movimento->documento;
                                        } else {
                                            $return[$count]['documento'] = "";
                                        }// else if (!empty($movimento->documento))
                                        
                                        /******************************************/
                                        
                                        if (!empty($movimento->obs)) {
                                            $return[$count]['obs'] = $movimento->obs;
                                        } else {
                                            $return[$count]['obs'] = "";
                                        }// else if (!empty($movimento->obs))
                                        
                                        /******************************************/
                                        
                                        $count++;
                                        
                                    endforeach;
                                    
                                    /**********************************************/
    
                                    //ENVIA E-MAIL COM RESUMO DIÁRIO
                                    $sendMail = ['subject'  => 'SISTEMA R2: Resumo das contas a pagar/receber - ' . date('d/m/Y'),
                                                 'template' => 'cron_mail_diario',
                                                 'vars'     => ['moviments' => $return],
                                                 'toEmail'  => $usuario->username
                                                ];
    
                                    $this->EmailFunctions->sendMail($sendMail);
                                    
                                }//if (!empty($movimentos->toArray()))
                                
                            }//if ($empresa['dtvalidade'] > date('Y-m-d'))
                            
                        endforeach;//foreach($empresas as $empresa)
                        
                    endforeach;//foreach($empusuarios as $empusuario)
                    
                }//if ($usuario['sendmail'] == 'S')
                
            endforeach;//foreach($usuarios as $usuario)

        }//if (!empty($usuarios->toArray()))

        /**********************************************************************/

        //NÃO BUSCA A VIEW
        $this->autoRender = false;
    }
    
    public function resumoSemanal()
    {
        $this->Users           = TableRegistry::get('Users');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Moviments       = TableRegistry::get('Moviments');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        $this->Customers       = TableRegistry::get('Customers');
        $this->Providers       = TableRegistry::get('Providers');
        
        $return = null;
        
        //SÓ É EXECUTADO AOS DOMINGOS!!
        if (date('w') == 0) {
            
            //LISTA OS USUÁRIOS DO SISTEMA
            $usuarios = $this->Users->find('all')
                                    ->select(['Users.id', 'Users.username', 'UsersParameters.sendmail'])
                                    ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                                  'type'       => 'LEFT',
                                                                  'conditions' => ['UsersParameters.users_id = Users.id',
                                                                                   'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                                  ]
                                                                 ]
                                           ]);

            /**********************************************************************/
            
            foreach ($usuarios as $usuario):
                
                if ($usuario->sendmail == 'S') {
                    
                    //LISTA DE VÍNCULO DE USUÁRIOS E PERFIS
                    $empusuarios = $this->UsersParameters->find('all')
                                                         ->select(['UsersParameters.parameters_id', 'UsersParameters.users_id', 
                                                                   'UsersParameters.rules_id' 
                                                                  ])
                                                         ->where(['UsersParameters.users_id' => $usuario->id]);
                    
                    foreach ($empusuarios as $empusuario):
                        
                        //LISTA DE PERFIS
                        $empresas = $this->Parameters->find('all')
                                                     ->select(['Parameters.id', 'Parameters.razao', 'Parameters.dtvalidade', 
                                                               'Parameters.plans_id'
                                                              ])
                                                     ->where(['Parameters.id' => $empusuario->parameters_id]);
                        
                        foreach ($empresas as $perfil):
            
                            $return = [];
                    
                            /**************************************************/
                            
                            //VERIFICA SE O PERFIL ESTÁ DENTRO DA VALIDADE, MAS PERMITE O RESUMO POR E-MAIL NO PLANO GRATUITO
                            if ($perfil->dtvalidade > date('Y-m-d')) {
                                
                                //ACESSA A TABELA MOVIMENTS
                                $inicio_semana = date('Y-m-d', strtotime('-' . date('w') . ' days'));
                                $fim_semana    = date('Y-m-d', strtotime('+' . (6 - date('w')) . ' days'));
                                $periodo       = implode('/', array_reverse(explode('-', $inicio_semana))) . ' à ' . 
                                                 implode('/', array_reverse(explode('-', $fim_semana)));
                                
                                /**********************************************/
                                
                                $movimentos = $this->Moviments->find('all')
                                                              ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id', 
                                                                        'Moviments.boxes_id', 'Moviments.cards_id', 'Moviments.plannings_id', 'Moviments.costs_id', 
                                                                        'Moviments.account_plans_id', 'Moviments.event_types_id', 'Moviments.document_types_id', 
                                                                        'Moviments.customers_id', 'Moviments.providers_id',  'Moviments.documento', 'Moviments.cheque', 
                                                                        'Moviments.nominal', 'Moviments.emissaoch', 'Moviments.creditodebito', 'Moviments.data', 
                                                                        'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.historico', 'Moviments.contabil', 
                                                                        'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.status', 'Moviments.username', 'Moviments.obs',
                                                                        'EventTypes.id', 'EventTypes.title', 
                                                                        'DocumentTypes.id', 'DocumentTypes.title', 
                                                                        'Customers.id', 'Customers.cpfcnpj', 'Customers.title', 'Customers.fantasia', 
                                                                        'Providers.id', 'Providers.cpfcnpj', 'Providers.title', 'Providers.fantasia', 
                                                                        'Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj'
                                                                       ])
                                                              ->where([//'Moviments.vencimento BETWEEN ? AND ?' => [$inicio_semana, $fim_semana],
                                                                       'Moviments.parameters_id' => $perfil->id,
                                                                       'Moviments.status IN '    => ['A', 'P']
                                                                      ])
                                                              ->andWhere(function ($exp, $q) use($inicio_semana, $fim_semana) {
                                                                          return $exp->between('Moviments.vencimento', $inicio_semana, $fim_semana);
                                                                        })
                                                              ->contain(['DocumentTypes', 'EventTypes', 'Parameters', 'Customers', 'Providers']);
                                
                                /**********************************************/

                                if (!empty($movimentos->toArray())) {
                                    
                                    $count = 0;
                                    
                                    foreach ($movimentos as $movimento):

                                        //Consulta de títulos parciais pelo id do vínculo
                                        $mergeds = $this->MovimentMergeds->find('all')
                                                                         ->select(['MovimentMergeds.moviments_merged'])
                                                                         ->where(['MovimentMergeds.moviments_id'  => $movimento->id,
                                                                                  'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                                                                                 ]);
                                        
                                        /**************************************/
                                        
                                        if (!empty($mergeds->toArray())) {
                                            foreach ($mergeds as $merged):
                                                
                                                $vinculado = $this->Moviments->find('all')
                                                                             ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.dtbaixa',
                                                                                       'Moviments.valorbaixa', 'Moviments.status'
                                                                                      ])
                                                                             ->where(['Moviments.id'            => $merged->moviments_merged,
                                                                                      'Moviments.parameters_id' => $perfil->id
                                                                                     ]);
                                        
                                                if (!empty($vinculado->toArray())) {
                                                    foreach ($vinculado as $value):
                                                        $return[$count]['parcial'] = "Valor Parcial Pago/Recebido em " .  
                                                                                     implode('/', array_reverse(explode("-", $value->dtbaixa))) . 
                                                                                     ": " . 
                                                                                     str_replace('.', ',', $value->valorbaixa);
                                                    endforeach;
                                                }//if (!empty($vinculado))
                                            
                                            endforeach;
                                        }//if (!empty($mergeds->toArray()))
                                        
                                        /**************************************/
                                        
                                        if (!isset($return[$count]['parcial'])) { $return[$count]['parcial'] = ""; }
                                        
                                        /**************************************/
                                        
                                        if ($movimento->creditodebito == 'C') {

                                            $return[$count]['Customers'] = $this->Customers->find('all')
                                                                                           ->select(['Customers.id', 'Customers.title'])
                                                                                           ->where(['Customers.id' => $movimento->customers_id])
                                                                                           ->first();

                                        } elseif ($movimento->creditodebito == 'D') {
                                            
                                            $return[$count]['Providers'] = $this->Providers->find('all')
                                                                                           ->select(['Providers.id', 'Providers.title'])
                                                                                           ->where(['Providers.id' => $movimento->providers_id])
                                                                                           ->first();

                                        }//if ($movimento->creditodebito == 'C')
                                        
                                        /**************************************/

                                        $return[$count]['ordem']                  = $movimento->ordem;
                                        $return[$count]['creditodebito']          = $movimento->creditodebito;
                                        $return[$count]['Parameters']['id']       = $movimento->Parameters['id'];
                                        $return[$count]['Parameters']['razao']    = $movimento->Parameters['razao'];
                                        $return[$count]['document_types_id']      = $movimento->document_types_id;
                                        $return[$count]['DocumentTypes']['id']    = $movimento->DocumentTypes['id'];
                                        $return[$count]['DocumentTypes']['title'] = $movimento->DocumentTypes['title'];
                                        $return[$count]['event_types_id']         = $movimento->event_types_id;
                                        $return[$count]['EventTypes']['id']       = $movimento->EventTypes['id'];
                                        $return[$count]['EventTypes']['title']    = $movimento->EventTypes['title'];
                                        $return[$count]['valor']                  = $movimento->valor;
                                        $return[$count]['periodo']                = $periodo;

                                        if ($movimento->historico) {
                                            $return[$count]['historico']  = $movimento->historico;
                                        } elseif ($movimento->title) {
                                            $return[$count]['title']      = $movimento->title;
                                        }
                                    
                                        $vencimento = explode("-", $movimento->vencimento);
                                        $return[$count]['vencimento'] = implode('/', array_reverse($vencimento));
                                        
                                        /**************************************/
                                        
                                        if (!empty($movimento->documento)) { 
                                            $return[$count]['documento'] = $movimento->documento;
                                        } else {
                                            $return[$count]['documento'] = "";
                                        }//if (!empty($movimento->documento))
                                        
                                        /**************************************/
                                        
                                        if (!empty($movimento->obs)) {
                                            $return[$count]['obs'] = $movimento->obs;
                                        } else {
                                            $return[$count]['obs'] = "";
                                        }//if (!empty($movimento->obs))
                                        
                                        /**************************************/
                                        
                                        $count++;
                                        
                                    endforeach;
                                    
                                    /******************************************/

                                    //Envio de e-mail com relatório do CRON
                                    $sendMail = ['subject'  => 'SISTEMA R2: Resumo das contas a pagar/receber da semana - ' . $periodo,
                                                 'template' => 'cron_mail_semanal',
                                                 'vars'     => ['moviments' => $return],
                                                 'toEmail'  => $usuario->username
                                                ];

                                    $this->EmailFunctions->sendMail($sendMail);
                                    
                                }//if (!empty($movimentos))
                                
                            }//if ($empresa['dtvalidade'] > date('Y-m-d'))
                            
                        endforeach;//foreach($empresas as $empresa)
                        
                    endforeach;//foreach($empusuarios as $empusuario)
                    
                }//if ($usuario['sendmail'] == 'S')
                
            endforeach;//foreach($usuarios as $usuario)
            
        }//executa somente aos domingos
        
        //NÃO BUSCA A VIEW
        $this->autoRender = false;
    }

    public function resumoAtrasados()
    {
        $this->Users           = TableRegistry::get('Users');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        $this->Moviments       = TableRegistry::get('Moviments');
        $this->MovimentMergeds = TableRegistry::get('MovimentMergeds');
        $this->Customers       = TableRegistry::get('Customers');
        $this->Providers       = TableRegistry::get('Providers');
        
        $return = null;

        //Envia somente no dia 1 de cada mês
        if (date('d') == '01') {
            
            //LISTA OS USUÁRIOS DO SISTEMA
            $usuarios = $this->Users->find('all')
                                    ->select(['Users.id', 'Users.username', 'UsersParameters.sendmail'])
                                    ->join(['UsersParameters' => ['table'      => 'users_parameters',
                                                                  'type'       => 'LEFT',
                                                                  'conditions' => ['UsersParameters.users_id = Users.id',
                                                                                   'UsersParameters.parameters_id = '.$this->request->Session()->read('sessionParameterControl')
                                                                                  ]
                                                                 ]
                                           ]);

            /**********************************************************************/
            
            foreach ($usuarios as $usuario):
                
                if ($usuario->sendmail == 'S') {
                    
                    //LISTA DE VÍNCULO DE USUÁRIOS E PERFIS
                    $empusuarios = $this->UsersParameters->find('all')
                                                         ->select(['UsersParameters.parameters_id', 'UsersParameters.users_id', 
                                                                   'UsersParameters.rules_id' 
                                                                  ])
                                                         ->where(['UsersParameters.users_id' => $usuario->id]);
                    
                    foreach ($empusuarios as $empusuario):
                        
                        //LISTA DE PERFIS
                        $empresas = $this->Parameters->find('all')
                                                     ->select(['Parameters.id', 'Parameters.razao', 'Parameters.dtvalidade', 
                                                               'Parameters.plans_id'
                                                              ])
                                                     ->where(['Parameters.id' => $empusuario->parameters_id]);
                        
                        foreach ($empresas as $perfil):
            
                            $return = [];
                    
                            /**************************************************/
                            
                            //VERIFICA SE O PERFIL ESTÁ DENTRO DA VALIDADE, MAS PERMITE O RESUMO POR E-MAIL NO PLANO GRATUITO
                            if ($perfil->dtvalidade > date('Y-m-d')) {
                                
                                //ACESSA A TABELA MOVIMENTS
                                $dt_inicio = date('Y-m-d', strtotime('2000-01-01'));
                                $dt_fim    = date('Y-m-d', strtotime('-1 days'));
                                $periodo   = implode('/', array_reverse(explode('-', $dt_inicio))) . ' à ' . 
                                             implode('/', array_reverse(explode('-', $dt_fim)));
                                
                                /**********************************************/
                                
                                $movimentos = $this->Moviments->find('all')
                                                              ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.ordem', 'Moviments.banks_id', 
                                                                        'Moviments.boxes_id', 'Moviments.cards_id', 'Moviments.plannings_id', 'Moviments.costs_id', 
                                                                        'Moviments.account_plans_id', 'Moviments.event_types_id', 'Moviments.document_types_id', 
                                                                        'Moviments.customers_id', 'Moviments.providers_id',  'Moviments.documento', 'Moviments.cheque', 
                                                                        'Moviments.nominal', 'Moviments.emissaoch', 'Moviments.creditodebito', 'Moviments.data', 
                                                                        'Moviments.vencimento', 'Moviments.dtbaixa', 'Moviments.historico', 'Moviments.contabil', 
                                                                        'Moviments.valor', 'Moviments.valorbaixa', 'Moviments.status', 'Moviments.username', 'Moviments.obs',
                                                                        'EventTypes.id', 'EventTypes.title', 
                                                                        'DocumentTypes.id', 'DocumentTypes.title', 
                                                                        'Customers.id', 'Customers.cpfcnpj', 'Customers.title', 'Customers.fantasia', 
                                                                        'Providers.id', 'Providers.cpfcnpj', 'Providers.title', 'Providers.fantasia', 
                                                                        'Parameters.id', 'Parameters.razao', 'Parameters.cpfcnpj'
                                                                       ])
                                                              ->where(['Moviments.parameters_id' => $perfil->id,
                                                                       'Moviments.status IN '    => ['A', 'P']
                                                                      ])
                                                              ->andWhere(function ($exp, $q) use($dt_inicio, $dt_fim) {
                                                                          return $exp->between('Moviments.vencimento', $dt_inicio, $dt_fim);
                                                                        })
                                                              ->contain(['DocumentTypes', 'EventTypes', 'Parameters', 'Customers', 'Providers']);
                                
                                /**********************************************/

                                if (!empty($movimentos->toArray())) {
                                    
                                    $count = 0;
                                    
                                    foreach ($movimentos as $movimento):

                                        //Consulta de títulos parciais pelo id do vínculo
                                        $mergeds = $this->MovimentMergeds->find('all')
                                                                         ->select(['MovimentMergeds.moviments_merged'])
                                                                         ->where(['MovimentMergeds.moviments_id'  => $movimento->id,
                                                                                  'MovimentMergeds.parameters_id' => $this->request->Session()->read('sessionParameterControl')
                                                                                 ]);
                                        
                                        /**************************************/
                                        
                                        if (!empty($mergeds->toArray())) {
                                            foreach ($mergeds as $merged):
                                                
                                                $vinculado = $this->Moviments->find('all')
                                                                            ->select(['Moviments.id', 'Moviments.parameters_id', 'Moviments.dtbaixa',
                                                                                    'Moviments.valorbaixa', 'Moviments.status'
                                                                                    ])
                                                                            ->where(['Moviments.id'            => $merged->moviments_merged,
                                                                                    'Moviments.parameters_id' => $perfil->id
                                                                                    ]);
                                        
                                                if (!empty($vinculado->toArray())) {
                                                    foreach ($vinculado as $value):
                                                        $return[$count]['parcial'] = "Valor Parcial Pago/Recebido em " .  
                                                                                    implode('/', array_reverse(explode("-", $value->dtbaixa))) . 
                                                                                    ": " . 
                                                                                    str_replace('.', ',', $value->valorbaixa);
                                                    endforeach;
                                                }//if (!empty($vinculado))
                                            
                                            endforeach;
                                        }//if (!empty($mergeds->toArray()))
                                        
                                        /**************************************/
                                        
                                        if (!isset($return[$count]['parcial'])) { $return[$count]['parcial'] = ""; }
                                        
                                        /**************************************/
                                        
                                        if ($movimento->creditodebito == 'C') {

                                            $return[$count]['Customers'] = $this->Customers->find('all')
                                                                                           ->select(['Customers.id', 'Customers.title'])
                                                                                           ->where(['Customers.id' => $movimento->customers_id])
                                                                                           ->first();

                                        } elseif ($movimento->creditodebito == 'D') {
                                            
                                            $return[$count]['Providers'] = $this->Providers->find('all')
                                                                                           ->select(['Providers.id', 'Providers.title'])
                                                                                           ->where(['Providers.id' => $movimento->providers_id])
                                                                                           ->first();

                                        }//if ($movimento->creditodebito == 'C')
                                        
                                        /**************************************/

                                        $return[$count]['ordem']                  = $movimento->ordem;
                                        $return[$count]['creditodebito']          = $movimento->creditodebito;
                                        $return[$count]['Parameters']['id']       = $movimento->Parameters['id'];
                                        $return[$count]['Parameters']['razao']    = $movimento->Parameters['razao'];
                                        $return[$count]['document_types_id']      = $movimento->document_types_id;
                                        $return[$count]['DocumentTypes']['id']    = $movimento->DocumentTypes['id'];
                                        $return[$count]['DocumentTypes']['title'] = $movimento->DocumentTypes['title'];
                                        $return[$count]['event_types_id']         = $movimento->event_types_id;
                                        $return[$count]['EventTypes']['id']       = $movimento->EventTypes['id'];
                                        $return[$count]['EventTypes']['title']    = $movimento->EventTypes['title'];
                                        $return[$count]['valor']                  = $movimento->valor;
                                        $return[$count]['periodo']                = $periodo;

                                        if ($movimento->historico) {
                                            $return[$count]['historico']  = $movimento->historico;
                                        } elseif ($movimento->title) {
                                            $return[$count]['title']      = $movimento->title;
                                        }
                                    
                                        $vencimento = explode("-", $movimento->vencimento);
                                        $return[$count]['vencimento'] = implode('/', array_reverse($vencimento));
                                        
                                        /**************************************/
                                        
                                        if (!empty($movimento->documento)) { 
                                            $return[$count]['documento'] = $movimento->documento;
                                        } else {
                                            $return[$count]['documento'] = "";
                                        }//if (!empty($movimento->documento))
                                        
                                        /**************************************/
                                        
                                        if (!empty($movimento->obs)) {
                                            $return[$count]['obs'] = $movimento->obs;
                                        } else {
                                            $return[$count]['obs'] = "";
                                        }//if (!empty($movimento->obs))
                                        
                                        /**************************************/
                                        
                                        $count++;
                                        
                                    endforeach;
                                    
                                    /******************************************/

                                    //Envio de e-mail com relatório do CRON
                                    $sendMail = ['subject'  => 'SISTEMA R2: Resumo das contas a pagar/receber em atraso',
                                                 'template' => 'cron_mail_atrasados',
                                                 'vars'     => ['moviments' => $return],
                                                 'toEmail'  => $usuario->username
                                                ];

                                    $this->EmailFunctions->sendMail($sendMail);

                                }//if (!empty($movimentos))
                                
                            }//if ($empresa['dtvalidade'] > date('Y-m-d'))
                            
                        endforeach;//foreach($empresas as $empresa)
                        
                    endforeach;//foreach($empusuarios as $empusuario)
                    
                }//if ($usuario['sendmail'] == 'S')
                
            endforeach;//foreach($usuarios as $usuario)

        }//if (date('d') == '01')
        
        //NÃO BUSCA A VIEW
        $this->autoRender = false;
    }

}