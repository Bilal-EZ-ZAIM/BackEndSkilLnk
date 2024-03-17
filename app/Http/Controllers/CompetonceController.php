<?php

namespace App\Http\Controllers;

use App\Models\Competonce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetonceController extends Controller
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

        $user = Auth::user();

        // $check = User::with('competonces')->where('id' , 2)->get();

        // $com = $user->competonces;

        $check = Competonce::all();

        


        return response()->json([
            $check
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Competonce $competonce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competonce $competonce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Competonce $competonce)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Competonce $competonce)
    {
        //
    }
}
