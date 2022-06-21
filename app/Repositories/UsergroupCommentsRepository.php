<?php

namespace App\Repositories;

use App\Models\UsergroupComments;
use App\Repositories\BaseRepository;

/**
 * Class UsergroupCommentsRepository
 * @package App\Repositories
 * @version September 23, 2021, 12:55 pm UTC
*/

class UsergroupCommentsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'comment',
        'theme_id'
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
        return UsergroupComments::class;
    }
}
