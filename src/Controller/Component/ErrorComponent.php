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
use Cake\Log\Log;

use BadMethodCallException;

class ErrorComponent extends Component 
{   
    public function __construct()
    {
        $this->EmailFunctions = new EmailFunctionsComponent();
    }
    
    public function registerError($object = null, $message, $mail = null)
    {
        if (is_object($object) || is_array($object)) {

            $message .= " \n" . "Object: " . json_encode($object);

            //Try to get errors message
            try {
                if (is_object($object)) {
                    $message .= " \n" . "Error: " . json_encode($object->errors());
                }//if (is_object($object))
            } catch (BadMethodCallException $e) {
                //Log::write('debug', 'BadMethodCallException: ' . $e);
            }

        }//if (!empty($object) || is_array($object))

        /**********************************************************************/

        //Registra no DEBUG
        Log::write('debug', $message);

        /**********************************************************************/

        //Envia e-mail
        if ($mail) {
            
            $sendMail = ['subject'  => 'SISTEMA R2: Falha de Sistema',
                         'template' => 'error_email_template',
                         'vars'     => ['message'  => $message],
                         'toEmail'  => null
                        ];

            $this->EmailFunctions->sendMail($sendMail);

        }//if ($mail)
        
    }
    
}