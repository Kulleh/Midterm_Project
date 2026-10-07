<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    private function validationRules(bool $passwordRequired = true): array
    {
        return [
            'username'  => 'required|max_length[50]',
            'full_name' => 'required|max_length[100]',
            'password'  => $passwordRequired ? 'required|min_length[8]|max_length[255]' : 'permit_empty|min_length[8]|max_length[255]',
            'avatar'    => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
        ];
    }

    private function avatarDirectory(): string
    {
        return FCPATH . 'uploads/avatars';
    }

    private function saveAvatar()
    {
        $avatar = $this->request->getFile('avatar');

        if ($avatar === null || ! $avatar->isValid() || $avatar->hasMoved()) {
            return null;
        }

        $directory = $this->avatarDirectory();

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $fileName = $avatar->getRandomName();
        $avatar->move($directory, $fileName);

        return $fileName;
    }

    private function removeAvatar(?string $fileName): void
    {
        if ($fileName === null || basename($fileName) !== $fileName) {
            return;
        }

        $path = $this->avatarDirectory() . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function usernameExists(string $username, ?int $ignoreId = null): bool
    {
        $model = new UserModel();
        $query = $model->where('username', $username);

        if ($ignoreId !== null) {
            $query->where('id !=', $ignoreId);
        }

        return $query->first() !== null;
    }

    public function index()
    {
        return view('users/index', [
            'users' => (new UserModel())->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('users/create', [
            'user'       => [],
            'validation' => null,
            'password' => 'required|min_length[12]'
        ]);

        if (! $this->validateData($this->request->getPost(), $rules)) {
            return view('users/new');
        }

        $validated = $this->validator->getValidated();
    }

    public function store()
    {
        $username = trim((string) $this->request->getPost('username'));

        if (! $this->validate($this->validationRules())) {
            return view('users/create', [
                'user'       => $this->request->getPost(),
                'validation' => $this->validator,
            ]);
        }

        if ($this->usernameExists($username)) {
            return view('users/create', [
                'user'       => array_merge($this->request->getPost(), ['username' => $username]),
                'validation' => null,
                'error'      => 'That username is already in use.',
            ]);
        }

        $avatarName = $this->saveAvatar();

        (new UserModel())->insert([
            'username'   => $username,
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'password'   => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'avatar'     => $avatarName,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'Staff account added successfully.');
    }

    public function edit($id)
    {
        $user = (new UserModel())->find((int) $id);

        if ($user === null) {
            return redirect()->to('/users')->with('error', 'Staff account not found.');
        }

        return view('users/edit', [
            'user'       => $user,
            'validation' => null,
        ]);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user      = $userModel->find((int) $id);

        if ($user === null) {
            return redirect()->to('/users')->with('error', 'Staff account not found.');
        }

        if (! $this->validate($this->validationRules(false))) {
            return view('users/edit', [
                'user'       => array_merge($user, $this->request->getPost()),
                'validation' => $this->validator,
            ]);
        }

        $username = trim((string) $this->request->getPost('username'));

        if ($this->usernameExists($username, (int) $id)) {
            return view('users/edit', [
                'user'       => array_merge($user, $this->request->getPost()),
                'validation' => null,
                'error'      => 'That username is already in use.',
            ]);
        }

        $newAvatarName = $this->saveAvatar();
        $updateData    = [
            'username'  => $username,
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($newAvatarName !== null) {
            $updateData['avatar'] = $newAvatarName;
            $this->removeAvatar($user['avatar'] ?? null);
        }

        $userModel->update((int) $id, $updateData);

        return redirect()->to('/users')->with('success', 'Staff account updated successfully.');
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $user      = $userModel->find((int) $id);

        if ($user === null) {
            return redirect()->to('/users')->with('error', 'Staff account not found.');
        }

        try {
            $userModel->delete((int) $id);
        } catch (\Throwable $exception) {
            return redirect()->to('/users')->with(
                'error',
                'Staff account could not be deleted because existing sales reference this account.'
            );
        }

        $this->removeAvatar($user['avatar'] ?? null);

        return redirect()->to('/users')->with('success', 'Staff account deleted successfully.');
    }
}
