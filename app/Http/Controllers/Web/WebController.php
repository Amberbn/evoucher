<?php

namespace App\Http\Controllers\Web;

use GuzzleHttp\Client;
use Illuminate\Routing\Controller as BaseController;

class WebController extends BaseController
{
    private $isAssoc = true;

    public function apiUrl()
    {
        return 'http://evoucher.test:8090/api/v1/';
    }

    public function guzzleRequest($param, $body = null)
    {

    }

    public function getMe()
    {
        return $this->guzzleGet('me');

    }

    public function guzzleGet($param)
    {
        $request = null;
        try {
            $client = new \GuzzleHttp\Client();
            $token = $this->getSessionToken();
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ];
            $request = $client->request('GET', $this->apiUrl() . $param, [
                'headers' => $headers,
            ]);
            $response = $request->getBody()->getContents();
            $response = json_decode($response, $this->isAssoc);
            dd($response);
            return $response;
        } catch (\Exception $e) {
            return $this->getErrorResponse($e);
        }
    }

    public function guzzlePost($param, $body)
    {
        try {
            $request = null;
            $client = new \GuzzleHttp\Client();
            if (!array_has($body, 'is_login_request')) {
                $token = $this->getSessionToken();
                $headers = [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ];
                $request = $client->request('GET', $this->apiUrl() . $param, [
                    'headers' => $headers,
                    'form_params' => $body,
                ]);
            }
            if (!$request) {
                $request = $client->request('POST', $this->apiUrl() . $param,
                    ['form_params' => $body]);
            }
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
        if ($response) {
            $jsonBody = (string) $response->getBody();
            $decode = json_decode($jsonBody, $this->isAssoc);
            return $decode;
        }
        return $response;
    }

    public function isNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }

    public function getSessionToken()
    {
        return session()->get('token');
    }

    public function isTokenValid($response)
    {
        if ($response['status_code'] == '401') {
            session()->forget('token');
            return true;
        }
        return false;
    }

}
