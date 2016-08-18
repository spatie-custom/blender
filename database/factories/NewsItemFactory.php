<?php

use App\Models\NewsItem;

$factory->define(NewsItem::class, function () {
    return [
        'name' => faker()->translate(faker()->title()),
        'text' => faker()->translate(faker()->text()),
        'meta' => collect([]),
        'publish_date' => faker()->futureDate(),
        'online' => faker()->mostly(),
        'draft' => false,
    ];
});
