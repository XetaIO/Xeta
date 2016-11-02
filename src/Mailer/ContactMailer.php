<?php
namespace App\Mailer;

use Cake\Core\Configure;
use Cake\Mailer\Mailer;

class ContactMailer extends Mailer
{
    /**
     * Contact Email.
     *
     * @param array $viewVars The variables to pass to the view.
     *
     * @return void
     */
    public function contact($viewVars = [])
    {
        $this
            ->emailFormat('html')
            ->from(['contact@xeta.io' => 'Contact Form'])
            ->to(Configure::read('Site.contact_email'))
            ->subject(isset($viewVars['subject']) ? $viewVars['subject'] : 'Someone has contacted you')
            ->set($viewVars);
    }
}
