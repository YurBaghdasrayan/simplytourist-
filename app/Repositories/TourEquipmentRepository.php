<?php

namespace App\Repositories;

use App\Models\TourEquipment;
use App\Repositories\BaseRepository;

/**
 * Class TourEquipmentRepository
 * @package App\Repositories
 * @version September 24, 2021, 9:30 am UTC
*/

class TourEquipmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tour_id',
        'equipment_id',
        'equipment_type_id',
        'equipment_note'
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
        return TourEquipment::class;
    }
}
