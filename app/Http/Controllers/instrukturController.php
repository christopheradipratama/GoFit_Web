<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruktur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class instrukturController extends Controller
{
    public function index(){
        $instruktur = Instruktur::all();

        return view("dbInstruktur/dbInstruktur")->with ([
            'pegawai'=> Auth::guard('pegawai')->user(),
            'instruktur'=> $instruktur
        ]);
    }

    public function create() {
        return view('dbInstruktur/addInstruktur')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
        ]);
    }

    public function store(Request $request) {

        $this->validate($request, [
            "NAMA_INSTRUKTUR" => ["required"],
            "ALAMAT_INSTRUKTUR" => ["required"],
            "EMAIL_INSTRUKTUR" => ["required"],
            "NOTELP_INSTRUKTUR" => ["required", "numeric"],
            "TANGGAL_LAHIR_INSTRUKTUR" => ["required"],
            "JENIS_KELAMIN_INSTRUKTUR" => ["required"],
            "password" => ["required"],
        ]);

        $dataInstruktur = $request->all();
        
        // $dataInstruktur['MASA_AKTIVASI'] = null;
        // $dataInstruktur['SISA_DEPOSIT_KELAS'] = null;
        // $dataInstruktur['SISA_DEPOSIT_UANG'] = null;
        $dataInstruktur['password'] = \bcrypt($request->password);

        $instruktur = Instruktur::create($dataInstruktur);

        if($instruktur) {
            return redirect()->intended('/instruktur')->with(['success' => 'Successfully added Instruktur']);
        }
        return redirect()->intended('dbInstruktur/dbInstruktur')->with(['error' => 'Failed added Instruktur']);
    }

    public function edit($id){
        $instruktur = Instruktur::where('ID_INSTRUKTUR',$id)->first();

        return view('dbInstruktur/editInstruktur')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'instruktur' => $instruktur,
        ]);
    }

    public function update(Request $request, $id) {
        $instruktur = Instruktur::where('ID_INSTRUKTUR',$id)->first();

        if($request->NAMA_INSTRUKTUR) {
            $instruktur->NAMA_INSTRUKTUR = $request->NAMA_INSTRUKTUR;
        }
        if($request->ALAMAT_INSTRUKTUR){
            $instruktur->ALAMAT_INSTRUKTUR = $request->ALAMAT_INSTRUKTUR;
        }
        if($request->EMAIL_INSTRUKTUR){
            $instruktur->EMAIL_INSTRUKTUR = $request->EMAIL_INSTRUKTUR;
        }
        if($request->NOTELP_INSTRUKTUR){
            $instruktur->NOTELP_INSTRUKTUR = $request->NOTELP_INSTRUKTUR;
        }
        if($request->TANGGAL_LAHIR_INSTRUKTUR){
            $instruktur->TANGGAL_LAHIR_INSTRUKTUR = $request->TANGGAL_LAHIR_INSTRUKTUR;
        }
        if($request->JENIS_KELAMIN_INSTRUKTUR){
            $instruktur->JENIS_KELAMIN_INSTRUKTUR = $request->JENIS_KELAMIN_INSTRUKTUR;
        }
        if($request->password){
            $instruktur->password = \bcrypt ($request->password);
        }
        
        $updateInstruktur = Instruktur::where('ID_INSTRUKTUR', $id)
        ->limit(1) 
        ->update(array('NAMA_INSTRUKTUR' => $instruktur->NAMA_INSTRUKTUR, 
        'ALAMAT_INSTRUKTUR' => $instruktur->ALAMAT_INSTRUKTUR,
        'EMAIL_INSTRUKTUR' => $instruktur->EMAIL_INSTRUKTUR,
        'NOTELP_INSTRUKTUR' => $instruktur->NOTELP_INSTRUKTUR,
        'TANGGAL_LAHIR_INSTRUKTUR' => $instruktur->TANGGAL_LAHIR_INSTRUKTUR,
        'JENIS_KELAMIN_INSTRUKTUR'=> $instruktur->JENIS_KELAMIN_INSTRUKTUR,
        'password' => $instruktur->password),
    ); 
        if($updateInstruktur) {
            return redirect()->intended('/instruktur')->with(['success' => 'Successfully update Instruktur']);
        }
        return redirect()->intended('dbInstruktur/dbInstruktur')->with(['error' => 'Failed update Instruktur']);
    }

    public function destroy($id){
        $deleteInstruktur = instruktur::where('ID_INSTRUKTUR',$id)->first();
        $deleteInstruktur->delete();

        try{
        if($deleteInstruktur) {
            return redirect()->intended('/instruktur')->with(['success' => 'Successfully delete Instruktur']);
        }
    } catch ( \Exception $e) {
        return redirect()->intended('/dashinsboard')->with(['error' => $e->errorInfo]);
   }
        
    }

    public function search(Request $request) {
        if($request->search != null) {
            $instruktur = instruktur::where('ID_INSTRUKTUR', 'like','%'.$request->search.'%')->
            orWhere('NAMA_INSTRUKTUR', 'like','%'.$request->search.'%')->
            orWhere('EMAIL_INSTRUKTUR', 'like','%'.$request->search.'%')->
            orWhere('NOTELP_INSTRUKTUR', 'like','%'.$request->search.'%')->
            orWhere('TANGGAL_LAHIR_INSTRUKTUR', 'like','%'.$request->search.'%')->
            orWhere('JENIS_KELAMIN_INSTRUKTUR', 'like','%'.$request->search.'%')->
            orWhere('JUMLAH_TERLAMBAT', 'like','%'.$request->search.'%')->
            get();
        }
        else {
            $instruktur = instruktur::orderby('ID_INSTRUKTUR','desc')->get();
        }
        
        return view('dbInstruktur/dbInstruktur')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'instruktur' => $instruktur,
        ]);
    }

    public function resetTerlambatIndex(){
        $instruktur = Instruktur::all();

        return view("dbInstruktur/dbInstrukturReset")->with ([
            'pegawai'=> Auth::guard('pegawai')->user(),
            'instruktur'=> $instruktur
        ]);
    }

    public function processResetTerlambat(){
        $instruktur = Instruktur::all();
        
        if($instruktur){
            if($instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT < Carbon::now() || $instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT == null ) {
                foreach($instruktur as $item){
                    $item->JUMLAH_TERLAMBAT = 0;
                    $item->TANGGAL_EXPIRED_TERLAMBAT = Carbon::now()->addMonths(1);
                    $item->update();
                }
                return redirect()->intended('/resetTerlambat')->with(['success' => 'Succesfully reset instruktur late. You can reset again on '.$item->TANGGAL_EXPIRED_TERLAMBAT]);
            }else {
                
                return redirect()->intended('/resetTerlambat')->with(['error' => 'Failed reset instruktur late. You can reset again on '.$instruktur->first()->TANGGAL_EXPIRED_TERLAMBAT]);
            }
            
        }
        return redirect()->intended('/resetTerlambat')->with(['error' => 'Failed reset instruktur late']);
    }

    public function getDataInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {
            // $dataInstruktur = DB::table("instruktur as i")
            //     ->select(
            //         "i.NAMA_INSTRUKTUR",
            //         "i.EMAIL_INSTRUKTUR",
            //         "i.JENIS_KELAMIN_INSTRUKTUR",
            //         "i.NO_TELPON_INSTRUKTUR",
            //         "pi.WAKTU_TERLAMBAT"
            //     )
            //     ->leftJoin(
            //         "presensi_instruktur as pi",
            //         "i.ID_INSTRUKTUR",
            //         "pi.ID_INSTRUKTUR"
            //     )
            //     ->where("i.ID_INSTRUKTUR", $id)
            //     ->orWhere("pi.ID_INSTRUKTUR", $id)
            //     ->first();

            $dataInstruktur = Instruktur::where("ID_INSTRUKTUR", $id)->first();

            if ($dataInstruktur) {
                return response(
                    [
                        "message" => "Berhasil mengambil data instruktur",
                        "data" => $dataInstruktur,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Instruktur tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }

    public function getHistoryAktivitasInstruktur(Request $request, $id)
    {
        if ($request->expectsjson()) {
       
            // $dataInstruktur = Instruktur::where("ID_INSTRUKTUR", $id)->first();

            $dataInstruktur = DB::table("instruktur as i")
            ->select(
                "k.NAMA_KELAS",
                "k.TARIF",
                "ju.HARI_JADWAL",
                "ju.TANGGAL_JADWAL",
                "ju.WAKTU_JADWAL",
                "i.NAMA_INSTRUKTUR",
                "pi.JAM_MULAI",
                "pi.JAM_SELESAI"
            )
            ->leftJoin("jadwal_umum as ju", "i.ID_INSTRUKTUR", "=", "ju.ID_INSTRUKTUR")
            ->leftJoin("kelas as k", "ju.ID_KELAS", "=", "k.ID_KELAS")
            ->leftJoin("presensi_instruktur as pi", "ju.ID_KELAS", "=", "pi.ID_INSTRUKTUR")
            ->where("i.ID_INSTRUKTUR", $id)
            ->get();
        

            if ($dataInstruktur) {
                return response(
                    [
                        "message" => "Berhasil mengambil data instruktur",
                        "data" => $dataInstruktur,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Instruktur tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }
    
}