<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCompetoncesUser()
    {
        $user = Auth::user();
        return response()->json(["competonces" => $user->competonces]);
    }

    public function getProjectUser()
    {
        $user = Auth::user();
        return response()->json([ "project" => $user->project]);
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

        $user = auth()->user();

        $gates =  Gate::allows('cree-profile');

        if ($gates) {

            $validator = Validator::make($request->all(), [
                'bio' => 'required|string|max:2000',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }


            $profile = Profile::create([
                'user_id' =>  $user->id,
                'bio' => $request->bio
            ]);

            return response()->json([
                'profile' => $profile,
                'messager' => "oui créét profile"
            ], 201);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $profile = Profile::where('id', $request->id)->first();

        $gates =  Gate::allows('update-profile', $profile);


        if ($gates) {

            $validator = Validator::make($request->all(), [
                'bio' => "required|string|max:2000",
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $profile->update([
                'bio' => $request->bio,
            ]);

            return response()->json([
                'message' => 'Profile updated successfully',
                'profile' =>  $profile,
            ]);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
