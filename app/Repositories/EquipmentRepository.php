<?php

namespace App\Repositories;

use App\Models\Equipment;

/**
 * Class EquipmentRepository
 * @package App\Repositories
 * @version September 20, 2021, 7:45 am UTC
*/

class EquipmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name_en',
        'name_de',
        'name_ru',
        'equipment_type_id',
        'packlist_hiking_daytour',
        'packlist_skitour',
        'packlist_via_ferrata',
        'packlist_ice_climbing',
        'packlist_bouldering_on_rock',
        'packlist_expedition',
        'packlist_indoor_climbing',
        'packlist_snowshoe_tour'
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
        return Equipment::class;
    }
}
