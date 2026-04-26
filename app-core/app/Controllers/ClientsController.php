<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\UserClientAccessModel;
use App\Services\EncryptionService;
use RuntimeException;

class ClientsController extends BaseController
{
    private ClientModel $clientModel;
    private UserClientAccessModel $accessModel;
    private EncryptionService $encryptionService;

    public function __construct()
    {
        $this->clientModel        = new ClientModel();
        $this->accessModel        = new UserClientAccessModel();
        $this->encryptionService  = new EncryptionService();
    }

    public function index()
    {
        $role   = (string) session()->get('role');
        $userId = (int) session()->get('user_id');

        if ($role === 'super_admin') {
            $clients = $this->clientModel->orderBy('id', 'DESC')->findAll();
        } else {
            $clients = $this->clientModel
                ->select('clients.*')
                ->join('user_client_access', 'user_client_access.client_id = clients.id')
                ->where('user_client_access.user_id', $userId)
                ->orderBy('clients.id', 'DESC')
                ->findAll();
        }

        return view('clients/index', [
            'clients' => $clients,
            'role'    => $role,
        ]);
    }

    public function create()
    {
        return view('clients/create');
    }

    public function store()
    {
        $rules = [
            'client_name' => 'required|min_length[2]|max_length[191]',
            'client_data' => 'required|min_length[3]',
            'master_key'  => 'required|min_length[12]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please correct the highlighted client form errors.');
        }

        try {
            $encrypted = $this->encryptionService->encrypt(
                (string) $this->request->getPost('client_data'),
                (string) $this->request->getPost('master_key')
            );
        } catch (RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $this->clientModel->insert([
            'client_name'           => trim((string) $this->request->getPost('client_name')),
            'encrypted_client_data' => $encrypted['ciphertext'],
            'iv'                    => $encrypted['iv'],
            'salt'                  => $encrypted['salt'],
        ]);

        return redirect()->to('/clients')->with('success', 'Client created successfully.');
    }

    public function edit(int $id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/clients')->with('error', 'Client not found.');
        }

        return view('clients/edit', [
            'client'        => $client,
            'decryptedData' => null,
        ]);
    }

    public function loadForEdit(int $id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/clients')->with('error', 'Client not found.');
        }

        $rules = [
            'master_key' => 'required|min_length[12]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/clients/edit/' . $id)->with('error', 'Master key is required to load existing data.');
        }

        try {
            $decrypted = $this->encryptionService->decrypt(
                (string) $client['encrypted_client_data'],
                (string) $this->request->getPost('master_key'),
                (string) $client['iv'],
                (string) $client['salt']
            );
        } catch (\RuntimeException $e) {
            return redirect()->to('/clients/edit/' . $id)->with('error', $e->getMessage());
        }

        return view('clients/edit', [
            'client'        => $client,
            'decryptedData' => $decrypted,
        ]);
    }

    public function update(int $id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/clients')->with('error', 'Client not found.');
        }

        $rules = [
            'client_name' => 'required|min_length[2]|max_length[191]',
            'client_data' => 'required|min_length[3]',
            'master_key'  => 'required|min_length[12]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Please correct the highlighted client form errors.');
        }

        try {
            $encrypted = $this->encryptionService->encrypt(
                (string) $this->request->getPost('client_data'),
                (string) $this->request->getPost('master_key')
            );
        } catch (RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $this->clientModel->update($id, [
            'client_name'           => trim((string) $this->request->getPost('client_name')),
            'encrypted_client_data' => $encrypted['ciphertext'],
            'iv'                    => $encrypted['iv'],
            'salt'                  => $encrypted['salt'],
        ]);

        return redirect()->to('/clients')->with('success', 'Client updated successfully.');
    }

    public function view(int $id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/clients')->with('error', 'Client not found.');
        }

        return view('clients/view', [
            'client'        => $client,
            'decryptedData' => null,
        ]);
    }

    public function decrypt(int $id)
    {
        $client = $this->clientModel->find($id);

        if (! $client) {
            return redirect()->to('/clients')->with('error', 'Client not found.');
        }

        $rules = [
            'master_key' => 'required|min_length[12]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('error', 'Master key is required to decrypt.');
        }

        $decrypted = null;
        try {
            $decrypted = $this->encryptionService->decrypt(
                (string) $client['encrypted_client_data'],
                (string) $this->request->getPost('master_key'),
                (string) $client['iv'],
                (string) $client['salt']
            );
        } catch (RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return view('clients/view', [
            'client'        => $client,
            'decryptedData' => $decrypted,
        ]);
    }

    public function delete(int $id)
    {
        if (! $this->clientModel->find($id)) {
            return redirect()->to('/clients')->with('error', 'Client not found.');
        }

        $this->clientModel->delete($id);

        return redirect()->to('/clients')->with('success', 'Client deleted successfully.');
    }
}
