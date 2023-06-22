<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiDepositKelas;
use App\Models\Member;
use App\Models\Promo;
use App\Models\Kelas;
use App\Models\MemberDepositKelas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class transaksiDepositKelasController extends Controller
{

    public function index() {
        $transaksiDepositKelas = TransaksiDepositKelas::orderBy('ID_TRANSAKSI_DEPOSIT_KELAS','asc')->get();
        $member = Member::all();
        $promo = Promo::all();
        $kelas = Kelas::all();

        return view('dbTransaksi/dbTransaksiDepositKelas/dbTransaksiDepositKelas')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiDepositKelas' => $transaksiDepositKelas, 
            'member' => $member,
            'promo' => $promo,
            'kelas' => $kelas,
        ]);
    }

    public function cetakStruk($id){
        $member = Member::all();
        $transaksiDepositKelas = TransaksiDepositKelas::where('ID_TRANSAKSI_DEPOSIT_KELAS',$id)->first();
        $promo = Promo::where('ID_PROMO', $id)->first();
        $kelas = Kelas::where('ID_KELAS', $id)->first();

        return view('dbTransaksi/dbTransaksiDepositKelas/strukTransaksiDepositKelas')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiDepositKelas' => $transaksiDepositKelas,
            'member' => $member,
            'promo' => $promo,
            'kelas' => $kelas, 
        ]);
    }


    public function create(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
            'JUMLAH_UANG' => ['required']
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric',
            'JUMLAH_UANG.required' => 'The pay cost field is required'
        ]);

        $datadepoclass = TransaksiDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->orderby('ID_TRANSAKSI_DEPOSIT_KELAS','desc')->first();
        
        $member_check_activate = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
        if(!($member_check_activate)) {
            return redirect()->intended('/transaksiDepositKelas')->with(['error' => 'Member not activated. Please activate first']);
        }

        $member_deposit = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
        if($member_deposit){
            if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPOSIT != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->SISA_DEPOSIT == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->SISA_DEPOSIT == 0) {
                $member_deposit->SISA_DEPOSIT = 0;
                $member_deposit->MASA_BERLAKU = null;
                $member_deposit->update();
            }else {
                return redirect()->intended('/transaksiDepositKelas')->with(['error' => 'This member has been deposit this class. Member cant deposit before expired date or remaining deposit = 0']);
            }
        }

        
        if($request->JUMLAH_DEPOSIT_KELAS == 5 || $request->JUMLAH_DEPOSIT_KELAS == 10 ) {
            $promo = Promo::where('MINIMAL_PEMBELIAN',$request->JUMLAH_DEPOSIT_KELAS)->first();
            if($promo) {
                if($promo->MINIMAL_PEMBELIAN == 5) {
                    $month = 1;
                }else {
                    $month=2;
                }
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

        $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();

        if($request->JUMLAH_UANG < ($kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS)){
            return redirect()->back()->with(['error' => 'Your money is less']);
        }

        $datadepoclass = TransaksiDepositKelas::create([
            'ID_MEMBER' => $request->ID_MEMBER,
            'ID_PROMO' => $idPromo,
            'ID_PEGAWAI' => Auth::guard('pegawai')->user()->ID_PEGAWAI,
            'ID_KELAS' => $request->ID_KELAS,
            'JUMLAH_DEPOSIT_KELAS'=> $request->JUMLAH_DEPOSIT_KELAS,
            'TANGGAL_DEPOSIT_KELAS' => Carbon::now(),
            'BONUS_DEPOSIT_KELAS' => $bonus,
            'TOTAL_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS + $bonus,
            'JUMLAH_PEMBAYARAN'=> $kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS,
            'MASA_BERLAKU_KELAS' => Carbon::now()->addMonths($month),
            'KEMBALIAN' => $request->JUMLAH_UANG - ($kelas->TARIF * $request->JUMLAH_DEPOSIT_KELAS)
        ]);

        if($datadepoclass){
            $member_deposit2 = MemberDepositKelas::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

            if($member_deposit2){
                $member_deposit2->SISA_DEPOSIT = $request->JUMLAH_DEPOSIT_KELAS + $bonus;
                $member_deposit2->MASA_BERLAKU = Carbon::now()->addMonths($month);
                $member_deposit2->update();
            }else {
                $member_deposit_create = MemberDepositKelas::create([
                    'ID_MEMBER'=>$request->ID_MEMBER,
                    'ID_KELAS'=> $request->ID_KELAS,
                    'SISA_DEPOSIT'=> $request->JUMLAH_DEPOSIT_KELAS + $bonus,
                    'MASA_BERLAKU'=> Carbon::now()->addMonths($month),
                ]);
            }
            
            $data = TransaksiDepositKelas::latest('ID_TRANSAKSI_DEPOSIT_KELAS')->first();
            return redirect()->intended('/strukTransaksiDepositKelas/'.$data->ID_TRANSAKSI_DEPOSIT_KELAS);
        }else {
            return redirect()->intended('/transaksiDepositKelas')->with(['error' => 'Failed deposit member']);
        }
    }

    public function indexKonfirmasiDepositKelas(Request $request){
        $this->validate($request,[
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric'
        ]);

        $member = Member::where('ID_MEMBER',$request->ID_MEMBER)->first();
        $kelas = Kelas::where('ID_KELAS',$request->ID_KELAS)->first();
        
        return view('dbTransaksi/dbTransaksiDepositKelas/confirmTransaksiDepositKelas')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'ID_KELAS' => $request->ID_KELAS,
            'NAMA_KELAS' => $kelas->NAMA_KELAS,
            'JUMLAH_DEPOSIT_KELAS' => $request->JUMLAH_DEPOSIT_KELAS,
            'BIAYA' => $request->JUMLAH_DEPOSIT_KELAS * $kelas->TARIF
        ]);
    }


}