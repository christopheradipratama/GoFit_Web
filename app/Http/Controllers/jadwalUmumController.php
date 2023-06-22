<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Kelas;
use App\Models\Instruktur;
use App\Models\JadwalUmum;

class jadwalUmumController extends Controller
{
    public function index() {
        $kelas = Kelas::all();
        $jadwalUmum = JadwalUmum::orderBy('WAKTU_JADWAL','asc')->get();

        return view('dbJadwalUmum/dbJadwalUmum')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            // 'kelas' => $kelas,
            'jadwalUmum' => $jadwalUmum
        ]);
    }

    public function create(){
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();
        return view('dbJadwalUmum/addJadwalUmum')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'kelas' => $kelas,
            'instruktur' => $instruktur
        ]);
    }

    public function store(Request $request){

        $this->validate($request, [
            'ID_KELAS' => ['required', 'numeric'],
            'ID_INSTRUKTUR' => ['required','numeric'],
            'HARI_JADWAL' => ['required'],
            'WAKTU_JADWAL' => ['required']
        ]);

        $jadwalUmum = $request->all();

        $cekJadwalUmum = JadwalUmum::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL',$request->HARI_JADWAL)->where('WAKTU_JADWAL',$request->WAKTU_JADWAL)->first();

        if($cekJadwalUmum) {
            return redirect()->intended('/addJadwalUmum')->with(['error' => 'Instructor has been scheduled']);
        }else {
            $jadwalUmum = JadwalUmum::create($jadwalUmum);

            if($jadwalUmum) {
                return redirect()->intended('/jadwalUmum')->with(['success' => 'Successfully added Schedule']);
            }
            return redirect()->intended('/addJadwalUmum')->with(['error' => 'Failed added Schedule']);
        }
    }

    public function edit($id){
        $jadwalUmum = JadwalUmum::where('ID_JADWAL_UMUM',$id)->first();
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();

        return view('dbJadwalUmum/editJadwalUmum')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'jadwalUmum' => $jadwalUmum,
            'kelas' => $kelas,
            'instruktur' => $instruktur
        ]);
    }

    public function update(Request $request,$id) {
        $jadwalUmum = JadwalUmum::find($id);
        $temp = JadwalUmum::find($id);

        if($request->ID_KELAS != $temp->ID_KELAS && $request->ID_INSTRUKTUR == $temp->ID_INSTRUKTUR && $request->HARI_JADWAL == $temp->HARI_JADWAL && $request->WAKTU_JADWAL == $temp->WAKTU_JADWAL) {
            $jadwalUmum->ID_KELAS = $request->ID_KELAS;
            $jadwalUmum->update();
            if($jadwalUmum) {
                return redirect()->intended('/JadwalUmum')->with(['success' => 'Successfully update schedule']);
            }
            return redirect()->intended('dbJadwalUmum/editJadwalUmum/'.$id)->with(['error' => 'Failed update schedule']);
        }
        if($request->ID_INSTRUKTUR){
            $jadwalUmum->ID_INSTRUKTUR = $request->ID_INSTRUKTUR;
        }
        if($request->HARI_JADWAL){
            $jadwalUmum->HARI_JADWAL = $request->HARI_JADWAL;
        }
        if($request->WAKTU_JADWAL){
            $jadwalUmum->WAKTU_JADWAL = $request->WAKTU_JADWAL;
        }
        
        // if($schedule->update() == null) {
        //     return redirect()->intended('dashboard/general-schedule')->with(['success' => 'Successfully upda schedule']);
        // }

        $cekJadwalUmum = JadwalUmum::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL',$request->HARI_JADWAL)->where('WAKTU_JADWAl',$request->WAKTU_JADWAL)->first();
        // $schedule_check2 = GeneralSchedule::where('ID_INSTRUKTUR',$request->ID_INSTRUKTUR)->where('HARI_JADWAL',$request->HARI_JADWAL)->where('WAKTU_JADWAl',$request->WAKTU_JADWAL)->first();

        if($cekJadwalUmum) {
            return redirect()->intended('editJadwalUmum/'.$id)->with(['error' =>'Instructor has been scheduled']);
        }else {
            $jadwalUmum->ID_KELAS = $request->ID_KELAS;
            $updateJadwalUmum = $jadwalUmum->update();

            if($updateJadwalUmum) {
                return redirect()->intended('/jadwalUmum')->with(['success' => 'Successfully update schedule']);
            }
            return redirect()->intended('editJadwalUmum/'.$id)->with(['error' => 'Failed update schedule']);
        } 
    }

    public function destroy($id) {
        $jadwalUmum = jadwalUmum::find($id);

        $jadwalUmum->delete();

        if($jadwalUmum) {
            return redirect()->intended('/jadwalUmum')->with([
                'success' => 'Schedule has been successfully deleted'
            ]);
        }else {
            return redirect()->intended('/jadwalUmum')->with([
                'error' => 'Schedule not deleted successfully'
            ]);

            
        }
    }
}