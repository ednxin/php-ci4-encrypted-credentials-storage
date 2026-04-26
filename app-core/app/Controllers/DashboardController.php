<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\UserClientAccessModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $role   = (string) session()->get('role');
        $userId = (int) session()->get('user_id');

        $userModel   = new UserModel();
        $clientModel = new ClientModel();

        $stats = [
            'totalUsers'   => $userModel->countAllResults(),
            'totalClients' => $clientModel->countAllResults(),
            'assigned'     => 0,
        ];

        if ($role === 'viewer_user') {
            $accessModel       = new UserClientAccessModel();
            $stats['assigned'] = $accessModel->where('user_id', $userId)->countAllResults();
        }

        return view('dashboard/index', [
            'stats' => $stats,
            'role'  => $role,
        ]);
    }
}
