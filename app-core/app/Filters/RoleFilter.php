<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $currentRole = (string) session()->get('role');

        if ($currentRole === '') {
            return redirect()->to('/login')->with('error', 'Please login to continue.');
        }

        if ($arguments === null || $arguments === []) {
            return null;
        }

        if (! in_array($currentRole, $arguments, true)) {
            return redirect()->to('/dashboard')->with('error', 'You are not authorized to access that page.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
