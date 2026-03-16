<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopStudent;
use Illuminate\Http\Request;

class TopStudentAdminController extends Controller
{
    public function index()
    {
        $students = TopStudent::orderBy('order')->get();
        return view('admin.top-students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.top-students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'average'     => 'nullable|numeric',
            'rank'        => 'nullable|string|max:50',
            'order'       => 'nullable|integer',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'grades_photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'certificate_photo'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name','school_name','average','rank','order','is_active']);

      foreach (['photo','grades_photo','certificate_photo'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = uploadImage('assets/admin/uploads', $request->$field);
            }
        }

        TopStudent::create($data);
        return redirect()->route('admin.top-students.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(TopStudent $topStudent)
    {
        return view('admin.top-students.edit', compact('topStudent'));
    }

    public function update(Request $request, TopStudent $topStudent)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'average'     => 'nullable|numeric',
            'rank'        => 'nullable|string|max:50',
            'order'       => 'nullable|integer',
            'photo'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'grades_photo'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'certificate_photo'=> 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['name','school_name','average','rank','order']);
        $data['is_active'] = $request->has('is_active');

        foreach (['photo','grades_photo','certificate_photo'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = uploadImage('assets/admin/uploads', $request->$field);
            }
        }

        $topStudent->update($data);
        return redirect()->route('admin.top-students.index')->with('success', 'تم التعديل بنجاح');
    }

    public function destroy(TopStudent $topStudent)
    {
        $topStudent->delete();
        return back()->with('success', 'تم الحذف');
    }
}