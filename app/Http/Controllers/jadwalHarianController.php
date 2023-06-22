<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktur;
use App\Models\JadwalUmum;
use App\Models\JadwalHarian;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class jadwalHarianController extends Controller
{
    // public function index() {
    //     $jadwalHarian = JadwalHarian::orderBy("TANGGAL_JADWAL_HARIAN", "asc")->get();
    //     $tanggalJadwalHarian = JadwalHarian::first();

    //     return view('dbJadwalHarian/dbJadwalHarian')->with([
    //         'pegawai' => Auth::guard('pegawai')->user(),
    //         'jadwalHarian' => $jadwalHarian,
    //         'tanggalJadwalHarian' => $tanggalJadwalHarian
    //     ]);
    // }

    public function index(){
        $jadwalHarian = JadwalHarian::where('expired_at','>=',Carbon::now()->format('Y-m-d'))->orderBy('TANGGAL_JADWAL_HARIAN','asc')->get();
        // $jadwalHarian = JadwalHarian::first();
        $tanggalJadwalHarian = JadwalHarian::where('expired_at','>=',Carbon::now()->format('Y-m-d'))->first();

        return view('dbJadwalHarian/dbJadwalHarian')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarian,
            'tanggalJadwalHarian' => $tanggalJadwalHarian,
        ]);
    }

    // public function generateJadwalHarian(){
    //     $jadwalUmum = JadwalUmum::all();
    //     $tanggalJadwalHarian = jadwalHarian::first();

    //     $checkGenerate = jadwalHarian::where('expired_at', '>=' ,Carbon::now())->first();

    //     if(jadwalHarian::exists() || $checkGenerate) {
    //         return redirect()->intended('/jadwalHarian')->with(['error' => 'Daily schedule has been generated. You can generate again on the date after '. $tanggalJadwalHarian->expired_at ]);
    //     }else {
    //         // JadwalHarian::truncate();
            
    //         for($i=Carbon::now();$i<=Carbon::now()->addDays(6);$i->modify('+1 day')){
    //             $hari = Carbon::createFromFormat('Y-m-d H:i:s', $i)->translatedformat('l');
    //             foreach($jadwalUmum as $item){
    //                 if($hari == $item->HARI_JADWAL){
    //                     $harian = jadwalHarian::create([
    //                         'TANGGAL_JADWAL_HARIAN' => $i->format('Y-m-d').' '.$item->WAKTU_JADWAL,
    //                         'ID_INSTRUKTUR' => $item->ID_INSTRUKTUR,
    //                         'ID_JADWAL_UMUM' => $item->ID_JADWAL_UMUM,
    //                         'KETERANGAN_JADWAL_HARIAN' => 'Tidak Ada Keterangan',
    //                         'expired_at' => Carbon::now()->addDays(6)->format('Y-m-d H:i:s'),
    //                     ]);
    //                 }
    //             }
    //         }
    //         return redirect()->intended('/jadwalHarian')->with(['success' => 'Succesfully generate daily schedule']);
    //     }
    // }

    public function generateJadwalHarian(){
        $jadwalUmum = JadwalUmum::all();
        // $jadwalHarian = DailySchedule::where('expired_at','>=',Carbon::now())->first();

        $check_generate = JadwalHarian::where('expired_at', '>=' ,Carbon::now()->format('Y-m-d'))->latest('expired_at')->first();

        if($check_generate) {
            return redirect()->intended('/jadwalHarian')->with(['error' => 'Daily schedule has been generated. You can generate again on the date after '. $check_generate->expired_at ]);
        }else {
            // DailySchedule::truncate();
            $expired = Carbon::now()->addDays(6)->format('Y-m-d H:i:s');
            for($i=Carbon::now();$i<=Carbon::now()->addDays(6);$i->modify('+1 day')){
                $hari = Carbon::createFromFormat('Y-m-d H:i:s', $i)->translatedformat('l');
                foreach($jadwalUmum as $item){
                    if($hari == $item->HARI_JADWAL){
                        $harian = jadwalHarian::create([
                            'TANGGAL_JADWAL_HARIAN' => $i->format('Y-m-d').' '.$item->WAKTU_JADWAL,
                            'ID_INSTRUKTUR' => $item->ID_INSTRUKTUR,
                            'ID_JADWAL_UMUM' => $item->ID_JADWAL_UMUM,
                            'KETERANGAN_JADWAL_HARIAN' => 'Tidak Ada Keterangan',
                            'expired_at' => $expired,
                        ]);
                    }
                }
            }
            return redirect()->intended('/jadwalHarian')->with(['success' => 'Succesfully generate daily schedule']);
        }
    }

    public function edit($id){
        $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$id)->first();
        $instruktur = Instruktur::all();

        return view('dbJadwalHarian/editJadwalHarian')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarian,
            'instruktur' => $instruktur
        ]);
    }

    public function update(Request $request,$id) {
        $jadwalHarian = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$id)->first();
        
        if($request->ID_INSTRUKTUR){
            $jadwalHarian->ID_INSTRUKTUR = $request->ID_INSTRUKTUR;
        }
        if($request->KETERANGAN_JADWAL_HARIAN) {
            $jadwalHarian->KETERANGAN_JADWAL_HARIAN = $request->KETERANGAN_JADWAL_HARIAN;
        }
        $jadwalHarianUpdate = $jadwalHarian->update();
        
        if($jadwalHarianUpdate) {
            return redirect()->intended('/jadwalHarian')->with(['success' => 'Succesfully update daily schedule']);
        }
        return redirect()->intended('/jadwalHarian')->with(['error' => 'Failed update daily schedule']);
    }

    // public function search(Request $request){
    //     $jadwalHarian = JadwalHarian::first();
    //     if($request->search != null) {
    //         $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->search)->first();
    //         $kelas = Kelas::where('NAMA_KELAS',$request->search)->first(); 
    //         // $kelas = Kelas::where('NAMA_KELAS',$request->search)->get();          
    //         if($instruktur) {
    //             // $daily_schedule = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$request->search)->orWhere('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->orWhere('ID_JADWAL_UMUM',$jadwalUmum->ID_JADWAL_UMUM)->orWhere('KETERANGAN_JADWAL_HARIAN',$request->search);
    //             $jadwalHarians = JadwalHarian::where('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->get();
    //         }else if($kelas){
    //             //MASIH AMBIGU
    //             $jadwalUmum = JadwalUmum::where('ID_KELAS',$kelas->ID_KELAS)->first();
    //             $jadwalHarians = JadwalHarian::where('ID_JADWAL_UMUM',$jadwalUmum->ID_JADWAL_UMUM)->get();
    //         }else {
    //             $jadwalHarians = JadwalHarian::where('TANGGAL_JADWAL_HARIAN',$request->search)->orWhere('KETERANGAN_JADWAL_HARIAN',$request->search)->get();
    //         }
    //     }
    //     else {
    //         $jadwalHarians = JadwalHarian::orderBy('TANGGAL_JADWAL_HARIAN','asc')->get();
    //     }
        
    //     return view('dbJadwalHarian/dbJadwalHarian')->with([
    //         'pegawai' => Auth::guard('pegawai')->user(),
    //         'jadwalHarian' => $jadwalHarians,
    //         'tanggalJadwalHarian' => $jadwalHarian
    //     ]);
    // }

    public function search(Request $request){
        // $jadwalHarian = DailySchedule::where('expired_at','<=',Carbon::now());
        $jadwalHarian = JadwalHarian::where('expired_at','>=',Carbon::now())->first();
        if($request->search != null) {
            $instruktur = Instruktur::where('NAMA_INSTRUKTUR',$request->search)->first();
            $kelas = Kelas::where('NAMA_KELAS',$request->search)->first();
            if($instruktur) {
                // $daily_schedule = DailySchedule::where('TANGGAL_JADWAL_HARIAN',$request->search)->orWhere('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->orWhere('ID_JADWAL_UMUM',$jadwalUmum->ID_JADWAL_UMUM)->orWhere('KETERANGAN_JADWAL_HARIAN',$request->search);
                $jadwalHarians = JadwalHarian::where('ID_INSTRUKTUR',$instruktur->ID_INSTRUKTUR)->where('expired_at',$jadwalHarian->expired_at)->get();
            }
            else if($kelas){
                //MASIH AMBIGU
                $jadwalUmum = JadwalUmum::where('ID_KELAS',$kelas->ID_KELAS)->get();
                $jadwalHarians = JadwalHarian::whereIn('ID_JADWAL_UMUM',$jadwalUmum->pluck('ID_JADWAL_UMUM'))->where('expired_at',$jadwalHarian->expired_at)->get();
                // $jadwalHarians = DB::select('SELECT * from jadwal_harian jh 
                // join jadwal_umum ju ON (jh.ID_JADWAL_UMUM = ju.ID_JADWAL_UMUM) 
                // join kelas k on (ju.ID_KELAS = k.ID_KELAS)
                // where k.NAMA_KELAS LIKE "%'.$kelas->NAMA_KELAS.'%"
                // ');
            }else {
                $jadwalHarians = JadwalHarian::where('TANGGAL_JADWAL_HARIAN','like','%'.$request->search.'%')
                ->where('expired_at',$jadwalHarian->expired_at)
                ->orWhere('KETERANGAN_JADWAL_HARIAN','like','%'.$request->search.'%')
                ->where('expired_at',$jadwalHarian->expired_at)
                ->get();
            }
        }
        else {
            $jadwalHarians = JadwalHarian::orderby('TANGGAL_JADWAL_HARIAN','asc')->where('expired_at',$jadwalHarian->expired_at)->get();
        }
        
        return view('dbJadwalHarian/dbJadwalHarian')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalHarian' => $jadwalHarians,
            'tanggalJadwalHarian' => $jadwalHarian
        ]);
    }

    public function index_mobile(Request $request){
        if($request->expectsjson()){
            $schedule_daily = DB::table('jadwal_harian as jh')->select('jh.TANGGAL_JADWAL_HARIAN','i.NAMA_INSTRUKTUR','k.NAMA_KELAS','ju.ID_KELAS','jh.KETERANGAN_JADWAL_HARIAN','ju.HARI_JADWAL', 'k.TARIF')
            ->join('instruktur as i','jh.ID_INSTRUKTUR','i.ID_INSTRUKTUR')
            ->join('jadwal_umum as ju','jh.ID_JADWAL_UMUM','ju.ID_JADWAL_UMUM')
            ->join('kelas as k','ju.ID_KELAS','k.ID_KELAS')
            ->where('jh.TANGGAL_JADWAL_HARIAN','>',Carbon::now())
            ->orderby('jh.TANGGAL_JADWAL_HARIAN','asc')->get();
            if($schedule_daily){
                return response([
                    'message' => 'Successfully get data schedule',
                    'data' => $schedule_daily,
                ],200);
            }
            return response([
                'message' => 'Successfully get data permission',
                'data' => null,
            ],400);
        }
    }
}