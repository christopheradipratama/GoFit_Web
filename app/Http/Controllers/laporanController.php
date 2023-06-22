<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use App\Models\TransaksiDepositKelas;
use App\Models\TransaksiDepositUang;
use App\Models\BookingGym;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Facades\Charts;
// use DB;


class laporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getLaporanPendapatan(Request $request)
    // {
    //     $tahun_transaksi_aktivasi = $request->input('tahun');
    
        // $total_transaksi_aktivasi = TransaksiAktivasi::select(DB::raw("MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan, CAST(SUM(BIAYA_AKTIVASI) as int) as total_transaksi_aktivasi"))
        //     ->whereYear('TANGGAL_TRANSAKSI_AKTIVASI', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTH(TANGGAL_TRANSAKSI_AKTIVASI)"))
        //     ->pluck('total_transaksi_aktivasi');

        // $total_transaksi_aktivasi = TransaksiAktivasi::select(DB::raw("MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan, CAST(SUM(BIAYA_AKTIVASI) as int) as total_transaksi_aktivasi"))
        //     ->whereYear('TANGGAL_TRANSAKSI_AKTIVASI', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTH(TANGGAL_TRANSAKSI_AKTIVASI), TANGGAL_TRANSAKSI_AKTIVASI"))
        //     ->pluck('total_transaksi_aktivasi', 'bulan');
    
        // $total_transaksi_deposit_kelas = TransaksiDepositKelas::select(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_KELAS) as bulan, CAST(SUM(JUMLAH_PEMBAYARAN) as int) as total_transaksi_deposit_kelas"))
        //     ->whereYear('TANGGAL_DEPOSIT_KELAS', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_KELAS)"))
        //     ->pluck('total_transaksi_deposit_kelas', 'bulan');
    
        // $total_transaksi_deposit_uang = TransaksiDepositUang::select(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_UANG) as bulan, CAST(SUM(TOTAL_DEPOSIT_UANG) as int) as total_transaksi_deposit_uang"))
        //     ->whereYear('TANGGAL_DEPOSIT_UANG', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_UANG)"))
        //     ->pluck('total_transaksi_deposit_uang', 'bulan');
    
        // $bulan_transaksi_aktivasi = TransaksiAktivasi::select(DB::raw("MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan"))
        //     ->whereYear('TANGGAL_TRANSAKSI_AKTIVASI', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI)"))
        //     ->pluck('bulan');
    
        // $bulan_transaksi_deposit_kelas = TransaksiDepositKelas::select(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_KELAS) as bulan"))
        //     ->whereYear('TANGGAL_DEPOSIT_KELAS', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_KELAS)"))
        //     ->pluck('bulan');
    
        // $bulan_transaksi_deposit_uang = TransaksiDepositUang::select(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_UANG) as bulan"))
        //     ->whereYear('TANGGAL_DEPOSIT_UANG', $tahun_transaksi_aktivasi)
        //     ->groupBy(DB::raw("MONTHNAME(TANGGAL_DEPOSIT_UANG)"))
        //     ->pluck('bulan');
    
        // $bulan_transaksi = $bulan_transaksi_aktivasi
        //     ->merge($bulan_transaksi_deposit_kelas)
        //     ->merge($bulan_transaksi_deposit_uang)
        //     ->unique()
        //     ->sortBy(function ($bulan) {
        //         return Carbon::parse($bulan)->month;
        //     });
    
        // return view("dbLaporan.dbLaporanPendapatan", compact(
        //     'total_transaksi_aktivasi',
        //     'total_transaksi_deposit_kelas',
        //     'total_transaksi_deposit_uang',
        //     'tahun_transaksi_aktivasi',
        //     'bulan_transaksi',
        //     'bulan_transaksi_aktivasi',
        //     'bulan_transaksi_deposit_kelas',
        //     'bulan_transaksi_deposit_uang'
        // ))->with([
        //     'pegawai' => Auth::guard('pegawai')->user(),
        //     'tanggal_cetak' => Carbon::now()->translatedFormat('d F Y')
        // ]);
        // }

    public function indexLaporanPendapatan(){
        return view('dbLaporan/dbLaporanPendapatan')->with([
            'pegawai' => Auth::guard('pegawai')->user(),
            'data_depo_class' => [],
            'data_activation' => [],
            'data_total_income' => []
        ]);
    }
    
    public function getLaporanPendapatan(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'tahun' => ['required']
            ]);
            
            for($x = 0; $x < 12 ; $x++){
                $report_income_deposit[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income_deposit FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT TOTAL_DEPOSIT_UANG, tanggal_deposit_uang FROM transaksi_deposit_uang) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = '.$request->tahun.' AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan');

                $report_income_activaton[] = DB::select(
                    'SELECT MONTHNAME(TANGGAL_TRANSAKSI_AKTIVASI) as bulan, SUM(BIAYA_AKTIVASI) as total_income_activation 
                    FROM transaksi_aktivasi 
                    WHERE YEAR(TANGGAL_TRANSAKSI_AKTIVASI) = '.$request->tahun.' AND MONTH(TANGGAL_TRANSAKSI_AKTIVASI) ='.$x.' + 1 GROUP BY bulan');
                    
                $report_total[] = DB::select(
                    'SELECT MONTHNAME(t.TANGGAL_DEPOSIT_KELAS) as bulan, SUM(t.jumlah_pembayaran) AS total_income FROM 
                    (SELECT jumlah_pembayaran, tanggal_deposit_kelas FROM transaksi_deposit_kelas 
                    UNION ALL 
                    SELECT TOTAL_DEPOSIT_UANG, tanggal_deposit_uang FROM transaksi_deposit_uang
                    UNION ALL
                    SELECT biaya_aktivasi, tanggal_transaksi_aktivasi FROM transaksi_aktivasi ) t WHERE YEAR(t.TANGGAL_DEPOSIT_KELAS) = '.$request->tahun.' AND MONTH(t.TANGGAL_DEPOSIT_KELAS) ='.$x.' +1 GROUP BY bulan'
                );
            }

            $collection = collect([
                $report_total
            ]);
    
            $collapsed = $collection->collapse();
            $collapsed2 = $collapsed->collapse();

            $temp_keys =['January','February','March','April','May','June','July','August','September','October','November','December'];
            $temp_value = [0,0,0,0,0,0,0,0,0,0,0,0];
            $keys = [];
            $value = [];

            for($i = 0; $i < 12; $i++){
                if($collapsed[$i]){
                    $keys[] = $collapsed[$i][0]->bulan;
                    $value[] = $collapsed[$i][0]->total_income;
                }else{
                    $keys[] = $temp_keys[$i];
                    $value[] = $temp_value[$i];
                }
            }
            
            return redirect()->intended('laporanPendapatan')->with([
                'success' => 'Sucessfully Get Report '.$request->tahun,
                'user' => Auth::guard('pegawai')->user(),
                'data_depo_class' => $report_income_deposit,
                'data_activation' => $report_income_activaton,
                'data_total_income' => $report_total,
                'year'=> $request->tahun,
                'report_keys'=> $keys,
                'report_value' => $value
            ]);
        }
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLaporanKelas(Request $request){
        if($request->accepts('text/html')){
            return view('dbLaporan/dbLaporanKelas')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_class_activity' => null,
            ]);
        }
    }

    public function getLaporanKelas(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);
            
            $data_class_activity = DB::select('SELECT k.NAMA_KELAS AS kelas, i.nama_instruktur AS instruktur, 
            SUM(CASE WHEN bk.KODE_BOOKING_KELAS IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_peserta_kelas, 
            SUM(CASE WHEN jh.KETERANGAN_JADWAL_HARIAN = "Libur" THEN 1 ELSE 0 END) AS jumlah_libur 
            FROM kelas as k 
            LEFT JOIN jadwal_umum as ju on ju.ID_KELAS = k.ID_KELAS 
            LEFT JOIN jadwal_harian as jh on ju.ID_JADWAL_UMUM = jh.ID_JADWAL_UMUM 
            LEFT JOIN instruktur AS i ON jh.id_instruktur = i.id_instruktur 
            LEFT JOIN booking_kelas as bk on jh.TANGGAL_JADWAL_HARIAN = bk.TANGGAL_JADWAL_HARIAN 
            WHERE MONTH(jh.tanggal_jadwal_harian) = '.$request->month_filter.' AND YEAR(jh.TANGGAL_JADWAL_HARIAN) = '.$request->year_filter.' GROUP BY k.NAMA_KELAS, i.NAMA_INSTRUKTUR;');

            return redirect()->intended('/laporanKelas')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter, 
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_class_activity' => $data_class_activity,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
            
            
        }else{

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexLaporanGym(Request $request){
        if($request->accepts('text/html')){
            return view('dbLaporan/dbLaporanGym')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_gym_activity' => null,
            ]);
        }
    }

    public function getLaporanGym(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);

            $data_gym_activity = DB::select('SELECT TANGGAL_BOOKING_GYM as tanggal, COUNT(KODE_BOOKING_GYM) as jumlah_member  FROM `booking_gym` 
            WHERE YEAR(TANGGAL_BOOKING_GYM) = '.$request->year_filter.'
            AND STATUS_PRESENSI_GYM = "Hadir"
            AND MONTH(TANGGAL_BOOKING_GYM) = '.$request->month_filter.'
            GROUP BY TANGGAL_BOOKING_GYM');

            return redirect()->intended('/laporanGym')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_gym_activity' => $data_gym_activity,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
        }
    }

    public function indexLaporanInstruktur(Request $request){
        if($request->accepts('text/html')){
            return view('dbLaporan/dbLaporanInstruktur')->with([
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_instructor' => null,
            ]);
        }
    }

    public function getLaporanInstruktur(Request $request){
        if($request->accepts('text/html')){
            $validate = $request->validate([
                'year_filter' => ['required'],
                'month_filter' => ['required']
            ]);

            // $data_instructor = DB::select('SELECT i.nama_instruktur, SUM(CASE WHEN pi.ID_PRESENSI_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir, SUM(CASE WHEN iz.ID_IZIN_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin, 
            // IFNULL(i.jumlah_terlambat, 0) AS akumulasi_terlambat 
            // FROM instruktur AS i 
            // LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur 
            // AND MONTH(pi.created_at) = '.$request->month_filter.' AND YEAR(pi.created_at) = '.$request->year_filter.'
            // LEFT JOIN izin_instruktur AS iz ON i.id_instruktur = iz.id_instruktur 
            // AND MONTH(iz.created_at) = '.$request->month_filter.'  AND YEAR(iz.created_at) = '.$request->year_filter.'
            // GROUP BY i.NAMA_INSTRUKTUR, i.jumlah_terlambat
            // ORDER BY i.jumlah_terlambat');

            $data_instructor = DB::select('SELECT i.nama_instruktur, SUM(CASE WHEN pi.ID_PRESENSI_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir, SUM(CASE WHEN iz.ID_IZIN_INSTRUKTUR IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin, 
            SUM(CASE WHEN pi.WAKTU_TERLAMBAT iS NOT NULL THEN pi.WAKTU_TERLAMBAT ELSE 0 END) AS akumulasi_terlambat 
            FROM instruktur AS i 
            LEFT JOIN presensi_instruktur AS pi ON i.id_instruktur = pi.id_instruktur 
            AND MONTH(pi.created_at) = '.$request->month_filter.' AND YEAR(pi.created_at) = '.$request->year_filter.'
            LEFT JOIN izin_instruktur AS iz ON i.id_instruktur = iz.id_instruktur 
            AND MONTH(iz.created_at) = '.$request->month_filter.'  AND YEAR(iz.created_at) = '.$request->year_filter.'
            GROUP BY i.NAMA_INSTRUKTUR, i.jumlah_terlambat
            ORDER BY SUM(CASE WHEN pi.WAKTU_TERLAMBAT iS NOT NULL THEN pi.WAKTU_TERLAMBAT ELSE 0 END) ');

            return redirect()->intended('/laporanInstruktur')->with([
                'success' => 'Sucessfully Get Report '.Carbon::now()->month($request->month_filter)->translatedformat('F').' '.$request->year_filter ,
                'pegawai' => Auth::guard('pegawai')->user(),
                'data_instructor' => $data_instructor,
                'year' => $request->year_filter,
                'month' => $request->month_filter,
                'print' => 'yes'
            ]);
        }
    }
}