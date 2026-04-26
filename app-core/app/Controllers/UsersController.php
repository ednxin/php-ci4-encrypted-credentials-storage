<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\UserClientAccessModel;
use App\Models\UserModel;

class UsersController extends BaseController
{
    public function index()
    {
        $userModel   = new UserModel();
        $clientModel = new ClientModel();
        $accessModel = new UserClientAccessModel();

        $users   = $userModel->orderBy('id', 'DESC')->findAll();
        $clients = $clientModel->orderBy('client_name', 'ASC')->findAll();

        $accessMap = [];
        foreach ($accessModel->findAll() as $row) {
            $accessMap[(int) $row['user_id']][] = (int) $row['client_id'];
        }

        return view('users/index', [
            'users'     => $users,
            'clients'   => $clients,
            'accessMap' => $accessMap,
        ]);
    }

    public function create()
    {
        $clientModel = new ClientModel();

        return view('users/create', [
            'clients' => $clientModel->orderBy('client_name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'password' => 'required|min_length[10]|max_length[255]',
            'role'     => 'required|in_list[super_admin,viewer_user]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please correct the highlighted user form errors.');
        }

        $userModel = new UserModel();
        $userId    = (int) $userModel->insert([
            'username'      => trim((string) $this->request->getPost('username')),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => (string) $this->request->getPost('role'),
            'is_active'     => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        $clientIds   = $this->request->getPost('client_ids') ?? [];
        $accessModel = new UserClientAccessModel();
        $accessModel->syncUserClientAccess($userId, is_array($clientIds) ? $clientIds : []);

        return redirect()->to('/users')->with('success', 'User created successfully.');
    }

    public function edit(int $id)
    {
        $userModel   = new UserModel();
        $clientModel = new ClientModel();
        $accessModel = new UserClientAccessModel();

        $user = $userModel->find($id);
        if (! $user) {
            return redirect()->to('/users')->with('error', 'User not found.');
        }

        $assigned = array_map(
            static fn ($row) => (int) $row['client_id'],
            $accessModel->where('user_id', $id)->findAll()
        );

        return view('users/edit', [
            'user'     => $user,
            'clients'  => $clientModel->orderBy('client_name', 'ASC')->findAll(),
            'assigned' => $assigned,
        ]);
    }

    public function update(int $id)
    {
        $userModel = new UserModel();
        $user      = $userModel->find($id);

        if (! $user) {
            return redirect()->to('/users')->with('error', 'User not found.');
        }

        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,' . $id . ']',
            'role'     => 'required|in_list[super_admin,viewer_user]',
        ];

        $password = (string) $this->request->getPost('password');
        if ($password !== '') {
            $rules['password'] = 'permit_empty|min_length[10]|max_length[255]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please correct the highlighted user form errors.');
        }

        $payload = [
            'username'  => trim((string) $this->request->getPost('username')),
            'role'      => (string) $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($password !== '') {
            $payload['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $userModel->update($id, $payload);

        $clientIds   = $this->request->getPost('client_ids') ?? [];
        $accessModel = new UserClientAccessModel();
        $accessModel->syncUserClientAccess($id, is_array($clientIds) ? $clientIds : []);

        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }

    public function delete(int $id)
    {
        if ((int) session()->get('user_id') === $id) {
            return redirect()->to('/users')->with('error', 'You cannot delete your current account.');
        }

        $userModel = new UserModel();
        if (! $userModel->find($id)) {
            return redirect()->to('/users')->with('error', 'User not found.');
        }

        $userModel->delete($id);

        return redirect()->to('/users')->with('success', 'User deleted successfully.');
    }
}
