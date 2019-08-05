<?php
namespace Services\FlashMessages;

class FlashMessage
{
    private $message;

    private $type;

    public function __construct($message, $type)
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function messageBuilder()
    {
        return [
            'flash-message' => $this->message,
            'type-class'    => $this->type
        ];
    }

}