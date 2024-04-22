<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\KycModel;

class UserController extends ResourceController
{
    use ResponseTrait;

    protected $userModel;
    protected $kycModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->kycModel = new KycModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index($id = null)
    {
        $token = $this->request->decodedToken ?? null;
        if ($token && $token->user_id == $id) {
            $user_id = $token->user_id;
        } else {
            return $this->failUnauthorized('Unauthorized');
        }
        $user = $this->userModel->find($user_id);
        if (!$user) {
            // Handle case when user with the provided ID is not found
            return $this->failNotFound('User not found.');
        }
        $user['kyc'] = $this->kycModel->where('user_id', $user_id)->first();
        return $this->respond($user);
    }

    public function submitKYC($id = null)
    {
        $token = $this->request->decodedToken ?? null;
        if ($token && $token->user_id == $id) {
            $user_id = $token->user_id;
        } else {
            return $this->failUnauthorized('Unauthorized');
        }

        // Check if user already has KYC details
        $existingKYC = $this->kycModel->where('user_id', $user_id)->first();
        if ($existingKYC) {
            return $this->failValidationErrors('KYC details already exist for this user.');
        }

        // Get the request data
        $data = $this->request->getJSON();
        
        // Validation rules for KYC fields
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'state' => 'required',
            'country' => 'required',
            'phone_number' => 'required',
        ];

        $data = [
            'first_name' => $data->first_name ?? null,
            'last_name' => $data->last_name ?? null,
            'address' => $data->address ?? null,
            'city' => $data->city ?? null,
            'postal_code' => $data->postal_code ?? null,
            'state' => $data->state ?? null,
            'country' => $data->country ?? null,
            'phone_number' => $data->phone_number ?? null,
        ];

        // validation
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();
        $validData['user_id'] = $user_id;
        
        // Save the KYC information
        if ($this->kycModel->save($validData)) {
            $user = $this->userModel->find($user_id);
            if (!$user) {
                // Handle case when user with the provided ID is not found
                return $this->failNotFound('User not found.');
            }
            $user['kyc'] = $this->kycModel->where('user_id', $user_id)->first();
            return $this->respond($user);
        }

        return $this->failServerError('Could not create the KYC');
    }

    public function updateKYC($id = null, $kyc_id)
    {
        if (!$id || !$kyc_id) {
            return $this->failBadRequest('Both user ID and KYC ID are required');
        }

        $token = $this->request->decodedToken ?? null;
        if ($token && $token->user_id == $id) {
            $user_id = $token->user_id;
        } else {
            return $this->failUnauthorized('Unauthorized');
        }

        // Check if the KYC record exists and belongs to the user
        $kycRecord = $this->kycModel->where('id', $kyc_id)->where('user_id', $user_id)->first();
        if (!$kycRecord) {
            return $this->failNotFound('No KYC record found for the given user and KYC ID');
        }
        // Check if user already has KYC details
        $existingKYC = $this->kycModel->where('user_id', $user_id)->first();
        if (!$existingKYC) {
            return $this->failNotFound('No KYC details found for this user.');
        }

        // Get the request data
        $data = $this->request->getJSON();
        
        // Validation rules for KYC fields
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'state' => 'required',
            'country' => 'required',
            'phone_number' => 'required',
        ];

        $data = [
            'first_name' => $data->first_name ?? null,
            'last_name' => $data->last_name ?? null,
            'address' => $data->address ?? null,
            'city' => $data->city ?? null,
            'postal_code' => $data->postal_code ?? null,
            'state' => $data->state ?? null,
            'country' => $data->country ?? null,
            'phone_number' => $data->phone_number ?? null,
        ];

        // validation
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();
        // $validData['user_id'] = $user_id;
        
    // Update the KYC record in the database
    try {
        $success = $this->kycModel->update($kyc_id, $validData);
        if (!$success) {
            return $this->failServerError('Failed to update KYC details');
        }
    } catch (\Exception $e) {
        return $this->failServerError($e->getMessage());
    }

    return $this->respondUpdated(['message' => 'KYC details updated successfully']);
    }

}
