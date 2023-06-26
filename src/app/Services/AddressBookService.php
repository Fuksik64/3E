<?php

namespace App\Services;

use App\Models\AddressBook;

class AddressBookService
{
    private AddressBook $addressBookModel;

    public function __construct()
    {
        $this->addressBookModel = new AddressBook();
    }

    public function getAll(): array
    {
        return $this->addressBookModel->getAll();
    }

    public function store(array $data): void
    {
        $this->addressBookModel->store($data);
    }

    public function destroy(int $id): void
    {
        $this->addressBookModel->destroy($id);
    }

}