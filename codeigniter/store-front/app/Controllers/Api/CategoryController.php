<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;


class CategoryController extends ResourceController
{
    use ResponseTrait;

    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $categories = $this->categoryModel->findAll();
        return $this->respond($categories);
    }

    public function show($id = null)
    {
        $category = $this->categoryModel->find($id);
        if ($category) {
            return $this->respond($category);
        }
        return $this->failNotFound('Category not found');
    }

    public function create()
    {
        $data = $this->request->getJSON();

        // Validation rules
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'permit_empty|integer',
        ];

        $data = [
            'name' => $data->name ?? null,
            'description' => $data->description ?? null,,
        ];
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        if ($this->categoryModel->save($validData)) {
            return $this->respondCreated($data, 'Category created successfully');
        }
        return $this->failServerError('Could not create the category');
    }

    public function update($id = null)
    {
        if (!$this->categoryModel->find($id)) {
            return $this->failNotFound('Category not found');
        }

        $data = $this->request->getJSON();

        // Validation rules
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'parent_id' => 'permit_empty|integer',
        ];

        $data = [
            'name' => $data->name ?? null,
            'description' => $data->description ?? null,,
        ];
        if (! $this->validateData($data, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $validData = $this->validator->getValidated();

        if ($this->categoryModel->update($id, $validData)) {
            return $this->respondUpdated($data, 'Category updated successfully');
        }
        return $this->failServerError('Could not update the category');
    }

    public function delete($id = null)
    {
        if (!$this->categoryModel->find($id)) {
            return $this->failNotFound('Category not found');
        }

        if ($this->categoryModel->delete($id)) {
            return $this->respondDeleted('Category deleted successfully');
        }
        return $this->failServerError('Could not delete the category');
    }
}