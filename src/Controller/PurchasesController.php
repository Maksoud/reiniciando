<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Purchases */
/* File: src/Controller/PurchasesController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class PurchasesController extends AppController
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
        
        $this->loadComponent('PurchasesFunctions');
        $this->loadComponent('PurchaseRequestsFunctions');
        $this->PurchaseRequests          = TableRegistry::get('PurchaseRequests');
        $this->PurchaseItems             = TableRegistry::get('PurchaseItems');
        $this->Invoices                  = TableRegistry::get('Invoices');
        $this->InvoicesPurchasesSells    = TableRegistry::get('InvoicesPurchasesSells');
        $this->PurchasesPurchaseRequests = TableRegistry::get('PurchasesPurchaseRequests');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $purchases = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                     ->where($where)
                                     ->contain(['Providers'])//, 'PurchaseRequests'
                                     ->order(['Purchases.code']);
                                     //->limit(200);

        /**********************************************************************/

        //Lista de vínculos
        $purchases_list = [];
        $purchaseRequests_list = [];

        //Lista pedidos de compras
        foreach ($purchases as $purchase):

            //Armazena os id's dos pedidos de compras
            $purchases_list[] = $purchase->id;

            //Lista de vínculos de solicitações de compras
            $array = $this->PurchasesFunctions->findPurchasesPurchaseRequests($purchase->id, $this->request->Session()->read('sessionParameterControl'));

            if (!empty($array)) {

                //Agrupa Id's
                foreach ($array as $arr):
                    $purchaseRequests_list[] = $arr;
                endforeach;

            }//if (!empty($array))

        endforeach;

        /**********************************************************************/

        if (!empty($purchases_list) && !empty($purchaseRequests_list)) {

            //Vínculo entre solicitações de compras e 
            $purchasesPurchaseRequests = $this->PurchasesPurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                         ->where(['PurchasesPurchaseRequests.purchases_id IN' => $purchases_list]);

            /******************************************************************/

            //Solicitações de compras
            $purchaseRequests = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['PurchaseRequests.id', 'PurchaseRequests.parameters_id', 'PurchaseRequests.created', 
                                                                 'PurchaseRequests.modified', 'PurchaseRequests.username', 'PurchaseRequests.industrializations_id', 
                                                                 'PurchaseRequests.code', 'PurchaseRequests.date', 'PurchaseRequests.applicant', 
                                                                 'PurchaseRequests.authorizer', 'PurchaseRequests.dtauth', 'PurchaseRequests.status', 
                                                                 'PurchaseRequests.obs', 
                                                                 'Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.sells_id',
                                                                 'Industrializations.code'
                                                                ])
                                                       ->where(['PurchaseRequests.id IN' => $purchaseRequests_list,
                                                                'PurchaseRequests.status IN' => ['P', 'A', 'F'] // P - pending, A - in progress, C - cancelled, F - finalized
                                                               ])
                                                       ->join(['Industrializations' => ['table'      => 'Industrializations',
                                                                                        'type'       => 'LEFT',
                                                                                        'conditions' => 'Industrializations.id = purchaseRequests.industrializations_id'
                                                                                       ]
                                                               ])
                                                       ->order(['PurchaseRequests.id']);

        }//if (!empty($purchaseRequests_list))

        /**********************************************************************/

        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $purchases = $this->paginate($purchases);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $purchases = $this->paginate($purchases);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('purchases', 'purchasesPurchaseRequests', 'purchaseRequests'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $purchase = $this->Purchases->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->select(['Purchases.id', 'Purchases.parameters_id', 'Purchases.created', 
                                              'Purchases.modified', 'Purchases.username', 'Purchases.username', 
                                              'Purchases.providers_id', 'Purchases.date', 'Purchases.code', 'Purchases.freighttype', 
                                              'Purchases.paymenttype', 'Purchases.deadline', 'Purchases.totalipi', 'Purchases.totalicms', 
                                              'Purchases.totalicmssubst', 'Purchases.totalfreight', 'Purchases.totaldiscount', 
                                              'Purchases.grandtotal', 'Purchases.endingdate', 'Purchases.status', 'Purchases.obs', 
                                              'Providers.id', 'Providers.parameters_id', 'Providers.title', 'Providers.fantasia',
                                              'Providers.cpfcnpj'
                                            ])
                                    ->contain(['Providers'])//, 'PurchaseRequests'
                                    ->first();

        /**********************************************************************/

        $purchaseItems = $this->PurchaseItems->findByPurchasesIdAndParametersId($purchase->id, $this->request->Session()->read('sessionParameterControl'))
                                             ->contain(['Products']);

        /**********************************************************************/

        //lista de vínculos de solicitações de compras
        $purchaseRequests_list = $this->PurchasesFunctions->findPurchasesPurchaseRequests($purchase->id, $this->request->Session()->read('sessionParameterControl'));

        /**********************************************************************/

        if (!empty($purchaseRequests_list)) {

            $purchaseRequests = $this->PurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                       ->select(['PurchaseRequests.id', 'PurchaseRequests.parameters_id', 'PurchaseRequests.created', 
                                                                 'PurchaseRequests.modified', 'PurchaseRequests.username', 'PurchaseRequests.industrializations_id', 
                                                                 'PurchaseRequests.code', 'PurchaseRequests.date', 'PurchaseRequests.applicant', 
                                                                 'PurchaseRequests.authorizer', 'PurchaseRequests.dtauth', 'PurchaseRequests.status', 
                                                                 'PurchaseRequests.obs', 
                                                                 'Industrializations.id', 'Industrializations.parameters_id', 'Industrializations.sells_id',
                                                                 'Industrializations.code'
                                                                ])
                                                       ->where(['PurchaseRequests.id IN' => $purchaseRequests_list,
                                                                'PurchaseRequests.status IN' => ['P', 'A', 'F'] // P - pending, A - in progress, C - cancelled, F - finalized
                                                               ])
                                                       ->join(['Industrializations' => ['table'      => 'Industrializations',
                                                                                        'type'       => 'LEFT',
                                                                                        'conditions' => 'Industrializations.id = purchaseRequests.industrializations_id'
                                                                                       ]
                                                              ])
                                                       ->order(['PurchaseRequests.id']);

        }//if (!empty($purchaseRequests_list)
        
        /**********************************************************************/
        
        $invoices = $this->Invoices->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                   ->select(['Invoices.id', 'Invoices.parameters_id', 'Invoices.nf', 'Invoices.dtemissaonf', 
                                             'Invoices.dtdelivery', 'Invoices.grandtotal', 'Invoices.status', 'Invoices.type', 
                                             'InvoicesPurchasesSells.parameters_id', 'InvoicesPurchasesSells.invoices_id', 
                                             'InvoicesPurchasesSells.purchases_id', 'InvoicesPurchasesSells.sells_id', 
                                             'Purchases.id', 'Purchases.parameters_id', 'Purchases.providers_id', 'Purchases.code', 
                                             'Providers.id', 'Providers.parameters_id', 'Providers.cpfcnpj', 'Providers.title'
                                            ])
                                   ->where(['InvoicesPurchasesSells.purchases_id' => $purchase->id,
                                            'Purchases.id' => $purchase->id,
                                            'Purchases.status IN' => ['P', 'D', 'E', 'F'] // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                           ])
                                   ->contain(['Transporters'])
                                   ->join(['InvoicesPurchasesSells' => ['table'      => 'invoices_purchases_sells',
                                                                        'type'       => 'LEFT',
                                                                        'conditions' => 'Invoices.id = InvoicesPurchasesSells.invoices_id'
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

        /**********************************************************************/
        
        $this->set(compact('purchase', 'purchaseItems', 'purchaseRequests', 'invoices'));
    }

    public function add()
    {
        $this->Products = TableRegistry::get('Products');
        
        /**********************************************************************/

        $purchase = $this->Purchases->newEntity();
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
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

            //Solicitações de compras
            $purchase_requests_id = $this->request->data['purchase_requests_id'];
            unset($this->request->data['purchase_requests_id']);

            /******************************************************************/

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->select(['MAX' => 'MAX(Purchases.code)'])
                                        ->first();
            $this->request->data['code'] = $max_code->MAX + 1;
            
            /******************************************************************/
            
            $purchase = $this->Purchases->patchEntity($purchase, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $purchase->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $purchase->username      = $this->Auth->user('name');
            $purchase->status        = 'P'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['totalfreight'] = str_replace($source, $replace, $this->request->data['totalfreight']);
            
            /******************************************************************/
            
            if ($this->Purchases->save($purchase)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($purchase, 'add', 'Purchases');
            
                /**************************************************************/

                //ITENS DA VENDA
                $this->PurchasesFunctions->addItems($purchase->id, $productList, $purchase->parameters_id);
            
                /**************************************************************/

                //SOLICITAÇÕES DE COMRPAS
                $this->PurchasesFunctions->addPurchasesPurchaseRequests($purchase, $purchase_requests_id);
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Purchases->save($purchase))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchasesController->add';
            $this->Error->registerError($purchase, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $purchaseRequests = $this->PurchaseRequests->find('list', ['keyField'   => 'id',
                                                                   'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . ($e->industrializations_id ? $e->Industrializations->Sells->Customers->title : __('Avulsa')); }
                                                                  ])
                                                   ->where(['PurchaseRequests.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                            'PurchaseRequests.status IN' => ['P', 'A'] // P - pending, A - in progress, C - cancelled, F - finalized
                                                           ])
                                                   ->contain(['Industrializations.Sells.Customers'])
                                                   ->order(['PurchaseRequests.code']);
        $this->set('purchaseRequests', $purchaseRequests);

        /**********************************************************************/

        $providers = $this->Purchases->Providers->find('list')
                                                ->where(['Providers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                                ->order(['Providers.title']);
        $providers = $providers->select(['id', 'title' => $providers->func()->concat(['Providers.title' => 'identifier', 
                                                                                      ' - (',
                                                                                      'Providers.cpfcnpj' => 'identifier',
                                                                                      ')'
                                                                                     ])
                                                          ]);
        $this->set('providers', $providers);
        
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
        
        /**********************************************************************/
        
        $max_code = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                    ->select(['MAX' => 'MAX(Purchases.code)'])
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
        $code     = null;
        
        if ($this->request->is('post')) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('add', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {

                $mensagem = 'Sem permissão para realizar a operação solicitada';

                $this->response->type('json');  
                $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
                return $this->response;

            }//if (!$this->SystemFunctions->validaAcesso()
            
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

            //Solicitações de compras
            $purchase_requests_id = $this->request->data['purchase_requests_id'];
            unset($this->request->data['purchase_requests_id']);

            /******************************************************************/

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                        ->select(['MAX' => 'MAX(Purchases.code)'])
                                        ->first();
            $this->request->data['code'] = $max_code->MAX + 1;

            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            $this->request->data['status']        = 'P'; // P - Pendente, A - Em Andamento, C - Cancelado, F - Finalizado
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['totalfreight'] = str_replace($source, $replace, $this->request->data['totalfreight']);

            /******************************************************************/

            $purchase = $this->Purchases->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/

            if ($this->Purchases->save($purchase)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($purchase, 'add', 'Purchases');
            
                /**************************************************************/

                //ITENS DA VENDA
                $this->PurchasesFunctions->addItems($purchase->id, $productList, $purchase->parameters_id);
            
                /**************************************************************/

                //SOLICITAÇÕES DE COMRPAS
                $this->PurchasesFunctions->addPurchasesPurchaseRequests($purchase, $purchase_requests_id);
            
                /**************************************************************/

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $purchase->id;
                $code     = $purchase->code;

            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'PurchasesController->addjson';
                $this->Error->registerError($purchase, $message, true);

            }//else if ($this->Purchases->save($purchase))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $purchase = $this->Purchases->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->contain(['Providers'])//, 'PurchaseRequests'
                                    ->first();
        
        /**********************************************************************/
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))

            /******************************************************************/

            //Identifica o status atual do registro
            if ($purchase->status != 'P') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                $this->Flash->error(__('Registro NÃO pode ser editado pois não está pendente'));
                return $this->redirect($this->referer());
            }//if ($purchase->status != 'P')

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

            //Solicitações de compras
            $purchase_requests_id = $this->request->data['purchase_requests_id'];
            unset($this->request->data['purchase_requests_id']);
            
            /******************************************************************/

            //Não permite a mudança do código sequencial
            unset($this->request->data['code']);
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $this->request->data['parameters_id'] = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE ALTEROU O REGISTRO
            $this->request->data['username']      = $this->Auth->user('name');
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['totalfreight'] = str_replace($source, $replace, $this->request->data['totalfreight']);

            /******************************************************************/
            
            $purchase = $this->Purchases->patchEntity($purchase, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Purchases->save($purchase)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($purchase, 'edit', 'Purchases');
            
                /**************************************************************/

                //ITENS DA VENDA
                $this->PurchasesFunctions->updateItems($purchase->id, $productList, $purchase->parameters_id);
            
                /**************************************************************/

                //SOLICITAÇÕES DE COMRPAS
                $this->PurchasesFunctions->addPurchasesPurchaseRequests($purchase, $purchase_requests_id);
            
                /**************************************************************/
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Purchases->save($purchase))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchasesController->edit';
            $this->Error->registerError($purchase, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $purchaseRequests = $this->PurchaseRequests->find('list', ['keyField'   => 'id',
                                                                   'valueField' => function ($e) { return str_pad($e->code, 6, '0', STR_PAD_LEFT) . ' - ' . $e->applicant; }
                                                                  ])
                                                   ->where(['PurchaseRequests.parameters_id' => $this->request->Session()->read('sessionParameterControl'),
                                                            'PurchaseRequests.status IN' => ['P', 'A'] // P - pending, A - in progress, C - cancelled, F - finalized
                                                           ])
                                                   ->order(['PurchaseRequests.code']);
        $this->set('purchaseRequests', $purchaseRequests);

        /**********************************************************************/

        $providers = $this->Purchases->Providers->find('list')
                                            ->where(['Providers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                            ->order(['Providers.title']);
        $providers = $providers->select(['id', 'title' => $providers->func()->concat(['Providers.title' => 'identifier', 
                                                                                      ' - (',
                                                                                      'Providers.cpfcnpj' => 'identifier',
                                                                                      ')'
                                                                                     ])
                                                          ]);
        $this->set('providers', $providers);
        
        /**********************************************************************/

        $purchaseItems = $this->PurchaseItems->findByPurchasesIdAndParametersId($purchase->id, $this->request->Session()->read('sessionParameterControl'))
                                             ->contain(['Products']);
        $this->set('purchaseItems', $purchaseItems);
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($purchase->date)) {
            $purchase->date = date("d/m/Y", strtotime($purchase->date));
        }
        if (!empty($purchase->deadline)) {
            $purchase->deadline = date("d/m/Y", strtotime($purchase->deadline));
        }
        if (!empty($purchase->shipment)) {
            $purchase->shipment = date("d/m/Y", strtotime($purchase->shipment));
        }
        
        /**********************************************************************/
        
        $this->set(compact('purchase'));
    }

    public function finish($id)
    {
        //CONSULTA REGISTRO
        $purchase = $this->Purchases->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/

        if ($this->request->is(['patch', 'post', 'put'])) {

            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('edit', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            /**********************************************************************/

            //Consulta vínculos
            $invoicesPurchasesSells = $this->InvoicesPurchasesSells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                   ->where(['InvoicesPurchasesSells.purchases_id' => $id]);

            foreach ($invoicesPurchasesSells as $invoicesPurchasesSell):

                //Consulta faturamentos
                $invoices = $this->Invoices->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                           ->where(['Invoices.id' => $invoicesPurchasesSell->invoices_id]);

                $faturamento_finalizado = false;

                foreach($invoices as $invoice):
                    
                    if ($invoice->status == 'P') { // P - delivering, C - cancelled, F - finalized
                        $this->Flash->error(__('Registro NÃO finalizado, há faturas pendentes vinculadas'));
                        return $this->redirect($this->referer());
                    }//if ($invoice->status == 'P')
            
                    /**********************************************************/

                    if ($invoice->status == 'F') { // P - delivering, C - cancelled, F - finalized
                        //Verifica se há pelo menos um faturamento finalizado
                        $faturamento_finalizado = true;
                    }//if ($invoice->status == 'F')

                endforeach;

            endforeach;
            
            /******************************************************************/

            //Valida se há faturamentos vinculados e se algum desses está finalizado
            if (empty($invoices->toArray()) || $faturamento_finalizado == false) {
                $this->Flash->error(__('Registro NÃO finalizado, não há faturamentos válidos'));
                return $this->redirect($this->referer());
            }//if (!$faturamento_finalizado)
            
            /******************************************************************/

            //Finaliza o pedido
            $purchase->status = 'F'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
            
            /******************************************************************/
            //ESTOQUE É MOVIMENTADO NA FUNÇÃO FINISH DO CONTROLLER INVOICES
            /******************************************************************/
            
            if ($this->Purchases->save($purchase)) {
                
                $this->Flash->success(__('Registro finalizado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Purchases->save($purchase))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchasesController->finish';
            $this->Error->registerError($purchase, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO finalizado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        
        /**********************************************************************/
        
        $this->set(compact('purchase'));

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
        $purchase = $this->Purchases->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                                    ->first();
        
        /**********************************************************************/
        
        if (!empty($purchase)) {

            //CANCELA A VENDA
            $purchase->username = $this->Auth->user('name');
            
            /******************************************************************/
                
            $this->Log->gravaLog($purchase, 'deleted', 'Purchases'); //GRAVA LOG
            
            /******************************************************************/
            
            if ($this->Purchases->delete($purchase)) {

                //SOLICITAÇÕES DE COMPRAS
                $this->PurchasesFunctions->purchaseRequests($purchase, true);

                /**************************************************************/
                
                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//else if ($this->Purchases->delete($purchase))
            
        }//if (!empty($purchase))
        
        /**********************************************************************/

        //Alerta de erro
        $message = 'PurchasesController->delete';
        $this->Error->registerError($purchase, $message, true);
        
        /**********************************************************************/

        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $purchase = $this->Purchases->get($id);
                
            /******************************************************************/

            //Verfifica se há faturamentos vinculados (não cancelados)
            $invoicesPurchasesSells = $this->InvoicesPurchasesSells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                   ->contain(['Invoices'])
                                                                   ->where(['InvoicesPurchasesSells.purchases_id' => $id,
                                                                            'Invoices.status <>' => 'C'
                                                                           ]);
                                                                    
            if (!empty($invoicesPurchasesSells->toArray())) {

                //VERIFICAÇÃO SIMPLIFICADA
                if ($invoicesPurchasesSells->count() > 1) {

                    if ($purchase->status == 'D' || $purchase->status == 'E') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                        
                        $this->Flash->error(__('Registro NÃO cancelado, há faturamentos vinculados'));
                        return $this->redirect($this->referer());

                    }//if ($purchase->status == 'D' || $purchase->status == 'E')

                    /**********************************************************/

                    //Define o status para cancelado
                    $purchase->status = 'D'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized

                    /**********************************************************/

                    //Grava atualização de status da compra
                    if ($this->Purchases->save($purchase)) {
                        
                        $this->Flash->warning(__('Finalização cancelada com sucesso'));
                        return $this->redirect($this->referer());
                        
                    }//if ($this->Purchases->save($purchase))
                    
                }//if ($invoicesPurchasesSells->count() > 1)

            }//if (!empty($invoicesPurchasesSells->toArray()))
                
            /******************************************************************/

            //Define o status para cancelado
            $purchase->status = 'C'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized

            /******************************************************************/

            //Consulta vínculo de solicitação de compra
            $purchasesPurchaseRequests = $this->PurchasesPurchaseRequests->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                         ->where(['PurchasesPurchaseRequests.purchases_id' => $purchase->id]);

            /******************************************************************/

            //Contabiliza quantos registros estão vinculados
            $numberOfPurchasesPurchaseRequests = count((array)$purchasesPurchaseRequests->toArray());

            /******************************************************************/

            //Lista todos as solicitações de compras vinculadas
            foreach ($purchasesPurchaseRequests as $purchasesPurchaseRequest):

                //Consulta solicitação de compras
                $purchaseRequest = $this->PurchaseRequests->findByIdAndParametersId($purchasesPurchaseRequests->purchase_requests_id, $this->request->Session()->read('sessionParameterControl'))
                                                          ->first();

                /******************************************************************/
    
                //Há mais de 1 lançamento vinculado?
                if ($numberOfPurchasesPurchaseRequests > 1) {

                    //Define o status da solicitação de compra
                    $purchaseRequest->status = 'A'; //P - pending, A - in progress, C - cancelled, F - finalized
                    
                } else {
                
                    //Define o status da solicitação de compra
                    $purchaseRequest->status = 'P'; //P - pending, A - in progress, C - cancelled, F - finalized

                }//else if (!empty($invoicesPurchasesSells->toArray()))

                /******************************************************************/

                //Grava atualização de staus da solicitação de compras
                if (!$this->PurchaseRequests->save($purchaseRequest)) {

                    //Alerta de erro
                    $message = 'PurchasesController->cancel->PurchaseRequests';
                    $this->Error->registerError($purchaseRequest, $message, true);

                }//if (!$this->PurchaseRequests->save($purchaseRequest))

            endforeach;

            /******************************************************************/
            
            //Grava atualização de status da compra
            if ($this->Purchases->save($purchase)) {
                
                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Purchases->save($purchase))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchasesController->cancel';
            $this->Error->registerError($purchase, $message, true);
            
            /******************************************************************/

            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }

    public function reopen($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $purchase = $this->Purchases->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($purchase->status != 'C') { // P - delivering, C - cancelled, F - finalized
                $this->Flash->error(__('Registro NÃO foi ativado pois não está cancelado'));
                return $this->redirect($this->referer());
            }//if ($purchase->status != 'C')
                
            /******************************************************************/

            //Define o status para pendente de entrega
            $purchase->status = 'P'; // P - delivering, C - cancelled, F - finalized
                
            /******************************************************************/
            
            if ($this->Purchases->save($purchase)) {
                
                $this->Flash->success(__('Registro ativado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Purchases->save($purchase))
            
            /******************************************************************/

            //Alerta de erro
            $message = 'PurchasesController->reopen';
            $this->Error->registerError($purchase, $message, true);
            
            /******************************************************************/

            $this->Flash->error(__('Registro NÃO ativado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }
    
    public function report()
    {
        $this->Providers = TableRegistry::get('Providers');

        if ($this->request->is(['patch', 'post', 'put'])) {

            //CHAMA FUNÇÃO PARA CONSULTAS
            $ordenacao = $this->request->data['Ordem'];
            $periodo   = [];

            /******************************************************************/
                
            // MONTAGEM DO SQL
            $conditions = ['Purchases.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

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

            $conditions[] = '(Purchases.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';

            /******************************************************************/

            //FILTRA POR STATUS
            if (!empty($this->request->data['status'])) {
                $conditions[] = '(Purchases.status = "' . $this->request->data['status'] . '")';
            }//if (!empty($this->request->data['status']))

            /******************************************************************/

            $fields = ['Purchases.id', 'Purchases.parameters_id', 'Purchases.providers_id', 
                       'Purchases.code', 'Purchases.date', 'Purchases.freighttype', 'Purchases.deadline', 
                       'Purchases.grandtotal', 'Purchases.endingdate', 'Purchases.status', 'Purchases.obs',
                       'Providers.id', 'Providers.parameters_id', 'Providers.title', 'Providers.fantasia', 'Providers.cpfcnpj'
                      ];

            $purchases = $this->Purchases->find('all')
                                         ->select($fields)
                                         ->join(['Providers' => ['table'      => 'providers',
                                                                 'type'       => 'LEFT',
                                                                 'conditions' => 'Providers.id = Purchases.providers_id'
                                                                ]
                                                ])
                                         ->where($conditions)
                                         ->order(['Purchases.'.$ordenacao]);

            $this->set('purchases', $purchases);

            /******************************************************************/

            //LISTA O ID
            $purchases_id = [];

            foreach ($purchases as $purchase):
                $purchases_id[] = $purchase->id;
            endforeach;

            /******************************************************************/

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

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/Purchases/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Purchases/reports/purchases_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
        /******************************************************************/
        
        //FORNECEDORES
        $providers = $this->Providers->find('list')
                                     ->select(['Providers.id', 'Providers.title'])
                                     ->where(['Providers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                     ->order(['Providers.title']);
        
        $this->set('providers', $providers);

    }
    
    public function filter($request)
    {
        $table = 'Purchases';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['providers_search'])) { 
            $where[] = '(Providers.title LIKE "%'.$this->params['providers_search'].'%")';
        }
        
        if (!empty($this->params['status_search'])) { 
            $where[] = '('.$table.'.status = "'.$this->params['status_search'].'")';
        } else {
            $where[] = '('.$table.'.status = "P" OR '.$table.'.status = "D" OR '.$table.'.status = "F")'; //Não lista cancelados
        }
        
        return $where;
    }
    
    public function json()
    {
        if ($this->request->is('get')) {
            
            if (isset($this->request->query['query'])) {
                
                $query[] = '(Purchases.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }//else if (isset($this->request->query['query']))
            
            $purchases = $this->Purchases->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['Purchases.id', 'Purchases.title'])
                                         ->where(['Purchases.status IN' => ['P', 'D', 'E', 'F']]) // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                         ->where($query)
                                         ->order(['Purchases.title']);
            
            $json = [];
            
            foreach ($purchases as $data) {
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

    public function jsonItems()
    {
        if ($this->request->is('get')) {

            if (isset($this->request->query['query'])) {

                $query[] = '(PurchaseItems.purchases_id LIKE "'.$this->request->query['query'].'")';
                
            } else {
                
                $where = null;
                
            }//else if (isset($this->request->query['query']))

            $purchaseItems = $this->PurchaseItems->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                 ->select(['PurchaseItems.id', 'PurchaseItems.parameters_id', 'PurchaseItems.products_id', 
                                                           'PurchaseItems.quantity', 'PurchaseItems.unity', 'PurchaseItems.imobilizado',
                                                           'PurchaseItems.icms', 'PurchaseItems.pericms',
                                                           'PurchaseItems.icmssubst', 'PurchaseItems.pericmssubst',
                                                           'PurchaseItems.ipi', 'PurchaseItems.peripi',
                                                           'PurchaseItems.vlunity', 'PurchaseItems.vldiscount', 'PurchaseItems.vltotal',
                                                           'Products.id', 'Products.parameters_id', 'Products.title',
                                                           'Products.code'
                                                          ])
                                                 ->contain(['Products'])
                                                 ->where($where)
                                                 ->order(['PurchaseItems.id']);

            $json = [];
            
            foreach ($purchaseItems as $data) {
                array_push($json, [
                    'products_id'  => $data->Products['id'],
                    'code'      => $data->Products['code'],
                    'title'        => $data->Products['title'],
                    'quantity'     => $data->quantity,
                    'unity'        => $data->unity,
                    'imobilizado'  => $data->imobilizado,
                    'icms'         => $data->icms,
                    'pericms'      => $data->pericms,
                    'icmssubst'    => $data->icmssubst,
                    'pericmssubst' => $data->pericmssubst,
                    'ipi'          => $data->ipi,
                    'peripi'       => $data->peripi,
                    'vlunity'      => $data->vlunity,
                    'vldiscount'   => $data->vldiscount,
                    'vltotal'      => $data->vltotal
                ]);
            }
            
            echo json_encode($json);

        }//if ($this->request->is('get'))
        
        $this->autoRender = false;
        die();
    }
    
}