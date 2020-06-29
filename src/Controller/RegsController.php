<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Regs */
/* File: src/Controller/RegsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;

class RegsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }
    
    public function index()
    {
        /* EXCLUIR SELECIONADOS */
        if ($this->request->is('post')) {
            
            //Atribui request a variável
            $request = $this->request->data;
            
            //Verifica se algum item foi selecionado
            if (!isset($request['record']) || !count($request['record'])) {
                $this->Flash->warning(__('Nenhum registro selecionado'));
                return $this->redirect($this->referer(), null, true);
            }//if (!isset($request['record']) || !count($request['record']))
            
            if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
                
                $regs = $this->Regs->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                   ->where(['id IN' => $request['record']]);
                
                if ($this->Regs->deleteAll(['Regs.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                            'Regs.id IN'         => $request['record']
                                           ])) {
                    
                    $this->Flash->success(__(count($request['record']).' Registros excluídos com sucesso'));
                    return $this->redirect($this->referer());
                }
                
            } else {
                
                if ($this->Regs->deleteAll(['Regs.id IN' => $request['record']])) {
                    $this->Flash->success(__(count($request['record']).' Registros excluídos com sucesso'));
                    return $this->redirect($this->referer());
                }//if ($this->Regs->deleteAll(['Regs.id IN' => $request['record']]))
                
            }//else if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
            
            $this->Flash->error(__(count($request['record']).' Registros NÃO excluídos, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        
        /**********************************************************************/
        
        if (isset($this->request->query['radio_search'])) { 
            
            if (!empty($this->request->query['search'])) {
                unset($this->request->query['search']);
                $this->request->params['named']['page'] = 1;
            }//if (!empty($this->request->query['search']))
            
            $this->filter($this->request->query);
            
        } else {
            
            $where = [];
            
            if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
            
                $where[] = 'Regs.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');

            }//if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
            
            $regs = $this->Regs->find('all')
                               ->where($where)
                               ->contain(['Parameters'])
                               ->order(['Regs.created DESC']);
                               //->limit(200);
        
            $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
            $this->paginate = ['page' => $page, 'limit' => '10'];

            try {

                $regs = $this->paginate($regs);

            } catch (NotFoundException $e) {

                $this->paginate = ['page' => $page-1, 'limit' => '10'];
                $regs = $this->paginate($regs);

            }
            
            $this->set(compact('regs'));
            
        }
        
    }

    public function view($id = null)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $where = [];
        
        /**********************************************************************/
            
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {

            $where[] = 'Regs.parameters_id = ' . $this->request->Session()->read('sessionParameterControl');

        }//if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
        
        /**********************************************************************/
        
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) == 'super') {
            $reg = $this->Regs->findById($id)->first();
        } else {
            $reg = $this->Regs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))->first();
        }
        
        /**********************************************************************/
        
        $this->set(compact('reg'));
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('delete', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super') {
            
            $reg = $this->Regs->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                              ->first();
            
        } else {

            $reg = $this->Regs->findById($id)
                              ->first();

        }//else if ($this->SystemFunctions->GETuserRules($this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')) != 'super')
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/

        if (!empty($reg)) {

            //GRAVA LOG
            $this->Log->gravaLog($reg, 'delete', 'Regs');
            
            /******************************************************************/
            
            if ($this->Regs->delete($reg)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Regs->delete($reg))

        }//if (!empty($reg))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'RegsController->delete';
        $this->Error->registerError($reg, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request = null)
    {
        $table = 'Regs';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['busca'])) { 
            $data = explode("/", $this->params['busca']);
            $this->params['busca'] = implode('-', array_reverse($data));
            
            $where[] = '('.$table . '.created LIKE = "%' . $this->params['busca'] . '%")';
        }//if (!empty($this->params['busca']))
        
        if (!empty($this->params['log_type'])) { 
            if ($this->params['log_type'] == 'Login') {       $this->params['log_type'] = "login"; }
            if ($this->params['log_type'] == 'Edição') {      $this->params['log_type'] = "edit"; }
            if ($this->params['log_type'] == 'Cancelamento') {$this->params['log_type'] = "cancel"; }
            if ($this->params['log_type'] == 'Exclusão') {    $this->params['log_type'] = "delete"; }
            
            $where[] = '('.$table . '.log_type LIKE = "%' . $this->params['log_type'] . '%")';
        }//if (!empty($this->params['log_type']))
        
        if (!empty($this->params['reftable'])) { 
            switch ($this->params['reftable']) {
                case 'Acesso ao Sistema':
                    $this->params['reftable'] = "Login";
                break;
                case 'Lançamentos Financeiros':
                    $this->params['reftable'] = "Moviments";
                break;
                case 'Transferências':
                    $this->params['reftable'] = "Transfers";
                break;
                case 'Lançamentos de Bancos':
                    $this->params['reftable'] = "MovimentBanks";
                break;
                case 'Lançamentos de Caixas':
                    $this->params['reftable'] = "MovimentBoxes";
                break;
                case 'Lançamentos de Cartões':
                    $this->params['reftable'] = "MovimentCards";
                break;
                case 'Bancos':
                    $this->params['reftable'] = "Banks";
                break;
                case 'Caixas':
                    $this->params['reftable'] = "Boxes";
                break;
                case 'Cartões':
                    $this->params['reftable'] = "Cards";
                break;
                case 'Centros de Custos':
                    $this->params['reftable'] = "Costs";
                break;
                case 'Clientes':
                    $this->params['reftable'] = "Customers";
                break;
                case 'Tipos de Documentos':
                    $this->params['reftable'] = "DocumentTypes";
                break;
                case 'Tipos de Eventos':
                    $this->params['reftable'] = "EventTypes";
                break;
                case 'Fornecedores':
                    $this->params['reftable'] = "Providers";
                break;
                case 'Suporte':
                    $this->params['reftable'] = "SupportContacts";
                break;
                case 'Transportadoras':
                    $this->params['reftable'] = "Transporters";
                break;
                case 'Usuários':
                    $this->params['reftable'] = "Users";
                break;
                case 'Parâmetros de Sistema':
                    $this->params['reftable'] = "UsersParameters";
                break;
            }//switch ($this->params['reftable'])
            
            $where[] = '('.$table . '.reftable LIKE = "%' . $this->params['reftable'] . '%")';
        }//if (!empty($this->params['reftable']))
        
        if (!empty($this->params['username'])) { 
            $where[] = '('.$table . '.username LIKE = "%' . $this->params['username'] . '%")';
        }//if (!empty($this->params['username']))
        
        return $where;
    }
}