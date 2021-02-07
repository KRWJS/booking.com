<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Datatables, Input, Validator, Notification, Redirect;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'email' => 'required|email|max:255|unique:users',
            'name' => 'required|max:255',
            'password' => 'required|min:6|confirmed',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if ($validation->fails()){
            Notification::error('There were errors during the creation process. Please refer to the error messages below');

            return Redirect::back()->withErrors($validation)->withInput();
        }

        $user = User::create([
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'password' => bcrypt(Input::get('password')),
            'activated' =>  Input::has('activated') ? true : false,
        ]);


        Notification::success('User '. Input::get('name') .' has been created.');

        return Redirect::route('comasy.user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Redirect::route('comasy.user.edit', ['id' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit')->with([
            'id'    =>  $id,
            'user'  =>  $user,
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
        $validationRules = [
            'email' => 'required|email|max:150|unique:users,email,'.$id,
            'name' => 'required|max:150',
        ];

        $validation = Validator::make($request->all(), $validationRules);

        if ($validation->fails()){
            Notification::error('There were errors during the update process. Please refer to the error messages below');

            return Redirect::back()->withErrors($validation)->withInput();
        }

        $user = User::findOrFail($id);
        $user->email = Input::get('email');
        $user->name = Input::get('name');
        $user->activated = Input::has('activated') ? true : false;

        $user->save();

        Notification::success('The user has been updated.');

        return Redirect::route('comasy.user.edit', $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;

        $user->delete();

        Notification::success('User '. $userName .' has been deleted.');

        return Redirect::route('comasy.user.index');
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDatatableData()
    {
        $usersQuery = User::select('id', 'name', 'email', 'activated', 'last_login');

        return Datatables::of($usersQuery)
            ->orderColumn('activated', 'activated $1, id $1')
            ->editColumn('activated', '{!! $activated ? \'<i class="fa fa-check text-success"><span style="display: none;">1</span></i>\' : \'<i class="fa fa-close text-danger"><span style="display: none;">0</span></i>\' !!}')
            ->addColumn('actions', '{!! \'<a href="\'.URL::route(\'comasy.user.edit\', $id).\'" class="btn btn-primary btn-sm offset-xs-right"><i class="fa fa-wrench"></i></a>\' !!}')
            ->make(true);
    }
}
