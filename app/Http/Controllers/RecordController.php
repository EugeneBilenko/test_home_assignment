<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowed_records_owners = [];

        if (Auth::user()->role->role == 'manager') {
            $allowed_records_owners = Auth::user()->employees()->pluck('id')->toArray();
        }

        array_push( $allowed_records_owners, Auth::id());
        $records = Record::with('recordCategory')
                        ->whereIn('user_id', $allowed_records_owners)
                        ->paginate(10);

        if ($request->is('api/*')) {
            return response()->json($records);
        }

        return view('pages.records.list', compact('records'));
    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request, $id)
    {
        $records = Record::with('recordCategory')
                        ->where('user_id', $id)
                        ->paginate(10);

        if ($request->is('api/*')) {
            return response()->json($records);
        }

        return view('pages.records.employee_list', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (Auth::user()->role->role == 'manager') {
            return response()->json(['error' => 'you can not create records']);
        }

        if ($request->method() !== 'POST') {
            $categories = Category::select('category', 'id')->get();

            return view('pages.records.create', compact('categories'));
        }

        $valid = self::validating($request, [
            'name' => 'sometimes|nullable|string|max:255',
            'category' => 'sometimes|nullable|numeric',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (isset($valid['error'])) {
            return response()->json($valid, 422);
        }

        if (!$request->hasFile('image')) {
            return response()->json(['error' => 'image is not provided']);
        }

        $path = $request->file('image')->store('images', 'public');

        $record = Record::create([
            'name' => $request->name ?? '',
            'image' => $path,
            'category' => $request->category ?? '',
            'user_id' => Auth::id(),
        ]);

        if ($record) {
            if ($request->is('api/*')) {
                return response()->json($record);
            }

            return redirect()->route('records.index');
        }

        return response()->json(['error' => 'record was not created']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $record = Record::findOrFail($id);

        if ($record) {
            $categories = Category::select('category', 'id')->get();
            if ($request->is('api/*')) {
                return response()->json(compact('record', 'categories'));
            }
            return view('pages.records.edit', compact('record', 'categories'));
        }

        return response()->json(['error' => 'record not found']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $valid = self::validating($request, [
            'name' => 'sometimes|nullable|string|max:255',
            'category' => 'sometimes|nullable|string',
        ]);

        if (isset($valid['error'])) {
            return response()->json($valid, 422);
        }

        $record = Record::findOrFail($id);

        if (!$record) {
            return response()->json(['error' => 'record not found']);
        }

        if ($request->get('name')) {
            $record->name = $request->get('name');
        }

        if ($request->get('category')) {
            $record->category = $request->get('category');
        }

        $record->save();

        if ($request->is('api/*')) {
            return response()->json(['success' => 'Record updated.', 'record' => $record]);
        }

        return redirect()->route('records.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Record::findOrFail($id);

        if ($record->delete()) {
            return response()->json(['success' => 'Record deleted.']);
        }

        return response()->json(['error' => 'Record not deleted.']);
    }

    /**
     * @param $request
     */
    private static function responseByType($request, $data_to_return, $page = 'list')
    {
        if ($request->is('api/*')) {
            return response()->json($data_to_return);
        }

        return view('pages.records.'.$page, $data_to_return);
    }

    /**
     * @param $request
     */
    private static function validating($request, $rules)
    {
        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return [
                'message' => 'Validation failed',
                'error' => $e->errors()
            ];
        }

        return ['success' => true];
    }
}
