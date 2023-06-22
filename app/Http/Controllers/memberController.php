<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\MemberDepositKelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class memberController extends Controller
{
    public function index(){
        $member = Member::all();

        return view("dbMember/dbMember")->with ([
            'pegawai'=> Auth::guard('pegawai')->user(),
            'member'=> $member
        ]);
    }

    public function create() {
        return view('dbMember/addMember')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
        ]);
    }

    public function store(Request $request) {

        $this->validate($request, [
            "NAMA_MEMBER" => ["required"],
            "ALAMAT_MEMBER" => ["required"],
            "EMAIL_MEMBER" => ["required"],
            "NOTELP_MEMBER" => ["required", "numeric"],
            "TANGGAL_LAHIR_MEMBER" => ["required"],
            "JENIS_KELAMIN_MEMBER" => ["required"],
            "password" => ["required"],
        ]);

        $datamember = $request->all();
        
        $datamember['MASA_AKTIVASI'] = null;
        $datamember['SISA_DEPOSIT_KELAS'] = null;
        $datamember['SISA_DEPOSIT_UANG'] = null;
        $datamember['password'] = \bcrypt($request->password);

        $member = Member::create($datamember);

        if($member) {
            return redirect()->intended('/member')->with(['success' => 'Successfully added member']);
        }
        return redirect()->intended('dbMember/addMember')->with(['error' => 'Failed added member']);
    }

    public function edit($id){
        $member = Member::where('ID_MEMBER',$id)->first();

        return view('dbMember/editMember')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'member' => $member,
        ]);
    }

    public function update(Request $request, $id) {
        $member = Member::where('ID_MEMBER',$id)->first();

        if($request->NAMA_MEMBER) {
            $member->NAMA_MEMBER = $request->NAMA_MEMBER;
        }
        if($request->ALAMAT_MEMBER){
            $member->ALAMAT_MEMBER = $request->ALAMAT_MEMBER;
        }
        if($request->EMAIL_MEMBER){
            $member->EMAIL_MEMBER = $request->EMAIL_MEMBER;
        }
        if($request->NOTELP_MEMBER){
            $member->NOTELP_MEMBER = $request->NOTELP_MEMBER;
        }
        if($request->TANGGAL_LAHIR_MEMBER){
            $member->TANGGAL_LAHIR_MEMBER = $request->TANGGAL_LAHIR_MEMBER;
        }
        if($request->JENIS_KELAMIN_MEMBER){
            $member->JENIS_KELAMIN_MEMBER = $request->JENIS_KELAMIN_MEMBER;
        }
        if($request->password){
            $member->password = \bcrypt ($request->password);
        }
        
        $member_update = Member::where('ID_MEMBER', $id)
        ->limit(1) 
        ->update(array('NAMA_MEMBER' => $member->NAMA_MEMBER, 
        'ALAMAT_MEMBER' => $member->ALAMAT_MEMBER,
        'EMAIL_MEMBER' => $member->EMAIL_MEMBER,
        'NOTELP_MEMBER' => $member->NOTELP_MEMBER,
        'TANGGAL_LAHIR_MEMBER' => $member->TANGGAL_LAHIR_MEMBER,
        'JENIS_KELAMIN_MEMBER'=> $member->JENIS_KELAMIN_MEMBER,
        'password' => $member->password),
    ); 
        if($member_update) {
            return redirect()->intended('/member')->with(['success' => 'Successfully update member']);
        }
        return redirect()->intended('dbMember/editMember')->with(['error' => 'Failed update member']);
    }

    public function destroy($id){
        $member_del = member::where('ID_MEMBER',$id)->first();

        $member_del->delete();

        if($member_del) {
            return redirect()->intended('/member')->with(['success' => 'Successfully delete member']);
        }
        return redirect()->intended('/dashboard')->with(['error' => 'Failed delete member']);
    }

    public function search(Request $request) {
        if($request->search != null) {
            $member = member::where('ID_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('NAMA_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('ALAMAT_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('EMAIL_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('NOTELP_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('TANGGAL_LAHIR_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('JENIS_KELAMIN_MEMBER', 'like','%'.$request->search.'%')->
            orWhere('MASA_AKTIVASI', 'like','%'.$request->search.'%')->
            orWhere('SISA_DEPOSIT_KELAS', 'like','%'.$request->search.'%')->
            orWhere('SISA_DEPOSIT_UANG', 'like','%'.$request->search.'%')->
            get();
        }
        else {
            $member = member::orderby('ID_MEMBER','desc')->get();
        }
        
        return view('dbMember/dbMember')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'member' => $member,
        ]);
    }

    public function resetPassword($id){
        $member = Member::where('ID_MEMBER',$id)->first();

        $member_update = Member::where('ID_MEMBER', $id)
        ->limit(1) 
        ->update(array('password' => bcrypt($member->TANGGAL_LAHIR_MEMBER))); 

        if($member_update) {
            return redirect()->intended('/member')->with([
                'success' => 'Member has been successfully reset password using DOB Member (yyyy-mm-dd)'
            ]);
        }else {
            return redirect()->intended('/dashboard')->with([
                'success' => 'Member not reset password successfully'
            ]);
        }
    }

    public function cardMember($id) {
        $member = Member::where('ID_MEMBER',$id)->first();
        return view('dbMember/cardMember')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'member' => $member,
        ]);
        // return view('member/member_card');
    }

    public function deactiveIndex(){
        $member = member::orderby('ID_MEMBER','desc')->where('MASA_AKTIVASI','<',Carbon::now())->get();

        return view("dbMember/dbMemberDeactive")->with ([
            'pegawai'=> Auth::guard('pegawai')->user(),
            'member'=> $member
        ]);
    }

    public function proccessDeactiveAll(){
        $member = member::where("MASA_AKTIVASI","<",Carbon::now())->get();

        if($member){     
                foreach($member as $item){
                    $item->MASA_AKTIVASI = null;
                    $item->SISA_DEPOSIT_KELAS = 0;
                    $item->SISA_DEPOSIT_UANG = 0;
                    $item->MASA_EXPIRED_MEMBER = null;
                    $item->TANGGAL_DEACTIVE_MEMBER = Carbon::now()->addDays(1);
                    $item->update();
                }
                return redirect()->intended('/deactiveMember')->with(['success' => 'Sucessfully deactive member']);
        }
        return redirect()->intended('/deactiveMember')->with(['error' => 'Failed deactive member']);
    }

    public function processDeactive($id){
        $member = member::where("ID_MEMBER",$id)->first();
        
        if($member && $member->TANGGAL_DEACTIVE_MEMBER < Carbon::now() || $member && $member->TANGGAL_DEACTIVE_MEMBER == null ){
            $member->MASA_AKTIVASI = null;
            $member->SISA_DEPOSIT_KELAS = 0;
            $member->SISA_DEPOSIT_UANG = 0;
            $member->MASA_EXPIRED_MEMBER = null;
            $member->TANGGAL_DEACTIVE_MEMBER = Carbon::now()->addDays(1);
            $member->update();
            return redirect()->intended('/deactiveMember')->with(['success' => 'Sucessfully deactive member']);
        }
        return redirect()->intended('/deactiveMember')->with(['error' => 'Failed deactive member']);
    }

    public function resetClassIndex(){
        $member = MemberDepositKelas::orderby('ID_MEMBER_DEPOSIT_KELAS','desc')->where('MASA_BERLAKU','<',Carbon::now())->get();
        $member_after = MemberDepositKelas::orderby('ID_MEMBER_DEPOSIT_KELAS','desc')->where('MASA_BERLAKU',null)->get();

        // return view("dbMember/dbMemberResetClass")->with ([
        //     'pegawai'=> Auth::guard('pegawai')->user(),
        //     'member'=> $member
        // ]);

        return view('dbMember/dbMemberResetClass')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'member' => $member,
            'member_after' => $member_after
        ]);
    }

    public function proccessResetClass(){
        $members = MemberDepositKelas::orderby('ID_MEMBER_DEPOSIT_KELAS','desc')->where('MASA_BERLAKU','<',Carbon::now())->get();
        
        if($members){
            foreach($members as $member){
                if($member->EXPIRED_RESET_KELAS < Carbon::now() || $member && $member->EXPIRED_RESET_KELAS == null ){
                    $member->SISA_DEPOSIT = 0;
                    $member->MASA_BERLAKU = null;
                    $member->EXPIRED_RESET_KELAS = Carbon::now()->addDays(1);
                    $member->update();
                }else {
                    return redirect()->intended('/resetClass')->with(['error' => 'Failed reset class member '.$member->member->NAMA_MEMBER.' class '.$member->kelas->NAMA_KELAS.' because you can deactive this member tomorrow']);
                }
            }
            return redirect()->intended('/resetClass')->with(['success' => 'Sucessfully reset class packet']);
        }
    }

    public function getDataMember(Request $request, $id)
    {
        if ($request->expectsjson()) {


            $members = DB::select(
                'SELECT m.ID_MEMBER, m.NAMA_MEMBER, m.EMAIL_MEMBER, m.MASA_AKTIVASI, m.SISA_DEPOSIT_UANG, md.SISA_DEPOSIT FROM member m LEFT JOIN member_deposit_kelas md ON m.ID_MEMBER = md.ID_MEMBER  WHERE m.ID_MEMBER = "' .
                    $id .
                    '" GROUP BY m.NAMA_MEMBER, md.SISA_DEPOSIT '
            );

            if ($members) {
                return response(
                    [
                        "message" => "Berhasil mengambil data member",
                        "data" => $members,
                    ],
                    200
                );
            }

            return response(
                [
                    "message" => "Member tidak ditemukan",
                    "data" => null,
                ],
                200
            );
        }
    }
}