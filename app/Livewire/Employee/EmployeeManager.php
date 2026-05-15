<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use App\Models\Employee;
use Livewire\Attributes\Title;

#[Title('Kelola Karyawan | Hisan Makmur')]
class EmployeeManager extends Component
{
    // Menyimpan ID karyawan (null = mode tambah, ada nilai = mode edit)
    public ?int $employee_id = null;

    // Penanda apakah sedang dalam mode edit
    public bool $isEditMode = false;

    public function mount()
    {
        if (\Illuminate\Support\Facades\Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }
    }

    // Properti yang terhubung dengan input form (binding Livewire)
    public string $nik = '';
    public string $name = '';
    public string $phone = '';
    public string $position = '';
    public string $address = '';
    public ?int $user_id = null;


    // create/update data

    public function store(){
        // validasi input form
        // NIK harus unik, tapi dikecualikan jika sedang edit data sendiri

        $this->validate([
            'nik'      => 'required|unique:employees,nik,' . $this->employee_id,
            'name'     => 'required|min:3',
            'phone'    => 'required',
            'position' => 'required|min:3',
            'address'  => 'required|min:5',
            'user_id'  => 'nullable|exists:users,id',
        ],[
            'nik.required'      => 'NIK wajib diisi.',
            'nik.unique'        => 'NIK sudah digunakan oleh karyawan lain.',
            'name.required'     => 'Nama wajib diisi.',
            'name.min'          => 'Nama minimal 3 karakter.',
            'phone.required'    => 'No. Telepon wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'position.min'      => 'Jabatan minimal 3 karakter.',
            'address.required'  => 'Alamat wajib diisi.',
            'address.min'       => 'Alamat minimal 5 karakter.',
        ]);

        // 1. Dapatkan atau Buat User account untuk Karyawan
        if ($this->user_id) {
            $user = \App\Models\User::find($this->user_id);
            // Update nama user agar sinkron dengan nama karyawan jika ada perubahan
            if ($user && $user->name !== $this->name) {
                $user->update(['name' => $this->name]);
            }
        } else {
            // Jika tidak memilih akun, buatkan otomatis berdasarkan nama depan
            $firstName = strtolower(explode(' ', trim($this->name))[0]);
            // Bersihkan karakter non-alphanumeric jika ada
            $firstName = preg_replace('/[^a-z0-9]/', '', $firstName);
            
            $email = $firstName . '@gmail.com';
            $counter = 1;

            while (\App\Models\User::where('email', $email)->exists()) {
                $email = $firstName . $counter . '@gmail.com';
                $counter++;
            }

            $user = \App\Models\User::create([
                'email' => $email,
                'name' => $this->name,
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]);

            // Jika update nama, update juga nama di user
            if ($user && $user->name !== $this->name) {
                $user->update(['name' => $this->name]);
            }
        }

        // 2. Simpan atau update data karyawan
        // Jika employee_id null, berarti tambah data baru, jika ada nilai berarti update data lama
        Employee::updateOrCreate(
            ['id' => $this->employee_id],
            [
                'user_id'  => $user->id,
                'nik'      => $this->nik,
                'name'     => $this->name,
                'phone'    => $this->phone,
                'position' => $this->position,
                'address'  => $this->address,
            ]
        );

        // Flash message untuk notifikasi sukses
        session()->flash(
            'success',
            $this->isEditMode 
            ? 'Data karyawan berhasil diperbarui.' 
            : 'Data karyawan berhasil ditambahkan.'
        );

        // Reset form setelah simpan
        $this->resetForm();

    }
    // 2. Siapkan form Edit
    public function edit(int $id)
    {
        $emp = Employee::findOrFail($id);
        $this->employee_id = $emp->id;
        $this->nik         = $emp->nik;
        $this->name        = $emp->name;
        $this->position    = $emp->position;
        $this->phone       = $emp->phone;
        $this->address     = $emp->address;
        $this->user_id     = $emp->user_id;
        $this->isEditMode  = true;
    }

    // 3. DELETE
    public function delete(int $id)
    {
        Employee::findOrFail($id)->delete();
        session()->flash('success', 'Karyawan berhasil dihapus.');
    }

    public function resetForm()
    {
        $this->reset(['employee_id', 'nik', 'name', 'phone', 'position', 'address', 'user_id', 'isEditMode']);
        $this->resetValidation();
    }

    // 4. READ
    public function render()
    {
        $unlinked_users = \App\Models\User::whereDoesntHave('employee')->where('role', '!=', 'admin')->get();

        return view('livewire.employee.employee-manager', [
            'employees' => Employee::orderBy('id', 'desc')->get(),
            'unlinked_users' => $unlinked_users,
        ])->layout('layouts.app');
    }
}
