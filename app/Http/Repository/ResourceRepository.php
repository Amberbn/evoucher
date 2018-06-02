<?php
namespace App\Http\Repository;

use App\Repository\BaseRepository;
use App\Resource;
use DB;

class ResourceRepository extends BaseRepository
{
    public function resourceFilter()
    {
        $filter = [
            'orderBy' => 'resources_group',
            'filter_1' => 'resources_object',
            'filter_2' => 'resources_type',
            'filter_3' => 'resources_event',
        ];

        return $filter;
    }

    public function getAllResource()
    {
        $resource = DB::table('frm_resources as frs')
            ->join('frm_user_roles as fur', 'frs.resources_id', '=', 'fur.user_roled_id')
            ->join('frm_roles as fr', 'fur.user_roled_id', '=', 'fr.roles_id')
            ->join('frm_user as fu', 'fur.user_roled_id', '=', 'fu.user_id')
            ->select(
                'frs.roles_id',
                'frs.resources_group',
                'frs.resources_object',
                'frs.resources_type',
                'frs.resources_event',
                'frs.resources_isallow',
                'frs.resources_helper',
                'frs.resources_description'
            );
        
        if (empty($resource->get()->toArray())) {
            return $this->sendNotfound();
        }
        $filter = $this->resourceFilter();

        return $this->dataTableResponseBuilder($resource, $filter);
    }
}
