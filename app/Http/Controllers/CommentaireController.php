<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function getCommentaireUser()
    {
        
        $user = Auth::user();

        $commenters = Commentaire::where('freelancer_id', $user->id)->with('users.developerType')->get();

        return response()->json($commenters);
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
            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $commentaire = Commentaire::create([
                'user_id' => $user->id,
                'commentaire' => $request->commentaire,
                'freelancer_id' => $request->id
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
}
