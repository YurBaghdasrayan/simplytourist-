<?php

namespace App\Repositories;

use App\Models\EquipmentType;
use App\Repositories\BaseRepository;

/**
 * Class EquipmentTypeRepository
 * @package App\Repositories
 * @version September 24, 2021, 9:43 am UTC
*/

class EquipmentTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_en',
        'name_de',
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
        return EquipmentType::class;
    }
}
