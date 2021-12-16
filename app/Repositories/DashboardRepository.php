<?php
/*
 * Author: Samsul Ma'arif<samsulma828@gmail.com>
 * Copyright (c) 2021.
 */

namespace App\Repositories;


// use App\Models\Dashboard;
use App\Repositories\Contracts\DashboardContract;

class DashboardRepository extends Repository implements DashboardContract
{
    public function getModel()
    {
        // return Dashboard::ins();
    }

}
