<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Knowledges */
/* File: src/Controller/KnowledgesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class KnowledgesController extends AppController
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
        
        $knowledges = $this->Knowledges->find('all')
                                       ->where($where)
                                       ->order(['Knowledges.id']);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $knowledges = $this->paginate($knowledges);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $knowledges = $this->paginate($knowledges);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('knowledges'));
    }
    
    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $knowledge = $this->Knowledges->findById($id)
                                      ->first();
        
        /**********************************************************************/
        
        $this->set(compact('knowledge'));
    }
    
    public function add()
    {
        $knowledge = $this->Knowledges->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $knowledge = $this->Knowledges->patchEntity($knowledge, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Knowledges->save($knowledge)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Knowledges->save($knowledge))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'KnowledgesController->add';
            $this->Error->registerError($knowledge, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
    }
    
    public function edit($id)
    {
        //CONSULTA REGISTRO
        $knowledge = $this->Knowledges->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            $knowledge = $this->Knowledges->patchEntity($knowledge, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Knowledges->save($knowledge)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Knowledges->delete($register))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'KnowledgesController->edit';
            $this->Error->registerError($knowledge, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('knowledge'));
    }

    public function delete($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        $knowledge = $this->Knowledges->get($id);
        
        /**********************************************************************/
        
        //GRAVA LOG
        $this->Log->gravaLog($knowledge, 'delete', 'Knowledges');
        
        /**********************************************************************/
        
        if ($this->Knowledges->delete($knowledge)) {

            $this->Flash->warning(__('Registro excluído com sucesso'));
            return $this->redirect($this->referer());

        }//if ($this->Knowledges->delete($knowledge))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'KnowledgesController->delete';
        $this->Error->registerError($knowledge, $message, true);

        /******************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'Knowledges';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['busca'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['busca'].'%")';
        }
        
        return $where;
    }
}