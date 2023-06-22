<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class memberDepositKelasController extends Controller
{
    public function store(Request $request){
        $validate = $request->validate([
            'ID_MEMBER' => ['required'],
            'ID_KELAS' => ['required'],
            'JUMLAH_DEPOSIT_KELAS' => ['required','numeric'],
        ],[
            'ID_MEMBER.required' => 'The member name field is required',
            'ID_KELAS.required' => 'The kelas name field is required',
            'JUMLAH_DEPOSIT_KELAS.required' => 'The packet field is required',
            'JUMLAH_DEPOSIT_KELAS.numeric' => 'Format packet is numeric'
        ]);

        $datadepoclass = DepoClassTransaction::where('ID_MEMBER',$request->ID_MEMBER)->orderby('ID_TRANSAKSI_PAKET','desc')->first();
        
        $member_check_activate = Member::where('ID_MEMBER',$request->ID_MEMBER)->where('MASA_AKTIVASI','!=',null)->where('MASA_AKTIVASi','>=',Carbon::now())->first();
        if(!($member_check_activate)) {
            return redirect()->intended('dashboard/class-deposit')->with(['error' => 'Member not activated. Please activate first']);
        }

        $member_deposit = MemberDepositClass::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();
        if($member_deposit){
            if($member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->DEPO_SISA != 0 || $member_deposit->MASA_BERLAKU > Carbon::now() && $member_deposit->DEPO_SISA == 0 || $member_deposit->MASA_BERLAKU < Carbon::now() && $member_deposit->DEPO_SISA == 0) {
                $member_deposit->DEPO_SISA = 0;
                $member_deposit->MASA_BERLAKU = null;
                $member_deposit->update();
            }else {
                return redirect()->intended('dashboard/class-deposit')->with(['error' => 'This member has been deposit this class. Member cant deposit before expired date or remaining deposit = 0']);
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

        $datadepoclass = DepoClassTransaction::create([
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
        ]);

        if($datadepoclass){
            $member_deposit2 = MemberDepositClass::where('ID_MEMBER',$request->ID_MEMBER)->where('ID_KELAS',$request->ID_KELAS)->first();

            if($member_deposit2){
                $member_deposit2->DEPO_SISA = $request->JUMLAH_DEPOSIT_KELAS + $bonus;
                $member_deposit2->MASA_BERLAKU = Carbon::now()->addMonths($month);
                $member_deposit2->update();
            }else {
                $member_deposit_create = MemberDepositClass::create([
                    'ID_MEMBER'=>$request->ID_MEMBER,
                    'ID_KELAS'=> $request->ID_KELAS,
                    'DEPO_SISA'=> $request->JUMLAH_DEPOSIT_KELAS + $bonus,
                    'MASA_BERLAKU'=> Carbon::now()->addMonths($month),
                ]);
            }
            
            $data = DepoClassTransaction::latest('ID_TRANSAKSI_PAKET')->first();
            return redirect()->intended('dashboard/class-deposit-receipt/'.$data->ID_TRANSAKSI_PAKET);
        }else {
            return redirect()->intended('dashboard/class-deposit')->with(['error' => 'Failed deposit member']);
        }
    }
}
