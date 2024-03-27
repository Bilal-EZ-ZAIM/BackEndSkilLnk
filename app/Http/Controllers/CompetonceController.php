<?php

namespace App\Http\Controllers;

use App\Models\Competonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompetonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $competences = DB::table('competonces')->select('id', 'name')->get();

        return response()->json($competences);
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
    }
}
