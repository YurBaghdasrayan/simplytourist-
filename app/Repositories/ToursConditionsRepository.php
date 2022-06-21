<?php

namespace App\Repositories;

use App\Models\ToursConditions;
use App\Repositories\BaseRepository;

/**
 * Class ToursConditionsRepository
 * @package App\Repositories
 * @version September 24, 2021, 11:58 am UTC
*/

class ToursConditionsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_en',
        'description_en',
        'name_de',
        'description_de',
        'name_ru',
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
        return ToursConditions::class;
    }
}
