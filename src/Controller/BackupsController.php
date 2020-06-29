<?php

/**
 * Developed by:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

/* Backups */
/* File: src/Controller/BackupsController.php */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;

class BackupsController extends AppController
{
    var $uses = false;
    
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('Ftp');
        $this->loadComponent('BackupsFunctions');
    }
    
    public function index()
    {
        /* EXCLUIR SELECIONADOS */
        if ($this->request->is('post')) {
            
            $deleted = $nodeleted = 0;
            $delete = $this->request->data;
            
            /******************************************************************/
            
            if (!isset($delete['record']) || !count($delete['record'])) {
                $this->Flash->warning(__('Nenhum registro selecionado'));
                return $this->redirect($this->referer());
            }//if (!isset($delete['record']) || !count($delete['record']))
            
            /******************************************************************/
            
            $key = key($delete['record']);
            
            /******************************************************************/
            
            if ($delete['source'][$key] == 'Local') {
                
                foreach($delete['record'] as $file):
                    
                    $file = new File('backup/' . utf8_decode($file));
                    
                    if ($file->delete()) {
                        $deleted++;
                    } else {
                        $nodeleted++;
                    }

                    $file->close();

                endforeach;
                
            } elseif ($delete['source'][$key] == 'Remoto') {
                
                foreach($delete['record'] as $file):
                
                    if ($this->Ftp->delete($file)) {
                        $deleted++;
                    } else {
                        $nodeleted++;
                    }
                    
                endforeach;
                
            }//elseif ($delete['source'][$key] == 'Remoto')
            
            /******************************************************************/
            
            if ($nodeleted == 0) {
                $this->Flash->success(__($deleted . ' Registros excluídos com sucesso'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__($nodeleted . ' Registros NÃO excluídos, tente novamente'));
                return $this->redirect($this->referer());
            }
            
        }//if ($this->request->is('post'))
        
        /**********************************************************************/
        
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        //CRIA DIRETÓRIO SE NÃO EXISTIR
        if (!file_exists('backup/')) {
            umask(0); 
            @mkdir("backup", 0777, true);
        }
        
        /**********************************************************************/
        
        $path = "backup/";
        $diretorio = dir($path);
        $backups = [];
        $id = 0;
        $remote_files['quantity'] = 0;
        $local_files['quantity'] = 0;
        $remote_files['size'] = 0;
        $local_files['size'] = 0;

        
        /**********************************************************************/
        
        //AQUIVOS NO DIRETÓRIO LOCAL
        while ($arquivo = $diretorio->read()) {
            
            if (utf8_encode($arquivo) != '.' && utf8_encode($arquivo) != '..' && substr(strrchr($arquivo, "."), 1) == 'sql') {
                
                $backups[] = ['file'      => $arquivo,
                              'id'        => $id++,
                              'modifield' => date("d/m/Y H:i:s", filemtime($path . $arquivo)),
                              'size'      => round((filesize($path . $arquivo) / 1024), 2),
                              'source'    => 'Local'
                             ];
                $local_files['quantity']++;
                $local_files['size'] += round((filesize($path . $arquivo) / 1024), 2);
                
            }//if (utf8_encode($arquivo) != '.' && utf8_encode($arquivo) != '..')
            
        }//while ($arquivo = $diretorio->read())
        
        /**********************************************************************/
        
        //AQUIVOS FTP
        if (!empty($arquivos = $this->Ftp->index())) {
            
            foreach ($arquivos as $arquivo):

                if (substr(strrchr($arquivo['filename'], "."), 1) == 'sql') {
                    
                    $backups[] = ['file'      => utf8_encode($arquivo['filename']),
                                'id'        => $id++,
                                'modifield' => date("d/m/Y H:i:s", $arquivo['mtime']),
                                'size'      => round(($arquivo['size'] / 1024), 2),
                                'source'    => 'Remoto'
                                ];
                    $remote_files['quantity']++;
                    $remote_files['size'] += round(($arquivo['size'] / 1024), 2);

                }//if (substr(strrchr($arquivo['filename'], "."), 1) == 'sql')

            endforeach;
            
        }//if (!empty($arquivos = $this->Ftp->index()))
        
        /**********************************************************************/
        
        rsort($backups);
        
        /**********************************************************************/
        
        $this->set(compact('backups', 'remote_files', 'local_files'));
        
        /**********************************************************************/
        
        $diretorio->close();
    }
    
    public function upload($file)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        //Consulta se o arquivo já está no servidor
        if ($this->Ftp->consulta($file)) {
            
            //Exclui arquivo local
            $file = new File('backup/' . utf8_decode($file));
            $file->delete();
            $file->close();
            
            $this->Flash->warning(__('O backup já foi gravado no servidor remoto anteriormente'));
            return $this->redirect($this->referer());
            
        }//if ($this->Ftp->consulta($file))
        
        /**********************************************************************/
        
        //Arquivo do backup
        if (!$this->Ftp->upload($file)) {
            $this->Flash->error(__('Backup NÃO foi gravado no servidor remoto'));
            return $this->redirect($this->referer());
        }//if (!$this->Ftp->upload($file))
        
        /**********************************************************************/
        
        //Consulta se o arquivo está completo
        if ($this->Ftp->consulta($file)) {
            
            //Exclui arquivo local
            $file = new File('backup/' . utf8_decode($file));
            $file->delete();
            $file->close();
            
            $this->Flash->success(__('O backup foi gravado no servidor remoto com sucesso'));
            return $this->redirect($this->referer());
            
        }
        
        $this->Flash->error(__('Backup NÃO foi gravado no servidor remoto'));
        return $this->redirect($this->referer());
    }
    
    public function download($file)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        $this->response->file('backup/' . utf8_decode($file));
        
        /**********************************************************************/
         
        return $this->response;
    }
    
    public function downloadFTP($file)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        
        /**********************************************************************/
        
        //Arquivo do backup
        $download = $this->Ftp->download($file);
        
        if ($download) {
            
            //Escreve a mensagem no response
            $this->response->getBody()->write(($download));
            
            //Define o tipo do conteúdo
            $this->response = $this->response->withType('html/text');
            
            //Retorna arquivo para download
            return $this->response;
            
        }//if ($download)
        
        return false;
    }
    
    public function backupFull()
    {
        if ($this->BackupsFunctions->backupFull()) {
            
            $this->Flash->success(__('Backup completo realizado com sucesso'));
            return $this->redirect($this->referer());
            
        }//if ($this->BackupsFunctions->backupFull())
        
        $this->Flash->error(__('Houve um problema ao realizar o backup do sistema. Entre em contato com o suporte'));
        return $this->redirect($this->referer());
            
    }
    
    public function backupFTP()
    {
        if ($this->BackupsFunctions->backupFTP()) {

            $this->Flash->success(__('O backup foi gravado no servidor remoto com sucesso'));
            return $this->redirect($this->referer());
            
        }//if ($this->BackupsFunctions->backupFTP())
        
        $this->Flash->error(__('Backup NÃO foi gravado no servidor remoto'));
        return $this->redirect($this->referer());
        
    }
    
    public function backup()
    {
        //PARAMETERS
        $this->Parameters = TableRegistry::get('Parameters');
        
        /**********************************************************************/
        
        if ($this->request->is('post')) {
            //AppController - Controle de Permissões
            if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
                $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
                return $this->redirect($this->referer());
            }//if (!$this->SystemFunctions->validaAcesso('admin', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
            
            //CRIA DIRETÓRIO SE NÃO EXISTIR
            if (!file_exists('backup/')) {
                umask(0); 
                @mkdir("backup", 0777, true);
            }//if (!file_exists('backup/'))
            
            //Inicializa variável
            $return = " ";
            
            //Incrementa variável com as dependências do banco
            if (!empty($this->request->data['moviments']) && $this->request->data['moviments'] == '1') {
                $this->request->data['moviment_mergeds'] = '1';
                $this->request->data['moviment_recurrents'] = '1';
            }
            
            if (!empty($this->request->data['moviment_cards']) && $this->request->data['moviment_cards'] == '1') {
                $this->request->data['moviments_moviment_cards'] = '1';
            }
            
            if ($this->request->data['radio'] == 'sql') {
                
                unset($this->request->data['radio']);
                
                //Executa função para as tabelas selecionadas
                foreach($this->request->data as $table => $value):
                    
                    //Seleciona todos os dados da empresa logada
                    $results = $this->Parameters->query("SELECT * FROM " . $table . " WHERE parameters_id = " . $this->request->Session()->read('sessionParameterControl'));
                    
                    //Guada a quantidade de campos da tabela
                    $field_names = array_keys($results[0][$table]); // Campos da tabela
                    //unset($field_names[0]); //Remove o ID do arquivo exportado
                    $num_fields  = sizeof($field_names); // Quantidade de campos da tabela
                    $num_result  = sizeof($results); // Quantidade de valores da tabela
                    
                    if (!empty($results)) {
                        
                        //PERCORRE TODOS OS CAMPOS DA TABELA 
                        $return.= "INSERT INTO '" . $table . "' ('";
                        
                        //INFORMA OS CAMPOS DA TABELA
                        foreach($field_names as $index => $j):
                            $return.= $j;
                            if ($index < $num_fields) $return.= "', '";
                        endforeach;
                        
                        $return.= "') VALUES (";
                        
                        //INFORMA OS VALORES DOS CAMPOS
                        foreach($results as $ind => $result): //foreach no resultado
                            
                            foreach($field_names as $index => $j): //foreach nos campos
                                
                                //Remove o ID do arquivo exportado    
                                //unset($result[$table]['id']); 
                                
                                if (isset($result[$table][$j])) {
                                    $return.= '"' . utf8_decode($result[$table][$j]) . '"'; //Adiciona aspas nos valores
                                } else {
                                    $return.= 'NULL'; //Campos vazios são preenchidos com NULL
                                }
                                
                                if ($index < $num_fields) $return.= ', '; //Separa campos por vírgula
                                
                            endforeach;
                            if ($ind < $num_result - 1) $return.= "),\n ("; //Separa registros por parênteses
                            
                        endforeach;
                        $return.= ");\n"; //Separa tabelas por ponto-e-vírgula
                    }
                    
                    $return.= "\n\n";
                endforeach;
                
                $filename = 'backup/db-backup-' . date('Y-m-d-H-i-s') . '_' . ((implode(', ', array_keys($this->request->data)))) . '.sql';
                $handle = fopen($filename, 'w+');
                
                fwrite($handle, utf8_decode($return));
                fclose($handle);
                
            } elseif ($this->request->data['radio'] == 'csv') {
                
                unset($this->request->data['radio']);
                
                //ABRE O ARQUIVO
                $filename = 'backup/db-backup-' . date('Y-m-d-H-i-s') . '_' . ((implode(', ', array_keys($this->request->data)))) . '.csv';
                $handle = fopen($filename, 'w+');
                
                //Executa função para as tabelas selecionadas
                foreach($this->request->data as $table => $value):
                    
                    $results = $this->Parameters->query("SELECT * FROM " . $table . " WHERE parameters_id = " . $this->request->Session()->read('sessionParameterControl'));
                    
                    if (!empty($results)) {
                        //ACRESCENTA O NOME DA TABELA AO CSV
                        fputcsv($handle, ['Table' => $table]);
                        
                        //Guada a quantidade de campos da tabela
                        $field_names = array_keys($results[0][$table]); // Campos da tabela
                        unset($field_names[0]); //Remove o ID do arquivo exportado
                        
                        //INFORMA OS VALORES DOS CAMPOS
                        foreach($results as $result): //foreach no resultado
                            
                            //Remove o ID do arquivo exportado
                            unset($result[$table]['id']); 
                            
                            //Decodifica os valores UTF8
                            foreach($field_names as $j):
                                $result[$table][$j] = utf8_decode($result[$table][$j]);
                            endforeach;
                            
                            //Grava valores no arquivo
                            fputcsv($handle, ($result[$table]));
                            
                        endforeach;
                    }
                    
                endforeach;
                
                //FECHA O ARQUIVO
                fclose($handle);
                
            }//if ($this->request->data['radio'] == SQL ou CSV
            
            //CRIA LINK PARA DOWNLOAD
            $download =  '<a href="' . $filename . '">Download</a>';
            
            if ($filename) {
                $this->Flash->success(__("Backup realizado com sucesso ") . $download, ['escape' => false]);
                return $this->redirect($this->referer());
            }
            
            $this->Flash->error(__('Backup NÃO realizado, tente novamente'));
            return $this->redirect($this->referer());
        }
    }

    public function cleanExceedFiles()
    {
        //Pode ser chamado através da URL /backups/cleanExceedFiles
        $this->BackupsFunctions->cleanExceedFiles();
        return $this->redirect($this->referer());
    }
    
    public function delete($file)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        $file = new File('backup/' . utf8_decode($file));
        
        /**********************************************************************/
        
        if ($file->delete()) {
            
            //Fecha conexão após exclusão
            $file->close();
            
            $this->Flash->warning(__('O backup local foi excluído com sucesso'));
            return $this->redirect($this->referer());
            
        }//if ($file->delete())
        
        /**********************************************************************/
        
        //Fecha conexão em caso de erro
        $file->close();
        
        /**********************************************************************/
        
        $this->Flash->error(__('O backup local NÃO foi excluído'));
        return $this->redirect($this->referer());
    }
    
    public function deleteFTP($file)
    {
        //AppController - Controle de Permissões
        if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl'))) {
            $this->Flash->warning(__('Sem permissão para realizar a operação solicitada'));   
            return $this->redirect($this->referer());
        }//if (!$this->SystemFunctions->validaAcesso('super', $this->Auth->user('id'), $this->request->Session()->read('sessionParameterControl')))
        
        /**********************************************************************/
        
        $this->request->allowMethod(['post', 'delete']);
        
        /**********************************************************************/
        
        if ($this->Ftp->delete($file)) {
            
            $this->Flash->warning(__('O backup remoto foi excluído com sucesso'));
            return $this->redirect($this->referer());
            
        }//if ($this->Ftp->delete($file))
        
        /**********************************************************************/
        
        $this->Flash->error(__('O backup remoto NÃO foi excluído'));
        return $this->redirect($this->referer());
    }
}