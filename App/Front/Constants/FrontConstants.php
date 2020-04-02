<?php


namespace Front\Constants;


final class FrontConstants
{
    const FRONT_HEADER = 'header';
    const FRONT_MAIN = 'main';
    const FRONT_FOOTER = 'footer';

    const FRONT_CONFIG_SECTIONS = [
        self::FRONT_HEADER => [],
        self::FRONT_MAIN => [],
        self::FRONT_FOOTER => [],
    ];

    const FRONT_CONFIGURATIONS_PATH = '../Front/Configurations/';
}
