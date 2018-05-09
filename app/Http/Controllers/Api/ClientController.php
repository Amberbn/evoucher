<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Client;

class ClientController extends ApiController
{
    public function getClients()
    {
        $client = Client::all();
        if(!$client) {
            return $this->sendNotfound();
        }
        
        return $this->sendSuccess($client);
    }
}
