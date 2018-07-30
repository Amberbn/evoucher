<?php

namespace App\Listeners;

use DB;
use Illuminate\Auth\Events\Login;

class StoreSessionResource
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $resource = DB::table('vw_user_resources as resource')
            ->where('resource.user_id', '=', 1)
            ->select([
                'resource.user_id',
                'resource.user_name',
                'resource.resources_group',
                'resource.resources_object',
                'resource.resources_type',
                'resource.resources_event',
                'resource.resources_isallow',
                'resource.resources_helper',
                'resource.resources_description',
                DB::raw("CONCAT(resource.resources_object,'.', resource.resources_event) AS route"),
            ])->get();

        $grouped = $resource->groupBy('resources_object');
        $arrayResource = [];
        foreach ($grouped as $group => $values) {
            $items = [];
            foreach ($values as $val) {
                if ($val->resources_event) {
                    $items[] = $val->resources_event;
                }
            }
            $comma_separated = implode("|", $items);
            $arrayResource[$group] = $comma_separated;
        }

        session()->put('resources', $arrayResource);
    }
}
