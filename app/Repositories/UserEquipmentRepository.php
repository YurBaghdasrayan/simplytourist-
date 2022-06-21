<?php

namespace App\Repositories;

use App\Models\UserEquipment;
use App\Repositories\BaseRepository;

/**
 * Class UserEquipmentRepository
 * @package App\Repositories
 * @version September 29, 2021, 10:09 am UTC
*/

class UserEquipmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'equipment_id',
        'equipment_type_id',
        'note'
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
        return UserEquipment::class;
    }
}
