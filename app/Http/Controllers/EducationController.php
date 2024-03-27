<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $education = Education::latest()->paginate(2)->where('user_id' , $user->id);

        return response()->json($education);
    }

  

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'nom' => 'required|string',
                'ecole' => 'required|string',
                'description' => 'required|string',
                'date_debut' => 'required|date',
                'date_fin' => 'nullable|date',
            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            // {
            //     "nom": "Nom de l'éducation",
            //     "ecole": "Nom de l'école",
            //     "description": "Description de l'éducation",
            //     "date_debut": "2022-01-01",
            //     "date_fin": "2022-12-31",
            //     "user_id": 1
            // }
            

            $education = Education::create([
                'nom' => $request->nom,
                'ecole' => $request->ecole,
                'description' => $request->description,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'user_id' => $user->id
            ]);

            if ($education) {
                return response()->json(['message' => 'Education créé avec succès', 'Education' => $education], 201);
            }

            if (!$education) {
                return response()->json(['message' => 'Education ne créé pas ', 'Education' => $education], 403);
            }


            return response()->json([$education]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        //
    }
}
