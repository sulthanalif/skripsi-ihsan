<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ResidentRequest;

class ResidentController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->whereHas('roles', function($query) {
            $query->where('name', 'warga');
        })->get();

        return view('back-end.resident.index', compact('users'));
    }

    public function show(User $user): JsonResponse
    {
        if(!empty($user)){
            return response()->json([
                'status'  => true,
                'data'    => $user->load('profile'),
                'message' => 'Data berhasil diambil.',
            ], JsonResponse::HTTP_OK);
        }else{
            return response()->json([
                'message' => 'Data Tidak Ada.',
                'data'    => [],
                'status' => false,
            ], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    public function store(ResidentRequest $request)
    {

        return $this->createData(model: new User(), request: $request, route: 'residents',
            beforeSubmit: function ($model, $request, &$validatedData) { // Updated signature to receive validatedData by reference
                if(!empty($validatedData['password'])) {
                    $validatedData['password'] = bcrypt($validatedData['password']);
                } else {
                    unset($validatedData['password']); // Remove password if null/empty
                }
            },
            afterSubmit: function ($createdInstance, $request) {
                $createdInstance->syncRoles('warga');

                $data = [...$request->only((new Profile)->fillable)];

                $createdInstance->profile()->create($data);
            }
        );
    }

    public function update(ResidentRequest $request, $id)
    {
        return $this->updateData(model: new User(), request: $request, id: $id, route: 'residents',
            beforeSubmit: function ($instance, $request, &$validatedData) { // Updated signature to receive validatedData by reference
                if(!empty($validatedData['password'])) {
                    $validatedData['password'] = bcrypt($validatedData['password']);
                } else {
                    unset($validatedData['password']); // Remove password if null/empty
                }
            },
            afterSubmit: function ($instance, $request) {
                $data = $request->validated(); // hanya ambil field yang valid
                $profileFields = (new \App\Models\Profile)->getFillable();
                $profileData = array_intersect_key($data, array_flip($profileFields));

                $instance->profile()->update($profileData);
            }
        );
    }

    public function destroy($id)
    {
        return $this->deleteData(new User(), $id, route: 'residents');
    }
}
