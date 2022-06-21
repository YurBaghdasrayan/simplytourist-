<?php

namespace App\Repositories;

use App\Models\TourAttendees;
use App\Repositories\BaseRepository;

/**
 * Class TourAttendeesRepository
 * @package App\Repositories
 * @version September 24, 2021, 9:21 am UTC
*/

class TourAttendeesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tour_id',
        'user_id',
        'tour_admin'
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
        return TourAttendees::class;
    }
}
