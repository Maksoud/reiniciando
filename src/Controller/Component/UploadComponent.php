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
use Cake\Network\Exception\InternalErrorException;
use Cake\Utility\Text;

class UploadComponent extends Component
{
    public function send($data = null)
    {
        if (!empty($data)) {
            
            $filename      = $data['name'];
            $file_tmp_name = $data['tmp_name'];
            $dir           = WWW_ROOT . 'img' . DS . 'uploads';
            $type          = $data['type'];
            $allowed       = ['image/png', 'image/jpg', 'image/jpeg'];
            
            if (!in_array($type, $allowed)) {
                throw new InternalErrorException("File type was not accepted {$allowed}", 1);
            }
            
            if (is_uploaded_file($file_tmp_name)) {
                $filename = Text::uuid() . '-' . $filename;
                
                if (!move_uploaded_file($file_tmp_name, $dir . DS . $filename)) {
                    throw new InternalErrorException("File was not uploaded, something was wrong", 1);
                } else {
                    $dirImage = 'uploads/' . $filename;
                }
            }
            //Retorno do vetor com o caminho completo das imagens carregadas
            return $dirImage;
        }
    }
}