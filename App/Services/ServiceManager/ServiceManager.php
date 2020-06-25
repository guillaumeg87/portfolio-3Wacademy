<?php


namespace Services\ServiceManager;


use Admin\Core\Entity\User;
use Services\ApiManager\ApiManager;
use Services\FlashMessages\FlashMessage;
use Services\FormBuilder\Core\FormBuilderManager;
use Services\FrontManager\FrontManager;
use Services\ImagesManager\ImagesManager;
use Services\Mailer\MailerService;
use Services\MenuManager\ContentManager;
use Services\PaginationManager\PaginationManager;
use Services\Templating\Engine\TemplateEngine;
use Services\Widget\AdminWidgetManager;

class ServiceManager
{

    /**
     * Get FlashMessage
     * @param string $message
     * @param string $type
     * @return FlashMessage
     */
    public function getFlashMessage(string $message, string $type): FlashMessage
    {
        return new FlashMessage($message, $type);
    }


    /**
     * Get MenuManager
     * @return ContentManager
     */
    public function getMenuManager(): ContentManager
    {
        return new ContentManager();
    }

    /**
     * Get Mailer
     * @param User $to
     * @param $subject
     * @param $message
     * @return MailerService
     */
    public function getMailer(User $to, $subject, $message): MailerService
    {
        return new MailerService($to, $subject, $message);
    }

    /**
     * Get Template Engine
     * @param $file
     * @return TemplateEngine
     */
    private function getTemplateEngine(string $file): TemplateEngine
    {
        return new TemplateEngine($file);
    }

    /**
     * @param array $params
     * @return FormBuilderManager
     */
    public function getFormBuilderManager(array $params):FormBuilderManager
    {
        return new FormBuilderManager($params);
    }

    /**
     * @param $contentName
     * @return AdminWidgetManager
     */
    public function getAdminWidget($contentName):AdminWidgetManager
    {
        return new AdminWidgetManager($contentName);
    }

    /**
     * @return ImagesManager
     */
    public function getImageManager():ImagesManager
    {
        return new ImagesManager();
    }

    /**
     * @return FrontManager
     */
    public function getFrontManager():FrontManager
    {
        return new FrontManager();
    }

    /**
     * @param $credentials
     * @return ApiManager
     */
    public function getApiManager($credentials):ApiManager
    {
        return new ApiManager($credentials);
    }

    /**
     * @return PaginationManager
     */
    public function getPaginationManager($params):PaginationManager
    {
        return new PaginationManager($params);
    }

}
