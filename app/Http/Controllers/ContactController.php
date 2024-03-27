<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
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
                'phone' => '|string',
                'facebook' => '|string|min:10|max:1000',
                'linkedin' => 'required',
                'github' => 'required|string',

            ]);


            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }


            // {
            //     "name": "Nilero",
            //     "phone": "+1234567890",  
            //     "github": "https://github.com/nilero",
            //     "linkedin": "https://www.linkedin.com/in/nilero",
            //     "facebook": "https://www.facebook.com/nilero"
            
            // }
              
            



            $contact = Contact::create([
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'linkedin' => $request->linkedin,
                'github' => $request->github,
                'user_id' => $user->id,
            ]);

            if ($contact) {
                return response()->json(['message' => 'offer De Emploi créé avec succès', 'Contact' => $contact], 201);
            }

            if (!$contact) {
                return response()->json(['message' => 'offer De Emploi ne créé pas ', 'Contact' => $contact], 403);
            }


            return response()->json([$contact]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
