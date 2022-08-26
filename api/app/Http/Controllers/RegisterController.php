<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends Controller
{

    /**
     * Login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'Utilisateur correctement connecté.');
        } 
        else{ 
            return $this->sendError('Identifiant incorrect.', null);
        } 
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $isTokenDelete = $request->user()->tokens()->delete();

        if($isTokenDelete){
            $success = [
                'success' => true,
                'data' => null,
                'message' => "Utilisateur correctement déconnecter"
            ];

            return $this->sendResponse($success, 'Utilisateur correctement déconnecté.');
        } else {
            return $this->sendError('Problème lors de la déconnexion.', null);
        }


    }
}
