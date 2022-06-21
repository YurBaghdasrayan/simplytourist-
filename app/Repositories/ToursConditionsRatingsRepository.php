<?php

namespace App\Repositories;

use App\Models\ToursConditionsRatings;
use App\Repositories\BaseRepository;

/**
 * Class ToursConditionsRatingsRepository
 * @package App\Repositories
 * @version September 24, 2021, 12:50 pm UTC
*/

class ToursConditionsRatingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tour_condition_id',
        'tour_condition_rating',
        'description_de',
        'description_en',
        'description_ru'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ToursConditionsRatings::class;
    }
}
