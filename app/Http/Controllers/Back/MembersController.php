<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\Auth\Front\User;
use App\Services\Auth\Front\Enums\UserRole;
use App\Services\Auth\Front\Enums\UserStatus;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\Auth\Front\Events\UserCreatedThroughBack;

class MembersController
{
    use ValidatesRequests;

    public function index()
    {
        $users = User::all();

        return view('back.members.index')->with(compact('users'));
    }

    public function create()
    {
        return view('back.members.create', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validationRules());

        $user = new User();

        $user->email = $request->get('email');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->locale = $request->get('locale', 'nl');

        $user->role = UserRole::MEMBER;
        $user->status = UserStatus::ACTIVE;

        $user->save();

        $eventDescription = $this->getEventDescriptionFor('created', $user);
        activity()->on($user)->log($eventDescription);
        flash()->success(strip_tags($eventDescription).'. '.__('Er werd een mail verstuurd naar de gebruiker waarmee een wachtwoord kan ingesteld worden'));

        event(new UserCreatedThroughBack($user));

        return redirect()->action('Back\MembersController@index');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('back.members.edit')->with(compact('user'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, $this->validationRules());

        $user = User::findOrFail($id);

        $user->email = $request->get('email');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->locale = $request->get('locale', 'nl');

        $user->save();

        $eventDescription = $this->getEventDescriptionFor('updated', $user);
        activity()->on($user)->log($eventDescription);
        flash()->success(strip_tags($eventDescription));

        return redirect()->action('Back\MembersController@index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $eventDescription = $this->getEventDescriptionFor('deleted', $user);

        $user->delete();

        activity()->log($eventDescription);
        flash()->success(strip_tags($eventDescription));

        return redirect()->action('Back\MembersController@index');
    }

    protected function getEventDescriptionFor(string $event, User $user): string
    {
        $name = sprintf(
            '<a href="%s">%s</a>',
            action('Back\MembersController@edit', [$user->id]),
            $user->email
        );

        $action = '';

        if ($event === 'created') {
            $action = __('werd aangemaakt');
        }

        if ($event === 'updated') {
            $action = __('werd gewijzigd');
        }

        if ($event === 'deleted') {
            $name = $user->email;
            $action = __('werd verwijderd');
        }

        return __('Lid').' '.$name.' '.$action;
    }

    protected function validationRules(): array
    {
        return [
            'email' => $this->getEmailValidationRule(),
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }

    protected function getEmailValidationRule(): string
    {
        $uniqueRule = Rule::unique('users_front', 'email');

        if (request()->method() === 'PATCH') {
            $userId = request()->route('member');

            $uniqueRule = $uniqueRule->ignore($userId);
        }

        return "required|email|{$uniqueRule}";
    }
}
