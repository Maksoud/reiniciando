<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use Cake\Mailer\MailerAwareTrait; //Utilizado para o envio de e-mails
use Cake\Log\Log;

use Cake\Core\Exception\Exception;

class BackupsFunctionsComponent extends Component 
{
    public function __construct()
    {
        $this->Error = new ErrorComponent();

        $this->Backups         = TableRegistry::get('Backups');
        $this->Parameters      = TableRegistry::get('Parameters');
        $this->UsersParameters = TableRegistry::get('UsersParameters');
        
        $this->Ftp             = new FtpComponent();
        $this->EmailFunctions  = new EmailFunctionsComponent();
    }
    
    public function backupFull()
    {
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        //CRIA DIRETÓRIO SE NÃO EXISTIR
        if (!file_exists('backup/')) {
            umask(0); 
            @mkdir("backup", 0777, true);
        }//if (!file_exists('backup/'))
        
        /**********************************************************************/
        
        $tables = ['AccountPlans'           => 'account_plans',
                   'Balances'               => 'balances',
                   'Banks'                  => 'banks',
                   'Boxes'                  => 'boxes',
                   'Cards'                  => 'cards',
                   //'Coins'                => 'coins',
                   'Costs'                  => 'costs',
                   'Customers'              => 'customers',
                   'DocumentTypes'          => 'document_types',
                   'EventTypes'             => 'event_types',
                   //'Knowledges'             => 'knowledges', //system table
                   'Moviments'              => 'moviments',
                   'MovimentsMovimentCards' => 'moviments_moviment_cards',
                   'MovimentBanks'          => 'moviment_banks',
                   'MovimentBoxes'          => 'moviment_boxes',
                   'MovimentCards'          => 'moviment_cards',
                   'MovimentChecks'         => 'moviment_checks',
                   'MovimentMergeds'        => 'moviment_mergeds',
                   'MovimentRecurrents'     => 'moviment_recurrents',
                   'Parameters'             => 'parameters',
                   'Plannings'              => 'plannings',
                   'Providers'              => 'providers',
                   'Regs'                   => 'regs',//logs
                   //'Rules'                  => 'rules', //system table
                   'SupportContacts'        => 'support_contacts',
                   'Transfers'              => 'transfers',
                   'Users'                  => 'users',
                   //'UsersParameters'        => 'users_parameters', //system table
                   //'Versions'               => 'versions', //system table
                   //'Plans'                  => 'plans', //system table
                   'Industrializations'     => 'industrializations',
                   'Inventories'            => 'inventories',
                   'InventoryItems'         => 'invetory_items',
                   'Invoices'               => 'invoices',
                   'InvoiceItems'           => 'invoice_items',
                   'InvoicesPurchasesSells' => 'invoices_purchases_sells',
                   'Products'               => 'products',
                   'ProductGroups'          => 'product_groups',
                   'ProductTypes'           => 'product_types',
                   'Purchases'              => 'purchases',
                   'PurchaseItems'          => 'purchase_items',
                   'PurchaseRequests'       => 'purchase_requests',
                   'PurchaseRequestItems'   => 'purchase_request_items',
                   'Requisitions'           => 'requisitions',
                   'RequisitionItems'       => 'requisition_items',
                   'Sells'                  => 'sells',
                   'SellItems'              => 'sell_items',
                   'StockBalances'          => 'stock_balances',
                  ];
        
        /**********************************************************************/
        
        //LISTA OS PERFIS
        $parameters = $this->Parameters->find('all')
                                       ->select(['Parameters.id', 'Parameters.razao', 
                                                 'Parameters.dtvalidade', 'Parameters.plans_id'
                                                ]);
        
        foreach ($parameters as $parameter):

            //Plano Limitado?
            $plano_limitado = false;

            /**************************************************************/

            //REGRAS PARA O PLANO LIMITADO
            if ($parameter->plans_id == '4') {

                //Identifica que o plano é limitado
                $plano_limitado = true;

                //Executa o backup do plano limitado somente no dia primeiro
                if (date('d') == '01') {
                    $plano_limitado = false;
                }//if (date('d') == '01')

            }//if ($parameter->plans_id == '4')

            /**************************************************************/
            
            //BACKUP APENAS DOS PERFIS DENTRO DA VALIDADE DE ACESSO E O PLANO NÃO SEJA LIMITADO (FORA DO DIA DE EXECUÇÃO)
            if ($parameter->dtvalidade > date('Y-m-d') && $plano_limitado == false) { 

                $return = "";

                /**********************************************************/
                
                //Executa função para as tabelas selecionadas
                foreach ($tables as $model => $table):
                    
                    $this->Model = TableRegistry::get($model);
                    $results = null;

                    /******************************************************/
                    
                    //Seleciona todos os dados da empresa logada
                    if ($table == 'parameters') {
                        
                        $results = $this->Model->find('all')
                                               ->where(['id' => $parameter->id]);
                        
                    } elseif ($table == 'users') {

                        $users = $this->UsersParameters->find('all')
                                                       ->select(['users_id'])
                                                       ->where(['parameters_id' => $parameter->id]);
                        $list_of_users = [];

                        /**************************************************/

                        foreach ($users as $user):
                            array_push($list_of_users, $user->users_id);
                        endforeach;

                        /**************************************************/

                        $results = $this->Model->find('all')
                                               ->where(['id IN' => $list_of_users]);

                    } elseif ($table == 'rules') {

                        $results = $this->Model->find('all');

                    } else {

                        $results = $this->Model->find('all')
                                               ->where(['parameters_id' => $parameter->id]);

                    }//else elseif ($table == 'rules')

                    /******************************************************/

                    //Try to get errors message
                    try {

                        if (!empty($results->toArray())) {

                            /*
                            $results_array = (array) $results->toArray();
                            foreach ((array) $results_array as $results_arr):
                                foreach ((array) $results_arr as $value):
                                    $arr[] = $value;
                                endforeach;
                            endforeach;
                            $field_names = array_keys($arr[1]); // Campos da tabela
                            */

                            /**************************************************/

                            //Guada a quantidade de campos da tabela
                            $field_names = $this->Model->schema()->columns(); // Campos da tabela
                            //unset($field_names[0]); //Remove o ID do arquivo exportado
                            $num_fields  = sizeof($field_names); // Quantidade de campos da tabela
                            $num_result  = sizeof($results->toArray()); // Quantidade de valores da tabela

                            /**************************************************/
                            
                            //PERCORRE TODOS OS CAMPOS DA TABELA
                            $return .= "INSERT INTO '" . $table . "' ('";

                            /**************************************************/
                            
                            //INFORMA OS CAMPOS DA TABELA
                            foreach ($field_names as $index => $j):
                                $return .= $j;
                                if ($index < $num_fields - 1) $return .= "', '";
                            endforeach;

                            /**************************************************/
                            
                            $return .= "') VALUES \n (";

                            /**************************************************/
                            
                            //INFORMA OS VALORES DOS CAMPOS
                            foreach ($results as $ind => $result): //foreach no resultado
                                
                                foreach ($field_names as $index => $j): //foreach nos campos
                                    
                                    //Remove o ID do arquivo exportado
                                    //unset($result[$table]['id']);
                                    if (isset($result[$j])) {
                                    
                                        //Modifica o formato da data
                                        if (strlen($result[$j]) == '14' && strpos($result[$j], '/') && strpos($result[$j], ':')) {
                                            $result[$j] = $result[$j]->i18nFormat('YYYY-MM-dd HH:mm');
                                            //$date = date('Y-m-d H:i', strtotime($result[$j]));
                                        }//if (strlen($result[$j]) == '14' && strpos($result[$j], '/') && strpos($result[$j], ':'))

                                        //echo($result[$j]);
                                        //echo '<br>';
                                        
                                        //Remover aspas das descrições
                                        $result[$j] = str_replace('"', '', $result[$j]);
                                        $result[$j] = str_replace("'", '', $result[$j]);
                                        
                                        $return .= '"' . ($result[$j]) . '"'; //Adiciona aspas nos valores
                                    } else {
                                        $return .= 'NULL'; //Campos vazios são preenchidos com NULL
                                    }// else if (isset($result[$j]))
                                    
                                    if ($index < $num_fields - 1) $return .= ', '; //Separa campos por vírgula
                                    
                                endforeach;
                                
                                if ($ind < $num_result - 1) $return .= "),\n ("; //Separa registros por parênteses
                                
                            endforeach;

                            /**************************************************/
                            
                            $return .= ");\n"; //Separa tabelas por ponto-e-vírgula
                            //$return.= "<br><br>";

                        }//if (!empty($results->toArray()))
                        
                    } catch (Exception $e) {
                        //Alerta de errors
                        Log::write('debug', 'BackupFunctionsComponent->backupFull: ERROR' . json_encode($results));
                    }

                    /******************************************************/
                    
                    $return .= "\n";
                    //echo $return;
                    
                endforeach;
                //echo $return;
        
                /**************************************************************/

                //echo ("-" . $parameter->razao) . "<br>";
                $filename = 'db-backup-' . date('Y-m-d-H-i-s') . '_' . utf8_decode($parameter->razao) . '.sql';
                $filenames[] = $filename;
                $handle = fopen('backup/'.$filename, 'w+');
                fwrite($handle, $return);
        
                /**************************************************************/

                //Envia e-mail com confirmação de backup realizado
                $size = filesize('backup/'.$filename);
                
                if ($size <= 0) {

                    //Alerta de erro
                    $message = 'BackupFunctionsComponent->backupFull, houve algum erro no tamanho do arquivo de backup: '.$size.'kb - '.$return;
                    $this->Error->registerError(null, $message, true);

                }// if ($size <= 0)
        
                /**************************************************************/

                fclose($handle);
                unset($return);
                unset($list_of_users);
                
            }//if ($parameter->dtvalidade > date('Y-m-d') && $plano_limitado == false)
            
        endforeach;

        /**********************************************************************/

        //Relação de arquivos criados
        if (is_array($filenames)) {

            //Envio de e-mail com relatório do CRON
            $sendMail = ['subject'  => 'SISTEMA R2: Backup do Sistema Realizado',
                         'template' => 'backup_email_template',
                         'vars'     => ['filenames'  => $filenames],
                         'toEmail'  => null
                        ];

            $this->EmailFunctions->sendMail($sendMail);

        }//if (is_array($filenames))
        
        return $filenames;
        
    }

    public function cleanExceedFiles()
    {   
        set_time_limit(120);
        ini_set('max_execution_time', 120);

        /**********************************************************************/

        $id = 0;
        $quantity = 0;
        
        /**********************************************************************/

        //AQUIVOS FTP
        if (!empty($arquivos = $this->Ftp->index())) {
            
            //LISTA OS ARQUIVOS FTP
            foreach ($arquivos as $arquivo):

                if (substr(strrchr($arquivo['filename'], "."), 1) == 'sql') {
                    
                    $backups[] = ['file'      => utf8_encode($arquivo['filename']),
                                  'id'        => $id++,
                                  'modified'  => date("d/m/Y H:i:s", $arquivo['mtime']),
                                  'size'      => round(($arquivo['size'] / 1024), 2),
                                ];
                    $array_date[] = date("Y-m-d", $arquivo['mtime']);
                    $quantity++;

                }//if (substr(strrchr($arquivo['filename'], "."), 1) == 'sql')

            endforeach;

            //EXCLUI ARQUIVOS ANTIGOS ACIMA DE 200 CÓPIAS
            if ($quantity > 200) {
                
                //Ordena o Array
                array_multisort($array_date, SORT_ASC, $arquivos);
            
                //Exclui os mais antigos
                for ($x = 0; $x < ($quantity-200); $x++) {

                    $this->Ftp->delete($arquivos[$x]['filename']);

                }//for ($x = 0; $x <= ($quantity-200); $x++)

            }//if ($quantity > 200)

        }//if (!empty($arquivos = $this->Ftp->index()))
    }
    
    public function backupFTP()
    {
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        //Realiza backup completo
        $backup = $this->backupFull();
        
        /**********************************************************************/
        
        foreach ($backup as $filename):
            
            //Faz upload do arquivo
            $this->Ftp->upload($filename);
        
            /******************************************************************/

            //Consulta se o arquivo está completo
            if ($this->Ftp->consulta($filename)) {
                
                //Grava nome do arquivo para alerta de e-mail
                $filenames[] = $filename;

                //Exclui arquivo local
                $file = new File('backup/' . utf8_decode($filename));
                $file->delete();
                $file->close();
                
            } else {

                //Alerta de erro
                $message = 'BackupFunctionsComponent->backupFTP, houve algum erro no backup via FTP: '.$filename;
                $this->Error->registerError(null, $message, true);

            }//if ($this->Ftp->consulta($filename))
            
        endforeach;

        /**********************************************************************/

        //LIMPA ARQUIVOS ANTIGOS (Quando acima de 200 arquivos no diretório)
        $this->cleanExceedFiles();

        /**********************************************************************/

        //Relação de arquivos gravados no FTP
        if (is_array($filenames)) {

            //Envio de e-mail com relatório do CRON
            $sendMail = ['subject'  => 'SISTEMA R2: Backup do Sistema no FTP',
                         'template' => 'backupftp_email_template',
                         'vars'     => ['filenames'  => $filenames],
                         'toEmail'  => null
                        ];

            $this->EmailFunctions->sendMail($sendMail);

        }//if (is_array($filenames))
        
        return $backup;
        
    }
    
}