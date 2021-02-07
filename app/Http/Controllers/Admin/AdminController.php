<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Elasticsearch, Datatables, Notification, Redirect, Validator, Auth, Artisan;
use App\Models\User;
use App\Models\Jobs;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDashboard()
    {
        return view('admin.dashboard');
    }


    public function generateSearchIndex()
    {
        // try deleting the index (if exists)
        try {
            // remove index
            Elasticsearch::indices()->delete([
                'index' =>  'booking',
            ]);
        }
        catch (Missing404Exception $e) {

        }

        // create index
        Elasticsearch::indices()->create([
            'index' =>  'booking',
        ]);

        // set mappings before adding any data
        Jobs::putMappings();

        Jobs::addAllToIndex([
            'field'     =>  'published',
            'operator'  =>  '=',
            'value'     => 1
        ]);


        Notification::success('The search index has been successfully rebuilt');

        return Redirect::route('comasy.dashboard');
    }

    /**
     * Triggers the fetch vacancies command from the CMS dashboard
     *
     * @return Redirect
     */
    public function fetchVacancies()
    {
        $exitCode = Artisan::call('feed:fetch');

        if ($exitCode == 1) {
            Notification::success('Vacancies have been successfully updated');
        }
        else {
            Notification::error('Unable to fetch vacancies, please try again later');
        }

        return Redirect::route('comasy.dashboard');
    }

    /**
     * Triggers the clean vacancies command from the CMS dashboard
     *
     * @return Redirect
     */
    public function cleanVacancies()
    {
        $exitCode = Artisan::call('feed:clean');

        if ($exitCode == 1) {
            Notification::success('Vacancies have been successfully cleaned');
        }
        else {
            Notification::error('Unable to clean vacancies, please try again later');
        }

        return Redirect::route('comasy.dashboard');
    }

}
