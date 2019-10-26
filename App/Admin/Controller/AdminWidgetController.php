<?php


namespace Admin\Controller;


use Admin\Requests\Content\ColorsRequest;
use Services\FlashMessages\FlashMessage;

class AdminWidgetController
{
    /**
     * @param $params
     * @param $contentName
     * @return bool
     */
    public function getElementList($contentName)
    {
        try{
            $request = new ColorsRequest();
            $isList = $request->selectAll($contentName);

            if($isList){
                return $params['list'] = $isList;
            }
        }catch (\Exception $e) {
            $options['flash-message'][] = (new FlashMessage(
                'ERROR : ' . '</br>' .
                'Code : ' . $e->getCode() .
                'Stack Trace : ' . $e->getTraceAsString() . '</br>' .
                'Message : ' . $e->getMessage() . '</br>' .
                'Line : ' . $e->getLine() . '</br>',
                'error'
            ))->messageBuilder();
        }
    }
}