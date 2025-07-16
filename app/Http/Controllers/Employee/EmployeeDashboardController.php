<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;

class EmployeeDashboardController extends Controller
{
    public function index()
    {
        return view('employee.dashboard');
    }
}
