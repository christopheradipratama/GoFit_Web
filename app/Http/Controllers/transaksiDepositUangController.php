<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiDepositUang;
use App\Models\Member;
use App\Models\Promo;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class transaksiDepositUangController extends Controller
{
    public function index() {
        $transaksiDepositUang = TransaksiDepositUang::orderBy('ID_TRANSAKSI_DEPOSIT_UANG','asc')->get();
        $member = Member::all();
        $promo = Promo::all();
        $kelas = Kelas::all();

        return view('dbTransaksi/dbTransaksiDepositUang/dbTransaksiDepositUang')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiDepositUang' => $transaksiDepositUang, 
            'member' => $member,
            'promo' => $promo,
            'kelas' => $kelas
        ]);
    }

    public function cetakStruk($id){
        $member = Member::all();
        $transaksiDepositUang = TransaksiDepositUang::where('ID_TRANSAKSI_DEPOSIT_UANG',$id)->first();
        $promo = Promo::where('ID_PROMO', $id)->first();
        $kelas = Kelas::where('ID_KELAS', $id)->first();

        return view('dbTransaksi/dbTransaksiDepositUang/strukTransaksiDepositUang')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiDepositUang' => $transaksiDepositUang,
            'member' => $member,
            'promo' => $promo,
            'kelas' => $kelas, 
        ]);
    }

    public function create(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'JUMLAH_DEPOSIT_UANG' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'JUMLAH_DEPOSIT_UANG.required' => 'The nominal field is required',
            'JUMLAH_DEPOSIT_UANG.numeric' => 'Format nominal is numeric'
        ]);

        $members = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();

        $aktivasiMemberCheck = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
        if(!($aktivasiMemberCheck)) {
            return redirect()->intended('/transaksiDepositUang')->with(['error' => 'Member not activated']);
        }

        // if($member->MASA_AKTIVASI == null) {
        //     return redirect()->intended('dbTransaksi/dbTransaksiDepositUang/dbTransaksiDepositUang')->with(['error' => 'Member not activated']);
        // }
        
        if($request->JUMLAH_DEPOSIT_UANG >= 3000000 && $members->SISA_DEPOSIT_UANG >=500000) {
            $promo = Promo::where('BONUS', 300000)->first();
            if($promo) {
                $idPromo = $promo->ID_PROMO;
                $bonus = $promo->BONUS;
            }else {
                $idPromo = null;
                $bonus = 0;
            }
        }else {
            $idPromo = null;
            $bonus = 0;
        }
        
        
        if($members->SISA_DEPOSIT_UANG) {
            $sisa = $members->SISA_DEPOSIT_UANG;
        }else {
            $sisa = 0;
        }
        
        $transaksiDepositUang = TransaksiDepositUang::create([
            'ID_PROMO' => $idPromo,
            'ID_MEMBER' => $request->ID_MEMBER,
            'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
            'JUMLAH_DEPOSIT_UANG' => $request->JUMLAH_DEPOSIT_UANG,
            'BONUS_DEPOSIT_UANG' => $bonus,
            'SISA_DEPOSIT' => $sisa,
            'TOTAL_DEPOSIT_UANG' => $request->JUMLAH_DEPOSIT_UANG + $sisa + $bonus,
            'TANGGAL_DEPOSIT_UANG' => Carbon::now(),
            'KEMBALIAN' => $request->JUMLAH_UANG - $request->JUMLAH_DEPOSIT_UANG,
        ]);

        if($transaksiDepositUang){
            $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
            $member->SISA_DEPOSIT_UANG = $request->JUMLAH_DEPOSIT_UANG + $sisa + $bonus;
            $member->update();
            return redirect()->intended('/transaksiDepositUang')->with(['success' => 'Success deposit member']);
        }else {
            return redirect()->intended('/transaksiDepositUang')->with(['error' => 'Failed deposit member']);
        }
    }
}
