<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use App\Models\BlacklistModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    protected $originalToken;

    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the Authorization header exists
        if (!$request->hasHeader('Authorization')) {
            // Handle case where Authorization header is missing
            $response = service('response');
            return $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                            ->setBody(json_encode(['error' => 'Authorization header is missing']))
                            ->setHeader('Content-Type', 'application/json');
        }

        // Get the Authorization header
        $authorizationHeaders = $request->header('Authorization')->getValue();
        $parts = explode(' ', $authorizationHeaders);
        $token = isset($parts[1]) ? $parts[1] : null;
        
        try {

            $key = $_ENV['JWT_SECRET_KEY'];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // Check if the token is blacklisted

            $blacklistModel = new BlacklistModel();
            $isBlacklisted = $blacklistModel->where('token', $token)->first();

            if ($isBlacklisted) {
                throw new \Exception('Token blacklisted');
            }

            // Store both the decoded token and the original token in the request object
            $request->decodedToken = $decoded;
            $request->originalToken = $token;

        } catch (\Exception $e) {
            $response = service('response');
            return $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED)
                            ->setBody(json_encode(['error' => $e->getMessage()]))
                            ->setHeader('Content-Type', 'application/json');
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
