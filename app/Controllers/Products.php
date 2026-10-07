<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        $data['products'] = $productModel
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('products/index', $data);
    }

    public function create()
    {
        return view('products/create');
    }

    public function store()
    {
        $productModel = new ProductModel();

        $productModel->insert([
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'created_at'     => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/products');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();

        $data['product'] = $productModel->find($id);

        return view('products/edit', $data);
    }

    public function update($id)
    {
        $productModel = new ProductModel();

        $productModel->update($id, [
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity')
        ]);

        return redirect()->to('/products');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();

        $productModel->delete($id);

        return redirect()->to('/products');
    }
}