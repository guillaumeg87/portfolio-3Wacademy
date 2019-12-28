<?php


namespace Services\Dumper;


class Dumper
{
    /**
     * Helper for debug
     * Datas are more reaadable
     *
     * @param $data
     * @return bool|string
     */
    public static function dump($data)
    {
        return highlight_string("<?php\n\$data =\n" . var_export($data, true) . ";\n?>");
    }
}
