<?php

namespace App\Models\Traits;

use App\Models\ContentBlock;
use App\Http\Requests\Request;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasContentBlocks
{
    public function contentBlocks(): MorphMany
    {
        return $this
            ->morphMany(ContentBlock::class, 'model')
            ->whereDraft(false)
            ->orderBy('order_column');
    }

    public function getContentBlockCollections(): array
    {
        return $this->contentBlockCollections ?? ['default'];
    }

    public function hasContentBlocks($collection = 'default'): int
    {
        return $this->getContentBlocks($collection)->count();
    }

    public function getContentBlockMediaLibraryCollections(): array
    {
        return $this->contentBlockMediaLibraryCollections ?? ['image'];
    }

    public function getContentBlocks($collection = 'default'): Collection
    {
        return $this->contentBlocks->where('collection_name', $collection);
    }

    public function syncContentBlocks(Request $request)
    {
        foreach ($this->getContentBlockCollections() as $collection) {
            if (! $request->has("content_blocks_{$collection}")) {
                continue;
            }

            $this->syncContentBlockCollection(
                json_decode($request->get("content_blocks_{$collection}"), true),
                $collection
            );
        }
    }

    protected function syncContentBlockCollection(array $data, string $collection)
    {
        $contentBlocks = collect($data)->map(function (array $attributes, int $i): ContentBlock {
            return ContentBlock::findOrFail($attributes['id'])
                ->updateWithAttributes($attributes)
                ->setOrder($i);
        });

        $this->contentBlocks()
            ->where('collection_name', $collection)
            ->whereNotIn('id', $contentBlocks->pluck('id'))
            ->delete();
    }
}
