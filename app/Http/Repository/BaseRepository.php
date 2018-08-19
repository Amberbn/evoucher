<?php
namespace App\Repository;

use DB;
use Illuminate\Http\File;

class BaseRepository
{
    use \App\Http\Controllers\Contract\UserTrait;
    use \App\Http\Controllers\Contract\ResponseTrait;

    /**
     *FUNCTION GET RESPONSE DATATABLE
     *@param Request $request
     *@param Builder $query
     *@param Array $filterParam
     *@return \Illuminate\Http\Response
     */
    public function dataTableResponseBuilder($query, array $filterParam)
    {
        //example : http://evoucher.test:8090/api/v1/client?sort=client_category_pid|asc&page=1&per_page=2&filter=go
        //note use must parse pipeline | after sort look the example
        try {
            $request = request();
            //check if query string has sort parameter

            if (request()->has('sort')) {
                //explode sort parameter handle when multiple sort
                $sorts = explode(',', request()->sort);
                //loop sort parameter and explode with pipe to buld list array
                foreach ($sorts as $sort) {
                    list($sortCol, $sortDir) = explode('|', $sort);
                    $query = $query->orderBy($sortCol, $sortDir);
                }
            } else {
                //if sort empty then use default value to sorting
                $query = $query->orderBy($filterParam['orderBy'], 'asc');
            }

            //check if query string has filter parameter
            if ($request->exists('filter')) {
                //use array filteParam as indexes array key value
                $query->where(function ($q) use ($request, $filterParam) {
                    //get value filter and use as like query
                    $value = "%{$request->filter}%";
                    $q->where($filterParam['filter_1'], 'like', $value)
                        ->orWhere($filterParam['filter_2'], 'like', $value)
                        ->orWhere($filterParam['filter_3'], 'like', $value);
                });
            }

            //check if query string has per_page parameter then use it or skip when null
            $totalDataCount = $query->count();
            //if request perpage not found then use default count all data from total data count
            $perPage = $request->per_page > 0 ? (int) $request->per_page : $totalDataCount;
            // $perPage = request()->has('per_page') ? (int) request()->per_page : $totalDataCount;
            $pagination = $query->paginate($perPage);
            //split up data from object return for split response
            $data = $pagination->toArray()['data'];
            //append links url for concernate with url search, sorting or page
            $pagination->appends([
                'sort' => request()->sort,
                'filter' => request()->filter,
                'per_page' => request()->per_page,
            ]);

            //build array to split up value
            $arr = $pagination->toArray();
            //uset array data for take links object
            unset($arr['data']);
            //this is how value like without data object inside
            $links = $arr;

            //if array data is empty then send response as not found
            if (empty($data)) {
                return $this->sendNotfound();
            }

            //if array not empty then merge data and links object as array
            $data = [
                'data' => $data,
                'links' => $links,
            ];

            //then send data and links as final response
            return $this->sendSuccess($data);
        } catch (\Exception $e) {
            return $this->throwErrorException($e);
        }
    }

    public function throwErrorException($e)
    {
        \Log::error($e->getMessage());
        $defaultErrorMessage = 'Oops! Something went wrong';
        if (config('app.debug')) {
            return $this->sendBadRequest($e->getMessage());
        } else {
            return $this->sendBadRequest($defaultErrorMessage);
        }
    }

    public function getConfig($filters)
    {
        $config = DB::table('frm_config')
            ->where('config_name', $filters)
            ->first()->config_value;
        return $config;
    }

    public function saveImage($request, $requestType, $folderName)
    {
        $file = $request->file($requestType);
        $imageFileName = strtolower(str_random(10)) . '.' . $file->getClientOriginalExtension();
        $storage = \Storage::disk('public');

        //convert image
        $image = \Image::make($file);
        $image->widen(1024);

        // upload storage
        $filePath = $folderName . '/original/';
        $storage->put($filePath . $imageFileName, (string) $image->encode() . $filePath);

        $imageThumnail = \Image::make($file);
        $imageThumnail->widen(300);

        //upload storage
        $filePathThumnail = $folderName . '/thumbnail/';
        $storage->put($filePathThumnail . $imageFileName, (string) $imageThumnail->encode() . $filePathThumnail);

        // return name
        return $imageFileName;
    }
}
