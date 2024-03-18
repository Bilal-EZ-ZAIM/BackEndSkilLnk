<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'commentaire' => 'required|string',
                'freelancer_id' => 'required|integer',

            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }



            $commentaire = Commentaire::create([
                'user_id' => $user->id,
                'commentaire' => $request->commentaire,
                'freelancer_id'=>$request->freelancer_id
            ]);

            if ($commentaire) {
                return response()->json(['message' => 'Commentaire créé avec succès', 'competons' => $commentaire], 201);
            }

            if (!$commentaire) {
                return response()->json(['message' => 'Commentaire ne créé pas ', 'competons' => $commentaire], 403);
            }


            return response()->json([$commentaire]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commentaire $commentaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commentaire $commentaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commentaire $commentaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commentaire $commentaire)
    {
        //
    }
}
