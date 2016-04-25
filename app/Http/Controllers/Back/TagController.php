<?php

namespace App\Http\Controllers\Back;

use App\Models\Tag;
use Illuminate\Support\Collection;

class TagController extends ModuleController
{
    protected $modelName = 'Tag';
    protected $moduleName = 'tags';

    protected $redirectToIndex = true;

    public function index()
    {
        $tags = Tag::nonDraft()->get()->reduce(function (Collection $carry, Tag $tag) {

            if (!$carry->has($tag->type)) {
                $carry->put($tag->type, new Collection());
            }

            $carry->get($tag->type)->push($tag);

            return $carry;

        }, new Collection());

        return view('back.tags.index', compact('tags'));
    }

    /**
     * Return a fresh instance of the model (called on `create()`).
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function make()
    {
        $model = new Tag();
        $model->save();

        return $model;
    }
}
