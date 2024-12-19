<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Guests extends Controller {
    protected $apiUrl = 'http://localhost/clarika/public/api/guests';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $client = service('curlrequest');
        $response = $client->get($this->apiUrl);
        $guests = json_decode($response->getBody());

        return view('guests/list', ['guests' => $guests]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('guests/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];

        $client = service('curlrequest');
        $response = $client->post($this->apiUrl, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($data),
        ]);

        if ($response->getStatusCode() === 201) {
            return redirect()->to('/guests')->with('success', 'Guest added successfully');
        }

        $errors = json_decode($response->getBody(), true);
        return redirect()->back()->with('errors', $errors)->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $client = service('curlrequest');
        $response = $client->get("$this->apiUrl/$id");
        $guest = json_decode($response->getBody());

        if (!$guest) {
            return redirect()->to('/guests')->with('error', 'Guest not found');
        }

        return view('guests/form', ['guest' => $guest]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id) {
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ];
    
        $client = service('curlrequest');
        
        try {
            $response = $client->put("$this->apiUrl/$id", [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data),
            ]);
    
            if ($response->getStatusCode() === 200) {
                return redirect()->to('/guests')->with('success', 'Guest updated successfully');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('errors', ['error' => $e->getMessage()])->withInput();
        }
    
        $errors = json_decode($response->getBody(), true);

        if (isset($errors['messages'])) {
            return redirect()->back()
                ->with('errors', $errors['messages'])
                ->withInput();
        }
    
        return redirect()->back()->with('errors', ['Unexpected error occurred.'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function delete($id) {
        $client = service('curlrequest');
        $response = $client->delete("$this->apiUrl/$id");

        if ($response->getStatusCode() === 200) {
            return redirect()->to('/guests')->with('success', 'Guest deleted successfully');
        }

        return redirect()->to('/guests')->with('error', 'Failed to delete guest');
    }
}
