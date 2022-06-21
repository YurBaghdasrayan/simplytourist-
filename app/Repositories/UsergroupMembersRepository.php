<?php

namespace App\Repositories;

use App\Models\UsergroupMembers;
use App\Repositories\BaseRepository;

/**
 * Class UsergroupMembersRepository
 * @package App\Repositories
 * @version September 23, 2021, 12:49 pm UTC
*/

class UsergroupMembersRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'usergroup_id',
        'admin'
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
        return UsergroupMembers::class;
    }
}
