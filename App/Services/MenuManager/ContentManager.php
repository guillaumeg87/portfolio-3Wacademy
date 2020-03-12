<?php
namespace Services\MenuManager;


use Services\FlashMessages\FlashMessage;
use Services\MenuManager\Requests\ContentRequest;

class ContentManager
{

    const DANGER_ZONE = [
        'contentTechnicalName' => 'danger_zone',
        'contentDisplayName' => 'Danger Zone',
        'controller' => 'dangerZone',
    ];
    /**
     * @return array
     */
    public function getMenu():array
    {
        $itemsMenu = (new ContentRequest())->getMenuEntryList();

        $menuKeys = $this->getContentKey($itemsMenu);
        $sorting = $this->sortEntryInMenu($itemsMenu, $menuKeys);
        return $this->addDangerZone($sorting);
    }

    /**
     * @param array $datas
     * @param string $contentType
     * @return array
     */
    public function addEntry(array $datas, string $contentType):array
    {
        $flashMessage = '';
        $isContentExist = (new ContentRequest())->isExist($datas);

        if (empty($isContentExist)) {
            $result = (new ContentRequest())->createMenuEntry($datas, $contentType);
            if($result){

                $flashMessage =  (new FlashMessage(
                    'Le nouveau type de contenu a bien été enregistré.',
                    'success'
                ))->messageBuilder();
            }
        }
        else {

            $flashMessage =  (new FlashMessage(
        'Le contenu saisi comporte un nom technique (technical name) déjà utilisé.',
            'warning'
            ))->messageBuilder();
        }
        return $flashMessage;
    }

    /**
     * Extract keys  as suffix in ContentTechnicalName (Settings, Content, Tanonomy
     * @param $param
     * @return array
     */
    private function getContentKey($param):array
    {
        $menuKeys = [];
        if (!empty($param)){
            foreach ($param as $item) {

                foreach ($item as $key => $value){

                    if ($key === 'contentTechnicalName') {
                        $chunk = explode('_', $value);

                        if (!in_array($chunk[1], $menuKeys)){
                            $menuKeys[end($chunk)] = [];
                        }
                    }
                }
            }
        }

        return $menuKeys;
    }

    /**
     * Sort menu entry under each keys
     * @param $param
     * @param $menuKeys
     * @return array
     */
    private function sortEntryInMenu($param, $menuKeys):array
    {

        foreach ($menuKeys as $id => $ve) {

            foreach ($param as $item) {
                foreach ($item as $key => $value) {

                    if (preg_match('/_' . $id . '$/', $value)){

                        $menuKeys[$id][] = $item;
                    }
                }


            }
        }
        return $menuKeys;
    }

    /**
     * Add default field in menu : Danger Zone
     * @param $menuKeys
     * @return mixed
     */
    private function addDangerZone($menuKeys):array
    {
        if (!in_array('settings', $menuKeys)){
            $menuKeys['settings'][] = self::DANGER_ZONE;
        }
        else {
            $menuKeys['settings'] = self::DANGER_ZONE;
        }
        return $menuKeys;
    }
}
