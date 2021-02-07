<?php namespace App\Services\Search;

use Elasticsearch;
use Elasticsearch\Common\Exceptions\Missing404Exception;

trait SearchTrait {
    private $index = 'booking';

    public function getMappingProperties()
    {
        return $this->mappingProperties;
    }

    public function getSearchable()
    {
        return $this->searchable;
    }

    public function getHighlightable()
    {
        $hightlightables = [];

        foreach($this->highlightable as $highlightable) {
            $hightlightables[$highlightable] = (object) [];
        }

        return $hightlightables;
    }

    public function addToIndex()
    {
        return Elasticsearch::index([
            'index'     =>  $this->index,
            'type'      =>  $this->table,
            'id'        =>  $this->id,
            'body'      =>  $this->addToDocument(),
        ]);
    }

    public function removeFromIndex()
    {
        try {
            return Elasticsearch::delete([
                'index'     =>  $this->index,
                'type'      =>  $this->table,
                'id'        =>  $this->id,
            ]);
        }
        catch (Missing404Exception $e) {
            return false;
        }
    }

    public static function addAllToIndex(array $condition = [])
    {
        if (count($condition) > 0) {
            $items = self::where($condition['field'], $condition['operator'], $condition['value'])->get();
        }
        else {
            $items = self::get();
        }

        foreach($items as $item) {
            $item->addToIndex();
        }
    }

    public static function removeAllFromIndex(array $condition = [])
    {
        if (count($condition) > 0) {
            $items = self::where($condition['field'], $condition['operator'], $condition['value'])->get();
        }
        else {
            $items = self::get();
        }

        foreach($items as $item) {
            $item->removeFromIndex();
        }
    }

    public static function reindexAll(array $condition = [])
    {
        self::removeAllFromIndex();
        self::addAllToIndex($condition);
    }

    public static function putMappings()
    {
        $instance = new static;

        return Elasticsearch::indices()->putMapping([
            'index'     =>  $instance->index,
            'type'      =>  $instance->table,
            'body'      =>  [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => $instance->getMappingProperties()
            ]
        ]);
    }

    public static function search($phrase)
    {
        $instance = new static;

        $parameters = [
            'index' =>  $instance->index,
            'type'  =>  $instance->table,
            'body'  =>  [
                'query' => [
                    'multi_match' => [
                        'query' => $phrase,
                        'fields' => $instance->getSearchable()
                    ],
                ],
                'highlight' => [
                    'fields' => $instance->getHighlightable()
                ]
            ]
        ];

        return Elasticsearch::search($parameters);
    }
}