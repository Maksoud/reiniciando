<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Plannings */
/* File: src/Controller/PlanningsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class PlanningsController extends AppController
{
    public $params = [];
    
    public function prepareParams($request = [])
    {
       if ($request->is('post')) {
            $params = $request->data;
       } else {
            $params = $request->query;
       }
       $this->params = $params;
    }
    
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('Register');
        $this->loadComponent('MovimentsFunctions');
        $this->loadComponent('GeneralBalance');
        $this->loadComponent('RegisterMoviments');
    }
    
    public function index()
    {
        $this->Balances = TableRegistry::get('Balances');
        
        /**********************************************************************/
        
        $balance_planning = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['Balances.id', 'Balances.value', 
                                                     'MAX' => 'MAX(Balances.id)', 'Balances.plannings_id'
                                                    ])
                                           ->where(['Balances.plannings_id IS NOT NULL']);
        
        $this->set(compact('balance_planning'));
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $plannings = $this->Plannings->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($where)
                                     ->contain(['Costs'])
                                     ->order(['Plannings.ordem DESC']);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $plannings = $this->paginate($plannings);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $plannings = $this->paginate($plannings);
            
        }
        
        $this->set(compact('plannings'));
    }
    
    public function indexSimple()
    {
        $this->Balances = TableRegistry::get('Balances');
        
        /**********************************************************************/
        
        $balance_planning = $this->Balances->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['Balances.id', 'Balances.value', 
                                                     'MAX' => 'MAX(Balances.id)', 'Balances.plannings_id'
                                                    ])
                                           ->where(['Balances.plannings_id IS NOT NULL']);
        
        $this->set(compact('balance_planning'));
        
        /**********************************************************************/
        
        //Busca
        $where = $this->filter($this->request);
        
        $plannings = $this->Plannings->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($where)
                                     ->contain(['Costs'])
                                     ->order(['Plannings.ordem DESC']);
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $plannings = $this->paginate($plannings);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $plannings = $this->paginate($plannings);
            
        }
        
        $this->set(compact('plannings'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->Moviments = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        $planning = $this->Plannings->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->contain(['Customers', 'Providers', 'AccountPlans', 'Costs'])
                                    ->first();
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where(['Moviments.plannings_id' => $planning->id]);
        
        /**********************************************************************/
        
        $this->set(compact('planning', 'moviments'));
    }

    public function viewSimple($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->Moviments = TableRegistry::get('Moviments');
        
        /**********************************************************************/
        
        $planning = $this->Plannings->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->contain(['Costs'])
                                    ->first();
        
        /**********************************************************************/
        
        $moviments = $this->Moviments->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where(['Moviments.plannings_id' => $planning->id]);
        
        /**********************************************************************/
        
        $this->set(compact('planning', 'moviments'));
    }

    public function add()
    {
        $planning = $this->Plannings->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->Plannings->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['MAX' => 'MAX(Plannings.ordem)'])
                                     ->first();
            $ordem = $ordem->MAX;
            $this->request->data['ordem'] = $ordem + 1;
            
            /******************************************************************/
            
            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {
            
                $this->request->data['providers_id'] = null;
            
            } elseif ($this->request->data['creditodebito'] == 'D') {
            
                $this->request->data['customers_id'] = null;
            
            }//elseif ($this->request->data['creditodebito'] == 'D')
            
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'A';
            $this->request->data['coins_id'] = '1'; //Campo utilizado na versão 1.0 do sistema
            
            /******************************************************************/
            
            //Preenche a data de vencimento
            if (!$this->request->data['vencimento']) {
                
                $this->request->data['vencimento'] = $this->request->data['data'];
                
            }//if (!$this->request->data['vencimento'])
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            $planning = $this->Plannings->patchEntity($planning, $this->request->getData());
            
            /******************************************************************/
            
            //CRIA FORNECEDOR PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            //$planning->providers_id = $this->Register->addProvider($this->request->data['title'], $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            if ($this->Plannings->save($planning)) {
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('plannings_id', $planning->id, '0.00', $this->request->Session()->read('sessionParameterControl'));
                
                //CRIA NOVO MOVIMENTO COM A DATA DE VENCIMENTO
                $this->RegisterMoviments->moviment_add($planning, $planning->parcelas, $this->request->data['dd']);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Plannings->save($planning))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PlanningsController->add';
            $this->Error->registerError($planning, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
    }

    public function addSimple()
    {
        $planning = $this->Plannings->newEntity();
        
        if ($this->request->is('post')) {

            //VERSÃO SIMPLIFICADA
            $this->request->data['documento']         = null;
            $this->request->data['providers_id']      = null;
            $this->request->data['customers_id']      = null;
            $this->request->data['event_types_id']    = null;
            $this->request->data['document_types_id'] = null;
            $this->request->data['account_plans_id']  = null;
            $this->request->data['cheque']            = null;
            $this->request->data['emissaoch']         = null;
            $this->request->data['nominal']           = null;
            
            /******************************************************************/
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            /******************************************************************/
            
            //DEFINE O VALOR DA ORDEM
            $ordem = $this->Plannings->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->select(['MAX' => 'MAX(Plannings.ordem)'])
                                     ->first();
            $ordem = $ordem->MAX;
            $this->request->data['ordem'] = $ordem + 1;
            
            /******************************************************************/
            
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'A';
            $this->request->data['coins_id'] = '1'; //Campo utilizado na versão 1.0 do sistema
            
            /******************************************************************/
            
            //Preenche a data de vencimento
            if (!$this->request->data['vencimento']) {
                
                $this->request->data['vencimento'] = $this->request->data['data'];
                
            }//if (!$this->request->data['vencimento'])
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            $planning = $this->Plannings->patchEntity($planning, $this->request->getData());
            
            /******************************************************************/
            
            //CRIA FORNECEDOR PARA VÍNCULO FUTURO NO CONTAS A PAGAR
            //$planning->providers_id = $this->Register->addProvider($this->request->data['title'], $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            if ($this->Plannings->save($planning)) {
                
                //CRIA NOVO REGISTRO NA TABELA DE SALDOS
                $this->GeneralBalance->addBalance('plannings_id', $planning->id, '0.00', $this->request->Session()->read('sessionParameterControl'));
                
                //CRIA NOVO MOVIMENTO COM A DATA DE VENCIMENTO
                $this->RegisterMoviments->moviment_add($planning, $planning->parcelas, $this->request->data['dd']);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Plannings->save($planning))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PlanningsController->addSimple';
            $this->Error->registerError($planning, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $planning = $this->Plannings->get($id, ['contain' => ['Customers', 'Providers', 'AccountPlans', 'Costs']]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Controle de preenchimento de Cliente/Fornecedor
            if ($this->request->data['creditodebito'] == 'C') {
                $this->request->data['providers_id'] = null;
            } elseif ($this->request->data['creditodebito'] == 'D') {
                $this->request->data['customers_id'] = null;
            }//elseif ($this->request->data['creditodebito'] == 'D')
            
            /******************************************************************/
            
            //Registra usuário que está realizando alteração no registro
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'A';
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            $planning = $this->Plannings->patchEntity($planning, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Plannings->save($planning)) {
                
                //ATUALIZA O CADASTRO DE FORNECEDOR DO PLANEJAMENTO
                //$this->Register->editProvider($planning);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Plannings->save($planning))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PlanningsController->edit';
            $this->Error->registerError($planning, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('providers', $this->Plannings->Providers->find('list')->where($conditions)->order(['title']));
        $this->set('customers', $this->Plannings->Customers->find('list')->where($conditions)->order(['title']));
        $this->set('costs', $this->Plannings->Costs->find('list')->where($conditions)->order(['title']));
        $accountPlans = $this->Plannings->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                                      ->where($conditions)
                                                      ->order(['AccountPlans.classification']);
        $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                           ' - ', 
                                                                                           'AccountPlans.title' => 'identifier'
                                                                                          ])
                              ]);
        $this->set('accountPlans', $accountPlans->toArray());
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($planning->data)) {
            $planning->data = date('d/m/Y', strtotime($planning->data));
        }
        if (!empty($planning->vencimento)) {
            $planning->vencimento = date('d/m/Y', strtotime($planning->vencimento));
        }
        
        $this->set(compact('planning'));
    }

    public function editSimple($id)
    {
        //CONSULTA REGISTRO
        $planning = $this->Plannings->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            //VERSÃO SIMPLIFICADA
            $this->request->data['documento']         = null;
            $this->request->data['providers_id']      = null;
            $this->request->data['customers_id']      = null;
            $this->request->data['event_types_id']    = null;
            $this->request->data['document_types_id'] = null;
            $this->request->data['account_plans_id']  = null;
            $this->request->data['cheque']            = null;
            $this->request->data['emissaoch']         = null;
            $this->request->data['nominal']           = null;
            
            /******************************************************************/
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }
            
            
            /******************************************************************/
            
            //Registra usuário que está realizando alteração no registro
            $this->request->data['username'] = $this->Auth->user('name');
            $this->request->data['status']   = 'A';
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['valor'] = str_replace($source, $replace, $this->request->data['valor']);
            
            /******************************************************************/
            
            $planning = $this->Plannings->patchEntity($planning, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Plannings->save($planning)) {
                
                //ATUALIZA O CADASTRO DE FORNECEDOR DO PLANEJAMENTO
                //$this->Register->editProvider($planning);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Plannings->save($planning))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PlanningsController->editSimple';
            $this->Error->registerError($planning, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl'), 'status IN' => ['A', 'T']];
        $this->set('costs', $this->Plannings->Costs->find('list')->where($conditions)->order(['title']));
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($planning->data)) {
            $planning->data = date('d/m/Y', strtotime($planning->data));
        }
        if (!empty($planning->vencimento)) {
            $planning->vencimento = date('d/m/Y', strtotime($planning->vencimento));
        }
        
        $this->set(compact('planning'));
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        //VERIFICA SE O PLANEJAMENTO ESTÁ PARCIALMENTE PAGO
        if ($pgto = $this->MovimentsFunctions->consultaPlanejamentos($id, $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Planejamento parcialmente pago. Lançamento(s) '.$pgto));
            return $this->redirect($this->referer());
        }//if ($pgto = $this->MovimentsFunctions->consultaPlanejamentos($id, $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO COMPLETO PARA REGISTRO DE LOG
        $planning = $this->Plannings->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/

        if (!empty($planning)) {

            //Exclui cadastro de fornecedor
            //$this->Register->deleteProvider($planning->providers_id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //Exclui Saldos
            $this->GeneralBalance->deleteBalance('plannings_id', $id, $this->request->Session()->read('sessionParameterControl'));
            
            //Exclui Movimentos
            $this->RegisterMoviments->deleteMoviments('plannings_id', $id, $this->request->Session()->read('sessionParameterControl'));
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($planning, 'delete', 'Plannings');
            
            /******************************************************************/
            
            if ($this->Plannings->delete($planning)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Plannings->delete($planning))

        }//if (!empty($planning))
            
        /**********************************************************************/
        
        //Alerta de erro
        $message = 'PlanningsController->delete';
        $this->Error->registerError($planning, $message, true);
            
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Plannings';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].'%")';
        }
        
        if (!empty($this->params['ordem_search'])) { 
            $where[] = '('.$table.'.ordem = "'.intval($this->params['ordem_search']).'")';
        }
        
        if (!empty($this->params['valor_search'])) { 
            $this->params['valor_search'] = str_replace(".", "", $this->params['valor_search']);
            $this->params['valor_search'] = str_replace(",", ".", $this->params['valor_search']);
            $where[] = '('.$table.'.valor = "'.$this->params['valor_search'].'")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        }
        
        if (!empty($this->params['mes_search'])) { 
            $where[] = '('.'MONTH('.$table.'.data) = "'.intval($this->params['mes_search']).'")'; 
        }
        
        if (!empty($this->params['ano_search'])) { 
            $where[] = '('.'YEAR('.$table.'.data) = "'.intval($this->params['ano_search']).'")'; 
        }
        
        return $where;
    }
    
    public function reportForm()
    {
        //Precisa ser desenvolvido 21/05/2018
    }
    
}