<?php

namespace App\Repositories;

use App\Models\Usergroups;
use App\Repositories\BaseRepository;

/**
 * Class UsergroupsRepository
 * @package App\Repositories
 * @version September 23, 2021, 8:24 am UTC
*/

class UsergroupsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usergroup_name',
        'usergroup_description',
        'usergroup_privat',
        'language_iso',
        'country_iso',
        'member_count',
        'edit_lock'
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
        return Usergroups::class;
    }
}
