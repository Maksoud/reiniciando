<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->user();
        
        if ($name = $user->getName()) {
	        echo "Nome: {$name} <br>";
        }//if ($name = $user->getName())
        
        if ($nickname = $user->getNickname()) {
	        echo "Apelido: {$nickname} <br>";
        }//if ($nickname = $user->getNickname())
        
        
        if ($email = $user->getEmail()) {
	        echo "E-mail: {$email} <br>";
        }
        
        if ($avatar = $user->getAvatar()) {
	        echo "<img src='{$avatar}' alt='Avatar' style='border-radius:50%;max-width:200px;'> <br>";
        }

        // $user->token;
    }
}
