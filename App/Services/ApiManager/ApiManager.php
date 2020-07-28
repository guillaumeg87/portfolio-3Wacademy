<?php

namespace Services\ApiManager;

use Services\LogManager\LogConstants;
use Services\LogManager\LogManager;

class ApiManager
{
    const AUTHORRIZATION_URL = "https://api.github.com/user";
    /**
     * @var $username string
     */
    private $username;

    /**
     * @var $endpoint string
     */
    private $endpoint;

    /**
     * @var $clientId string
     */
    private $clientId;

    /**
     * @var $clientSecret string
     */
    private $clientSecret;

    /**
     * @var $callback string
     */
    private $callback;

    /**
     * @var $callback string
     */
    private $token;

    public function __construct($params)
    {
        $this->username = $params['username'];
        $this->password = $params['password'];
        $this->clientId = $params['clientId'];
        $this->clientSecret = $params['clientSecret'];
        $this->endpoint = $params['url_endpoint'];
        $this->callback = $params['authorisation_callback_url'];
        $this->token = $params['token'];
    }

    /**
     * @return array
     */
    public function getAuthorization()
    {
        return $this->callAPI(self::AUTHORRIZATION_URL);
    }

    /**
     * Check if API calls is OK
     * @return mixed
     */
    public function getUser()
    {
        return $this->callAPI($this->endpoint . '/users/' . $this->username);
    }

    /**
     * @param string $url
     * @param array $params
     * @return array
     */
    private function callAPI(string $url, array $params = []): array
    {
        $curl = curl_init();
        $this->logRequest($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->username);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->token,
            'Content-Type: application/json',
        ]);
        $result = curl_exec($curl);

        $response = $this->extactDataFromResult($result);

        return [
            'response' => $response['body'],
            'pagination' => $response['pagination'],
            'code' => curl_getinfo($curl, CURLINFO_RESPONSE_CODE),
        ];
    }

    /**
     * @param int $page
     * @param int $per_page
     * @return array
     */
    public function getCommitList(int $page = 1, int $per_page = 10): array
    {
        /**
         * https://developer.github.com/v3/repos/commits/#list-commits-on-a-repository
         * repos/:owner/:repo/commits
         */

        $params = [
            'page' => $page,
            'per_page' => $per_page,
        ];

        $path = '/repos/' . $this->username . '/portfolio-3Wacademy/commits';
        $url = $this->endpoint . $path . '?' . http_build_query($params);

        return $this->callAPI($url, $params);
    }


    /**
     * @param string $result
     * @return array
     */
    private function extactDataFromResult(string $result):array
    {
        $response = [];

        $output = rtrim($result);
        $data = explode("\n", $output);

        array_shift($data);
        $pagination = [];
        $body = null;
        // NOTA
        // Dump $data allow to see all the request response elements
            foreach ($data as $part) {

                $chunk = explode(":", $part, 2);

                if (mb_strtolower($chunk[0]) === 'link') {

                    $split = explode(',', trim($chunk[1]));

                    foreach ($split as $link) {

                        $explode = explode(';', $link);
                        $getUrlParams = explode('?', trim(preg_replace('/[">]/', '', $explode[0])));

                        if (preg_match('/first/', $link)) {

                            $pagination[0] = $this->formatPaginationLink(
                                'première page', $getUrlParams[1], 'first');
                        }

                        if (preg_match('/prev/', $link)) {

                            $pagination[1] = $this->formatPaginationLink(
                                'précédente', $getUrlParams[1], 'prev');
                        }

                        if (preg_match('/next/', $link)) {

                            $pagination[2] = $this->formatPaginationLink(
                                'suivante', $getUrlParams[1], 'next');
                        }

                        if (preg_match('/last/', $link)) {

                            $pagination[3] = $this->formatPaginationLink(
                                'dernière page', $getUrlParams[1], 'last');
                        }
                    }

                }
                if (preg_match('/[?[{]/', $chunk[0])) {
                    $decode = json_decode($chunk[0]);

                    $body = (is_array($decode)) ? $chunk[0] : $chunk[0] . ':' . $chunk[1] ;
                }

                if (preg_match('/sha/', $chunk[0])) {
                    $body = $chunk[0] . ':' . $chunk[1];

                }
            }

        // Sort link by index
        ksort($pagination);

            $response['pagination'] = $pagination;

        return [
            'body' => $body,
            'pagination' => $pagination
        ];
    }

    /**
     * Format datas for pagination link handling in temeplate
     * @param string $label
     * @param string $path
     * @param string $class
     * @return array
     */
    private function formatPaginationLink(string $label, string $path, string $class): array
    {
        return [
            'label' => $label,
            'path' => $path,
            'class' => $class
        ];
    }

    public function countCommit()
    {
        /**
         * https://api.github.com/repos/guillaumeg87/portfolio-3Wacademy/commits?per_page=1
         */

        $page = 1;
        $count = 0;
        $url = $this->endpoint . '/repos/' . $this->username . '/portfolio-3Wacademy/commits?per_page=100&page=' . $page;
        $response = $this->callAPI($url, []);
        while (!empty(json_decode($response['response']))) {

            $url = $this->endpoint . '/repos/' . $this->username . '/portfolio-3Wacademy/commits?per_page=100&page=' . $page;

            $response = $this->callAPI($url, []);

            $pageResult = count(json_decode($response['response'], true));
            $results = json_decode($response['response'], true);

            if (empty($results) && $pageResult ===  0) {

                break;
            }
            else {
                $count += $pageResult;
            }
            $page++;
        }
        return $count;
    }

    /**
     * Logging API REQUEST
     * @param string $url
     */
    private function logRequest(string $url){
        (new LogManager())->log(
            '[ GITHUB API] Call to :  ' . $url.  PHP_EOL,
            LogConstants::ERROR_APP_LABEL,
            LogConstants::INFO_LABEL);
    }
}
