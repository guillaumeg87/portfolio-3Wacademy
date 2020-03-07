<?php

namespace Services\ImagesManager;

use Services\FlashMessages\FlashMessage;

class ImagesManager
{
    /**
     * @param $data
     * @return array|bool
     */
    public function imageHandler($data)
    {
        $extension = $this->getFileExtension($data['name']);
        $targetDirectory = $this->getTargetDirectoryPath(getcwd(), $extension);

        if ($data['error'] === 0 && in_array($extension, ImagesConstant::IMAGE_FORMATS)) {

            $size = (int)$data['size'];


            if ($size < ImagesConstant::IMAGE_SIZE) {
                $image = new Image($data);

                return move_uploaded_file($image->getTmpName(), $targetDirectory . $image->getName());

            }
            else {
                $flashMessage = (new FlashMessage(
                    'Le poids de l\'image est trop importante (inf à '. $this->getMaxSize() .') ' ,
                    'error'
                ))->messageBuilder();
            }
        }
        else {
            $flashMessage = (new FlashMessage(
                'Le format de l\'image n\'est aps pris en compte (jpeg, jpg, png, pff)',
                'error'
            ))->messageBuilder();
        }

        return $flashMessage;
    }

    /**
     * Return file extension
     * @param $fileName
     * @return string
     */
    private function getFileExtension($fileName)
    {
        return strtolower(end(explode('.',$fileName)));
    }

    /**
     * Return the max file size dynamically from the value set in ImagesConstant
     *
     * @return string
     */
    private function getMaxSize():string
    {
        return ((int)ImagesConstant::IMAGE_SIZE/1000000) . 'Mo';
    }

    /**
     * Handle target directory for image or docs stocking
     * Create directory if it doesn't exist
     * @param $path
     * @param $extension
     * @return string
     */
    private function getTargetDirectoryPath($path, $extension)
    {
        $target = $extension === ImagesConstant::LABEL_PDF ? ImagesConstant::DOC_DIR : ImagesConstant::IMAGE_DIR;
        if (!file_exists($path . ImagesConstant::IMAGE_TARGET_PATH_DIR)) {

            mkdir($path . ImagesConstant::IMAGE_TARGET_PATH_DIR . $target, 0777, true);
        }

        return $path . ImagesConstant::IMAGE_TARGET_PATH_DIR . $target;
    }

    /**
     * return image url
     * Could use for displaying img in frontend
     * Exemple : 'http://www.portfolio.localhost/uploads/img/test.jpeg'
     * @param $fileName
     * @return array
     */
    public function getFileUrl($fileName)
    {
        $extension = $this->getFileExtension($fileName);
        $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $target = $extension === ImagesConstant::LABEL_PDF ? ImagesConstant::DOC_DIR : ImagesConstant::IMAGE_DIR;

        return [
            'url' => $root . ImagesConstant::IMAGE_TARGET_PATH_DIR . $target . $fileName,
            'path' => ImagesConstant::IMAGE_TARGET_PATH_DIR . $target . $fileName
            ];
    }
}
