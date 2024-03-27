<?php

namespace App\Http\Controllers;

use App\Models\Notificaation;
use App\Models\OfferDeEmploi;
use App\Models\Postile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificaationController extends Controller
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

            $offerDemplois = OfferDeEmploi::where("user_id", $user->id)->where('id', $request->idOfferDemploi)->first();

            if (!$offerDemplois) {
                return response()->json(['message' => 'L\'offre d\'emploi n\'existe pas'], 404);
            }

            $accepterPostile = Postile::find($request->id);


            // return response()->json($accepterPostile);

            if (!$accepterPostile) {
                return response()->json(['message' => 'L\'offre d\'emploi n\'existe pas'], 404);
            }

            if ($accepterPostile-> status == 2 ) {
                return response()->json(['message' => 'Deja accepter le offire'], 404);
            }

            $accepterPostile->status = 2;
            $accepterPostile->save();

            Postile::where('id_offerdeomplis', $request->idOfferDemploi)->where('status', '!=', 2)->delete();

            if (!$accepterPostile->save()) {
                return response()->json(['message' => 'ne pas accepter le offer de omploi ', 'accepter'], 403);
            }

            $notifictaion = Notificaation::create([
                'messages' =>  'Accepter le offer de omploi ' . $offerDemplois->titre,
                'user_id' => $accepterPostile->id_freelancer,
            ]);

            if ($notifictaion) {
                return response()->json(['message' => 'Notification créé avec succès', 'Notification' => $notifictaion], 201);
            }

            if (!$notifictaion) {
                return response()->json(['message' => 'Notification ne créé pas ', 'Notification' => $notifictaion], 403);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notificaation $notificaation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notificaation $notificaation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notificaation $notificaation)
    {
        //
    }
}
