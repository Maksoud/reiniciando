<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Log\Log;

/**
 * User mailer.
 */
class UserMailer extends Mailer
{

    /**
     * Mailer's name.
     *
     * @var string
     */

    static public $name  = 'User';
    static public $email = 'renee.maksoud@correiarodrigues.com.br';
    
    public function falhaCritica($report)
    {
        $this->to(static::$email)
             ->profile('default')
             ->emailFormat('html')
             ->template('falha_email_template')
             ->layout('default')
             ->viewVars(['report'  => $report])
             ->subject('Falha Crítica do Sistema');
    }

}