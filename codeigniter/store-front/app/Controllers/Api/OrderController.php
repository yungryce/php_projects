<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrderModel;

class OrderController extends ResourceController
{
    use ResponseTrait;

    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        // Retrieve orders for the authenticated user
        $token = $this->request->decodedToken ?? null;
        if (! $token) {
            return $this->failUnauthorized('Unauthorized');
        }
        $user_id = $token->user_id;

        // Fetch orders with their associated order items
        $orders = $this->orderModel->with('orderItems')->where('user_id', $user_id)->findAll();

        return $this->respond($orders);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $token = $this->request->decodedToken ?? null;
        if (!$token) {
            return $this->failUnauthorized('Unauthorized');
        }

        $user_id = $token->user_id;
        $order = $this->orderModel->where('user_id', $user_id)->find($id);
        if (!$order) {
            return $this->failNotFound('Order not found');
        }

        return $this->respond($order);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $token = $this->request->decodedToken ?? null;
        if (!$token) {
            return $this->failUnauthorized('Unauthorized');
        }
    
        $data = $this->request->getJSON();
        $data = [
            'user_id' => $token->user_id,
            'total_amount' => $data->total_amount,
            'status' => $data->status,
        ];
        $rules = [
            'total_amount' => 'required|decimal',
            'status' => 'permit_empty|in_list[pending,confirmed,shipped,delivered,cancelled]'
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        if ($this->orderModel->insert($validData)) {
            $response = [
                'id' => $this->orderModel->getInsertID(),
                'message' => 'Order created successfully'
            ];
            return $this->respondCreated($response);
        }
        return $this->failServerError('Could not create the order');
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
        $token = $this->request->decodedToken ?? null;
        if (!$token) {
            return $this->failUnauthorized('Unauthorized');
        }
    
        $data = $this->request->getJSON();
        $data = [
            'user_id' => $token->user_id,
            'total_amount' => $data->total_amount,
            'status' => $data->status,
        ];
        $rules = [
            'total_amount' => 'required|decimal',
            'status' => 'permit_empty|in_list[pending,confirmed,shipped,delivered,cancelled]'
        ];

        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        $order = $this->orderModel->where('user_id', $token->user_id)->find($id);
        if (!$order) {
            return $this->failNotFound('Order not found');
        }
    
        if ($this->orderModel->update($id, $validData)) {
            return $this->respondUpdated(['message' => 'Order updated successfully']);
        } else {
            return $this->failServerError('Failed to update order');
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
        $token = $this->request->decodedToken ?? null;
        if (!$token) {
            return $this->failUnauthorized('Unauthorized');
        }
    
        $order = $this->orderModel->where('user_id', $token->user_id)->find($id);
        if (!$order) {
            return $this->failNotFound('Order not found');
        }
    
        if ($this->orderModel->delete($id)) {
            return $this->respondDeleted(['message' => 'Order deleted successfully']);
        } else {
            return $this->failServerError('Failed to delete order');
        }
    }
}
