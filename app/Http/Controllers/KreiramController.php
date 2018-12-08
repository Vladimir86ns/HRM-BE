<?php

namespace App\Http\Controllers;

class KreiramController extends Controller
{
    public function test()
    {
        return [
            [
                'employee_id' => 'CJK-001',
                'accountType' => "Advanced",
                'first_name' => 'Vladimir',
                'last_name' => 'Grujin',
                'status_work' => 'work',
                'avatar' => "http://reactify.theironnetwork.org/data/images/user-1.jpg",
                'badgeClass' => 'badge-success',
                'attendanceClass' => 'badge-success',
                'checked' => false,
                'dateCreated' => "13 Aug 2018",
                'emailAddress' => "Steve@example.com",
                'id' => 1,
                'lastSeen' => "Since 1 hour",
                'name' => 'Vladimir',
                'status' => 'Acive',
                'type' => 'new'
            ],
            [
                'employee_id' => 'CJK-001',
                'accountType' => "Advanced",
                'first_name' => 'Vladimir',
                'last_name' => 'Grujin',
                'status_work' => 'home',
                'avatar' => "http://reactify.theironnetwork.org/data/images/user-1.jpg",
                'activeClass' => 'badge-success',
                'attendanceClass' => 'badge-primary',
                'badgeClass' => 'badge-success',
                'checked' => false,
                'dateCreated' => "13 Aug 2018",
                'emailAddress' => "Steve@example.com",
                'id' => 2,
                'lastSeen' => "Since 1 hour",
                'name' => 'Vladimir',
                'status' => 'Acive',
                'type' => 'new'
            ],
            [
                'employee_id' => 'CJK-001',
                'accountType' => "Advanced",
                'first_name' => 'Vladimir',
                'last_name' => 'Grujin',
                'status_work' => 'sick',
                'avatar' => "http://reactify.theironnetwork.org/data/images/user-1.jpg",
                'activeClass' => 'badge-success',
                'attendanceClass' => 'badge-danger',
                'badgeClass' => 'badge-success',
                'checked' => false,
                'dateCreated' => "13 Aug 2018",
                'emailAddress' => "Steve@example.com",
                'id' => 3,
                'lastSeen' => "Since 1 hour",
                'name' => 'Vladimir',
                'status' => 'Acive',
                'type' => 'new'
            ]
        ];
    }
}
