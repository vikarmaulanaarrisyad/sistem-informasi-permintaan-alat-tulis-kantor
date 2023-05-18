<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();;

        return view('user.index', compact('roles'));
    }
    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $users = User::all();

        return datatables($users)
            ->addIndexColumn()
            ->editColumn('status', function ($users) {
                return '<span class="badge badge-' . $users->statusColor() . '">' . $users->statusText() . '</span>';
            })
            ->addColumn('ubah_status', function ($users) {
            if ($users->status == 'aktif') {
                return '
                    <button onclick="updateStatus(`' . route('user.update_status', $users->id) . '`, `' . $users->name  . '`)" class="btn btn-sm btn-success"><i class="fas fa-check-circle"></i> Non Aktifkan!</button>
                    </div>
                    ';
            } else {
                return '
                    <div class="btn-group">
                        <button onclick="updateStatus(`' . route('user.update_status', $users->id) . '`, `' . $users->name  . '`)" class="btn btn-sm btn-danger"><i class="fas fa-check-circle"></i> Aktifkan!</button>
                    </div>
                    ';
            }
            })
            ->addColumn('aksi', function ($users) {

                if ($users->status == 'aktif') {
                    return '
                    <div class="btn-group">
                    <button onclick="detailForm(`' . route('user.detail', $users->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</button>
                    <button onclick="editForm(`' . route('user.show', $users->id) . '`)" class="btn btn-sm btn-secondary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    </div>
                    ';
                } else {
                    return '
                    <div class="btn-group">
                    <button onclick="detailForm(`' . route('user.detail', $users->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</button>
                        <button onclick="editForm(`' . route('user.show', $users->id) . '`)" class="btn btn-sm btn-secondary"><i class="fas fa-pencil-alt"></i> Edit</button>
                        </div>
                        ';
                }
                // <button onclick="deleteData(`' . route('user.destroy', $users->id) . '`, `' . $users->name  . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>

            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'password_user' => $request->password
        ];

        $user = User::create($data);

        return response()->json([
            'data' => $user,
            'message' => 'Data ' . $request->name . ' ' . $request->semester . ' berhasil tersimpan.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrfail($id);
        return response()->json(['data' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(string $id)
    {
        $user = User::findOrfail($id);

        return response()->json(['data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrfail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:200',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        $user->update($data);

        return response()->json(['message' =>  $user->name . ' berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrfail($id);

        if (Storage::disk('public')->exists($user->path_image)) {
            Storage::disk('public')->delete($user->path_image);
        }

        $user->delete();

        return response()->json(['message' => 'Data ' . $user->name . ' berhasil dihapus']);
    }

    public function updateStatus($id)
    {

        $user = User::findOrfail($id);
        // cek status
        if ($user->status == 'tidak aktif') {
            // return response()->json(['message' =>  $user->name . ' status aktif.'], 401);
            $user->update(['status' => 'aktif']);
            return response()->json(['message' =>  $user->name . ' berhasil disimpan.'], 200);
        } else {
            $user->update(['status' => 'tidak aktif']);
            return response()->json(['message' =>  $user->name . ' berhasil disimpan.'], 200);
        }
    }
}
