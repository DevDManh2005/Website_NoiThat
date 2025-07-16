<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    private $availableRoles = ['staff', 'manager', 'supervisor'];

    public function index()
    {
        $employees = Employee::all();
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = $this->availableRoles;
        return view('admin.employees.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:employees',
            'phone'      => 'required',
            'password'   => 'required|min:6|confirmed',
            'role'       => 'required|in:' . implode(',', $this->availableRoles),
        ]);

        Employee::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'role'       => $request->role,
            'hire_date'  => now(),
            'salary'     => $request->salary ?? 0,
            'status'     => 'active',
            'password'   => Hash::make($request->password),
        ]);


        return redirect()->route('admin.manage-employees.index')->with('success', 'Thêm nhân viên thành công.');
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $roles = $this->availableRoles;
        return view('admin.employees.edit', compact('employee', 'roles'));
    }

   public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);

    $request->validate([
        'first_name' => 'required',
        'last_name'  => 'required',
        'email'      => 'required|email|unique:employees,email,' . $id,
        'role'       => 'required|in:' . implode(',', $this->availableRoles),
    ]);

    $data = $request->except('password');
    $data['role'] = $request->role;

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $employee->update($data);

    return redirect()->route('admin.manage-employees.index')->with('success', 'Cập nhật nhân viên thành công.');
}


    public function destroy($id)
    {
        Employee::destroy($id);
        return back()->with('success', 'Xóa nhân viên thành công.');
    }
}
