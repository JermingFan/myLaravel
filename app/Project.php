<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;

class Project extends Model {

//    protected $table = 'project';

    /**
     * @return mixed
     */
    public function projects()
    {
        return $this->select('id', 'name', 'intro')
            ->orderBy('name', 'desc')
            ->paginate(5);
    }

}