<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    private function validationRules(): array
    {
        return [
            'full_name' => 'required|max_length[100]',
            'email'    => 'required|valid_email|max_length[100]',
            'phone'    => 'permit_empty|max_length[20]',
        ];
    }

    public function index()
    {
        $customerModel = new CustomerModel();

        return view('customers/index', [
            'customers' => $customerModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('customers/create', [
            'customer'   => [],
            'validation' => null,
        ]);
    }

    public function store()
    {
        if (! $this->validate($this->validationRules())) {
            return view('customers/create', [
                'customer'   => $this->request->getPost(),
                'validation' => $this->validator,
            ]);
        }

        $customerModel = new CustomerModel();
        $customerModel->insert([
            'full_name'  => trim((string) $this->request->getPost('full_name')),
            'email'      => trim((string) $this->request->getPost('email')),
            'phone'      => trim((string) $this->request->getPost('phone')) ?: null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/customers')->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $customer = (new CustomerModel())->find((int) $id);

        if ($customer === null) {
            return redirect()->to('/customers')->with('error', 'Customer not found.');
        }

        return view('customers/edit', [
            'customer'   => $customer,
            'validation' => null,
        ]);
    }

    public function update($id)
    {
        $customerModel = new CustomerModel();
        $customer       = $customerModel->find((int) $id);

        if ($customer === null) {
            return redirect()->to('/customers')->with('error', 'Customer not found.');
        }

        if (! $this->validate($this->validationRules())) {
            return view('customers/edit', [
                'customer'   => array_merge($customer, $this->request->getPost()),
                'validation' => $this->validator,
            ]);
        }

        $customerModel->update((int) $id, [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
            'phone'     => trim((string) $this->request->getPost('phone')) ?: null,
        ]);

        return redirect()->to('/customers')->with('success', 'Customer updated successfully.');
    }

    public function delete($id)
    {
        try {
            (new CustomerModel())->delete((int) $id);
        } catch (\Throwable $exception) {
            return redirect()->to('/customers')->with(
                'error',
                'Customer could not be deleted because existing sales still reference this customer.'
            );
        }

        return redirect()->to('/customers')->with('success', 'Customer deleted successfully.');
    }
}
