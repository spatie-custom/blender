<?php

namespace App\Foundation\Models\Updaters;

use Illuminate\Support\Collection;
use Spatie\Regex\MatchResult;
use Spatie\Regex\Regex;

trait UpdatesMetaTags
{
    protected function updateMetaTags()
    {
        Collection::macro('dump', function (string $comment = '') {
            if ($comment) {
                dump($comment);
            }

            dump($this);

            return $this;
        });

        collect($this->request->all())
            ->filter(function ($value, $fieldName) {
                // Filter out everything that starts with 'translated_<locale>_meta_'
                return Regex::match('/^translated_([a-z][a-z])_meta_/', $fieldName)->hasMatch();
            })
            ->map(function ($value, $fieldName) {

                // Replace 'translated_<locale>_meta_<attribute>' with '<locale>_<attribute>'
                $localeAndAttribute = Regex::replace('/translated_([a-z][a-z])_meta_/', function (MatchResult $matchResult) {
                    return $matchResult->group(1) . '_';
                }, $fieldName)->result();

                $localeAndAttribute = explode('_', $localeAndAttribute, 2);

                return [
                    'locale' => $localeAndAttribute[0],
                    'attribute' => $localeAndAttribute[1],
                    'value' => $value,
                ];
            })
            ->groupBy('locale')
            ->map(function (Collection $valuesInLocale) {
                return $valuesInLocale->mapToAssoc(function ($values) {
                    return [$values['attribute'], $values['value']];
                });
            })
            ->each(function ($values, $locale) {
                $this->model->setTranslation('meta', $locale, $values);
            });
    }
}
