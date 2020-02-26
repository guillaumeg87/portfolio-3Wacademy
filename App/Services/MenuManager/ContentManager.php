<?php
namespace Services\MenuManager;

use Services\FlashMessages\FlashMessage;
use Services\MenuManager\Requests\ContentRequest;

class ContentManager
{

    public function getMenu()
    {
        return (new ContentRequest())->getMenuEntryList();
    }

    public function addEntry(array $datas, bool $isTaxonomy)
    {

        $isContentExist = (new ContentRequest())->isExist($datas);

        if(empty($isContentExist)){
            $result = (new ContentRequest())->createMenuEntry($datas, $isTaxonomy);
            if($result){

                return (new FlashMessage(
                    'Le nouveau type de contenu a bien été enregistré.',
                    'success'
                ))->messageBuilder();
            }
        }else{

            return (new FlashMessage(
        'Le contenu saisi comporte un nom technique (technical name) déjà utilisé.',
            'warning'
            ))->messageBuilder();
        }
    }
}
