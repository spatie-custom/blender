<div data-tabs class="tabs">
    <nav class="tabs__menu">
        <ul>
            <li><a href="#content" class="js-tabs-nav"><i class="fa fa-edit"></i> Inhoud</a></li>
            <li><a href="#settings" class="js-tabs-nav"><i class="fa fa-cog"></i> Instellingen</a></li>
        </ul>
    </nav>
    <div id="content">
        {{ html()->formGroup()->text('name', 'Naam') }}

        {{ html()->media('images', 'images') }}
    </div>
    <div id="settings">
        {{ html()->formGroup()->checkbox('online', 'Online') }}
    </div>
</div>
