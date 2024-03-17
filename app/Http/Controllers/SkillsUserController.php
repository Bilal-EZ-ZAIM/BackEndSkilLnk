<?php

namespace App\Http\Controllers;

use App\Models\Skills_user;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillsUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skills_user::where('user_id', 8)->where('competonce_id', 22)->get();

        return response()->json($skills);
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

        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'competonce_id' => 'required|integer',
            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }


            $skills = Skills_user::where('user_id', $user->id)->where('competonce_id', $request->competonce_id)->first();

            if ($skills) {
                return response()->json(['message' => 'Competonce déja crée', 'skills ' => $skills], 201);
            }

            $competons = Skills_user::create([
                'user_id' => $user->id,
                'competonce_id' => $request->competonce_id
            ]);

            if ($competons) {
                return response()->json(['message' => 'Competonce créé avec succès', 'competons' => $competons], 201);
            }

            if (!$competons) {
                return response()->json(['message' => 'Competonce ne créé pas ', 'competons' => $competons], 403);
            }


            return response()->json([$skills, $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(skills_user $skills_user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(skills_user $skills_user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, skills_user $skills_user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(skills_user $skills_user)
    {
        //
    }
}
