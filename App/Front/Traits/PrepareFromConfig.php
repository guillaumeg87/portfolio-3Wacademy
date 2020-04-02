<?php
namespace Front\Traits;

use Front\Constants\FrontConstants;

trait PrepareFromConfig
{

    /**
     * @param string $param
     * @return null|array
     */
    public function prepare(string $param) :?array
    {
        $fileName = $param . '.json';
        $getConfigurations = null;

        return $this->fileChecker($fileName);
    }

    /**
     * @param string $fileName
     * @return array|null
     */
    private function fileChecker(string $fileName):?array
    {
        $configurations = null;
        if (file_exists(FrontConstants::FRONT_CONFIGURATIONS_PATH . $fileName)){
            $configurations = json_decode(\file_get_contents(
                FrontConstants::FRONT_CONFIGURATIONS_PATH . $fileName
            ), true);
        }
        return $configurations;
    }
}
