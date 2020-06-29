<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Payments */
/* File: src/Controller/PaymentsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class PaymentsController extends AppController
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
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super' && 
                $this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'especial') {

            $where[] = 'Payments.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');

        }
        
        /**********************************************************************/
        
        $payments = $this->Payments->find('all')
                                   ->select(['Payments.id', 'Payments.parameters_id', 'Payments.vencimento', 
                                             'Payments.periodo', 'Payments.valor', 'Payments.status',
                                             'Payments.created', 'Payments.modified',
                                             'Parameters.id', 'Parameters.razao', 'Parameters.email_cobranca', 
                                             'Parameters.plans_id', 'Parameters.dtvalidade'
                                            ])
                                   ->join(['Parameters' => ['table'      => 'parameters',
                                                            'type'       => 'LEFT',
                                                            'conditions' => ['Payments.parameters_id = Parameters.id']
                                                           ]
                                          ])
                                   ->where($where)
                                   ->order(['Payments.parameters_id']);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $payments = $this->paginate($payments);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $payments = $this->paginate($payments);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('payments'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $payment = $this->Payments->findById($id)
                                  ->select(['Payments.id', 'Payments.parameters_id', 'Payments.vencimento', 
                                            'Payments.periodo', 'Payments.valor', 'Payments.status',
                                            'Payments.created', 'Payments.modified',
                                            'Parameters.id', 'Parameters.razao', 'Parameters.email_cobranca', 
                                            'Parameters.plans_id', 'Parameters.dtvalidade'
                                           ])
                                  ->join(['Parameters' => ['table'      => 'parameters',
                                                           'type'       => 'LEFT',
                                                           'conditions' => ['Payments.parameters_id = Parameters.id']
                                                          ]
                                         ])
                                  ->first();
        
        /**********************************************************************/
        
        $this->set(compact('payment'));
    }

    public function add()
    {
        $this->Parameters = TableRegistry::get('Parameters');
        
        $payment = $this->Payments->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $this->request->data['status'] = 'A';
            
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            
            /******************************************************************/

            if ($this->Payments->save($payment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Payments->save($payment))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PaymentsController->add';
            $this->Error->registerError($payment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        /**********************************************************************/
        
        $parameters = $this->Parameters->find('list')
                                       ->select(['Parameters.id', 'Parameters.razao'])
                                       ->order(['Parameters.razao']);
        
        $this->set(compact('parameters'));
        
        /**********************************************************************/
        
        $mensalidades = $this->Parameters->find('all')
                                         ->select(['Parameters.id', 'Parameters.razao', 'Parameters.mensalidade', 'Parameters.dtvalidade', 'Parameters.periodo_ativacao'])
                                         ->order(['Parameters.razao']);
        
        $this->set(compact('mensalidades'));
    }

    public function edit($id)
    {
        $this->Parameters = TableRegistry::get('Parameters');
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO
        $payment = $this->Payments->get($id);
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Payments->save($this->request->data)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Payments->save($this->request->data))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PaymentsController->edit';
            $this->Error->registerError($payment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        $parameters = $this->Parameters->find('list')
                                       ->select(['Parameters.id', 'Parameters.razao'])
                                       ->order(['Parameters.razao']);
        
        $this->set(compact('parameters'));
        
        /**********************************************************************/
        
        $mensalidades = $this->Parameters->find('all')
                                         ->select(['Parameters.id', 'Parameters.razao', 'Parameters.mensalidade', 'Parameters.dtvalidade', 'Parameters.periodo_ativacao'])
                                         ->order(['Parameters.razao']);
        
        $this->set(compact('mensalidades'));
        
        /**********************************************************************/
        
        if (!empty($payment->vencimento)) {
            $payment->vencimento = date("d/m/Y", strtotime($payment->vencimento));
        }
        
        /**********************************************************************/
        
        $this->set(compact('payment'));
    }
    
    public function low($id)
    {
        $this->Parameters = TableRegistry::get('Parameters');
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO
        $payment = $this->Payments->get($id);
        
        /**********************************************************************/
        
        $parameter = $this->Parameters->find('all')
                                      ->select(['Parameters.id', 'Parameters.dtvalidade'])
                                      ->where(['Parameters.id' => $payment->parameters_id])
                                      ->first();
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $this->request->data['status'] = 'B';
            
            //CALCULA A PRÓXIMA VALIDADE
            $dtvalidade = date("Y-m-d", strtotime("+" . $payment->periodo . " month", strtotime($parameter->dtvalidade)));
            
            $parameter->dtvalidade = $dtvalidade;
            
            /******************************************************************/
            
            //Atualiza Vencimento do Sistema
            if (!$this->Parameters->save($parameter)) {

                //Alerta de erro
                $message = 'PaymentsController->low, Parameters';
                $this->Error->registerError($parameter, $message, true);

            }//if (!$this->Parameters->save($parameter))
            
            /******************************************************************/
            
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            
            /******************************************************************/
            
            $payment->id               = $parameter->id;
            $payment->dtvalidade       = $dtvalidade;
            $payment->mensalidade      = $payment->valor / $payment->periodo;
            $payment->periodo_ativacao = $payment->periodo;
            
            /******************************************************************/
            
            if ($this->Payments->save($payment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Payments->save($payment))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PaymentsController->low';
            $this->Error->registerError($payment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
        }
    }
    
    public function renew($id)
    {
        //CONSULTA REGISTRO
        $payment = $this->Payments->get($id);
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            
            /******************************************************************/
            
            //Abre a fatura cancelada
            $payment->status = 'A';
            
            /******************************************************************/
            
            if ($this->Payments->save($payment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Payments->save($payment))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PaymentsController->renew';
            $this->Error->registerError($payment, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
        }
    }
    
    public function cancel($id)
    {
        $this->Parameters = TableRegistry::get('Parameters');
        
        /**********************************************************************/
            
        //CONSULTA REGISTRO
        $payment = $this->Payments->get($id);
        
        /**********************************************************************/
        
        //ATUALIZA VALIDADE DO SISTEMA
        $parameter = $this->Parameters->find('all')
                                      ->select(['Parameters.id', 'Parameters.dtvalidade'])
                                      ->where(['Parameters.id' => $payment->parameters_id])
                                      ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //CALCULA A PRÓXIMA VALIDADE
            $dtvalidade = date("Y-m-d", strtotime("-" . $payment->periodo . " month", strtotime($parameter->dtvalidade)));
            
            $parameter->dtvalidade = $dtvalidade;
            
            /******************************************************************/
            
            //Atualiza Vencimento do Sistema
            if (!$this->Parameters->save($parameter)) {

                //Alerta de erro
                $message = 'PaymentsController->cancel, Parameters';
                $this->Error->registerError($parameter, $message, true);

            }//if (!$this->Parameters->save($parameter))
            
            /******************************************************************/
            
            $payment = $this->Payments->patchEntity($payment, $this->request->getData());
            
            /******************************************************************/
            
            //Cancela o Pagamento
            $payment->status = 'C';
            
            /******************************************************************/
            
            if ($this->Payments->save($payment)) {

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Payments->save($payment))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PaymentsController->cancel';
            $this->Error->registerError($payment, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('O registro NÃO foi gravado. Por favor, tente novamente'));
            return $this->redirect($this->referer());
        }
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('especial', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        //CONSULTA REGISTRO COMPLETO PARA REGISTRO DE LOG
        $payment = $this->Payments->get($id);
        
        /**********************************************************************/

        if (!empty($payment)) {

            if ($this->Payments->delete($payment)) {
            
                //GRAVA LOG
                $this->gravaLog($payment, 'delete', 'Payments');
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Payments->delete($payment))

        }//if (!empty($payment))
            
        /******************************************************************/

        //Alerta de erro
        $message = 'PaymentsController->delete';
        $this->Error->registerError($payment, $message, true);
            
        /******************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Payments';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['busca'])) { 
            $where[] = '('.'Parameters.razao LIKE "%'.$this->params['busca'].'%")';
        }
        
        if (!empty($this->params['valor'])) { 
            $this->params['valor'] = str_replace(".", "", $this->params['valor']);
            $this->params['valor'] = str_replace(",", ".", $this->params['valor']);
            $where[] = '('.$table.'.valor = "'.$this->params['valor'].'")';
        }
        
        if (!empty($this->params['mes'])) { 
            $where[] = '('.'MONTH('.$table.'.vencimento) = "'.intval($this->params['mes']).'")'; 
        }
        
        if (!empty($this->params['ano'])) { 
            $where[] = '('.'YEAR('.$table.'.vencimento) = "'.intval($this->params['ano']).'")'; 
        }
        
        return $where;
    }
}