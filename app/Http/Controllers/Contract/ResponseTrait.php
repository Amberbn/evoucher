<?php

namespace App\Http\Controllers\Contract;

trait ResponseTrait
{

    private $customCodeAndMessage = [
        '200' => 'Success',
        '201' => 'Create data success',
        '400' => 'Request validation error',
        '401' => 'Unautithencated',
        '404' => 'Request data not found',
    ];

    protected function sendNotFound()
    {
        return $this->sendResponse(404,'404', $this->customCodeAndMessage['404'],[]);
    }

    protected function sendValidationError($data)
    {
        return $this->sendResponse(400,'400', $this->customCodeAndMessage['400'],$data);
    }

    protected function sendSuccess($data = [])
    {
        return $this->sendResponse(200,'200', $this->customCodeAndMessage['200'],$data);
    }

    protected function sendCreated($data = [])
    {
        return $this->sendResponse(201,'201', $this->customCodeAndMessage['201'],$data);
    }

    protected function sendBadRequest($message)
    {
        return $this->sendResponse(400,'400', $message,[]);
    }

    protected function sendResponse($httpCode = 200, $appCode, $messages, $data = [])
    {
        $appCode = is_string($appCode) ? (string) $appCode : $appCode;
        $responseData = [
            'status_code' => $appCode,
            'status_message' => $message
        ];

        $objectData = [];
        if(!isset($data['data'])) {
            $objectData['data'] = $data;
        } else {
            $objectData = $data;
        }

        $responseData = array_merge($responseData, $objectData);

        return response()->json($responseData, $httpCode, [
            'X-App-Version' => config('app.version'),
        ]);
    }
}