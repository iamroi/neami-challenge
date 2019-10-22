<?php

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * @param User $user
     * @param Role $role
     *
     * @return mixed|null
     */
    function signIn($user = null, $role = null) //, $role_guard = ''
    {
        $user = $user ?? factory(\App\User::class)->create();

        if(!empty($role)) {
            $user = $user->assignRole($role);
        }

        $this->be($user);

        return $user;
    }
}
