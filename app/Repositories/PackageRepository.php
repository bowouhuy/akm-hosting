<?php

namespace App\Repositories;


use App\Models\Package;
use App\Repositories\Contracts\PackageContract;

class PackageRepository extends Repository implements PackageContract
{
    public function getModel()
    {
        return Package::ins();
    }

}
