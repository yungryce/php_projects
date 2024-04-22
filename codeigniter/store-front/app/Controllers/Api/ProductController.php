<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;

class ProductController extends ResourceController
{
    protected $productModel;
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        // Retrieve all products
        $products = $this->productModel->findAll();
    
        return $this->respond($products);
    }

    public function show($id = null)
    {
        // Retrieve product by ID
        $product = $this->productModel->find($id);

        if ($product) {
            return $this->respond($product);
        }

        return $this->failNotFound('Product not found');
    }

    public function create()
    {
        $data = $this->request->getJSON();
        $data = [
            'name' => $data->name ?? null,
            'description' => $data->description ?? null,
            'price' => $data->price ?? null,
            'quantity' => $data->quantity ?? null,
            'category_id' => $data->category_id ?? null,
        ];
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|decimal',
            'quantity' => 'required|integer',
            'category_id' => 'required|integer',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        if ($this->productModel->save($validData)) {
            return $this->respondCreated($validData, 'Product created successfully');
        }
        return $this->failServerError('Could not create the product');
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();

        if (!$this->productModel->find($id)) {
            return $this->failNotFound('Product not found');
        }

        $data = [
            'name' => $data->name ?? null,
            'description' => $data->description ?? null,
            'price' => $data->price ?? null,
            'quantity' => $data->quantity ?? null,
            // 'category_id' => $data->category_id ?? null,
        ];
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|decimal',
            'quantity' => 'required|integer',
            // 'category_id' => 'required|integer',
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        if ($this->productModel->update($id, $validData)) {
            return $this->respondUpdated($validData, 'Product updated successfully');
        }
        return $this->failServerError('Could not update the product');
    }

    public function delete($id = null)
    {
        if (!$this->productModel->find($id)) {
            return $this->failNotFound('Product not found');
        }

        if ($this->productModel->delete($id)) {
            return $this->respondDeleted('Product deleted successfully');
        }
        return $this->failServerError('Could not delete the product');
    }
}
