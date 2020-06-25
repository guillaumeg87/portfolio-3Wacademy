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

    // New key in GITHUB API Response
    const COMMIT_MESSAGE = 'commitMessage';
    const LABEL_COMMIT = 'labelCommit';

    // Github API
    const REPO_NAME = 'portfolio-3Wacademy';
}
