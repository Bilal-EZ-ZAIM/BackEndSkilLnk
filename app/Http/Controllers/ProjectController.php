<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
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
                'titre' => 'required|string|min:3|max:30',
                'discription' => 'required|string|min:10',
                'link_github' => 'string',
                'link_host' => 'string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

                } else {
                    return response()->json([
                        'message' => "Une erreur est survenue lors du téléchargement de l'image."
                    ]);
                }
            }


            $project = Project::create([
                'titre' => $request->titre,
                'discription' => $request->discription,
                'link_github' => $request->link_github,
                'link_host' => $request->link_host,
                'user_id'=>$user->id,
                'image' => $imageUrl
            ]);

            if ($project) {
                return response()->json(['message' => 'Project créé avec succès', 'competons' => $project], 201);
            }

            if (!$project) {
                return response()->json(['message' => 'Projectne créé pas ', 'competons' => $project], 403);
            }


            return response()->json([$project, $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(project $project)
    {
        //
    }
}
