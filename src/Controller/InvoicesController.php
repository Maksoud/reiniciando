<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Invoices */
/* File: src/Controller/InvoicesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class InvoicesController extends AppController
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
        
        $this->loadComponent('InvoicesFunctions');
        $this->InvoiceItems           = TableRegistry::get('InvoiceItems');
        $this->InvoicesPurchasesSells = TableRegistry::get('InvoicesPurchasesSells');
        $this->Customers              = TableRegistry::get('Customers');
        $this->Providers              = TableRegistry::get('Providers');
        $this->Products               = TableRegistry::get('Products');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $invoices = $this->Invoices->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                   ->select(['Invoices.id', 'Invoices.parameters_id', 'Invoices.nf', 'Invoices.dtemissaonf', 
                                             'Invoices.dtdelivery', 'Invoices.grandtotal', 'Invoices.status', 'Invoices.type', 
                                             'InvoicesPurchasesSells.parameters_id', 'InvoicesPurchasesSells.invoices_id', 
                                             'InvoicesPurchasesSells.purchases_id', 'InvoicesPurchasesSells.sells_id', 
                                             'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 
                                             'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title',
                                             'Purchases.id', 'Purchases.parameters_id', 'Purchases.providers_id', 'Purchases.code', 
                                             'Providers.id', 'Providers.parameters_id', 'Providers.cpfcnpj', 'Providers.title'
                                            ])
                                   ->where($where)
                                   ->contain(['Transporters'])
                                   ->join(['InvoicesPurchasesSells' => ['table'      => 'invoices_purchases_sells',
                                                                        'type'       => 'RIGHT',
                                                                        'conditions' => 'Invoices.id = InvoicesPurchasesSells.invoices_id'
                                                                       ],
                                           'Sells' => ['table'      => 'Sells',
                                                       'type'       => 'LEFT',
                                                       'conditions' => 'Sells.id = InvoicesPurchasesSells.sells_id'
                                                      ],
                                           'Customers' => ['table'      => 'Customers',
                                                           'type'       => 'LEFT',
                                                           'conditions' => 'Customers.id = Sells.customers_id'
                                                          ],
                                           'Purchases' => ['table'      => 'Purchases',
                                                           'type'       => 'LEFT',
                                                           'conditions' => 'Purchases.id = InvoicesPurchasesSells.purchases_id'
                                                          ],
                                           'Providers' => ['table'      => 'Providers',
                                                           'type'       => 'LEFT',
                                                           'conditions' => 'Providers.id = Purchases.providers_id'
                                                          ]
                                          ])
                                   ->order(['Invoices.nf']);
                                   //->limit(200);

        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $invoices = $this->paginate($invoices);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $invoices = $this->paginate($invoices);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('invoices'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/

        $invoice = $this->Invoices->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->select(['Invoices.id', 'Invoices.parameters_id', 'Invoices.transporters_id', 'Invoices.type', 'Invoices.endingdate', 
                                            'Invoices.cfop', 'Invoices.nf', 'Invoices.dtemissaonf', 'Invoices.dtdelivery', 'Invoices.freighttype', 
                                            'Invoices.paymenttype', 'Invoices.grandtotal', 'Invoices.status', 'Invoices.obs', 
                                            'Invoices.totalipi', 'Invoices.totalicms', 'Invoices.totalicmssubst', 'Invoices.totalfreight', 
                                            'Invoices.totaldiscount', 'Invoices.created',  'Invoices.modified',  'Invoices.username', 
                                            'InvoicesPurchasesSells.parameters_id', 'InvoicesPurchasesSells.invoices_id', 
                                            'InvoicesPurchasesSells.purchases_id', 'InvoicesPurchasesSells.sells_id', 
                                            'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 
                                            'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title',
                                            'Purchases.id', 'Purchases.parameters_id', 'Purchases.providers_id', 'Purchases.code', 
                                            'Providers.id', 'Providers.parameters_id', 'Providers.cpfcnpj', 'Providers.title'
                                           ])
                                  ->contain(['Transporters'])
                                  ->join(['InvoicesPurchasesSells' => ['table'      => 'invoices_purchases_sells',
                                                                       'type'       => 'LEFT',
                                                                       'conditions' => 'Invoices.id = InvoicesPurchasesSells.invoices_id'
                                                                      ],
                                          'Sells' => ['table'      => 'Sells',
                                                      'type'       => 'LEFT',
                                                      'conditions' => 'Sells.id = InvoicesPurchasesSells.sells_id'
                                                     ],
                                          'Customers' => ['table'      => 'Customers',
                                                          'type'       => 'LEFT',
                                                          'conditions' => 'Customers.id = Sells.customers_id'
                                                         ],
                                          'Purchases' => ['table'      => 'Purchases',
                                                          'type'       => 'LEFT',
                                                          'conditions' => 'Purchases.id = InvoicesPurchasesSells.purchases_id'
                                                         ],
                                          'Providers' => ['table'      => 'Providers',
                                                          'type'       => 'LEFT',
                                                          'conditions' => 'Providers.id = Purchases.providers_id'
                                                         ]
                                         ])
                                  ->first();

        /**********************************************************************/

        $invoiceItems = $this->InvoiceItems->findByInvoicesIdAndParametersId($invoice->id, $this->request->Session()->read('sessionParameterControl'))
                                           ->contain(['Products']);

        /**********************************************************************/
        
        $this->set(compact('invoice', 'invoiceItems'));
    }

    public function add()
    {
        //Cria nova entidade
        $invoice = $this->Invoices->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //Identifica se é uma nota fiscal de compra ou venda
            if ($this->request->data['type'] == 'C') { //COMPRA
                
                //Remove o sells_id
                unset($this->request->data['sells_id']);

                //Identifica se foi informado um pedido de compra
                if (empty($this->request->data['purchases_id'])) {

                    $this->Flash->error(__('Não é possível gravar uma nota fiscal de compra sem um pedido de compra associado'));
                    return $this->redirect($this->referer());

                }//if (empty($this->request->data['purchases_id']))

            } elseif ($this->request->data['type'] == 'V') { //VENDA
                
                //Remove o purchases_id
                unset($this->request->data['purchases_id']);

                //Identifica se foi informado um pedido de venda
                if (empty($this->request->data['sells_id'])) {

                    $this->Flash->error(__('Não é possível gravar uma nota fiscal de venda sem um pedido de venda associado'));
                    return $this->redirect($this->referer());

                }//if (empty($this->request->data['sells_id']))

            } elseif ($this->request->data['type'] != 'EA' || $this->request->data['type'] != 'SA') { //AVULSO

                //Remove o sells_id e o purchases_id
                unset($this->request->data['sells_id']);
                unset($this->request->data['purchases_id']);

            }//elseif ($this->request->data['type'] != 'EA' || $this->request->data['type'] != 'SA')

            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);
            unset($this->request->data['vlunity']);
            unset($this->request->data['vldiscount']);
            unset($this->request->data['icms']);
            unset($this->request->data['pericms']);
            unset($this->request->data['ipi']);
            unset($this->request->data['peripi']);
            unset($this->request->data['icmssubst']);
            unset($this->request->data['pericmssubst']);
            unset($this->request->data['imobilizado']);

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
            
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $invoice->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $invoice->username      = $this->Auth->user('name');
            $invoice->status        = 'P'; // P - delivering, C - cancelled, F - finalized
            
            /******************************************************************/
            
            if ($this->Invoices->save($invoice)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($invoice, 'add', 'Invoices');

                //ITENS DA VENDA
                $this->InvoicesFunctions->addItems($invoice->id, $productList, $invoice->parameters_id);

                //CASO NÃO SEJA UM LANÇAMENTO AVULSO
                if ($this->request->data['type'] != 'EA' || $this->request->data['type'] != 'SA') {
                    //VINCULA VENDA/COMPRA AO FATURAMENTO
                    $this->InvoicesFunctions->addInvoicesPurchasesSells($invoice);
                }//if ($this->request->data['type'] != 'EA' || $this->request->data['type'] != 'SA')

                //Modifica status do pedido
                $this->InvoicesFunctions->purchasesSells($invoice);

                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Invoices->save($invoice))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'InvoicesController->add';
            $this->Error->registerError($invoice, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];

        $purchases = $this->Invoices->Purchases->find('list', ['keyField'   => 'id',
                                                               'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Providers->title; }
                                                              ])
                                               ->where(['Purchases.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                        'Purchases.status IN' => ['P', 'D', 'E'] // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                                       ])
                                               ->contain(['Providers'])
                                               ->order(['Purchases.code']);
        $this->set('purchases', $purchases);
        
        /**********************************************************************/

        $sells = $this->Invoices->Sells->find('list', ['keyField'   => 'id',
                                                       'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->Customers->title; }
                                                      ])
                                       ->where(['Sells.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                'Sells.status IN' => ['P', 'D', 'E'] // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                               ])
                                       ->contain(['Customers'])
                                       ->order(['Sells.code']);
        $this->set('sells', $sells);
        
        /**********************************************************************/

        $transporters = $this->Invoices->Transporters->find('list')
                                                     ->where(['Transporters.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                                     ->order(['Transporters.title']);
        $transporters = $transporters->select(['id', 'title' => $transporters->func()->concat(['Transporters.title' => 'identifier', 
                                                                                               ' - (',
                                                                                               'Transporters.cpfcnpj' => 'identifier',
                                                                                               ')'
                                                                                              ])
                                              ]);
        $this->set('transporters', $transporters);
        
        /**********************************************************************/

        $products = $this->Products->find('list')
                                   ->where(['Products.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                   ->order(['Products.title']);
        $products = $products->select(['id', 'title' => $products->func()->concat(['Products.code' => 'identifier', 
                                                                                   ' - (',
                                                                                   'Products.title' => 'identifier',
                                                                                   ')'
                                                                                  ])
                                              ]);
        $this->set('products', $products);
    }
    
    public function addjson()
    {
        $mensagem = "Nenhuma requisição foi identificada";
        $status   = "error";
        $errors   = [];
        $id       = null;
        $code     = null;
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /******************************************************************/

            //Identifica se é uma nota fiscal de compra ou venda
            if ($this->request->data['type'] == 'C') { //COMPRA
                
                //Remove o sells_id
                unset($this->request->data['sells_id']);

                //Identifica se foi informado um pedido de compra
                if (empty($this->request->data['purchases_id'])) {

                    $mensagem = 'Não é possível gravar uma nota fiscal de compra sem um pedido de compra associado';
                
                    $this->response->type('json');  
                    $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                    return $this->response;

                }//if (empty($this->request->data['purchases_id']))

            } elseif ($this->request->data['type'] == 'V') { //VENDA
                
                //Remove o purchases_id
                unset($this->request->data['purchases_id']);

                //Identifica se foi informado um pedido de venda
                if (empty($this->request->data['sells_id'])) {

                    $mensagem = 'Não é possível gravar uma nota fiscal de venda sem um pedido de venda associado';

                    $this->response->type('json');  
                    $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                    return $this->response;

                }//if (empty($this->request->data['sells_id']))

            } elseif ($this->request->data['type'] == 'EA' || $this->request->data['type'] == 'SA') { //AVULSO

                //Remove o sells_id e o purchases_id
                unset($this->request->data['sells_id']);
                unset($this->request->data['purchases_id']);

            }//elseif ($this->request->data['type'] == 'EA' || $this->request->data['type'] == 'SA')

            /******************************************************************/

            //LIMPA FORMULÁRIO DE INSERÇÃO DE PRODUTOS
            unset($this->request->data['products_id']);
            unset($this->request->data['unity']);
            unset($this->request->data['quantity']);
            unset($this->request->data['vlunity']);
            unset($this->request->data['vldiscount']);
            unset($this->request->data['icms']);
            unset($this->request->data['pericms']);
            unset($this->request->data['ipi']);
            unset($this->request->data['peripi']);
            unset($this->request->data['icmssubst']);
            unset($this->request->data['pericmssubst']);
            unset($this->request->data['imobilizado']);

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
            $this->request->data['status']        = 'P'; // P - delivering, C - cancelled, F - finalized

            /******************************************************************/
            
            $invoice = $this->Invoices->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/

            if ($this->Invoices->save($invoice)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($invoice, 'add', 'Invoices'); 

                //ITENS DO FATURAMENTO
                $this->InvoicesFunctions->addItems($invoice->id, $productList, $invoice->parameters_id);

                //CASO NÃO SEJA UM LANÇAMENTO AVULSO
                if ($this->request->data['type'] != 'EA' || $this->request->data['type'] != 'SA') {
                    //VINCULA VENDA/COMPRA AO FATURAMENTO
                    $this->InvoicesFunctions->addInvoicesPurchasesSells($invoice);
                }//if ($this->request->data['type'] != 'EA' || $this->request->data['type'] != 'SA')

                //Modifica status do pedido
                $this->InvoicesFunctions->purchasesSells($invoice);

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $invoice->id;
                $code     = $invoice->code;

            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'InvoicesController->addjson';
                $this->Error->registerError($invoice, $message, true);

            }//else if ($this->Invoices->save($invoice))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
        return $this->response;
    }

    public function finish($id)
    {
        //CONSULTA REGISTRO
        $invoice = $this->Invoices->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->first();
        
        /**********************************************************************/

        if ($this->request->is(['patch', 'post', 'put'])) {

            //Define o status para finalizado
            $invoice->status = 'F'; // P - delivering, C - cancelled, F - finalized
            
            /******************************************************************/
            
            $invoice = $this->Invoices->patchEntity($invoice, $this->request->getData());

            /******************************************************************/
            
            if ($this->Invoices->save($invoice)) {

                //Registra o estoque
                $this->InvoicesFunctions->stock($invoice);

                /**************************************************************/

                //Modifica status do pedido
                $this->InvoicesFunctions->purchasesSells($invoice);

                /**************************************************************/
                
                $this->Flash->success(__('Registro finalizado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Invoices->save($invoice))

            /******************************************************************/

            //Alerta de erro
            $message = 'InvoicesController->finish';
            $this->Error->registerError($invoice, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO finalizado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        $this->set(compact('invoice'));

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
        $invoice = $this->Invoices->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                  ->first();
        
        /**********************************************************************/
        
        if (!empty($invoice)) {

            //CANCELA A VENDA
            $invoice->username = $this->Auth->user('name');
            
            /******************************************************************/
                
            $this->Log->gravaLog($invoice, 'deleted', 'Invoices'); //GRAVA LOG
            
            /******************************************************************/
            
            if ($this->Invoices->delete($invoice)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Invoices->delete($invoice))
            
        }//if (empty($invoice))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'InvoicesController->delete';
        $this->Error->registerError($invoice, $message, true);
        
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $invoice = $this->Invoices->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($invoice->status != 'F') { // P - delivering, C - cancelled, F - finalized
                $this->Flash->error(__('Registro NÃO foi cancelado pois não está finalizado'));
                return $this->redirect($this->referer());
            }//if ($invoice->status != 'F')
                
            /******************************************************************/

            //Modifica status do pedido
            $this->InvoicesFunctions->purchasesSells($invoice, true);
            /** Executa função antes de definir o status para que se saiba o status atual */
                
            /******************************************************************/

            //Define o status para cancelado
            $invoice->status = 'C'; // P - delivering, C - cancelled, F - finalized
                
            /******************************************************************/
            
            if ($this->Invoices->save($invoice)) {

                //Registra o estoque
                $this->InvoicesFunctions->stock($invoice, true);

                /**************************************************************/
                
                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Invoices->save($invoice))

            /******************************************************************/

            //Alerta de erro
            $message = 'InvoicesController->cancel';
            $this->Error->registerError($invoice, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }

    public function reopen($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $invoice = $this->Invoices->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($invoice->status != 'C') { // P - delivering, C - cancelled, F - finalized
                $this->Flash->error(__('Registro NÃO foi ativado pois não está cancelado'));
                return $this->redirect($this->referer());
            }//if ($invoice->status != 'C')
                
            /******************************************************************/

            //Define o status para pendente de entrega
            $invoice->status = 'P'; // P - delivering, C - cancelled, F - finalized
                
            /******************************************************************/
            
            if ($this->Invoices->save($invoice)) {

                //Modifica status do pedido
                $this->InvoicesFunctions->purchasesSells($invoice);

                /**************************************************************/
                
                $this->Flash->success(__('Registro ativado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Invoices->save($invoice))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'InvoicesController->reopen';
            $this->Error->registerError($invoice, $message, true);
            
            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO ativado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }
    
    public function report()
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //CHAMA FUNÇÃO PARA CONSULTAS
            $ordenacao = $this->request->data['Ordem'];
            $periodo   = [];

            /******************************************************************/
                
            // MONTAGEM DO SQL
            $conditions = ['Invoices.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

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

            $conditions[] = '(Invoices.dtemissaonf BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';

            /******************************************************************/

            //FILTRA POR STATUS
            if (!empty($this->request->data['status'])) {
                $conditions[] = '(Invoices.status = "' . $this->request->data['status'] . '")';
            }//if (!empty($this->request->data['status']))

            /******************************************************************/

            //FILTRA POR FORNECEDOR
            if (!empty($this->request->data['providers_id'])) {
                $conditions[] = '(Providers.id = "' . $this->request->data['providers_id'] . '")';
            }//if (!empty($this->request->data['providers_id']))

            /******************************************************************/

            //FILTRA POR CLIENTE
            if (!empty($this->request->data['customers_id'])) {
                $conditions[] = '(Customers.id = "' . $this->request->data['customers_id'] . '")';
            }//if (!empty($this->request->data['customers_id']))

            /******************************************************************/

            $fields = ['Invoices.id', 'Invoices.parameters_id', 'Invoices.nf', 'Invoices.dtemissaonf', 
                       'Invoices.dtdelivery', 'Invoices.grandtotal', 'Invoices.status', 'Invoices.type', 
                       'Invoices.freighttype', 'Invoices.totalfreight', 
                       'InvoicesPurchasesSells.parameters_id', 'InvoicesPurchasesSells.invoices_id', 
                       'InvoicesPurchasesSells.purchases_id', 'InvoicesPurchasesSells.sells_id', 
                       'Purchases.id', 'Purchases.parameters_id', 'Purchases.code', 'Purchases.date', 
                       'Purchases.freighttype', 'Purchases.deadline', 'Purchases.grandtotal', 
                       'Purchases.endingdate', 'Purchases.status', 
                       'Providers.id', 'Providers.parameters_id', 'Providers.title', 'Providers.fantasia', 'Providers.cpfcnpj', 
                       'Sells.id', 'Sells.parameters_id', 'Sells.code', 'Sells.date', 'Sells.customercode', 
                       'Sells.freighttype', 'Sells.shipment', 'Sells.deadline', 'Sells.grandtotal', 
                       'Sells.endingdate', 'Sells.status',
                       'Customers.id', 'Customers.parameters_id', 'Customers.title', 'Customers.fantasia', 'Customers.cpfcnpj'
                      ];

            $invoices = $this->Invoices->find('all')
                                       ->select($fields)
                                       ->join(['InvoicesPurchasesSells' => ['table'      => 'invoices_purchases_sells',
                                                                            'type'       => 'RIGHT',
                                                                            'conditions' => 'InvoicesPurchasesSells.invoices_id = Invoices.id'
                                                                           ],
                                               'Purchases' => ['table'      => 'purchases',
                                                               'type'       => 'LEFT',
                                                               'conditions' => 'Purchases.id = InvoicesPurchasesSells.purchases_id'
                                                              ],
                                               'Sells' => ['table'      => 'sells',
                                                           'type'       => 'LEFT',
                                                           'conditions' => 'Sells.id = InvoicesPurchasesSells.sells_id'
                                                          ],
                                               'Providers' => ['table'      => 'providers',
                                                               'type'       => 'LEFT',
                                                               'conditions' => 'Providers.id = Purchases.providers_id'
                                                              ],
                                               'Customers' => ['table'      => 'customers',
                                                               'type'       => 'LEFT',
                                                               'conditions' => 'Customers.id = Sells.customers_id'
                                                              ]
                                               ])
                                       ->where($conditions)
                                       ->order(['Invoices.'.$ordenacao]);
            
            $this->set('invoices', $invoices);

            /******************************************************************/

            //LISTA O ID
            $invoices_id = [];
            foreach ($invoices as $invoice):
                $invoices_id[] = $invoice->id;
            endforeach;

            /******************************************************************/

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

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/Invoices/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Invoices/reports/invoices_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //FORNECEDORES
        $providers = $this->Providers->find('list')
                                     ->select(['Providers.id', 'Providers.title'])
                                     ->where(['Providers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                     ->order(['Providers.title']);
        
        $this->set('providers', $providers);
            
        /******************************************************************/
        
        //CLIENTES
        $customers = $this->Customers->find('list')
                                     ->select(['Customers.id', 'Customers.title'])
                                     ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                     ->order(['Customers.title']);
        
        $this->set('customers', $customers);

    }
    
    public function filter($request)
    {
        $table = 'Invoices';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['nf_search'])) { 
            $where[] = '('.$table.'.nf LIKE "%'.$this->params['nf_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status != "C")'; // P - delivering, C - cancelled, F - finalized
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(Invoices.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//if (isset($this->request->query['query']))
            
            $invoices = $this->Invoices->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                       ->select(['Invoices.id', 'Invoices.title'])
                                       ->where(['Invoices.status NOT IN' => ['C']]) // P - delivering, C - cancelled, F - finalized
                                       ->where($query)
                                       ->order(['Invoices.title']);
            
            $json = [];
            
            foreach ($invoices as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->title
                ]);
            }
            
            echo json_encode($json);
            
        }
        
        $this->autoRender = false;
        die();
    }
}