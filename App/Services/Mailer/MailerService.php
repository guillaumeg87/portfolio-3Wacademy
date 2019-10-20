<?php

namespace Services\Mailer;

use Admin\Core\Entity\User;

class MailerService
{
    /**
     * @var User $to
     */
    private $to;

    /**
     * @var String $subject
     */
    private $subject;

    /**
     * @var
     */
    private $message;


    private $header = [];

    public function __construct(User $to, $subject, $message)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->header = $this->headerBuilder();
    }

    /**
     *  Send mail
     * @TODO need test and improvement
     */
    public function sendMail()
    {
        return mail(
            $this->to->getEmail(),
            $this->subject,
            $this->message,
            $this->header
        );
    }

    /**
     * Build email header
     * @return array
     */
    private function headerBuilder()
    {
         return [
            'From' => 'gguillaumemail@gmail.com',
            'Reply-To' => 'gguillaumemail@gmail.com',
            'X-Mailer' => 'PHP/' . phpversion()
        ];
    }
}