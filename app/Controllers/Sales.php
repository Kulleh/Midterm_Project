<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;

class Sales extends BaseController
{
    public function create()
    {
        return view('sales/create', [
            'products' => (new ProductModel())
                ->where('stock_quantity >', 0)
                ->orderBy('name', 'ASC')
                ->findAll(),
            'customers' => (new CustomerModel())
                ->orderBy('id', 'ASC')
                ->findAll(),
        ]);
    }

    public function store()
    {
        $positiveInt = ['options' => ['min_range' => 1]];

        $productId = filter_var(
            $this->request->getPost('product_id'),
            FILTER_VALIDATE_INT,
            $positiveInt
        );
        $quantity = filter_var(
            $this->request->getPost('quantity'),
            FILTER_VALIDATE_INT,
            $positiveInt
        );

        if ($productId === false || $quantity === false) {
            return redirect()->to('/sales/create')
                ->with('error', 'Select a product and enter a quantity of at least 1.')
                ->withCookies();
        }

        $customerInput = $this->request->getPost('customer_id');
        $customerId = null;

        if ($customerInput !== null && $customerInput !== '') {
            $customerId = filter_var($customerInput, FILTER_VALIDATE_INT, $positiveInt);

            if ($customerId === false || (new CustomerModel())->find($customerId) === null) {
                return redirect()->to('/sales/create')
                    ->with('error', 'Select a valid customer.')
                    ->withCookies();
            }
        }

        $product = (new ProductModel())->find($productId);

        if ($product === null) {
            return redirect()->to('/sales/create')
                ->with('error', 'That product is no longer available.')
                ->withCookies();
        }

        $totalPrice = number_format(
            (float) $product['price'] * $quantity,
            2,
            '.',
            ''
        );

        $db = db_connect();

        try {
            $db->transBegin();

            // The stock check and decrease happen in one database statement.
            $updated = $db->query(
                'UPDATE products
            SET stock_quantity = stock_quantity - ?
            WHERE id = ? AND stock_quantity >= ?',
                [$quantity, $productId, $quantity]
            );

            if ($updated === false) {
                throw new \RuntimeException('Stock update failed.');
            }

            if ($db->affectedRows() !== 1) {
                $db->transRollback();

                return redirect()->to('/sales/create')
                    ->with('error', 'Out of stock.')
                    ->withCookies();
            }

            $saved = $db->table('sales')->insert([
                'product_id'  => $productId,
                'customer_id' => $customerId,
                'sold_by'     => (int) session()->get('staff_id'),
                'quantity'    => $quantity,
                'total_price' => $totalPrice,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            if (! $saved || $db->transStatus() === false) {
                throw new \RuntimeException('Sale insert failed.');
            }

            if (! $db->transCommit()) {
                throw new \RuntimeException('Sale commit failed.');
            }
        } catch (\Throwable $exception) {
            $db->transRollback();
            log_message('error', 'Could not record sale: ' . $exception->getMessage());

            return redirect()->to('/sales/create')
                ->with('error', 'The sale could not be saved. Please try again.')
                ->withCookies();
        }

        return redirect()->to('/sales/create')
            ->with('success', 'Purchased successfully.')
            ->withCookies();
    }

    public function history()
    {
        $db = db_connect();

        $sales = $db->table('sales s')
            ->select(
                's.id, s.product_id, s.customer_id, s.sold_by,
            s.quantity, s.total_price, s.created_at,
            p.name AS product_name,
            c.full_name AS customer_name,
            u.full_name AS staff_name'
            )
            ->join('products p', 'p.id = s.product_id', 'left')
            ->join('customers c', 'c.id = s.customer_id', 'left')
            ->join('users u', 'u.id = s.sold_by', 'left')
            ->orderBy('s.created_at', 'DESC')
            ->orderBy('s.id', 'DESC')
            ->get()
            ->getResultArray();

        return view('sales/history', ['sales' => $sales]);
    }
}
