<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Search\SearchTrait;


class Jobs extends Model
{
    use SearchTrait;

    protected $table = 'jobs';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'requisition_id',
        'job_id',
        'post_id',
        'slug',
        'flag',
        'entity',
        'region',
        'owner',
        'language',
        'cse',
        'title',
        'country',
        'city',
        'location',
        'department',
        'description',
        'internal',
        'status',
        'job_created_at',
        'job_updated_at'
    ];

    protected $mappingProperties = [
        'title' => [
            'type' => 'string',
            'analyzer' => 'ik_smart',//ik_smart
        ],
        'department' => [
            'type' => 'string',
            'analyzer' => 'ik_smart',
        ],
        'country' => [
            'type' => 'string',
            'analyzer' => 'ik_smart',
        ],
        'city' => [
            'type' => 'string',
            'analyzer' => 'ik_smart',
        ],
        'description' => [
            'type' => 'string',
            'analyzer' => 'ik_smart',
        ],
    ];


    protected $searchable = [
        'title',
        'department',
        'country',
        'city',
        'entity',
        'description',
    ];
    

    protected $highlightable = [
        'description',
    ];


    protected function addToDocument()
    {
        return [
            'requisition_id'    =>  $this->requisition_id,
            'job_id'            =>  $this->job_id,
            'post_id'           =>  $this->post_id,
            'slug'              =>  $this->slug,
            'title'             =>  $this->title,
            'department'        =>  $this->department,
            'country'           =>  $this->country,
            'city'              =>  $this->city,
            'flag'              =>  $this->flag,
            'entity'            =>  $this->entity,
            'description'       =>  $this->description,
            'status'            =>  $this->status,
        ];
    }


    /**
     * Get URL to detailed page
     *
     * @return string
     */
    public function getUrl()
    {
        return route('jobs.detail', ['slug' => $this->slug]);
    }



    public static function boot()
    {
        parent::boot();

        static::updated(function($entity)
        {
            $entity->status ? $entity->addToIndex() : $entity->removeFromIndex();
        });

        static::deleted(function($entity)
        {
            $entity->removeFromIndex();
        });
    }


    public function apply() {
        return $this->hasMany('App\Models\JobsApply','parent_id');
    }

    public function country() {
        return $this->hasOne('App\Models\Country','country','country');
    }

    // public function answers() {

    //     return $this->hasManyThrough('App\Models\JobsAnswer','App\Models\JobsQuestion','post_id','question_id');


    // }



}
