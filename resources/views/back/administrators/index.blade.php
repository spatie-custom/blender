@extends('back._layouts.master')

@section('pageTitle', fragment('back.administrators.title'))

@section('content')
    <section>
        <div class="grid">
            <h1>{{ fragment('back.administrators.title') }}</h1>
            <a href="{{ action('Back\AdministratorsController@create') }}" class="button">
                {{ fragment('back.administrators.new') }}
            </a>
            <table data-datatable data-order='[[ 0, "asc" ]]'>
                <thead>
                    <tr>
                        <th>E-mail</th>
                        <th>{{ fragment('back.administrators.name') }}</th>
                        <th>{{ fragment('back.administrators.lastActivity') }}</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="{{ action('Back\AdministratorsController@edit', [$user->id]) }}">{{ $user->email }}</a>
                        </td>
                        <td>
                            {!! Html::avatar($user, '-small') !!}  <span>{{ $user->name }}</span>
                        </td>
                        <td>
                            {{ $user->lastActivityDate }}
                        </td>
                        <td class="-right">
                            @unless ($user->isCurrentUser())
                                {!! Html::deleteButton(action('Back\AdministratorsController@destroy', $user->id)) !!}
                            @endunless
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
