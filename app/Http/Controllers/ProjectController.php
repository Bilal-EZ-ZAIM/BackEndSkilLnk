<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{

    public function getProjectUser()
    {
        $user = Auth::user();
        return response()->json($user->project);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            $imageUrl = null; 

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
                'user_id' => $user->id,
                'image' => $imageUrl
            ]);

            if ($project) {
                return response()->json(['message' => 'Project créé avec succès', 'competons' => $project], 201);
            } else {
                return response()->json(['message' => 'Projectne créé pas ', 'competons' => $project], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function update(Request $request, Project $project)
    {
        try {
            $user = Auth::user();

            if ($user->id !== $project->user_id) {
                return response()->json(['error' => 'You are not authorized to update this project.'], 403);
            }

            $validator = Validator::make($request->all(), [
                'titre' => 'required|string|min:3|max:30',
                'discription' => 'required|string|min:10',
                'link_github' => 'string',
                'link_host' => 'string',
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
                } else {
                    return response()->json([
                        'message' => "Une erreur est survenue lors du téléchargement de l'image."
                    ]);
                }
            }

            $project->update([
                'titre' => $request->titre,
                'discription' => $request->discription,
                'link_github' => $request->link_github,
                'link_host' => $request->link_host,
                'image' => isset($imageUrl) ? $imageUrl : $project->image
            ]);

            return response()->json(['message' => 'Project mis à jour avec succès', 'project' => $project], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $user = Auth::user();

            if ($user->id !== $project->user_id) {
                return response()->json(['error' => 'You are not authorized to delete this project.'], 403);
            }

            $project->delete();
            return response()->json(['message' => 'Project supprimé avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }
}
