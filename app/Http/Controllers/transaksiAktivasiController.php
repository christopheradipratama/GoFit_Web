<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class transaksiAktivasiController extends Controller
{
    public function index()
    {
        $transaksiAktivasi = TransaksiAktivasi::orderBy('ID_TRANSAKSI_AKTIVASI', 'asc')->get();
        $member = Member::where('MASA_AKTIVASI', '<', Carbon::now())
            ->orWhere('MASA_AKTIVASI', null)
            ->get();

        return view('dbTransaksi/dbTransaksiAktivasi/dbTransaksiAktivasi')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiAktivasi' => $transaksiAktivasi,
            'member' => $member,
        ]);
    }

    public function cetakStruk($id)
    {
        $transaksiAktivasi = TransaksiAktivasi::where('ID_TRANSAKSI_AKTIVASI', $id)->first();
        return view('dbTransaksi/dbTransaksiAktivasi/strukTransaksiAktivasi')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'transaksiAktivasi' => $transaksiAktivasi,
        ]);
    }

    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'ID_MEMBER' => 'required',
            ],
            [
                'ID_MEMBER.required' => 'The member field is required',
            ],
        );

        $member = Member::where('ID_MEMBER', $request->ID_MEMBER)->first();
        $pegawai = Auth::guard('pegawai')->user();

        if ($member) {
            $transaksiAktivasi = TransaksiAktivasi::create([
                'ID_MEMBER' => $member->ID_MEMBER,
                'ID_PEGAWAI' => $pegawai->ID_PEGAWAI,
                'TANGGAL_TRANSAKSI_AKTIVASI' => Carbon::now()->format('Y-m-d H:i:s'),
                'EXPIRED_TRANSAKSI_AKTIVASI' => Carbon::now()
                    ->addYears(1)
                    ->format('Y-m-d H:i:s'),
                'BIAYA_AKTIVASI' => 3000000,
                'STATUS_AKTIVASI' => 'Paid',
            ]);

            if ($transaksiAktivasi) {
                // generate masa aktif member di table member
                $member->MASA_AKTIVASI = Carbon::now()
                    ->addYears(1)
                    ->format('Y-m-d H:i:s');
                $member->update();
                $data = TransaksiAktivasi::latest('ID_TRANSAKSI_AKTIVASI')->first();
                return redirect()->intended('/strukTransaksiAktivasi/' . $data->ID_TRANSAKSI_AKTIVASI);
            } else {
                return redirect()
                    ->intended('/dbTransaksiAktivasi')
                    ->with(['error' => 'Failed activate member']);
            }
        } else {
            return redirect()
                ->intended('/dbTransaksiAktivasi')
                ->with(['error' => 'Failed activate member']);
        }
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'ID_MEMBER' => 'required',
                'JUMLAH_UANG' => 'required',
            ],
            [
                'ID_MEMBER.required' => 'ID Member Tidak Boleh Kosong',
                'JUMLAH_UANG.required' => 'Jumlah Uang Yang Diinputkan tidak boleh kosong',
            ],
        );

        $member = Member::where('ID_MEMBER', $request->ID_MEMBER)->first();
        $pegawai = Auth::guard('pegawai')->user();

        if ($request->JUMLAH_UANG < 3000000) {
            return redirect()
                ->back()
                ->with(['error' => 'Uang yang dimasukan kurang']);
        }

        if ($member) {
            $activation_transaction = TransaksiAktivasi::create([
                'ID_MEMBER' => $member->ID_MEMBER,
                'ID_PEGAWAI' => $pegawai->ID_PEGAWAI,
                'TANGGAL_TRANSAKSI_AKTIVASI' => Carbon::now()->format('Y-m-d H:i:s'),
                'EXPIRED_TRANSAKSI_AKTIVASI' => Carbon::now()
                    ->addYears(1)
                    ->format('Y-m-d H:i:s'),
                'BIAYA_AKTIVASI' => 3000000,
                'STATUS_AKTIVASI' => 'Paid',
                'KEMBALIAN' => $request->JUMLAH_UANG - 3000000,
            ]);

            if ($activation_transaction) {
                // generate masa aktif member di table member
                $member->MASA_AKTIVASI = Carbon::now()
                    ->addYears(1)
                    ->format('Y-m-d H:i:s');
                $member->update();
                $data = TransaksiAktivasi::latest('ID_TRANSAKSI_AKTIVASI')->first();
                return redirect()->intended('transaksiAktivasi');
            } else {
                return redirect()
                    ->intended('transaksiAktivasi')
                    ->with(['error' => 'Tidak Berhasil Aktivasi Member']);
            }
        } else {
            return redirect()
                ->intended('transaksiAktivasi')
                ->with(['error' => 'Tidak Berhasil Aktivasi Member']);
        }
    }

    public function indexTransaksiAktivasi(Request $request)
    {
        $this->validate(
            $request,
            [
                "ID_MEMBER" => "required",
            ],
            [
                "ID_MEMBER.required" => "ID Member tidak boleh kosong",
            ]
        );

        $member = Member::where("ID_MEMBER", $request->ID_MEMBER)->first();

        return view("dbTransaksi/dbtransaksiAktivasi/confirmTransaksiAktivasi")->with([
            "pegawai" => Auth::guard("pegawai")->user(),
            "member" => $member,
        ]);
    }
}