<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\ResourceRepository;

class ResourceController extends ApiController
{
    protected $resourceRepository;

    public function __construct()
    {
        $this->resourceRepository = new ResourceRepository;
    }

    public function index()
    {
        $resource = $this->resourceRepository->getAllResource();

        return $resource;
    }
}
