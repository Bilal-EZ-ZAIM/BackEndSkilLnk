<?php

namespace App\Http\Controllers;

use App\Models\OfferDeEmploi;
use App\Models\Postile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OfferDeEmploiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $postile = Postile::with('usersOffer')->get();
        
        $offerDemploi = OfferDeEmploi::where("user_id" , $user->id)->with('posteles')->latest()->get();
        // return response()->json(["postile" => $postile ], 200);
        return response()->json(['offerDemploi' => $offerDemploi , 'user' => $user , "postile" => $postile], 200);
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
        $imageUrl = Null;
        try {
            $user = Auth::user();

            $validator = Validator::make($request->all(), [
                'titre' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:10|max:1000',
                'prix' => 'required|numeric',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');

                if ($image->isValid()) {
                    $imageName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $currentDate = date('Y_m_d');
                    $newImageName = $imageName . '_' . $currentDate . '.' . $extension;

                    $image->move(public_path('uploads'),  $newImageName);
                    $imageUrl = url('/uploads/' . $newImageName);
                }
            }



            $offerDeEmploi = OfferDeEmploi::create([
                'titre' => $request->titre,
                'description' => $request->description,
                'prix' => $request->prix,
                'user_id' => $user->id,
                'image' => $imageUrl
            ]);

            if ($offerDeEmploi) {
                return response()->json(['message' => 'offer De Emploi créé avec succès', 'Offer de Omploi' => $offerDeEmploi], 201);
            }

            if (!$offerDeEmploi) {
                return response()->json(['message' => 'offer De Emploi ne créé pas ', 'Offer de Omploi' => $offerDeEmploi], 403);
            }


            return response()->json([$offerDeEmploi]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OfferDeEmploi $offerDeEmploi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfferDeEmploi $offerDeEmploi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfferDeEmploi $offerDeEmploi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfferDeEmploi $offerDeEmploi)
    {
        //
    }
}
