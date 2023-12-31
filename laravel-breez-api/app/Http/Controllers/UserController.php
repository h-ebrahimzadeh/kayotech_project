<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return $users;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user=User::find($request->input('id'));
        $path = date('Y/m/d');
        $imageName = time().'-'.'image'.'.'.$request->image->extension();

        $user->addMedia($path)->toMediaCollection('images');

        $user->update($request->only('name','email',));

        return response()->json(['msg'=>'update user successfully']);



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    //active user
    public function suspend(User $user)
    {
        $user->update(['suspend'=>true]);
        return response()->json(['msg'=>'suspend user successfully']);
    }
    public function unsuspend(User $user)
    {
        $user->update(['suspend'=>false]);
        return response()->json(['msg'=>'unsuspend user successfully']);
    }
}
