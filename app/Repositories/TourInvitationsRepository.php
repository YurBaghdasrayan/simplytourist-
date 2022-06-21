<?php

namespace App\Repositories;

use App\Models\TourInvitations;
use App\Repositories\BaseRepository;

/**
 * Class TourInvitationsRepository
 * @package App\Repositories
 * @version September 24, 2021, 11:22 am UTC
*/

class TourInvitationsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'tour_id',
        'user_id'
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
        return TourInvitations::class;
    }
}
