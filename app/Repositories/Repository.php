<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */


namespace App\Repositories;

use App\Repositories\Traits\RestfulRepository;

abstract class Repository
{
    use RestfulRepository;

    protected
        $sortBy = ['created_at'];
}
