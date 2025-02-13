<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            if ($user &&
                Hash::check($request->password, $user->password)) {
                $user_id = $user->id;
                $session_id = session()->getId();
                \App\Models\User::where('id', $user_id)->update(['session_id' => $session_id]);
                // dd($user->id);
                // dd(session()->getId());
                return $user;
            }
        });

        // Log out
        // Fortify::(function (Request $request) {
        //     // $user = User::where('email', $request->email)->first();
        //     // if ($user &&
        //     //     Hash::check($request->password, $user->password)) {
        //     //     $user_id = $user->id;
        //     //     $session_id = session()->getId();
        //     //     \App\Models\User::where('id', $user_id)->update(['session_id' => $session_id]);
        //     //     dd($user->id);
        //     //     // dd(session()->getId());
        //     //     return $user;
        //     // }
        // });

        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Vite::prefetch(concurrency: 3);
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
