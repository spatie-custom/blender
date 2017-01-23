<?php

use App\Services\Auth\Front\User;
use App\Services\Auth\Front\Enums\UserRole;
use App\Services\Auth\Front\Enums\UserStatus;

class FrontUserSeeder extends DatabaseSeeder
{
    public function run()
    {
        $this->truncate((new User())->getTable());

        collect([
            ['Freek', 'Van der Herten'],
            ['Jef', 'Van der Voort'],
            ['Rogier', 'De Boevé'],
            ['Sebastian', 'De Deyne'],
            ['Willem', 'Van Bockstal'],
        ])->each(function ($name) {
            [$firstName, $lastName] = $name;

            $this->createFrontUser([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => strtolower($firstName).'@spatie.be',
                'password' => bcrypt(strtolower($firstName)),
                'status' => UserStatus::ACTIVE,
            ]);
        });

        collect()->range(0, 10)->each(function () {
            $this->createFrontUser();
        });
    }

    public function createFrontUser(array $attributes = []): User
    {
        $person = faker()->person();

        return User::create($attributes + [
            'first_name' => $person['firstName'],
            'last_name' => $person['lastName'],
            'email' => $person['email'],
            'password' => bcrypt($person['firstName']),

            'locale' => 'nl',

            'role' => UserRole::MEMBER,
            'status' => UserStatus::ACTIVE,

            'address' => faker()->address,
            'postal' => faker()->postcode,
            'city' => faker()->city,
            'country' => faker()->country,
            'telephone' => faker()->phoneNumber,
        ]);
    }
}
