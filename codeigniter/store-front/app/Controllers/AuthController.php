<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Models\BlacklistModel;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;

class AuthController extends ResourceController
{
    use ResponseTrait;

    protected $userModel;
    protected $blacklistModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->blacklistModel = new BlacklistModel();
    }

    public function register()
    {
        // Get the JSON request
        $json = $this->request->getJSON();

        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]|max_length[20]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        // json data
        $data = [
            'username' => $json->username ?? null,
            'email' => $json->email ?? null,
            'password' => $json->password ?? null,
        ];

        // validation
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        // Check if the user already exists with the provided email or username
        $userExists = $this->userModel->where('email', $validData['email'])
                                ->orWhere('username', $validData['username'])
                                ->first();

        if ($userExists) {
            return $this->failValidationErrors(['error' => 'User already exists.']);
        }

        // Hash the password
        $validData['password'] = password_hash($validData['password'], PASSWORD_DEFAULT);

        // Save the user
        $this->userModel->save($validData);

        // Return success response
        return $this->respondCreated(['message' => 'User registered successfully.']);
    }

    public function login()
    {
        $json = $this->request->getJSON();
        $data = [
            'email' => $json->email ?? null,
            'password' => $json->password ?? null,
        ];
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        // validation
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        $user = $this->userModel->where('email', $validData['email'])->first();
        if (!$user || !password_verify($validData['password'], $user['password'])) {
            return $this->failUnauthorized('Invalid email or password');
        }
        $key = $_ENV['JWT_SECRET_KEY'];
        $iat = time(); // current timestamp value
        $exp = $iat + 3600; // expiration time is 1 hour

        $payload = array(
            // "iss" => "Issuer of the JWT",
            // "aud" => "Audience that the JWT",
            // "sub" => "Subject of the JWT",
            "iat" => $iat,
            "exp" => $exp,
            "email" => $user['email'],
            'user_id' => $user['id'],
        );

        $token = JWT::encode($payload, $key, 'HS256');
  
        $response = [
            'message' => 'Login Succesful',
            'token' => $token
        ];
          
        // return $this->respond($response, 200);
        return $this->respond(['data' => ['token' => $response], "status" => true, "message" => "Login Success!"], 200);

    }

    public function logout()
    {
        // Retrieve the decoded token and original token from the request object
        $token = $this->request->originalToken ?? null;
        if ($token) {
            $this->blacklistModel->save(['token' => $token]);
        return $this->respond(['message' => 'User logged out successfully.']);
        }

    }
}
