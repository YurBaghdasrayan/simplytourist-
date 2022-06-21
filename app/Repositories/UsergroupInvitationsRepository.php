<?php

namespace App\Repositories;

use App\Models\UsergroupInvitations;
use App\Repositories\BaseRepository;

/**
 * Class UsergroupInvitationsRepository
 * @package App\Repositories
 * @version September 23, 2021, 12:50 pm UTC
*/

class UsergroupInvitationsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usergroup_id',
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
        return UsergroupInvitations::class;
    }
}
