<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Sells */
/* File: src/Controller/SellsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

class SellsController extends AppController
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
        
        $this->loadComponent('SellsFunctions');
        $this->SellItems              = TableRegistry::get('SellItems');
        $this->Invoices               = TableRegistry::get('Invoices');
        $this->InvoicesPurchasesSells = TableRegistry::get('InvoicesPurchasesSells');
    }
    
    public function index()
    {
        //Busca
        $where = $this->filter($this->request);
        
        /**********************************************************************/
        
        $sells = $this->Sells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                             ->where($where)
                             ->contain(['Customers'])
                             ->order(['Sells.code']);
                             //->limit(200);
        
        /**********************************************************************/
        
        $page  = (!empty($this->request->query['pagina']) ? $this->request->query['pagina'] : 1);
        $this->paginate = ['page' => $page, 'limit' => '10'];
        
        try {
            
            $sells = $this->paginate($sells);
            
        } catch (NotFoundException $e) {
            
            $this->paginate = ['page' => $page-1, 'limit' => '10'];
            $sells = $this->paginate($sells);
            
        }
        
        /**********************************************************************/
        
        $this->set(compact('sells'));
    }

    public function view($id)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('view', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $sell = $this->Sells->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->contain(['Customers'])
                            ->first();

        /**********************************************************************/

        $sellItems = $this->SellItems->findBySellsIdAndParametersId($sell->id, $this->request->Session()->read('sessionParameterControl'))
                                     ->contain(['Products']);

        /**********************************************************************/
        
        $invoices = $this->Invoices->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                   ->select(['Invoices.id', 'Invoices.parameters_id', 'Invoices.nf', 'Invoices.dtemissaonf', 
                                             'Invoices.dtdelivery', 'Invoices.grandtotal', 'Invoices.status', 'Invoices.type', 
                                             'InvoicesPurchasesSells.parameters_id', 'InvoicesPurchasesSells.invoices_id', 
                                             'InvoicesPurchasesSells.purchases_id', 'InvoicesPurchasesSells.sells_id', 
                                             'Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 
                                             'Customers.id', 'Customers.parameters_id', 'Customers.cpfcnpj', 'Customers.title'
                                            ])
                                   ->where(['InvoicesPurchasesSells.sells_id' => $sell->id,
                                            'Sells.id' => $sell->id,
                                            'Invoices.status IN' => ['P', 'F'] // P - delivering, C - cancelled, F - finalized
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
                                                          ]
                                          ])
                                   ->order(['Invoices.nf']);
        
        /**********************************************************************/
        
        $this->set(compact('sell', 'sellItems', 'invoices'));
    }

    public function add()
    {
        $this->Products  = TableRegistry::get('Products');
        
        /**********************************************************************/

        $sell = $this->Sells->newEntity();
        
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

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Sells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                    ->select(['MAX' => 'MAX(Sells.code)'])
                                    ->first();
            $this->request->data['code'] = $max_code->MAX + 1;
            
            /******************************************************************/

            $sell = $this->Sells->patchEntity($sell, $this->request->getData());
            
            /******************************************************************/
            
            //DEFINE A QUAL EMPRESA O CADASTRO PERTENCE
            $sell->parameters_id = $this->request->Session()->read('sessionParameterControl');
            
            //DEFINE STATUS E USUÁRIO QUE CRIOU O REGISTRO
            $sell->username      = $this->Auth->user('name');
            $sell->status        = 'P'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
            
            /******************************************************************/
            
            //Retirar máscara do valor
            $source  = ['.', ','];
            $replace = ['', '.'];
            $this->request->data['totalfreight'] = str_replace($source, $replace, $this->request->data['totalfreight']);
            
            /******************************************************************/
            
            if ($this->Sells->save($sell)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($sell, 'add', 'Sells');

                //ITENS DA VENDA
                $this->SellsFunctions->addItems($sell->id, $productList, $sell->parameters_id);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Sells->save($sell))

            /******************************************************************/

            //Alerta de erro
            $message = 'SellsControler->add';
            $this->Error->registerError($sell, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());
            
        }//if ($this->request->is('post'))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        $customers = $this->Sells->Customers->find('list')
                                            ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                            ->order(['Customers.title']);
        $customers = $customers->select(['id', 'title' => $customers->func()->concat(['Customers.title' => 'identifier', 
                                                                                      ' - (',
                                                                                      'Customers.cpfcnpj' => 'identifier',
                                                                                      ')'
                                                                                     ])
                                                          ]);
        $this->set('customers', $customers);
        
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
        
        $max_code = $this->Sells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                ->select(['MAX' => 'MAX(Sells.code)'])
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

            //DEFINE O CÓDIGO SEQUENCIAL
            $max_code = $this->Sells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                    ->select(['MAX' => 'MAX(Sells.code)'])
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

            $sell = $this->Sells->newEntity($this->request->data, ['validate' => 'novo']);
            
            /******************************************************************/

            if ($this->Sells->save($sell)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($sell, 'add', 'Sells');

                //ITENS DA VENDA
                $this->SellsFunctions->addItems($sell->id, $productList, $sell->parameters_id);

                $mensagem = 'Registro gravado com sucesso';
                $status   = 'ok';
                $id       = $sell->id;
                $code     = $sell->code;

            } else { 
                
                $mensagem = 'Desculpe, ocorreu um erro e o registro não foi salvo. Por favor, verifique os campos e tente novamente';

                //Alerta de erro
                $message = 'SellsControler->addjson';
                $this->Error->registerError($sell, $message, true);

            }//else if ($this->Sells->save($sell))
            
        }//if ($this->request->is('post'))
        
        $this->response->type('json');  
        $this->response->body(json_encode(compact('mensagem', 'status', 'errors', 'id', 'code')));
        return $this->response;
    }

    public function edit($id)
    {
        //CONSULTA REGISTRO
        $sell = $this->Sells->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->contain(['Customers'])
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
            if ($sell->status != 'P') { // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                $this->Flash->error(__('Registro NÃO pode ser editado pois não está pendente'));
                return $this->redirect($this->referer());
            }//if ($sell->status != 'P')

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
            
            $sell = $this->Sells->patchEntity($sell, $this->request->getData());
            
            /******************************************************************/
            
            if ($this->Sells->save($sell)) {
                
                //GRAVA LOG
                $this->Log->gravaLog($sell, 'edit', 'Sells');

                //ITENS DA VENDA
                $this->SellsFunctions->updateItems($sell->id, $productList, $sell->parameters_id);
                
                $this->Flash->success(__('Registro gravado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Sells->save($sell))

            /******************************************************************/

            //Alerta de erro
            $message = 'SellsControler->edit';
            $this->Error->registerError($sell, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO gravado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
        $conditions = ['parameters_id' => $this->request->Session()->read('sessionParameterControl')];
        
        /**********************************************************************/

        $customers = $this->Sells->Customers->find('list')
                                            ->where(['Customers.parameters_id' => $this->request->Session()->read('sessionParameterControl')])
                                            ->order(['Customers.title']);
        $customers = $customers->select(['id', 'title' => $customers->func()->concat(['Customers.title' => 'identifier', 
                                                                                      ' - (',
                                                                                      'Customers.cpfcnpj' => 'identifier',
                                                                                      ')'
                                                                                     ])
                                                          ]);
        $this->set('customers', $customers);
        
        /**********************************************************************/

        $sellItems = $this->SellItems->findBySellsIdAndParametersId($sell->id, $this->request->Session()->read('sessionParameterControl'))
                                     ->contain(['Products']);
        $this->set('sellItems', $sellItems);
        
        /**********************************************************************/
        
        //AJUSTE NA VISUALIZAÇÃO DAS DATAS
        if (!empty($sell->date)) {
            $sell->date = date("d/m/Y", strtotime($sell->date));
        }
        if (!empty($sell->deadline)) {
            $sell->deadline = date("d/m/Y", strtotime($sell->deadline));
        }
        if (!empty($sell->shipment)) {
            $sell->shipment = date("d/m/Y", strtotime($sell->shipment));
        }
        
        /**********************************************************************/
        
        $this->set(compact('sell'));
    }

    public function finish($id)
    {
        //CONSULTA REGISTRO
        $sell = $this->Sells->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/

        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta vínculos
            $invoicesPurchasesSells = $this->InvoicesPurchasesSells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                   ->where(['InvoicesPurchasesSells.sells_id' => $id]);

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
            $sell->status = 'F'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized

            /******************************************************************/
            //ESTOQUE É MOVIMENTADO NA FUNÇÃO FINISH DO CONTROLLER INVOICES
            /******************************************************************/

            if ($this->Sells->save($sell)) {

                $this->Flash->success(__('Registro finalizado com sucesso'));
                return $this->redirect($this->referer());

            }//if ($this->Sells->save($sell))

            /******************************************************************/

            //Alerta de erro
            $message = 'SellsControler->finish';
            $this->Error->registerError($sell, $message, true);

            /******************************************************************/

            $this->Flash->error(__('Registro NÃO finalizado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))

        /**********************************************************************/

        $this->set(compact('sell'));

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
        $sell = $this->Sells->findByIdAndParametersId($id, $this->request->Session()->read('sessionParameterControl'))
                            ->first();
        
        /**********************************************************************/
        
        if (!empty($sell)) {

            //CANCELA A VENDA
            $sell->username = $this->Auth->user('name');
            
            /******************************************************************/
                
            $this->Log->gravaLog($sell, 'deleted', 'Sells'); //GRAVA LOG
            
            /******************************************************************/
            
            if ($this->Sells->delete($sell)) {

                $this->Flash->warning(__('Registro excluído com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Sells->delete($sell))
            
        }//if (!empty($sell))
  
        /**********************************************************************/

        //Alerta de erro
        $message = 'SellsController->delete';
        $this->Error->registerError($sell, $message, true);
  
        /**********************************************************************/
        
        $this->Flash->error(__('Registro NÃO excluído, tente novamente'));
        return $this->redirect($this->referer());
    }

    public function cancel($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $sell = $this->Sells->get($id);
                
            /******************************************************************/

            //Verfifica se há faturamentos vinculados (não cancelados)
            $invoicesPurchasesSells = $this->InvoicesPurchasesSells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                                                   ->contain(['Invoices'])
                                                                   ->where(['InvoicesPurchasesSells.sells_id' => $id,
                                                                            'Invoices.status <>' => 'C'
                                                                           ]);
                                                                    
            if (!empty($invoicesPurchasesSells->toArray())) {
                
                $this->Flash->error(__('Registro NÃO cancelado, há faturamentos vinculados'));
                return $this->redirect($this->referer());

            }//if (!empty($invoicesPurchasesSells->toArray()))
                
            /******************************************************************/

            //Define o status para cancelado
            $sell->status = 'C'; // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized

            /******************************************************************/
            
            if ($this->Sells->save($sell)) {
                
                $this->Flash->warning(__('Registro cancelado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Sells->save($sell))

            /******************************************************************/

            //Alerta de erro
            $message = 'SellsControler->cancel';
            $this->Error->registerError($sell, $message, true);

            /******************************************************************/
            
            $this->Flash->error(__('Registro NÃO cancelado, tente novamente'));
            return $this->redirect($this->referer());

        }//if ($this->request->is(['patch', 'post', 'put']))
    }

    public function reopen($id)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {

            //Consulta o registro
            $sell = $this->Sells->get($id);
                
            /******************************************************************/

            //Identifica o status atual do registro
            if ($sell->status != 'C') { // P - delivering, C - cancelled, F - finalized
                $this->Flash->error(__('Registro NÃO foi ativado pois não está cancelado'));
                return $this->redirect($this->referer());
            }//if ($sell->status != 'C')
                
            /******************************************************************/

            //Define o status para pendente de entrega
            $sell->status = 'P'; // P - delivering, C - cancelled, F - finalized
                
            /******************************************************************/
            
            if ($this->Sells->save($sell)) {
                
                $this->Flash->success(__('Registro ativado com sucesso'));
                return $this->redirect($this->referer());
                
            }//if ($this->Sells->save($sell))

            /******************************************************************/

            //Alerta de erro
            $message = 'SellsControler->reopen';
            $this->Error->registerError($sell, $message, true);
            
            /******************************************************************/

            $this->Flash->error(__('Registro NÃO ativado, tente novamente'));
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
            $conditions = ['Sells.parameters_id = '.$this->request->Session()->read('sessionParameterControl')];

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

            $conditions[] = '(Sells.date BETWEEN "'.$dtinicial.'" AND "'.$dtfinal.'")';

            /******************************************************************/

            //FILTRA POR STATUS
            if (!empty($this->request->data['status'])) {
                $conditions[] = '(Sells.status = "' . $this->request->data['status'] . '")';
            }//if (!empty($this->request->data['status']))

            /******************************************************************/

            $fields = ['Sells.id', 'Sells.parameters_id', 'Sells.customers_id', 'Sells.code', 
                       'Sells.date', 'Sells.customercode', 'Sells.freighttype', 'Sells.shipment', 
                       'Sells.deadline', 'Sells.grandtotal', 'Sells.endingdate', 'Sells.status', 
                       'Sells.obs',
                       'Customers.id', 'Customers.parameters_id', 'Customers.title', 'Customers.fantasia', 'Customers.cpfcnpj'
                      ];

            $sells = $this->Sells->find('all')
                                 ->select($fields)
                                 ->join(['Customers' => ['table'      => 'customers',
                                                         'type'       => 'LEFT',
                                                         'conditions' => 'Customers.id = Sells.customers_id'
                                                        ]
                                         ])
                                 ->where($conditions)
                                 ->order(['Sells.'.$ordenacao]);

            $this->set('sells', $sells);

            /******************************************************************/

            //LISTA O ID
            $sells_id = [];

            foreach ($sells as $sell):
                $sells_id[] = $sell->id;
            endforeach;

            /******************************************************************/

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
                                                  'SellItems.sells_id IN' => $sells_id
                                                 ]);

            $this->set('sellItems', $sellItems);

            /******************************************************************/

            //INFORMAÇÕES DO CABEÇALHO DO RELATÓRIO
            $this->set('parameter', $this->Parameters->findById($this->request->Session()->read('sessionParameterControl'))->first());

            /******************************************************************/

            //Evitar página de erro
            $this->render('/Sells/reports/sem_relatorio');

            /******************************************************************/
            
            $this->render('/Sells/reports/sells_analitico');
            
        }//if ($this->request->is(['patch', 'post', 'put']))
            
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
        $table = 'Sells';
        $where = [];
        $this->prepareParams($request);
        
        if (!empty($this->params['code_search'])) { 
            $where[] = '('.$table.'.code LIKE "%'.$this->params['code_search'].
                       '%" OR '.$table.'.customercode LIKE "%'.$this->params['code_search'].'%")';
        }
        
        if (!empty($this->params['customers_search'])) { 
            $where[] = '(Customers.title LIKE "%'.$this->params['customers_search'].'%")';
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
                
                $query[] = '(Sells.title LIKE "%'.$this->request->query['query'].'%")';
                
            } else {
                
                $query = null;
                
            }
            
            $sells = $this->Sells->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                 ->select(['Sells.id', 'Sells.title'])
                                 ->where(['Sells.status IN' => ['P', 'D', 'E']]) // P - pending, D - in delivery, E - partial delivery, C - cancelled, F - finalized
                                 ->where($query)
                                 ->order(['Sells.title']);
            
            $json = [];
            
            foreach ($sells as $data) {
                array_push($json, [
                    'id'    => $data->id,
                    'value' => $data->title
                ]);
            }
            
            echo json_encode($json);
            
        }//if ($this->request->is('get'))
        
        $this->autoRender = false;
        die();
    }

    public function jsonItems()
    {
        if ($this->request->is('get')) {

            if (isset($this->request->query['query'])) {

                $query[] = '(SellItems.sells_id LIKE "'.$this->request->query['query'].'")';
                
            } else {
                
                $where = null;
                
            }//else if (isset($this->request->query['query']))

            $sellItems = $this->SellItems->findByParametersId($this->request->Session()->read('sessionParameterControl'))
                                         ->select(['SellItems.id', 'SellItems.parameters_id', 'SellItems.products_id', 
                                                   'SellItems.quantity', 'SellItems.unity', 'SellItems.imobilizado',
                                                   'SellItems.icms', 'SellItems.pericms',
                                                   'SellItems.icmssubst', 'SellItems.pericmssubst',
                                                   'SellItems.ipi', 'SellItems.peripi',
                                                   'SellItems.vlunity', 'SellItems.vldiscount', 'SellItems.vltotal',
                                                   'Products.id', 'Products.parameters_id', 'Products.title',
                                                   'Products.code'
                                                  ])
                                         ->contain(['Products'])
                                         ->where($where)
                                         ->order(['SellItems.id']);

            $json = [];
            
            foreach ($sellItems as $data) {
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