<?php


namespace Services\LogManager;


final class LogConstants
{
    const FILE_EXTENSION  = '.log';

    const APP_LOG_DIRECTORY_ROOT = '../Logs/app/';
    const PHP_LOG_DIRECTORY_ROOT = '../Logs/php/';
    const LOGS_DIRECTORY_ROOT = '../Logs';



    const FILE_SLUG_NAME = "_log";


    const ERROR_PHP_LABEL = 'PHP';
    const ERROR_APP_LABEL = 'APP';

    const INFO_LABEL = '[INFO]';
    const WARN_LABEL = '[WARN]';
    const ERROR_LABEL = '[ERROR]';


    const LOGS_FILES = [
        'app' => LogConstants::APP_LOG_DIRECTORY_ROOT,
        'php' => LogConstants::PHP_LOG_DIRECTORY_ROOT
    ];
}
