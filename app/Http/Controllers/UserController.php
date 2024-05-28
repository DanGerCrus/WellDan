<?php

namespace App\Http\Controllers;

use App\Http\FilterTrait;
use App\Http\OrderTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    use OrderTrait;
    use FilterTrait;

    public static array $orderFields = [
        'first_name',
        'last_name',
        'father_name'
    ];

    public static array $filterFields = [
        'first_name' => [
            'type' => '',
            'action' => 'like'
        ],
        'last_name' => [
            'type' => '',
            'action' => 'like'
        ],
        'father_name' => [
            'type' => '',
            'action' => 'like'
        ],
    ];

    public function __construct()
    {
        $this->middleware('permission:user-list|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['create', 'store', 'edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request): Response
    {
        self::setDefaultOrder(['id' => 'DESC']);
        $users = User::query();
        $users = self::filterData($request, $users);
        $users = self::orderData($request, $users);
        $users = $users->paginate(6);

        return response()->view('users.index', [
            'data' => $users,
            'order' => self::orderGenerate($request),
            'filter' => self::filterGenerate($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $roles = Role::pluck('name', 'name')->all();
        return response()->view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'string|max:255',
            'phone' => 'required|string|max:16|min:16',
            'age' => 'required|integer|min:1',
            'email' => ['required', 'email', Rule::unique(User::class)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'Пользователь добавлен успешно');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        $user = User::findOrFail($id);
        return response()->view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(int $id): Response
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return response()->view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'father_name' => 'string|max:255',
            'phone' => 'required|string|max:16',
            'age' => 'required|integer|min:1',
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($id)],
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::findOrFail($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'Пользователь обновлен успешно');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'Пользователь удален успешно');
    }
}
