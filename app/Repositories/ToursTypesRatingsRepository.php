<?php

namespace App\Repositories;

use App\Models\ToursTypesRatings;
use App\Repositories\BaseRepository;

/**
 * Class ToursTypesRatingsRepository
 * @package App\Repositories
 * @version September 24, 2021, 12:50 pm UTC
*/

class ToursTypesRatingsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tour_type_id',
        'tour_type_rating',
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
        return ToursTypesRatings::class;
    }
}
