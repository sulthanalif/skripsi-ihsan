<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login');
    }

    public function registerPage()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:users,username',
            'password' => 'required',
        ]);

        $this->ensureIsNotRateLimited($request->username);

        if (!Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ], $request->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($request->username));

            return back()->with('error', 'Username atau password salah.');
        }

        RateLimiter::clear($this->throttleKey($request->username));

        Session::regenerate();

        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'username' => ['required', 'string', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'nik' => ['required', 'string', 'size:16', 'unique:profiles,nik'],
            'kk' => ['required', 'string', 'size:16'],
            'birth_place' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'nationality' => ['required', 'string'],
            'religion' => ['required', 'string'],
            'marital_status' => ['required', 'string'],
            'occupation' => ['required', 'string'],
            'address_ktp' => ['required', 'string'],
            'address_domisili' => ['required', 'string']
        ]);

        // return response()->json($data);

        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $user->assignRole('warga');

            $user->profile()->create([
                'nik' => $data['nik'],
                'kk' => $data['kk'],
                'birth_place' => $data['birth_place'],
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'nationality' => $data['nationality'],
                'religion' => $data['religion'],
                'marital_status' => $data['marital_status'],
                'occupation' => $data['occupation'],
                'address_ktp' => $data['address_ktp'],
                'address_domisili' => $data['address_domisili']
            ]);

            DB::commit();
            return redirect()->route('login')->with('success', 'Registrasi Berhasil');

        } catch (\Exception $th) {
            DB::rollBack();
            Log::error($th);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftarkan akun.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    protected function ensureIsNotRateLimited(string $email): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($email), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey($email));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(string $email): string
    {
        return Str::transliterate(Str::lower($email).'|'.request()->ip());
    }
}
