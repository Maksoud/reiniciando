<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* AccountPlans */
/* File: src/Controller/AccountPlansController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

class AccountPlansController extends AppController
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
        
        $accountPlans = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where($where)
                                           ->order(['AccountPlans.classification']);
                                           //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $accountPlans = $this->paginate($accountPlans);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $accountPlans = $this->paginate($accountPlans);
            
        }
        
        /**********************************************************************/
        
        $plangroups = $this->AccountPlans->find('threaded')
                                         ->where(['AccountPlans.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                  'AccountPlans.status IN'     => ['A']
                                                 ]);
        
        /**********************************************************************/
        
        $this->set(compact('accountPlans', 'plangroups'));
        
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $accountPlan = $this->AccountPlans->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        /**********************************************************************/
        
        $plangroups = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'));
        
        /**********************************************************************/
        
        $this->set(compact('accountPlan', 'plangroups'));
    }
    
    public function new_classification($plangroup)
    {
        $classifications = $this->AccountPlans->findByPlangroup($plangroup)
                                              ->order(['AccountPlans.classification']);
        
        $new_classification = '';
        
        //POSSUI SUBGRUPOS?
        if (!empty($classifications->toArray())) {
            
            foreach ($classifications as $classification):
                $part_classification = explode('.', $classification->classification);
            endforeach;
            
            $count = 0;
            
            while($count < count($part_classification) - 1) {
                
                $new_classification .= $part_classification[$count] . '.';
                $count++;
                
            }
            
            $value = ($part_classification[count($part_classification) - 1] + 1);
            
            if ($value < 10) {
                
                $new_classification .= '0' . ($part_classification[count($part_classification) - 1] + 1);
                
            } else {
                
                $new_classification .= ($part_classification[count($part_classification) - 1] + 1);
                
            }
            
        } else {
            
            $classifications = $this->AccountPlans->findById($plangroup)
                                                  ->order(['AccountPlans.classification']);
            
            if (!empty($classifications->toArray())) {
                
                foreach ($classifications as $classification):
                    $part_classification = explode('.', $classification->classification);
                endforeach;
                
                $count = 0;
                
                while($count < count($part_classification)) {
                    $new_classification .= $part_classification[$count] . '.';
                    $count++;
                }
                
                $new_classification .= '01';
                
            } else {
                
                $new_classification = '01';
                
            }
        }
        return $new_classification;
    }
    
    public function add()
    {
        $accountPlan = $this->AccountPlans->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //Consulta TITLE para evitar duplicidade
            $duplicidade = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                              ->select(['title'])
                                              ->where(['AccountPlans.title' => $this->request->data['title']]);
            
            if (!empty($duplicidade->toArray())) {
                $this->Flash->warning(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }
            
            /******************************************************************/
            
            $accountPlan = $this->AccountPlans->patchEntity($accountPlan, $this->request->getData());
            
            /******************************************************************/
            
            //DEFININDO A CLASSIFICAÇÃO DENTRO DO REQUEST
            $accountPlan->classification = $this->new_classification($this->request->data['plangroup']);
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $accountPlan->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $accountPlan->username      = $this->Auth->user('name');
            $accountPlan->status        = 'A';
            
            /******************************************************************/
            
            if ($this->AccountPlans->save($accountPlan)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->AccountPlans->save($accountPlan))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'AccountPlansController->add';
            $this->Error->registerError($accountPlan, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $accountPlans = $this->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                           ->where(['parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                           ->order(['AccountPlans.classification']);
        $plangroups = $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                                           ' - ', 
                                                                                                           'AccountPlans.title' => 'identifier'
                                                                                                          ])
                                        ]);
        
        $this->set(compact('plangroups'));
    }
    
    public function addjson()
    {
        $mensagem = "Nenhuma requisição foi identificada";
        $status   = "error";
        $errors   = [];
        $id       = null;
        $title    = null;
        $classification = null;
        
        if ($this->request->is('post')) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'A';
            
            //DEFININDO A CLASSIFICAÇÃO DENTRO DO REQUEST
            $this->request->data['classification'] = $this->new_classification($this->request->data['plangroup']);
            
            /******************************************************************/
            
            $accountPlan = $this->AccountPlans->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/
            
            if ($this->AccountPlans->save($accountPlan)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($accountPlan, 'add', 'AccountPlans');
                
                $mensagem = __('Registro gravado com sucesso');
                $status   = 'ok';
                $id       = $accountPlan->id;
                $title    = $accountPlan->title;
                $classification = $accountPlan->classification;
                
            } else {

                $mensagem = __('Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente');
        
                //Alerta de erro
                $message = 'AccountPlansController->addjson';
                $this->Error->registerError($accountPlan, $message, true);

            }//if ($this->AccountPlans->save($accountPlan))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'title', 'classification')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $accountPlan = $this->AccountPlans->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/
            
            //IDENTIFICA DUPLICIDADE DA ORDEM
            $duplicated_classification = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                            ->select(['AccountPlans.id', 'AccountPlans.classification'])
                                                            ->where(['AccountPlans.id !=' => $id,
                                                                     'AccountPlans.classification' => $this->request->data['classification']
                                                                    ]);
            if (!empty($duplicated_classification->toArray())) {
                $this->Flash->error(__('Registro com descrição já cadastrada'));
                return $this->redirect($this->referer());
            }//if (!empty($duplicated_classification->toArray()))
            
            /******************************************************************/
            
            //REATIVA REGISTRO INATIVO
            if ($accountPlan['status'] == 'I') { $this->request->data['status'] = 'A'; }
            
            /******************************************************************/
            
            $accountPlan = $this->AccountPlans->patchEntity($accountPlan, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $accountPlan->username = $this->Auth->user('name');
            
            /******************************************************************/
            
            if ($this->AccountPlans->save($accountPlan)) {
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->AccountPlans->save($accountPlan))

            /******************************************************************/

            //Alerta de erro
            $message = 'AccountPlansController->edit';
            $this->Error->registerError($accountPlan, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
        }
        
        $this->set(compact('accountPlan'));
        
        $accountPlans = $this->AccountPlans->find('list', ['keyField'   => 'id', 'valueField' => 'dropdown_accounts'])
                                           ->where(['parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                           ->order(['AccountPlans.classification']);
        $plangroups = $accountPlans->select(['id', 'dropdown_accounts' => $accountPlans->func()->concat(['AccountPlans.classification' => 'identifier', 
                                                                                                         ' - ', 
                                                                                                         'AccountPlans.title' => 'identifier'
                                                                                                        ])
                                            ]);
        
        $this->set(compact('plangroups'));
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
        
        //CONSULTA REGISTRO
        $accountPlan = $this->AccountPlans->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                          ->first();
        
        /**********************************************************************/

        if (!empty($accountPlan)) {

            //VERIFICA SE O CADASTRO ESTÁ EM USO NOS MOVIMENTOS
            if ($vinc_moviments = $this->consultaMovimentos($id, 'account_plans_id')) {
                
                if ($accountPlan->status != 'I') {
                    
                    $accountPlan->title    = $accountPlan->title.' (INATIVO)';
                    $accountPlan->username = $this->Auth->user('name');
                    $accountPlan->status   = 'I';
                    
                    if ($this->AccountPlans->save($accountPlan)) {
                        
                        $this->Log->gravaLog($accountPlan, 'inativate', 'AccountPlans'); //GRAVA LOG
                        
                        $this->Flash->warning(__('Registro inativado. Não pode ser excluído devido a movimentos vinculados'));
                        return $this->redirect($this->referer());
                        
                    } else {

                        //Alerta de erro
                        $message = 'AccountPlansController->delete, inativate';
                        $this->Error->registerError($accountPlan, $message, true);
                        
                        $this->Flash->error(__('Desculpe, ocorreu um erro. Por favor, tente novamente'));
                        return $this->redirect($this->referer());
                        
                    }//else if ($this->AccountPlans->save($accountPlan))
                    
                } else {

                    //Alerta de erro
                    $message = 'AccountPlansController->delete, inativated';
                    $this->Error->registerError(null, $message, true);

                    /**********************************************************/
                    
                    $this->Flash->warning(__('Registro inativo. Há movimentos vinculados em ').$vinc_moviments);
                    return $this->redirect($this->referer());
                    
                }//else if ($accountPlan->status != 'I')
                
            }//if ($vinc_moviments = $this->consultaMovimentos($id, 'account_plans_id'))
            
            /******************************************************************/
            
            //GRAVA LOG
            $this->Log->gravaLog($accountPlan, 'delete', 'AccountPlans');
            
            /******************************************************************/
            
            if ($this->AccountPlans->delete($accountPlan)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->AccountPlans->delete($accountPlan))

        }//if (!empty($accountPlan))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'AccountPlansController->delete';
        $this->Error->registerError($accountPlan, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }
    
    public function filter($request)
    {
        $table = 'AccountPlans';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['title_search'])) { 
            $where[] = '('.$table.'.title LIKE "%'.$this->params['title_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status = "A")';
        }
        
        return $where;
    }
    
    public function listPlans()
    {
        $accountPlans = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->select(['AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification', 
                                                     'AccountPlans.status', 'AccountPlans.plangroup'
                                                    ])
                                           ->where(['AccountPlans.status IN' => ['A', 'C']])
                                           ->order(['AccountPlans.classification']);
         
		//$this->set(compact('accountPlans'));
		
		$plansList   = '[';
		$lenght = 0;
		
		foreach($accountPlans as $accountPlan):
			
			//Identifica o tamanho do classification, através da contagem dos pontos
			$lenght_classification = substr_count($accountPlan->classification, ".");
			
			//Se o lenght for menor que o tamanho do classification
			if ($lenght < $lenght_classification) {
				
				//O lenght receberá o mesmo valor
				$lenght = $lenght_classification;
				
				//Remove a última } e adiciona uma ,
				$plansList = substr_replace($plansList, ',', -2);
				
				//Adiciona o nodes para as dependências
				$plansList .= ' nodes: [';
				
			} 
			//Se o lenght for maior que o tamanho do classification
			elseif ($lenght > $lenght_classification) {
				
				//Remove a última vírgula
				$plansList = substr_replace($plansList, '', -1);
				
				//Adiciona o fechamento dos nodes
				$i = 0;
				while ($i < $lenght - $lenght_classification) { //Fechamento leva em conta a diferença entre os níveis
					
					$i++;
					$plansList .= ']}';
					
				}//while ($i < $lenght)
				
				//Adiciona a vírgula ao final
				$plansList .= ',';
				
				//O lenght receberá o mesmo valor
				$lenght = $lenght_classification;
				
			}
			
			//Adiciona o texto 
			$plansList .= '{ text: "'.$accountPlan->classification . ' - ' . $accountPlan->title.'" },';
			
		endforeach;
		
		//Remove a última vírgula
		$plansList = substr_replace($plansList, '', -1);
		
		//Adiciona o último fechamento
		$plansList .= ']';
		
		//Adiciona o fechamento dos nodes
		$i = 0;
		while ($i < $lenght) {
			
			$i++;
			$plansList .= '}]';
			
		}//while ($i < $lenght)
		
		$this->set('plansList', $plansList);
		
		/*
		<table>
			<ul>
			<php 
				$lenght = 0;

				foreach($accountPlans as $accountPlan):

					$times = substr_count($accountPlan->classification, ".");

					if ($lenght < $times) {
						$lenght = $times;
						echo '<ul>';
					} elseif ($lenght > $times) {
						$lenght = $times;
						echo '</ul>';
					}

					echo '<li>' . $accountPlan->classification . ' - ' . $accountPlan->title . '</li>';

				endforeach;
			?>
			</ul>
		</table>
		*/
		
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(AccountPlans.title LIKE "%'.$this->request->query['query'].'%"'.
                           'OR AccountPlans.classification LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $accountPlans = $this->AccountPlans->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                               ->select(['AccountPlans.id', 'AccountPlans.title', 'AccountPlans.classification'])
                                               ->where(['AccountPlans.status IN' => ['A', 'T']])
                                               ->where($query)
                                               ->order(['AccountPlans.classification']);
            
            $json = [];
            
            foreach ($accountPlans as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->classification.' - '.$data->title
                ]);
            }
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}