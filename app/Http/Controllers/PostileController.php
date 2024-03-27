<?php

namespace App\Http\Controllers;

use App\Models\OfferDeEmploi;
use App\Models\Postile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $offerDemploi = OfferDeEmploi::all();
        return response()->json(['postiles' => $offerDemploi] , 200);
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

            $offerDemploi = OfferDeEmploi::where('id', $request->id)->first();

            if (!$offerDemploi) {
                return response()->json(['message' => 'L\'offre d\'emploi n\'existe pas'], 404);
            }

            $dejaPosteler = Postile::where('id_freelancer', $user->id)->where('id_offerdeomplis', $offerDemploi->id)->first();

            if ($dejaPosteler) {
                return response()->json(['message' => 'Déjà postulé'], 409);
            }


            $validator = Validator::make($request->all(), [
                'description' => 'required|string|min:10|max:250',
            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }




            $postile = Postile::create([
                'description' => $request->description,
                'id_offerdeomplis' => $offerDemploi->id,
                'id_freelancer' => $user->id,
                'status' => 1
            ]);

            if ($postile) {
                return response()->json(['message' => 'Postile créé avec succès', 'competons' => $postile], 201);
            }

            if (!$postile) {
                return response()->json(['message' => 'Postile ne créé pas ', 'competons' => $postile], 403);
            }


            return response()->json([$postile]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Postile $postile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Postile $postile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Postile $postile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Postile $postile)
    {
        //
    }
}
