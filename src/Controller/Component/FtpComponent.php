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
use phpseclib\Net\SFTP;
use Cake\Log\Log;

class FtpComponent extends Component 
{
    //CONFIGURAÇÃO FTP
    //private $host     = "sftp://reiniciando.com.br";
    private $host     = "reiniciando.com.br";
    private $port     = 1234;
    private $path     = "www/backups/";
    private $username = "username";
    private $password = "@password";
    private $sftp     = true;
    public $connected = null;
    
    public function __construct()
    {
        $this->Error = new ErrorComponent();
        $this->sftp  = new SFTP($this->host, $this->port);

        try {
            
            if ($this->sftp->login($this->username, $this->password)) {

                //Marca como conectado
                $this->connected = true;
                
                //Entra do diretório de backups
                $this->sftp->chdir($this->path);
                
            }//if ($this->sftp->login($this->username, $this->password))

		} catch (Exception $e) {
            
            //exit('sftp Login Failed');
            $this->connected = false;

            //Alerta de erro
            $message = 'FtpComponent->__construct: '.json_encode($e->getMessage());
            $this->Error->registerError(null, $message, true);

		}
        
        /****************************************/
        
        //$sftp->mkdir('test'); // create directory 'test'
        //$sftp->chdir('test'); // open directory 'test'
        //$sftp->chdir('..'); // go back to the parent directory
        //$sftp->rmdir('test'); // delete the directory
        
    }
    
    public function index() 
    {
        if ($this->connected) {

            try {
                
                foreach($this->sftp->nlist() as $file):
                    if ($file != '.' && $file != '..') {
                        $contents[] = array_merge(['filename' => $file], $this->sftp->stat($file));
                    }
                endforeach;
                
                /*
                (int) 0 => ['filename' => 'reinicia_financeiro_20170810.sql',
                            'size' => (int) 4021652,
                            'uid' => (int) 504,
                            'gid' => (int) 504,
                            'permissions' => (int) 33188,
                            'mode' => (int) 33188,
                            'type' => (int) 1,
                            'atime' => (int) 1517853828,
                            'mtime' => (int) 1517853862
                           ]
                 */
                
                if (isset($contents)) {
                    return $contents;
                }
                
                return false;
                
            } catch (Exception $e) {
                
                //Alerta de erro
                $message = 'FtpComponent->index: '.json_encode($e->getMessage());
                $this->Error->registerError(null, $message, true);
                
            }

        }//if ($this->connected)
    }
    
    public function consulta($file)
    {
        $file = utf8_decode($file);
        
        if (!empty($file) && $this->connected) {
            
            try {
                
                foreach($this->sftp->nlist() as $value):
                    
                    if ($value != '.' && $value != '..') {
                        
                        //Recebe os status do arquivo FTP
                        $stats = $this->sftp->stat($file);
                        $filesize = filesize('backup/'.$file);
                        
                        //Concilia o nome e o tamanho dos arquivos
                        if ($file == $value && $filesize == $stats['size']) {
                            return true;
                        }
                        
                    }//if ($file != '.' && $file != '..')
                    
                endforeach;
                
                return false;
                
            } catch (Exception $ex) {
                
                //Alerta de erro
                $message = 'FtpComponent->consulta: '.json_encode($e->getMessage());
                $this->Error->registerError(null, $message, true);
                
            }
            
        }//if (!empty($file) && $this->connected)
    }
    
    public function upload($file) 
    {
        //$file = base64_decode(urldecode($file));
        set_time_limit(240);
        ini_set('max_execution_time', 240);
        $file = utf8_decode($file);
        
        if (!empty($file) && $this->connected) {
            
            try {
                
                $source_file      = 'backup/'.$file;
                $destination_file = $file;
                
                if ($this->sftp->put($destination_file, $source_file, SFTP::SOURCE_LOCAL_FILE | SFTP::RESUME)) {
                    return true;
                }
                
                return false;
                
            } catch (Exception $e) {
                
                //Alerta de erro
                $message = 'FtpComponent->upload: '.json_encode($e->getMessage());
                $this->Error->registerError(null, $message, true);
                
            }
            
        }//if (!empty($file) && $this->connected)
    }
    
    public function download($file) 
    {
        //$file = base64_decode(urldecode($file));
        set_time_limit(120);
        ini_set('max_execution_time', 120);
        $file = utf8_decode($file);
        
        if (!empty($file) && $this->connected) {
            
            try {
                
                //Retorna arquivo para download
                return $this->sftp->get($file);
                
            } catch (Exception $e) {
                
                //Alerta de erro
                $message = 'FtpComponent->download: '.json_encode($e->getMessage());
                $this->Error->registerError(null, $message, true);
                
            }
            
        }//if (!empty($file) && $this->connected)
    }
    
    public function delete($file) 
    {
        //$file = base64_decode(urldecode($file));
        $file = utf8_decode($file);
        
        if (!empty($file) && $this->connected) {
            
            try {
                
                // non-recursive delete
                return $this->sftp->delete($file, false);
                
            } catch (Exception $e) {
                
                //Alerta de erro
                $message = 'FtpComponent->delete: '.json_encode($e->getMessage());
                $this->Error->registerError(null, $message, true);
                
            }
            
        }//if (!empty($file) && $this->connected)
        
    }
    
}
