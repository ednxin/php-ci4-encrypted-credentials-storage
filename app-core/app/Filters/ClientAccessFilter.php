<?php

namespace App\Filters;

use App\Models\UserClientAccessModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ClientAccessFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userId = (int) session()->get('user_id');
        $role   = (string) session()->get('role');

        if ($userId <= 0) {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        if ($role === 'super_admin') {
            return null;
        }

        $clientId = (int) service('uri')->getSegment(3);

        if ($clientId <= 0) {
            return redirect()->to('/clients')->with('error', 'Invalid client request.');
        }

        $accessModel = new UserClientAccessModel();
        if (! $accessModel->userCanAccessClient($userId, $clientId)) {
            return redirect()->to('/clients')->with('error', 'You do not have access to that client.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
