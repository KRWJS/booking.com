<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Jobs;
use Illuminate\Support\Str;
use Datatables, Input, Validator, Notification, Redirect, App, Image;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        App::abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        App::abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Redirect::route('comasy.jobs.edit', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobs = Jobs::findOrFail($id);


        return view('admin.jobs.edit')->with([
            'id'                =>  $id,
            'jobs'              =>  $jobs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO: add back end validation for the blocks

        $validationRules = [
            'title' => 'required|max:30',
            'subtitle' => 'max:15',
            'intro' =>  'max:180|no_html',
            'slug' => 'required|max:80|unique:pages,slug,'.$id,
            'weight' => 'required|integer',
            'page_title' => 'max:65',
            'meta_description' => 'max:160',
            'meta_keywords' => 'max:150',
            'page_category_id'  =>  'integer',
            'header_image_file' => 'sometimes|image|max:1024|dimensions:min_width=1600,min_height=650',
            'header_image_alt'  =>  'no_html',
            'listing_image' =>  'required',
            'listing_image_file'  =>  'sometimes|image|max:1024|dimensions:min_width=1600,min_height=650',
            'listing_image_alt'  =>  'no_html',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if ($validation->fails()){
            Notification::error('There were errors during the update process. Please refer to the error messages below');

            return Redirect::back()->withErrors($validation)->withInput();
        }

        $page = Page::findOrFail($id);
        $page->title = Input::get('title');
        $page->subtitle = Input::get('subtitle');
        $page->slug = Str::slug(Input::get('slug'));
        $page->intro = Input::get('intro');
        $page->weight = Input::get('weight');
        $page->page_title = Input::get('page_title');
        $page->meta_description = Input::get('meta_description');
        $page->meta_keywords = Input::get('meta_keywords');
        $page->status = Input::has('status') ? true : false;
        $page->listed = Input::has('listed') ? true : false;
        $page->page_category_id = Input::get('page_category_id');

        $blockIds = [];
        $blocks = Input::get('blocks');

        if (is_array($blocks)) {
            foreach ($blocks as $bid => $blockData)
            {
                $block = Block::find($bid) ?: new Block;

                $blockData['id'] = $bid;
                $block->populate($blockData, $request);

                $page->blocks()->save($block);
                $blockIds[] = $block->id;
            }
        }

        // sync blocks
        foreach($page->blocks as $savedBlock) {
            if (in_array($savedBlock->id, $blockIds) == false) {
                $savedBlock->delete();
            }
        }

        $page->uploadImage('header_image', $request);
        $page->header_image_alt = Input::get('header_image_alt');
        $page->uploadImage('listing_image', $request);
        $page->listing_image_alt = Input::get('listing_image_alt');

        $page->save();

        Notification::success('The page has been updated.');

        return Redirect::route('comasy.page.edit', $page->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // We don't allow jobs deletes with the CMS for now
        App::abort(403);

        // Below is not executed
        $jobs = jobs::findOrFail($id);
        $jobsTitle = $jobs->getTitle();

        $jobs->delete();

        Notification::success('Page "'. $pageTitle .'" has been deleted.');

        return Redirect::route('comasy.jobs.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDatatableData()
    {
        $jobsQuery = Jobs::select('id', 'job_id', 'title', 'department', 'country', 'city', 'status');
        return Datatables::of($jobsQuery)
            ->editColumn('status', '{!! $status ? \'<i class="fa fa-check text-success"><span style="display: none;">1</span></i>\' : \'<i class="fa fa-close text-danger"><span style="display: none;">0</span></i>\' !!}')
            ->addColumn('actions', '{!! \'<a href="\'.URL::route(\'comasy.jobs.edit\', $id).\'" class="btn btn-primary btn-sm offset-xs-right"><i class="fa fa-wrench"></i></a>\' !!}')
            ->make(true);
    }
}
