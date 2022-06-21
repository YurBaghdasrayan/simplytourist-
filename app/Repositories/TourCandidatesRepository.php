<?php

namespace App\Repositories;

use App\Models\TourCandidates;
use App\Repositories\BaseRepository;

/**
 * Class TourCandidatesRepository
 * @package App\Repositories
 * @version November 30, 2021, 3:40 pm UTC
*/

class TourCandidatesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'tour_id',
        'status'
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
        return TourCandidates::class;
    }
}
