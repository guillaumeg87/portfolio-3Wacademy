<?php


namespace Admin\Core\Traits;

use Services\MenuManager\ContentManager;

trait NavigationTrait
{
    /**
     * Get Navigation data for each admin controller
     * @return array
     */
    public function getNavigation(){

        $menuMgr = new ContentManager();
        return $menuMgr->getMenu();
    }

    //@TODO
    // faire quelque chose de similaire pur la nav coté front
}
