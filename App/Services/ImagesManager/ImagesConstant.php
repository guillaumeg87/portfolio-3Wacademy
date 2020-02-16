<?php


namespace Services\ImagesManager;


final class ImagesConstant
{
    const IMAGE_FORMATS = ['jpg', 'png', 'jpeg', 'pdf'];
    const IMAGE_SIZE = '2000000'; // 2 Mo MAX FILE SIZE

    const IMAGE_TARGET_PATH_DIR = '/uploads';
    const IMAGE_DIR = '/img/';
    const DOC_DIR = '/pdf/';

    const LABEL_PDF = 'pdf';

}
