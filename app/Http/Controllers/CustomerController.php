<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:customers',
            'phone'      => 'required',
            'password'   => 'required|min:6|confirmed',
        ]);

        Customer::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address ?? null,
            'city'       => $request->city ?? null,
            'district'   => $request->district ?? null,
            'ward'       => $request->ward ?? null,
            'is_active'  => true, // Mặc định là đã kích hoạt
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('admin.manage-customers.index')->with('success', 'Thêm khách hàng thành công.');
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:customers,email,' . $id,
        ]);

        $customer->update($request->except('password'));

        if ($request->filled('password')) {
            $customer->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.manage-customers.index')->with('success', 'Cập nhật khách hàng thành công.');
    }

    public function destroy($id)
    {
        Customer::destroy($id);
        return back()->with('success', 'Xóa khách hàng thành công.');
    }
}
