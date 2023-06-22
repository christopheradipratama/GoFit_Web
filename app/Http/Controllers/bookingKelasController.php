<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BookingKelas;
use App\Models\JadwalHarian;
use App\Models\PresensiInstruktur;
use App\Models\Member;
use App\Models\Kelas;
use App\Models\JadwalUmum;
use App\Models\MemberDepositKelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class bookingKelasController extends Controller
{
    public function index(Request $request){
        if($request->accepts('text/html')){
            $booking = BookingKelas::orderBy('KODE_BOOKING_KELAS','desc')->where('STATUS_PRESENSI_KELAS',null)->get();
            $booking2 = BookingKelas::orderBy('KODE_BOOKING_KELAS','desc')->get();
            
            return view('dbBookingKelas/dbBookingKelas')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'booking' => $booking,
                'booking2' => $booking2
            ]);
        }
    }

    public function cetakStruk(Request $request,$id){
        if($request->accepts('text/html')){
            $strukBookingReguler = DB::table('booking_kelas as bk')
            ->select('bk.KODE_BOOKING_KELAS', 'm.SISA_DEPOSIT_UANG' ,'m.ID_MEMBER','ik.NAMA_INSTRUKTUR','m.NAMA_MEMBER','jh.ID_INSTRUKTUR','k.NAMA_KELAS','bk.TANGGAL_JADWAL_HARIAN','bk.TANGGAL_MELAKUKAN_BOOKING','bk.WAKTU_PRESENSI_KELAS','bk.STATUS_PRESENSI_KELAS','bk.TARIF_KELAS')
            ->join('jadwal_harian as jh','bk.TANGGAL_JADWAL_HARIAN','jh.TANGGAL_JADWAL_HARIAN')
            ->join('jadwal_umum as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_UMUM')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->join('member as m', 'bk.ID_MEMBER','m.ID_MEMBER')
            ->join('instruktur as ik','jh.ID_INSTRUKTUR','ik.ID_INSTRUKTUR')
            ->where('KODE_BOOKING_KELAS',$id)->first();

            $check = BookingKelas::where('KODE_BOOKING_KELAS',$id)->first();
            $check2 = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$check->TANGGAL_JADWAL_HARIAN)->first();
            $check3 = JadwalUmum::where('ID_JADWAL_UMUM',$check2->ID_JADWAL_UMUM)->first();
            $strukBookingPaket = MemberDepositKelas::where('ID_MEMBER',$check->ID_MEMBER)->where('ID_KELAS',$check3->ID_KELAS)->first();

            return view('dbBookingKelas/strukBookingKelas')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'strukBooking' => $strukBookingReguler,
                'strukBooking2' => $strukBookingPaket,
            ]);
        }
    }

    public function store(Request $request){
        $validate = Validator::make($request->all(),[
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'TANGGAL_JADWAL_HARIAN' => ['required'],
        ]);
        
        $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();
        $member_deposit = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

        if($member_deposit && $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPOSIT != 0){
            
            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'You not activated',
                    'data' => null,
                ], 400);
            }
            
            $check_duplicate = BookingKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'You have been booking this class',
                    'data' => null,
                ], 400);
            }
            
            $check = BookingKelas::where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->count();
            if($check < $kelas->KAPASITAS) {
                $store_data = BookingKelas::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'TANGGAL_JADWAL_HARIAN' => $request->TANGGAL_JADWAL_HARIAN,
                    'TANGGAL_MELAKUKAN_BOOKING' => Carbon::now(),
                    'TARIF_KELAS' => 1,
                    'WAKTU_PRESENSI_KELAS' => null,
                    'STATUS_PRESENSI_KELAS' => null,
                ]);

                if($store_data) {
                        return response([
                            'message' => 'Succesfully create data',
                            'data' => $store_data,
                            // 'data_depo' => $member_deposit
                        ], 200);
                }else {
                    return response([
                        'message' => 'Failed create store booking class',
                        'data' => null,
                    ], 400); 
                }
            }else {
                return response([
                    'message' => 'Class Full',
                    'data' => null,
                ], 400);
            }
        }else if($member->SISA_DEPOSIT_UANG != 0 && $member->SISA_DEPOSIT_UANG > $kelas->TARIF){
            
            if($member->MASA_AKTIVASI == null || $member->MASA_AKTIVASI < Carbon::now()){
                return response([
                    'message' => 'You not activated',
                    'data' => null,
                ], 400);
            }
            
            $check_duplicate = BookingKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->first();
            if($check_duplicate) {
                return response([
                    'message' => 'You have been booking this class',
                    'data' => null,
                ], 400);
            }
            
            $check = BookingKelas::where('TANGGAL_JADWAL_HARIAN',$request->TANGGAL_JADWAL_HARIAN)->count();
            if($check < $kelas->KAPASITAS) {
                $store_data = BookingKelas::create([
                    'ID_MEMBER' => $request->ID_MEMBER,
                    'TANGGAL_JADWAL_HARIAN' => $request->TANGGAL_JADWAL_HARIAN,
                    'TANGGAL_MELAKUKAN_BOOKING' => Carbon::now(),
                    'TARIF_KELAS' => $kelas->TARIF,
                    'WAKTU_PRESENSI_KELAS' => null,
                    'STATUS_PRESENSI_KELAS' => null,
                ]);

                if($store_data){
                    // $member->SISA_DEPOSIT_UANG = $member->SISA_DEPOSIT_UANG - $kelas->TARIF;
                    // $member->update();
                    return response([
                        'message' => 'Succesfully create data',
                        'data' => $store_data,
                    ], 200);
                }else {
                    return response([
                        'message' => 'Failed create store booking class',
                        'data' => null,
                    ], 400); 
                }
            }else {
                return response([
                    'message' => 'Class Full',
                    'data' => null,
                ], 400);
            } 
        }else {
            return response([
                'message' => 'You cant book this class. Please check your deposit money or deposit packet class',
                'data' => null,
            ], 400);
        } 
    }

    public function index_mobile($id){
        $booking = DB::table('booking_kelas as bk')->select('bk.KODE_BOOKING_KELAS','k.NAMA_KELAS','bk.TANGGAL_JADWAL_HARIAN','bk.TANGGAL_MELAKUKAN_BOOKING','bk.WAKTU_PRESENSI_KELAS','bk.STATUS_PRESENSI_KELAS','i.NAMA_INSTRUKTUR')
        ->join('jadwal_harian as jh','bk.TANGGAL_JADWAL_HARIAN','jh.TANGGAL_JADWAL_HARIAN')
        ->join('jadwal_umum as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_UMUM')
        ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
        ->join("instruktur as i", "jh.ID_INSTRUKTUR", "i.ID_INSTRUKTUR")
        ->where('ID_MEMBER',$id)->get();

        if($booking){
            return response([
                'message' => 'Succesfully get data',
                'data' => $booking,
            ], 200);
        }
        return response([
            'message' => 'Failed get data',
            'data' => null,
        ], 400);
    }

    public function cancelBooking($id){
        $booking = BookingKelas::where('KODE_BOOKING_KELAS',$id)->first();
        
        if($booking){
            if(Carbon::now()->format('Y-m-d') <= Carbon::parse($booking->TANGGAL_JADWAL_HARIAN)->subDays(1)->format('Y-m-d')){
                $booking->delete();
                return response([
                    'message' => 'Succesfully cancel booking',
                    'data' => $booking,
                ], 200);
            }else {
                return response([
                    'message' => 'You can cancel booking class max h-1 day',
                    'data' => null,
                ], 400); 
            }
        }
        return response([
            'message' => 'Failed cancel booking',
            'data' => null,
        ], 400);
    }

    public function index_mobile_presensi_jadwal(Request $request,$id){
        if($request->expectsjson()){
            $schedule_daily = DB::table('jadwal_harian as jh')->select('jh.TANGGAL_JADWAL_HARIAN','i.ID_INSTRUKTUR','i.NAMA_INSTRUKTUR','k.NAMA_KELAS','ju.ID_KELAS','jh.KETERANGAN_JADWAL_HARIAN','ju.HARI_JADWAL', 'k.TARIF','pi.JAM_MULAI','pi.JAM_SELESAI')
            ->leftJoin('instruktur as i','jh.ID_INSTRUKTUR','i.ID_INSTRUKTUR')
            ->leftJoin('jadwal_umum as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_UMUM')
            ->leftJoin('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->leftJoin('presensi_instruktur as pi','pi.TANGGAL_MENGAJAR','jh.TANGGAL_JADWAL_HARIAN')
            ->where('jh.TANGGAL_JADWAL_HARIAN','>=',Carbon::now()->format('Y-m-d'))->where('jh.TANGGAL_JADWAL_HARIAN','<',Carbon::now()->addDays(1)->format('Y-m-d'))->where('jh.KETERANGAN_JADWAL_HARIAN','!=','Libur')
            ->orderby('jh.TANGGAL_JADWAL_HARIAN','asc')->get();
            if($schedule_daily){
                return response([
                    'message' => 'Successfully get data schedule',
                    'data' => $schedule_daily,
                ],200);
            }
            return response([
                'message' => 'Data schedule not found',
                'data' => null,
            ],400);
        }
    }

    public function index_mobile_presensi_history(Request $request, $id){
        if($request->expectsJson()){
            $booking = DB::table('booking_kelas as bk')->select('bk.KODE_BOOKING_KELAS','m.NAMA_MEMBER','m.ID_MEMBER', 'k.NAMA_KELAS','bk.TANGGAL_JADWAL_HARIAN','bk.TANGGAL_MELAKUKAN_BOOKING','bk.WAKTU_PRESENSI_KELAS','bk.STATUS_PRESENSI_KELAS')
            ->join('jadwal_harian as jh','bk.TANGGAL_JADWAL_HARIAN','jh.TANGGAL_JADWAL_HARIAN')
            ->join('jadwal_umum as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_UMUM')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->join('member as m','bk.ID_MEMBER','m.ID_MEMBER')
            ->where('jh.TANGGAL_JADWAL_HARIAN',$id)->get();
            if($booking){
                return response([
                    'message' => 'Successfully get data presence',
                    'data' => $booking,
                ],200);
            }
            return response([
                'message' => 'Failed get data presence',
                'data' => null,
            ],400);
        }
    }

    public function update_transaksi(Request $request){
        if($request->expectsJson()){
            $data = $request->only('KODE_BOOKING_KELAS','STATUS_PRESENSI_KELAS');
            $validate = Validator::make($data,[
                'KODE_BOOKING_KELAS' => ['required'],
                'STATUS_PRESENSI_KELAS' => ['required'],
            ],[
                'KODE_BOOKING_KELAS.required'=>'Kode Booking field is empty',
                'STATUS_PRESENSI_KELAS.required'=>'Status field is empty'
            ]);
    
            if($validate->fails()) {
                return response(['success' => false,'message' => $validate->errors()],400);   
            }
            
            $booking_class = BookingKelas::where('KODE_BOOKING_KELAS',$request->KODE_BOOKING_KELAS)->first();

            if($booking_class->STATUS_PRESENSI_KELAS != null){
                return response([
                    'message' => 'You have been confirm presence this member',
                    'data' => null,
                ],400);
            }
            
            if($booking_class){
                $presence = PresensiInstruktur::where('TANGGAL_MENGAJAR',$booking_class->TANGGAL_JADWAL_HARIAN)->first();
                if($presence){
                    if($presence->JAM_MULAI != null){
                        if($presence->JAM_SELESAI != null){
                            return response([
                                'message' => 'Class has been finished',
                                'data' => null,
                            ],400);
                        }
                        if($booking_class->TARIF_KELAS == 1){
                            $daily_schedule = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$booking_class->TANGGAL_JADWAL_HARIAN)->first();
                            $general_schedule = JadwalUmum::where('ID_JADWAL_UMUM',$daily_schedule->ID_JADWAL_UMUM)->first();
                            $member_deposit = MemberDepositKelas::where('ID_MEMBER',$booking_class->ID_MEMBER)->where('ID_KELAS',$general_schedule->ID_KELAS)->first();
                            if($member_deposit){
                                $member_deposit->SISA_DEPOSIT -= $booking_class->TARIF_KELAS;
                                $member_deposit->update();
                                $booking_class->STATUS_PRESENSI_KELAS = $request->STATUS_PRESENSI_KELAS;
                                $booking_class->WAKTU_PRESENSI_KELAS = Carbon::now();
                                $booking_class->update();
                                return response([
                                    'message' => 'Successfully update member deposit class',
                                    'data' => $member_deposit,
                                ],200);
                            }else {
                                return response([
                                    'message' => 'Failed get data member deposit',
                                    'data' => null,
                                ],400);
                            }
                        }else{
                            $member = Member::where('ID_MEMBER',$booking_class->ID_MEMBER)->first();
                            $member->SISA_DEPOSIT_UANG -= $booking_class->TARIF_KELAS;
                            $member->update();
                            $booking_class->STATUS_PRESENSI_KELAS =  $request->STATUS_PRESENSI_KELAS;
                            $booking_class->WAKTU_PRESENSI_KELAS = Carbon::now();
                            $booking_class->update();
                            return response([
                                'message' => 'Successfully update deposit money member',
                                'data' => $member,
                            ],200);
                        }
                    }else{
                        return response([
                            'message' => 'Instructor must confirm attendance by manajer operasional first',
                            'data' => null,
                        ],400);
                    }
                }else{
                    return response([
                        'message' => 'Instructor must confirm attendance by manajer operasional first',
                        'data' => null,
                    ],400);
                } 
            }else {
                return response([
                    'message' => 'Failed get data booking class',
                    'data' => null,
                ],400);
            }
        }
    }
}
