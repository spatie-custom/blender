@component('back._layouts.master', [
    'title' => 'Administrators',
    'breadcrumbs' => html()->backToIndex('Back\AdministratorsController@index'),
])
    <section>
        <div class="grid">
            <h1>New administrator</h1>

            {{ html()
                ->modelForm($user, 'POST', action('Back\AdministratorsController@store', $user->id))
                ->class('-stacked')
                ->open() }}

            @include('back.administrators._partials.form')

            {{ html()->formGroup()->submit('Save administrator') }}

            {{ html()->closeModelForm() }}
        </div>
    </section>
@endcomponent
