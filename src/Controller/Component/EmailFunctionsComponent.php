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
use Cake\Log\Log;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Mailer\Email;

class EmailFunctionsComponent extends Component 
{   
    public function __construct()
    {
        $this->Users = TableRegistry::get('Users');
    }

    public function sendMail($array)
    {
        //Verifica se o vetor foi preenchido
        if (!is_array($array)) {
            return false;
        }//if (!is_array($array))

        /**********************************************************************/

        //Tratamento dos campos
        array_key_exists('subject', $array)  ? $subject  = $array['subject']  : $subject = 'no subject was defined';
        array_key_exists('template', $array) ? $template = $array['template'] : $template = null;
        array_key_exists('vars', $array)     ? $vars     = $array['vars']     : $vars = null;
        array_key_exists('toEmail', $array)  ? $toEmail  = $array['toEmail']  : $toEmail = null;

        /**********************************************************************/

        if (!empty($toEmail)) {

            //Localiza o nome do usuário
            $user = $this->Users->findByUsername($toEmail)
                                ->select(['Users.id', 'Users.username', 'Users.name'])
                                ->first();

            //Caso o e-mail de cobrança não esteja vinculado a um usuário
            !empty($user) ? $to = [$toEmail => $user->name] : $to = [$toEmail];

        }//else if (empty($to))

        /**********************************************************************/

        try {

            //Cria objeto
            $Email = new Email();
            
            /******************************************************************/

            //Define campos e envia e-mail
            $Email->setEmailFormat('html')
                  ->setFrom(['suporte@reiniciando.com.br' => 'Reiniciando Sistemas'])
                  ->bcc(['suporte@reiniciando.com.br' => 'Reiniciando Sistemas'])
                  ->setSubject($subject)
                  ->setTemplate($template)
                  ->setViewVars($vars);
            
            /******************************************************************/

            //Identifica o destinatário
            !empty($to) ? $Email->setTo($to) : $Email->setTo(['suporte@reiniciando.com.br' => 'Reiniciando Sistemas']);
            
            /******************************************************************/

            //Envia E-mail
            if ($Email->send()) {
                return true;
            }//if ($Email->send())

            return false;
            
        } catch (\Exception $e) {

            //Alerta de erro
            $message = 'EmailsFunctionsComponent->sendMail, falha no envio de e-mail '.$e->getMessage() . ' - ' . json_encode($Email);
            Log::write('debug', $message);

        }//catch (\Exception $e)
    }
}