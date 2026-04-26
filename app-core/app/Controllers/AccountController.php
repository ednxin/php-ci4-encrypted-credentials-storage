<?php

namespace App\Controllers;

use App\Models\UserModel;

class AccountController extends BaseController
{
    public function change()
    {
        return view('account/change_password');
    }

    public function update()
    {
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[10]|max_length[255]',
            'new_password_confirm' => 'required|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please correct the highlighted errors.');
        }

        $userId = (int) session()->get('user_id');
        if ($userId <= 0) {
            return redirect()->to('/login')->with('error', 'Please login.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user) {
            return redirect()->to('/login')->with('error', 'User not found.');
        }

        $current = (string) $this->request->getPost('current_password');
        if (! password_verify($current, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Current password is incorrect.');
        }

        $new = (string) $this->request->getPost('new_password');
        $userModel->update($userId, ['password_hash' => password_hash($new, PASSWORD_DEFAULT)]);

        return redirect()->to('/dashboard')->with('success', 'Your password has been changed.');
    }
}
