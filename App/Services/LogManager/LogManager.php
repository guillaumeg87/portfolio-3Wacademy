<?php

namespace Services\LogManager;

class LogManager
{

    public function log(string $error, string $label, string $type)
    {
        $isTargetExist = $this->checkFile($label);

        if ($isTargetExist) {

            $this->writeFile($error, $label, $type);
        }
    }

    public function checkFile(string $label)
    {

        $targetDir = $this->getTargetDir($label);

        try {
            if (!\file_exists($targetDir)) {

                return \mkdir($targetDir, 0777, true) &&
                    \file_put_contents($targetDir . \strtolower($label) . LogConstants::FILE_SLUG_NAME . LogConstants::FILE_EXTENSION,
                        '/***** ' . $label . ' LOG *****/' . PHP_EOL);
            }
        } catch (\Exception $e) {
            $this->log(
                '[ LOG MANAGER ] An error occured durind checking logs files' . PHP_EOL . $e->getTraceAsString(),
                LogConstants::ERROR_PHP_LABEL,
                LogConstants::ERROR_LABEL);
            return false;
        }
        return true;
    }

    private function writeFile(string $error, string $label, string $type)
    {
        $targetDir = $this->getTargetDir($label);

        $errordate = new \DateTime();
        \file_put_contents($targetDir . \strtolower($label) . LogConstants::FILE_SLUG_NAME . LogConstants::FILE_EXTENSION, '[' . $errordate->format('Y-M-d H:m:i') . ']' . $type . ' : '. PHP_EOL . $error . PHP_EOL, FILE_APPEND);
    }

    private function getTargetDir(string $label)
    {
        return $label === LogConstants::ERROR_PHP_LABEL ?
            LogConstants::PHP_LOG_DIRECTORY_ROOT :
            LogConstants::APP_LOG_DIRECTORY_ROOT;
    }

    /**
     * Format Log Informations for admin widget
     * @return array
     */
    public function logInfos():array
    {
        $datas = [];
        if (\is_dir(LogConstants::LOGS_DIRECTORY_ROOT)){
            foreach (LogConstants::LOGS_FILES as $key => $value) {

                if (is_file(LogConstants::LOGS_FILES[$key] . $key . LogConstants::FILE_SLUG_NAME . LogConstants::FILE_EXTENSION)){
                    $filesize = (\filesize(LogConstants::LOGS_FILES[$key] . $key . LogConstants::FILE_SLUG_NAME . LogConstants::FILE_EXTENSION));
                    $datas[$key]['file'] = $key;
                    $datas[$key]['size'] = $this->filesizeFormat($filesize);
                    $datas[$key]['class'] = $filesize < 2000000 ? 'log-infos success' : 'log-infos error';
                }
            }

        }
        return $datas;
    }

    /**
     * Generate log file size for widget admin
     * @param int $filesize
     * @return string
     */
    private function filesizeFormat(int $filesize):string
    {
        $size   = array(' o', ' Ko', ' Mo', ' Go', ' To');
        $factor = floor((strlen($filesize) - 1) / 3);
        $dec = 2;

        return sprintf("%.{$dec}f", $filesize / pow(1024, $factor)). @$size[$factor];

    }


}
