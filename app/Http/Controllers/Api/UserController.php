<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Competonce;
use App\Models\skills_user;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function getAllUser(Request $request)
    {
        $user = User::with('competonces')->latest()->get();

        return response()->json([
            'users' => $user 
        ], 200);
    }

    // crée un neveu user 
    public function regester(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nom' => 'required|string|min:3|max:30',
                'prenom' => 'required|string|min:3|max:30',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error' . $e->getMessage()], 500);
        }
    }

    // upload image 

    public function upload(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user) {
                $profile = User::find($user->id);
            }

            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
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

                    $profile->image = $imageUrl;
                    $profile->save();

                    return response()->json([
                        'message' => "L'image a été téléchargée avec succès.",
                        'url' => $imageUrl,
                    ]);
                } else {
                    return response()->json([
                        'message' => "Une erreur est survenue lors du téléchargement de l'image."
                    ]);
                }
            }

            return redirect()->back()->with(['error' => "Aucune image n'a été téléchargée."]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Une erreur est survenue lors du traitement de la requête.",
                'error' => $e->getMessage()
            ], 500);
        }
    }



    // login 

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $user = User::where('email', $request->email)->first();

            if ($user && password_verify($credentials['password'], $user->password)) {


                Auth::login($user);

                $token = $user->createToken($user->nom)->plainTextToken;

                $authenticatedUser = Auth::user();

                return response()->json(['user' => $authenticatedUser, 'token' => $token], 200);
            } else {
                return response()->json(['error' => 'Email or password is incorrect'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }


    public function getUserFromToken()
    {
        $user = Auth::user();

        return response()->json(['user' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
