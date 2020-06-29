<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;

/**
 * Proposals Controller
 *
 *
 * @method \App\Model\Entity\Proposal[] paginate($object = null, array $settings = [])
 */
class ProposalsController extends AppController
{

    use MailerAwareTrait;

    public function requestProposal(){

    	if ($this->request->is('post')) {
    		$this->getMailer('Proposals')->send('requestProposalMail',
    			[
    				$this->request->data,
    				$this->request->data['email'],
    				'setorti@qualitex.com.br'
    			]);

            return $this->redirect(
                ['controller' => 'Answer', 'action' => 'answer_proposals']
            );
    	}

    }

}

