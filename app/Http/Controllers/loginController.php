<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Pegawai;
use App\Models\Member;
use App\Models\Instruktur;

class loginController extends Controller
{
    public function homePage()
    {
        return view('homePage');
    }

    public function loginPage()
    {
        return view('loginPage');
    }

    public function login(Request $request)
    {
        if ($request->accepts('text/html')) {
            $validate = $request->validate(
                [
                    'EMAIL_PEGAWAI' => ['required', 'email:rfc,dns'],
                    'password' => ['required'],
                ],
                [
                    'EMAIL_PEGAWAI.required' => 'The email employee field is required',
                    'EMAIL_PEGAWAI.email' => 'Email using format @',
                    'password' => 'The password employee field is required',
                ],
            );

            $credential = $request->only('EMAIL_PEGAWAI', 'password');

            if (Auth::guard('pegawai')->attempt($credential)) {
                $request->session()->regenerate();
                $user = Auth::guard('pegawai')->user();
                if ($user) {
                    return redirect()
                        ->intended('/dashboard')
                        ->with('success', 'You have successfully logged in');
                }
            } else {
                return redirect()
                    ->intended('/loginPage')
                    ->with('error', 'Invalid Credentials');
            }
        } else {
            $data = $request->only('Email', 'password');
            $credentials = Validator::make(
                $data,
                [
                    'Email' => ['required', 'email:rfc,dns'],
                    'password' => ['required'],
                ],
                [
                    'Email.required' => 'The email field is required',
                    'Email.email' => 'Email using format @',
                    'password' => 'The password field is required',
                ],
            );

            if ($credentials->fails()) {
                return response(['error' => false, 'message' => $credentials->errors()], 400);
            }

            $cekPegawai = Pegawai::where('EMAIL_PEGAWAI', $request->Email)
                ->where('ROLE_PEGAWAI', 'Manajer Operasional')
                ->first();
            $cekMember = Member::where('EMAIL_MEMBER', $request->Email)->first();
            $cekInstruktur = Instruktur::where('EMAIL_INSTRUKTUR', $request->Email)->first();

            if ($cekPegawai && Hash::check($request->password, $cekPegawai->password)) {
                if (
                    Auth::guard('pegawai')->attempt([
                        'EMAIL_PEGAWAI' => $request->Email,
                        'password' => $request->password,
                    ])
                ) {
                    $pegawai = Auth::guard('pegawai')->user();
                    $token = $pegawai->createToken('Authentication Token')->accessToken;
                    return response(
                        [
                            'message' => 'Authenticated',
                            'user' => $pegawai,
                            'token_type' => 'Bearer',
                            'access_token' => $token,
                        ],
                        200,
                    );
                }
                return response(
                    [
                        'message' => 'Invalid Credentials',
                        'user' => null,
                    ],
                    400,
                );
            } elseif ($cekMember && Hash::check($request->password, $cekMember->password)) {
                if (
                    Auth::guard('member')->attempt([
                        'EMAIL_MEMBER' => $request->Email,
                        'password' => $request->password,
                    ])
                ) {
                    $member = Auth::guard('member')->user();
                    $token = $member->createToken('Authentication Token')->accessToken;
                    return response(
                        [
                            'message' => 'Authenticated',
                            'user' => $member,
                            'token_type' => 'Bearer',
                            'access_token' => $token,
                        ],
                        200,
                    );
                }
                return response(
                    [
                        'message' => 'Invalid Credentials',
                        'user' => null,
                    ],
                    400,
                );
            } elseif ($cekInstruktur && Hash::check($request->password, $cekInstruktur->password)) {
                if (
                    Auth::guard('instruktur')->attempt([
                        'EMAIL_INSTRUKTUR' => $request->Email,
                        'password' => $request->password,
                    ])
                ) {
                    $instruktur = Auth::guard('instruktur')->user();
                    $token = $instruktur->createToken('Authentication Token')->accessToken;
                    return response(
                        [
                            'message' => 'Authenticated',
                            'user' => $instruktur,
                            'token_type' => 'Bearer',
                            'access_token' => $token,
                        ],
                        200,
                    );
                }
                return response(
                    [
                        'message' => 'Invalid Credentials',
                        'user' => null,
                    ],
                    400,
                );
            } else {
                return response(
                    [
                        'message' => 'Invalid Credentials',
                        'user' => null,
                    ],
                    400,
                );
            }
        }
    }

    public function logout(Request $request)
    {
        if ($request->accepts('text/html')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'You have successfully logged out');
        } else {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json(
                [
                    'message' => 'Logout Success',
                    'user' => $user,
                ],
                200,
            );
        }
    }

    public function gantiPassword(Request $request)
    {
        $data = $request->only('Email', 'password');
        $credentials = Validator::make(
            $data,
            [
                'Email' => ['required', 'email:rfc,dns'],
                'password' => ['required'],
            ],
            [
                'Email.required' => 'The email field is required',
                'Email.email' => 'Email using format @',
                'password' => 'The password field is required',
            ],
        );

        if ($credentials->fails()) {
            return response(['success' => false, 'message' => $credentials->errors()], 400);
        }
        $pegawai_exists = Pegawai::where('EMAIL_PEGAWAI', $request->Email)
            ->where('ROLE_PEGAWAI', 'Manajer Operasional')
            ->first();
        $member_exists = Member::where('EMAIL_MEMBER', $request->Email)->first();
        $instructor_exists = Instruktur::where('EMAIL_INSTRUKTUR', $request->Email)->first();

        if ($member_exists) {
            return response(
                [
                    'message' => 'Member tidak boleh ganti password. Tolong Kontak Kasir',
                    'user' => null,
                ],
                400,
            );
        } elseif ($pegawai_exists) {
            $pegawai_exists->password = \bcrypt($request->password);
            $pegawai_exists->update();
            return response(
                [
                    'message' => 'Berhasil mengganti password pegawai',
                    'user' => $pegawai_exists,
                ],
                200,
            );
        } elseif ($instructor_exists) {
            $instructor_exists->password = \bcrypt($request->password);
            $instructor_exists->update();
            return response(
                [
                    'message' => 'Berhasil mengganti password instruktur',
                    'user' => $instructor_exists,
                ],
                200,
            );
        }
        return response(
            [
                'message' => 'User tidak berhasil ditemukan, Tolong masukkan data yang benar',
                'user' => null,
            ],
            400,
        );
    }

    public function confirmEmailPage()
    {
        return view('confirm-email')->with([
            'EMAIL_PEGAWAI' => null,
        ]);
    }

    public function confirmEmailProccess(Request $request)
    {
        $data = $request->only('Email');
        $validate = $request->validate(
            [
                'Email' => ['required', 'email:rfc,dns'],
            ],
            [
                'Email.required' => 'The email employee field is required',
                'Email.email' => 'Email using format @',
            ],
        );

        $pegawai_exists = Pegawai::where('EMAIL_PEGAWAI', $request->Email)->first();
        $member_exists = Member::where('EMAIL_MEMBER', $request->Email)->first();
        $instructor_exists = Instruktur::where('EMAIL_INSTRUKTUR', $request->Email)->first();

        if ($pegawai_exists || $member_exists || $instructor_exists) {
            return redirect()->intended('/confirmPassword')->with([
                'Email' => $pegawai_exists,
            ]);
        } else {
            return redirect()
                ->intended('/confirmEmail')
                ->with('error', 'Email not found');
        }
    }

    public function confirmPasswordPage()
    {
        return view('confirm-password')->with([
        ]);
    }

    public function confirmPasswordProccess(Request $request, $id)
    {
        $pegawai_exists = Pegawai::where('ID_PEGAWAI',$id)->first();
        $pegawai_exists->password = \bcrypt($request->changePassword);
        $pegawai_exists->update();

        return view('/loginPage')->with([
        ]);
    }
}
