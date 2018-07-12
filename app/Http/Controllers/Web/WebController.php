<?php

namespace App\Http\Controllers\Web;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller as BaseController;

class WebController extends BaseController
{
    private $isAssoc = true;

    public function apiUrl()
    {
        return getEnv('API_URL');
    }

    public function guzzleRequest($param, $body = null)
    {

    }

    public function guzzleGet($param)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->request('GET', $this->apiUrl() . $param);
            $response = $request->getBody()->getContents();
            $response = json_decode($response, $this->isAssoc);
            return $response;
        } catch (\Exception $e) {
            return $this->getErrorResponse($e);
        }
    }

    public function guzzlePost($param, $body)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $request = $client->request('POST', $this->apiUrl() . $param, ['form_params' => $body]);
            $response = $request->getBody()->getContents();
            $response = json_decode($response, $this->isAssoc);
            return $response;
        } catch (\Exception $e) {
            //do some thing here
            return $this->getErrorResponse($e);
        }
    }

    public function getErrorResponse($e)
    {
        $response = $e->getResponse();
        $jsonBody = (string) $response->getBody();
        $decode = json_decode($jsonBody, $this->isAssoc);
        return $decode;
    }

    public function isNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    public function getSessionToken()
    {
        return session()->get('token');
    }

}
