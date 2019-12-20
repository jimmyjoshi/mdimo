<?php

namespace App\Http\Transformers;

abstract class Transformer
{
    public function transformCollection($items)
    {
        return array_map([$this, 'transform'], $items);
    }

    abstract public function transform($item);

    public function nulltoBlank($data)
    {
        return $data ? $data : '';
    }
}
