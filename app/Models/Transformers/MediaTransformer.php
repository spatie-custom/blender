<?php

namespace App\Models\Transformers;

use Spatie\MediaLibrary\Media;
use League\Fractal\TransformerAbstract;

class MediaTransformer extends TransformerAbstract
{
    public function transform(Media $media)
    {
        return [
            'id' => $media->id,
            'name' => $media->name,
            'collection' => $media->collection_name,
            'fileName' => $media->file_name,
            'customProperties' => json_encode($media->custom_properties, JSON_FORCE_OBJECT),
            'orderColumn' => $media->order_column,
            'thumbUrl' => strtolower($media->extension) === 'svg' ?
                $media->getUrl() :
                $media->getUrl('admin'),
            'originalUrl' => $media->getUrl(),
        ];
    }
}
