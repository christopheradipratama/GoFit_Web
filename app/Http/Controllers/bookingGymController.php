<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingGym;
use App\Models\JadwalHarian;
use App\Models\JadwalUmum;
use App\Models\Member;
use App\Models\MemberDepositKelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class bookingGymController extends Controller
{
    public function index(Request $request){
        if($request->accepts('text/html')){
            $bookingGym = BookingGym::orderBy('KODE_BOOKING_GYM','desc')->where('STATUS_PRESENSI_GYM',null)->get();
            $bookingGym_after = BookingGym::orderBy('KODE_BOOKING_GYM','desc')->where('STATUS_PRESENSI_GYM','!=',null)->get();

            return view('dbBookingGym/dbBookingGym')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'bookingGym' => $bookingGym,
                'bookingGym_after' => $bookingGym_after, 
            ]);            
        }
    }

    public function konfirmasiGym(Request $request,$id){
        if($request->accepts('text/html')){
            $booking = BookingGym::where('KODE_BOOKING_GYM',$id)->first();
            if($booking){
                $booking->WAKTU_PRESENSI_GYM = Carbon::now();
                $booking->STATUS_PRESENSI_GYM = 'Hadir';
                $booking->update();
                return redirect()->intended('/presensiBookingGym')->with(['success' => 'Successfully confirm booking gym']);
            }
            return redirect()->intended('/presensiBookingGym')->with(['error' => 'Failed confirm booking gym']);
        }
    }

    public function cetakStruk($id){
        $bookingGym = BookingGym::where('KODE_BOOKING_GYM',$id)->first();
        return view('dbBookingGym/strukBookingGym')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'bookingGym' => $bookingGym,
        ]);
    }

    public function index_mobile($id)
    {
        $bookingGym = BookingGym::where("ID_MEMBER", $id)->get();

        if ($bookingGym) {
            return response(
                [
                    "message" => "Berhasil mengambil data booking gym",
                    "data" => $bookingGym,
                ],
                200
            );
        }
        return response(
            [
                "message" => "Tidak berhasil mengambil data booking gym",
                "data" => null,
            ],
            200
        );
    }

    public function batal_gym($id){
        $bookingGym = BookingGym::where("KODE_BOOKING_GYM", $id)->first();

        if ($bookingGym){
            if(Carbon::now()->format('Y-m-d') <= Carbon::parse($bookingGym->TANGGAL_BOOKING_GYM)->subDays(1)){
                $bookingGym->delete();
                return response([
                    'message' => 'Succesfully cancel booking',
                    'data' => $bookingGym,
                ], 200);
            }
        } else {
            return response([
                'message' => 'You can cancel booking class max h-1 day',
                'data' => null,
            ], 400); 
        }
        return response([
            'message' => 'Failed Cancel Booking',
            'data' => null,
        ], 400); 
    }

    public function store(Request $request){
        if($request->expectsJson()){
            $validate = Validator::make($request->all(),[
                'ID_MEMBER' => ['required'],
                'SLOT_WAKTU_GYM' => ['required'],
                'TANGGAL_BOOKING_GYM' => ['required'],
            ]);
    
            if($validate->fails()) {
                return response(['success' => false,'message' => $validate->errors()],400);   
            }

            if($request->TANGGAL_BOOKING_GYM < Carbon::now()->format('Y-m-d')){
                return response([
                    'message' => 'please input date more than or same date now ',
                    'data' => null,
                ], 400);
            }

            $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'You not activated ',
                    'data' => null,
                ], 400);
            }

            $check_duplicate = BookingGym::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_BOOKING_GYM',$request->TANGGAL_BOOKING_GYM)->where('SLOT_WAKTU_GYM',$request->SLOT_WAKTU_GYM)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'You have been booking this class',
                    'data' => null,
                ], 400);
            }

            $check = BookingGym::where('SLOT_WAKTU_GYM',$request->SLOT_WAKTU_GYM)->where('TANGGAL_BOOKING_GYM',$request->TANGGAL_BOOKING_GYM)->count();

            if($check <= 10){
                $store_data = BookingGym::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'SLOT_WAKTU_GYM' => $request->SLOT_WAKTU_GYM,
                    'TANGGAL_BOOKING_GYM' => $request->TANGGAL_BOOKING_GYM,
                    'TANGGAL_MELAKUKAN_BOOKING' => Carbon::now(),
                    'WAKTU_KONFIRMASI_PRESENSI' => null,
                    'STATUS_PRESENSI_GYM' => null,
                ]);
                
                if($store_data){
                    return response([
                        'message' => 'Succesfully create booking gym',
                        'data' => $store_data,
                        // 'data_depo' => $member_deposit
                    ], 200);
                }else {
                    return response([
                        'message' => 'Failed create store booking gym',
                        'data' => null,
                    ], 400);
                }
            }else {
                return response([
                    'message' => 'Class Gym Full',
                    'data' => null,
                ], 400);
            }
        }
    }
}