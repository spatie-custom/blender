<?php

namespace App\Http\Controllers\Back;

use App\Http\Requests\Back\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Collection;

class TagsController extends ModuleController
{
    protected $redirectToIndex = true;

    protected function make(): Tag
    {
        return Tag::create();
    }

    protected function updateFromRequest(Tag $tag, TagRequest $request)
    {
        $tag->type = $request->get('type');

        $this->updateModel($tag, $request);
    }

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
}
