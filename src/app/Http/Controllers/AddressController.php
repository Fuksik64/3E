<?php

namespace App\Http\Controllers;

use App\Services\AddressBookService;

class AddressController extends Controller
{
    protected AddressBookService $addressBookService;

    public function __construct()
    {
        parent::__construct();
        $this->addressBookService = new AddressBookService();
    }

    public function index(): void
    {
        $addresses = $this->addressBookService->getAll();

        view('address/index', compact('addresses'));
    }


    public function store(): void
    {
        $data = $this->validate([
            'firstname' => 'required|string|min:3|max:64',
            'lastname' => 'required|string|min:3|max:64',
            'email' => 'required|email|min:3|max:64|unique:address_book,email',
            'phone' => 'required|phone|unique:address_book,phone',
            'address' => 'required|string|min:3|max:64',
        ]);

        $this->addressBookService->store($data);

        redirect_back();
    }

    public function destroy(): void
    {
        $data = $this->validate([
            'id' => 'required|numeric'
        ]);

        $this->addressBookService->destroy($data['id']);

        redirect_back();
    }
}