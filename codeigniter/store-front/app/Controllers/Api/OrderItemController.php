<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\OrderItemModel;

class OrderItemController extends ResourceController
{
    protected $orderItemModel;
    public function __construct()
    {
        $this->orderItemModel = new OrderItemModel();
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getJSON();

        // Validate the input data
        $rules = [
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit_price' => 'required|decimal',
        ];
        $data = [
            'order_id' => $data->order_id,
            'product_id' => $data->product_id,
            'quantity' => $data->quantity,
            'unit_price' => $data->unit_price,
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        // Insert the order item into the database
        if ($this->orderItemModel->insert($validData)) {
            return $this->respondCreated(['message' => 'Order item created successfully']);
        } else {
            return $this->failServerError('Failed to create order item');
        }
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        // Check if the order item exists
        $orderItem = $this->orderItemModel->find($id);
        if (! $orderItem) {
            return $this->failNotFound('Order item not found');
        }
        $data = $this->request->getJSON();

        // Validate the input data
        $rules = [
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit_price' => 'required|decimal',
        ];
        $data = [
            'order_id' => $data->order_id,
            'product_id' => $data->product_id,
            'quantity' => $data->quantity,
            'unit_price' => $data->unit_price,
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        // Update the order item
        if ($this->orderItemModel->update($id, $validatedData)) {
            return $this->respondUpdated(['message' => 'Order item updated successfully']);
        } else {
            return $this->failServerError('Failed to update order item');
        }
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        // Check if the order item exists
        $orderItem = $this->orderItemModel->find($id);
        if (! $orderItem) {
            return $this->failNotFound('Order item not found');
        }

        // Delete the order item
        if ($this->orderItemModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Order item deleted successfully']);
        } else {
            return $this->failServerError('Failed to delete order item');
        }
    }
}
