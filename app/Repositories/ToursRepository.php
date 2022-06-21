<?php

namespace App\Repositories;

use App\Models\Tours;

/**
 * Class ToursRepository
 * @package App\Repositories
 * @version September 16, 2021, 11:54 am UTC
*/

class ToursRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tour_name',
        'country_iso',
        'tour_type_id',
        'tour_type_rating',
        'tour_condition_id',
        'tour_condition_rating',
        'tour_date_start',
        'tour_date_end',
        'tour_description',
        'tour_link',
        'tour_creator',
        'tour_created_datetime',
        'attendees_min',
        'attendees_max',
        'open_places',
        'guide_needed',
        'guided',
        'estimated_costs',
        'tour_status',
        'edit_lock',
        'tour_private',
        'target_longitude',
        'target_latitude',
        'target_coordinates'
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
        return Tours::class;
    }
}
