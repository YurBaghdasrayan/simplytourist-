<?php

namespace App\Repositories;

use App\Models\UsergroupThemes;
use App\Repositories\BaseRepository;

/**
 * Class UsergroupThemesRepository
 * @package App\Repositories
 * @version September 23, 2021, 12:49 pm UTC
*/

class UsergroupThemesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'usergroup_id',
        'theme',
        'user_id',
        'tour_id'
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
        return UsergroupThemes::class;
    }
}
