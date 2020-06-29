<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Industrializations */
/* File: src/Controller/IndustrializationsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class IndustrializationsController extends AppController
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
        
        $this->loadComponent('IndustrializationsFunctions');
        $this->IndustrializationItems = TableRegistry::get('IndustrializationItems');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $industrializations = $this->Industrializations->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.date', 
                                                                 'Industrializations.code', 'Industrializations.status', 'Industrializations.sells_id',
                                                                 'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 
                                                                 'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title', 
                                                                ])
                                                       ->where($where)
                                                       ->join(['Sells' => ['table'      => 'Sells',
                                                                           'type'       => 'LEFT',
                                                                           'conditions' => 'Sells.id = Industrializations.sells_id'
                                                                          ],
                                                               'Customers' => ['table'      => 'Customers',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Customers.id = Sells.customers_id'
                                                                              ]
                                                              ])
                                                       ->order(['Industrializations.code']);
                                                       //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $industrializations = $this->paginate($industrializations);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $industrializations = $this->paginate($industrializations);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('industrializations'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $industrialization = $this->Industrializations->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                      ->select(['Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.created', 
                                                                'Industrializations.code', 'Industrializations.status', 'Industrializations.sells_id',
                                                                'Industrializations.created', 'Industrializations.modified', 'Industrializations.username', 
                                                                'Industrializations.date', 'Industrializations.inspecao', 'Industrializations.databook', 
                                                                'Industrializations.are', 'Industrializations.fichaEmergencia', 'Industrializations.multa', 
                                                                'Industrializations.pit', 'Industrializations.projeto', 'Industrializations.posCura', 
                                                                'Industrializations.fluido', 'Industrializations.certificado', 'Industrializations.temperatura', 
                                                                'Industrializations.duracao', 'Industrializations.instalacao', 'Industrializations.pintura', 
                                                                'Industrializations.localEntrega', 'Industrializations.compraTerceiros', 'Industrializations.resinabq', 
                                                                'Industrializations.catalizadorbq', 'Industrializations.espessurabq', 'Industrializations.resinare', 
                                                                'Industrializations.catalizadorre', 'Industrializations.espessurare', 'Industrializations.emitente', 
                                                                'Industrializations.qualidade', 'Industrializations.autorizacao1', 'Industrializations.autorizacao2', 
                                                                'Industrializations.obs', 
                                                                'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 
                                                                'Sells.deadline', 'Sells.shipment', 
                                                                'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title', 
                                                               ])
                                                      ->join(['Sells' => ['table'      => 'Sells',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'Sells.id = Industrializations.sells_id'
                                                                         ],
                                                              'Customers' => ['table'      => 'Customers',
                                                                              'type'       => 'LEFT',
                                                                              'conditions' => 'Customers.id = Sells.customers_id'
                                                                             ]
                                                             ])
                                                      ->first();
        
        /**********************************************************************/
        
        $this->set(compact('industrialization'));
        
        /**********************************************************************/

        $industrializationItems = $this->IndustrializationItems->findByIndustrializationsIdAndParametersId($industrialization->id, $this->request->Session()->read('sessionParameterControl'))
                                                               ->contain(['Products']);

        $this->set(compact('industrializationItems'));
    }

    public function add()
    {
        $industrialization = $this->Industrializations->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/

            //Identifica se a lista foi preenchida
            if (empty($this->request->data['ProductList'])) {

                $this->Flash->error(__('Não é possível gravar o registro sem itens'));
                return $this->redirect($this->referer());

            }//if (empty($this->request->data['ProductList']))

            //Itens do lançamento
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);
            
            /******************************************************************/
            
            $industrialization = $this->Industrializations->patchEntity($industrialization, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $industrialization->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $industrialization->username      = $this->Auth->user('name');
            $industrialization->status        = 'P'; // P - pending, C - cancelled, F - finalized

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Industrializations->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MAX' => 'MAX(Industrializations.code)'])
                                                 ->first();
            $this->request->data['code'] = $max_code->MAX + 1;
            
            /******************************************************************/
            
            if ($this->Industrializations->save($industrialization)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($industrialization, 'add', 'Industrializations');

                //ITENS DA ORDEM DE FABRICAÇÃO
                $this->IndustrializationsFunctions->addItems($industrialization->id, $productList, $industrialization->parameters_id);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Industrializations->save($industrialization))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'IndustrializationsController->add';
            $this->Error->registerError($industrialization, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $sells = $this->Industrializations->Sells->find('list', ['keyField'   => 'id',
                                                                 'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Customers->title; }
                                                                ])
                                       ->where(['Sells.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                'Sells.status' => 'P' // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                               ])
                                       ->contain(['Customers'])
                                       ->order(['Sells.code']);
        $this->set('sells', $sells);
        
        /**********************************************************************/
        
        $max_code = $this->Industrializations->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                             ->select(['MAX' => 'MAX(Industrializations.code)'])
                                             ->first();
        $code = $max_code->MAX + 1;
        $this->set('code', $code);

    }
    
    public function addjson()
    {
        $mensagem = "Nenhuma requisição foi identificada";
        $status   = "error";
        $errors   = [];
        $id       = null;
        $code    = null;
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //Identifica se a lista foi preenchida
            if (empty($this->request->data['ProductList'])) {

                $mensagem = 'Não é possível gravar o registro sem produtos';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (empty($this->request->data['ProductList']))

            //Itens do lançamento
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);

            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'P'; // P - pending, C - cancelled, F - finalized

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Industrializations->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['MAX' => 'MAX(Industrializations.code)'])
                                                 ->first();
            $this->request->data['code'] = $max_code->MAX + 1;
            
            /******************************************************************/
            
            $industrialization = $this->Industrializations->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/

            if ($this->Industrializations->save($industrialization)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($industrialization, 'add', 'Industrializations');

                //ITENS DA ORDEM DE FABRICAÇÃO
                $this->IndustrializationsFunctions->addItems($industrialization->id, $productList, $industrialization->parameters_id);

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $industrialization->id;
                $code     = $industrialization->code;
                
            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'IndustrializationsController->addjson';
                $this->Error->registerError($industrialization, $message, true);

            }//else if ($this->Industrializations->save($industrialization))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $industrialization = $this->Industrializations->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                      ->first();
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/

            //Identifica se a lista foi preenchida
            if (empty($this->request->data['ProductList'])) {

                $this->Flash->error(__('Não é possível gravar o registro sem itens'));
                return $this->redirect($this->referer());

            }//if (empty($this->request->data['ProductList']))

            //Itens do lançamento
            $productList = $this->request->data['ProductList'];
            unset($this->request->data['ProductList']);
            
            /******************************************************************/
            
            $industrialization = $this->Industrializations->patchEntity($industrialization, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $industrialization->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE USUÁRIO QUE ALTEROU O REGISTRO
            $industrialization->username      = $this->Auth->user('name');
            $industrialization->status        = 'P'; // P - pending, C - cancelled, F - finalized
            
            /******************************************************************/
            
            if ($this->Industrializations->save($industrialization)) {

                //ITENS DA ORDEM DE FABRICAÇÃO
                $this->IndustrializationsFunctions->updateItems($industrialization->id, $productList, $industrialization->parameters_id);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Industrializations->save($industrialization))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'IndustrializationsController->edit';
            $this->Error->registerError($industrialization, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $sells = $this->Industrializations->Sells->find('list', ['keyField'   => 'id',
                                                                 'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Customers->title; }
                                                                ])
                                                 ->where(['Sells.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                          'Sells.status' => 'P' // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                                         ])
                                                 ->contain(['Customers'])
                                                 ->order(['Sells.code']);
        $this->set('sells', $sells);
        
        /**********************************************************************/

        $industrializationItems = $this->IndustrializationItems->findByIndustrializationsIdAndParametersId($industrialization->id, $this->request->Session()->read('sessionParameterControl'))
                                                               ->contain(['Products']);

        $this->set('industrializationItems', $industrializationItems);
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($industrialization->date)) {
            
            $industrialization->date = date("d/m/Y", strtotime($industrialization->date));

        }//if (!empty($industrialization->date))
        
        /**********************************************************************/
        
        $this->set(compact('industrialization'));
    }

    public function finish($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $industrialization = $this->Industrializations->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($industrialization->status != 'P') { // P - pending, C - cancelled, F - finalized

                $this->Flash->error(__('Registro NÃO foi finalizado pois não está pendente'));
                return $this->redirect($this->referer());

            }//if ($industrialization->status != 'P')
                
            /******************************************************************/

            //Define o status para finalizado
            $industrialization->status = 'F'; // P - pending, C - cancelled, F - finalized
                
            /******************************************************************/
            
            if ($this->Industrializations->save($industrialization)) {
                
                $this->Flash->success(__('Registro finalizado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Industrializations->save($industrialization))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'IndustrializationsController->finish';
            $this->Error->registerError($industrialization, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO finalizado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))

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
        
        //CONSULTA REGISTRO PARA GRAVAÇÃO DE LOG E CONSULTA DE MOVIMENTOS
        $industrialization = $this->Industrializations->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                                      ->first();
        
        /**********************************************************************/

        if (!empty($industrialization)) {

            //GRAVA LOG
            $this->Log->gravaLog($industrialization, 'delete', 'Industrializations');
            
            /******************************************************************/
            
            if ($this->Industrializations->delete($industrialization)) {
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Industrializations->delete($industrialization))

        }//if (!empty($industrialization))

        /**********************************************************************/

        //Alerta de erro
        $message = 'IndustrializationsController->delete';
        $this->Error->registerError($industrialization, $message, true);
        
        /**********************************************************************/

        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $industrialization = $this->Industrializations->get($id);

            /******************************************************************/

            //Identifica o status atual do registro
            if ($industrialization->status != 'P') { // P - pending, C - cancelled, F - finalized

                $this->Flash->error(__('Registro NÃO foi cancelado pois não está pendente'));
                return $this->redirect($this->referer());

            }//if ($industrialization->status != 'P')

            /******************************************************************/

            //Define o status para cancelado
            $industrialization->status = 'C'; // P - pending, C - cancelled, F - finalized

            /******************************************************************/

            if ($this->Industrializations->save($industrialization)) {

                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Industrializations->save($industrialization))

            /******************************************************************/

            //Alerta de erro
            $message = 'IndustrializationsController->cancel';
            $this->Error->registerError($industrialization, $message, true);

            /******************************************************************/

            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }
    
    public function report()
    {
        $this->Customers = TableRegistry::get('Customers');

        if ($this->request->is(['patch', 'post', 'put'])) {

            //CHAMA FUNÇÃO PARA CONSULTAS
            $ordenacao = $this->request->data['Ordem'];
            $periodo   = [];

            /******************************************************************/
                
            // MONTAGEM DO SQL
            $conditions = ['Industrializations.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

            /******************************************************************/

            //PERÍODO DE CONSULTA
            if ($this->request->data['dtinicial']) { // datepicker
                $datepicker = explode("/", $this->request->data['dtinicial']);
                $dtinicial = implode('-', array_reverse($datepicker));
            }
            if ($this->request->data['dtfinal']) { // datepicker
                $datepicker = explode("/", $this->request->data['dtfinal']);
                $dtfinal = implode('-', array_reverse($datepicker));
            }

            $conditions[] = '(Industrializations.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';

            /******************************************************************/

            //FILTRA POR STATUS
            if (!empty($this->request->data['status'])) {
                $conditions[] = '(Industrializations.status = "' . $this->request->data['status'] . '")';
            }//if (!empty($this->request->data['status']))

            /******************************************************************/

            $fields = ['Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.sells_id', 
                       'Industrializations.code', 'Industrializations.date', 'Industrializations.penalty', 
                       'Industrializations.inspection', 'Industrializations.databook', 'Industrializations.certificate', 
                       'Industrializations.obs', 'Industrializations.status', 
                       'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 'Sells.customercode', 
                       'Sells.deadline', 'Sells.endingdate', 'Sells.grandtotal', 
                       'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title'
                      ];

            $industrializations = $this->Industrializations->find('all')
                                                           ->select($fields)
                                                           ->join(['Sells' => ['table'      => 'sells',
                                                                               'type'       => 'LEFT',
                                                                               'conditions' => 'Sells.id = Industrializations.sells_id'
                                                                              ],
                                                                   'Customers' => ['table'      => 'customers',
                                                                                   'type'       => 'LEFT',
                                                                                   'conditions' => 'Customers.id = Sells.customers_id'
                                                                                  ]
                                                                  ])
                                                           ->where($conditions)
                                                           ->order(['Industrializations.'.$ordenacao]);

            $this->set('industrializations', $industrializations);

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/Industrializations/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Industrializations/reports/industrializations_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //CLIENTES
        $customers = $this->Customers->find('list')
                                     ->select(['Customers.id', 'Customers.title'])
                                     ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                     ->order(['Customers.title']);
        
        $this->set('customers', $customers);

    }
    
    public function reportFull()
    {
        $this->Customers                 = TableRegistry::get('Customers');
        $this->Providers                 = TableRegistry::get('Providers');
        $this->Purchases                 = TableRegistry::get('Purchases');
        $this->PurchaseItems             = TableRegistry::get('PurchaseItems');
        $this->Sells                     = TableRegistry::get('Sells');
        $this->SellItems                 = TableRegistry::get('SellItems');
        $this->Requisitions              = TableRegistry::get('Requisitions');
        $this->RequisitionItems          = TableRegistry::get('RequisitionItems');
        $this->Invoices                  = TableRegistry::get('Invoices');
        $this->InvoiceItems              = TableRegistry::get('InvoiceItems');
        $this->InvoicesPurchasesSells    = TableRegistry::get('InvoicesPurchasesSells');
        $this->PurchasesPurchaseRequests = TableRegistry::get('PurchasesPurchaseRequests');
        $this->PurchaseRequests          = TableRegistry::get('PurchaseRequests');
        $this->PurchaseRequestItems      = TableRegistry::get('PurchaseRequestItems');
        $this->Products                  = TableRegistry::get('Products');

        if ($this->request->is(['patch', 'post', 'put'])) {
                
            // MONTAGEM DO SQL
            $conditions = ['Industrializations.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

            /******************************************************************/

            
            $conditions[] = 'Industrializations.id = '.$this->request->data['industrializations_id'];

            /******************************************************************/

            //ORDEM DE FABRICAÇÃO
            $industrialization = $this->Industrializations->find('all')
                                                          ->where($conditions)
                                                          ->first();

            $this->set('industrialization', $industrialization);

            /******************************************************************/

            //PEDIDO DE VENDA
            $sell = $this->Sells->find('all')
                                ->where(['Sells.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                         'Sells.id' => $industrialization->sells_id
                                        ])
                                ->first();

            $this->set('sell', $sell);

            //ITENS DOS PEDIDOS DE VENDAS
            $sellItems = $this->SellItems->find('all')
                                         ->select(['SellItems.id', 'SellItems.parameters_id', 'SellItems.sells_id', 
                                                   'SellItems.products_id', 'SellItems.quantity', 'SellItems.unity', 
                                                   'SellItems.imobilizado', 'SellItems.icms', 'SellItems.pericms', 
                                                   'SellItems.icmssubst', 'SellItems.pericmssubst', 'SellItems.vltotal', 
                                                   'SellItems.ipi', 'SellItems.peripi', 'SellItems.vlunity', 'SellItems.vldiscount', 
                                                   'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                  ])
                                         ->join(['Products' => ['table'      => 'products',
                                                                'type'       => 'LEFT',
                                                                'conditions' => 'Products.id = SellItems.products_id'
                                                               ]
                                                ])
                                         ->where(['SellItems.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                  'SellItems.sells_id' => $sell->id
                                                 ]);

            $this->set('sellItems', $sellItems);

            /******************************************************************/

            //CLIENTES
            $customer = $this->Customers->find('all')
                                        ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                 'Customers.id' => $sell->customers_id
                                                ])
                                        ->first();

            $this->set('customer', $customer);

            /******************************************************************/

            //SOLICITAÇÕES DE COMPRAS
            $purchaseRequests = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->where(['PurchaseRequests.industrializations_id' => $industrialization->id,
                                                                'PurchaseRequests.status IN' => ['P', 'A', 'F'] // P - pending, A - in progress, C - cancelled, F - finalized
                                                               ]);

            $this->set('purchaseRequests', $purchaseRequests);

            //Identifica se há solicitações de compras
            if (!empty($purchaseRequests->toArray())) {

                //LISTA O PURCHASE_REQUESTS_ID
                $purchaseRequests_id = [];
                foreach ($purchaseRequests as $purchaseRequest):
                    $purchaseRequests_id[] = $purchaseRequest->id;
                endforeach;

                /**************************************************************/

                if (!empty($purchaseRequests_id)) {

                    //ITENS DAS SOLICITAÇÕES DE COMPRAS
                    $purchaseRequestItems = $this->PurchaseRequestItems->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                    ->select(['PurchaseRequestItems.id', 'PurchaseRequestItems.parameters_id', 'PurchaseRequestItems.purchase_requests_id', 
                                                                                'PurchaseRequestItems.products_id', 'PurchaseRequestItems.quantity', 'PurchaseRequestItems.unity', 
                                                                                'PurchaseRequestItems.deadline', 
                                                                                'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                                                ])
                                                                    ->join(['Products' => ['table'      => 'products',
                                                                                            'type'       => 'LEFT',
                                                                                            'conditions' => 'Products.id = PurchaseRequestItems.products_id'
                                                                                            ]
                                                                            ])
                                                                    ->where(['PurchaseRequestItems.purchase_requests_id IN' => $purchaseRequests_id]);
                                                                            
                    $this->set('purchaseRequestItems', $purchaseRequestItems);

                    /**********************************************************/

                    //Vínculo de pedidos de compras e solicitações de compras
                    $purchasesPurchaseRequests = $this->PurchasesPurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                                ->where(['PurchasesPurchaseRequests.purchase_requests_id IN' => $purchaseRequests_id]);

                    /**********************************************************/

                    if (!empty($purchasesPurchaseRequests->toArray())) {

                        $purchases_id = [];

                        foreach ($purchasesPurchaseRequests as $purchasesPurchaseRequest):
                            //LISTA O PURCHASES_ID
                            $purchases_id[] = $purchasesPurchaseRequest->purchases_id;
                        endforeach;

                    }//if (!empty($purchasesPurchaseRequests->toArray()))

                    /**********************************************************/

                    if (!empty($purchases_id)) {

                        //PEDIDOS DE COMPRAS
                        $purchases = $this->Purchases->find('all')
                                                    ->select(['Purchases.id', 'Purchases.parameters_id', 'Purchases.providers_id', 
                                                              'Purchases.code', 'Purchases.date', 'Purchases.freighttype', 'Purchases.deadline', 
                                                              'Purchases.grandtotal', 'Purchases.totalfreight', 'Purchases.endingdate', 
                                                              'Purchases.status', 'Purchases.obs',
                                                              'Providers.id', 'Providers.parameters_id', 'Providers.title', 'Providers.fantasia', 'Providers.cpfcnpj'
                                                             ])
                                                    ->join(['Providers' => ['table'      => 'providers',
                                                                            'type'       => 'LEFT',
                                                                            'conditions' => 'Providers.id = Purchases.providers_id'
                                                                           ]
                                                            ])
                                                    ->where(['Purchases.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                             'Purchases.id IN' => $purchases_id,
                                                             'Purchases.status IN' => ['P', 'D', 'E', 'F'] // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                                            ]);

                        $this->set('purchases', $purchases);

                        /******************************************************/

                        //Identifica se há compras
                        if (!empty($purchases->toArray())) {

                            //ITENS DOS PEDIDOS DE COMRPAS
                            $purchaseItems = $this->PurchaseItems->find('all')
                                                                 ->select(['PurchaseItems.id', 'PurchaseItems.parameters_id', 'PurchaseItems.purchases_id', 
                                                                           'PurchaseItems.products_id', 'PurchaseItems.quantity', 'PurchaseItems.unity', 
                                                                           'PurchaseItems.imobilizado', 'PurchaseItems.icms', 'PurchaseItems.pericms', 
                                                                           'PurchaseItems.icmssubst', 'PurchaseItems.pericmssubst', 'PurchaseItems.vltotal', 
                                                                           'PurchaseItems.ipi', 'PurchaseItems.peripi', 'PurchaseItems.vlunity', 'PurchaseItems.vldiscount', 
                                                                           'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                                          ])
                                                                 ->join(['Products' => ['table'      => 'products',
                                                                                        'type'       => 'LEFT',
                                                                                        'conditions' => 'Products.id = PurchaseItems.products_id'
                                                                                       ]
                                                                        ])
                                                                 ->where(['PurchaseItems.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                          'PurchaseItems.purchases_id IN' => $purchases_id
                                                                         ]);

                            $this->set('purchaseItems', $purchaseItems);

                        }//if (!empty($purchases->toArray()))

                    }//if (!empty($purchases_id))

                }//if (!empty($purchaseRequests_id))

            }//if (!empty($purchaseRequests->toArray()))

            /******************************************************************/

            //REQUISIÇÕES
            $requisitions = $this->Requisitions->find('all')
                                               ->where(['Requisitions.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                        'Requisitions.industrializations_id' => $industrialization->id,
                                                        'Requisitions.status' => 'F' // F - finalized, C - cancelled
                                                       ]);

            $this->set('requisitions', $requisitions);

            //Identifica se há requisições
            if (!empty($requisitions->toArray())) {

                //LISTA O ID
                $requisitions_id = [];
                foreach ($requisitions as $requisition):
                    $requisitions_id[] = $requisition->id;
                endforeach;

                //ITENS DAS REQUISIÇÕES
                $requisitionItems = $this->RequisitionItems->find('all')
                                                           ->select(['RequisitionItems.id', 'RequisitionItems.parameters_id', 'RequisitionItems.requisitions_id', 
                                                                     'RequisitionItems.products_id', 'RequisitionItems.quantity', 'RequisitionItems.unity', 
                                                                     'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                                    ])
                                                           ->join(['Products' => ['table'      => 'products',
                                                                                  'type'       => 'LEFT',
                                                                                  'conditions' => 'Products.id = RequisitionItems.products_id'
                                                                                 ]
                                                                   ])
                                                           ->where(['RequisitionItems.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                    'RequisitionItems.requisitions_id IN' => $requisitions_id
                                                                   ]);

                $this->set('requisitionItems', $requisitionItems);

            }//if (!empty($requisitions->toArray()))

            /******************************************************************/

            //FATURAMENTOS RELACIONADOS
            $invoicesPurchasesSells = $this->InvoicesPurchasesSells->find('all')
                                                                   ->where(['InvoicesPurchasesSells.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                            'InvoicesPurchasesSells.sells_id' => $sell->id
                                                                           ]);

            //LISTA O ID
            $invoices_id = [];

            if (!empty($invoicesPurchasesSells)) {
                foreach ($invoicesPurchasesSells as $invoicesPurchasesSell):
                    $invoices_id[] = $invoicesPurchasesSell->invoices_id;
                endforeach;
            }//if (!empty($invoicesPurchasesSells))

            /******************************************************************/

            if (!empty($invoices_id)) {

                //FATURAMENTOS
                $invoices = $this->Invoices->find('all')
                                           ->where(['Invoices.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                    'Invoices.id IN' => $invoices_id,
                                                    'Invoices.status IN' => ['P', 'F'] // P - pending, C - cancelled, F - finalized
                                                   ]);

                $this->set('invoices', $invoices);

            }//if (!empty($invoices_id))

            //Identifica se há faturamentos
            if (!empty($invoices) && !empty($invoices->toArray())) {

                //LISTA O ID
                $invoices_id = [];
                foreach ($invoices as $invoice):
                    $invoices_id[] = $invoice->id;
                endforeach;

                //ITENS DOS FATURAMENTOS
                $invoiceItems = $this->InvoiceItems->find('all')
                                                   ->select(['InvoiceItems.id', 'InvoiceItems.parameters_id', 'InvoiceItems.invoices_id', 
                                                             'InvoiceItems.products_id', 'InvoiceItems.quantity', 'InvoiceItems.unity', 
                                                             'InvoiceItems.imobilizado', 'InvoiceItems.icms', 'InvoiceItems.pericms', 
                                                             'InvoiceItems.icmssubst', 'InvoiceItems.pericmssubst', 'InvoiceItems.vltotal', 
                                                             'InvoiceItems.ipi', 'InvoiceItems.peripi', 'InvoiceItems.vlunity', 'InvoiceItems.vldiscount', 
                                                             'Products.id', 'Products.parameters_id', 'Products.code', 'Products.title'
                                                            ])
                                                   ->join(['Products' => ['table'      => 'products',
                                                                          'type'       => 'LEFT',
                                                                          'conditions' => 'Products.id = InvoiceItems.products_id'
                                                                         ]
                                                           ])
                                                   ->where(['InvoiceItems.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                            'InvoiceItems.invoices_id IN' => $invoices_id
                                                           ]);

                $this->set('invoiceItems', $invoiceItems);

            }//if (!empty($invoices->toArray()))

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/Industrializations/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Industrializations/reports/tracker_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //ORDENS DE FABRICAÇÃO
        $industrializations = $this->Industrializations->find('list', ['keyField'   => 'id',
                                                                       'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Sells->Customers->title; }
                                                                      ])
                                                       ->where(['Industrializations.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                                'Industrializations.status IN ' => ['P', 'F'] // P - pending, C - cancelled, F - finalized
                                                               ])
                                                       ->contain(['Sells.Customers'])
                                                       ->order(['Industrializations.code']);
        
        $this->set('industrializations', $industrializations);

    }
    
    public function filter($request)
    {
        $table = 'Industrializations';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['customers_search'])) { 
            $where[] = '(Customers.title LIKE "%'.$this->params['customers_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status = "P")'; // P - pending, C - cancelled, F - finalized
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(Industrializations.code LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $industrializations = $this->Industrializations->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                           ->select(['Industrializations.id', 'Industrializations.code'])
                                                           ->where(['Industrializations.status' => 'P']) // P - pending, C - cancelled, F - finalized
                                                           ->where($query)
                                                           ->order(['Industrializations.code']);
            
            $json = [];
            
            foreach ($industrializations as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->code
                ]);
            }
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}