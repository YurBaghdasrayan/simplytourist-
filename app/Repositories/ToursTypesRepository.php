<?php

namespace App\Repositories;

use App\Models\ToursTypes;
use App\Repositories\BaseRepository;

/**
 * Class ToursTypesRepository
 * @package App\Repositories
 * @version September 24, 2021, 12:49 pm UTC
*/

class ToursTypesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_de',
        'name_en',
        'name_ru'
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
        return ToursTypes::class;
    }
}
