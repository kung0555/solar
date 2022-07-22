<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Contract;
use App\Models\Billing;
use App\Models\Gain;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;

use PDF;

use Mail;





class AdminController extends Controller
{
    public $key_id_On_Peak = 36;
    public $key_id_Off_Peak = 37;
    public $key_id_Holiday = 38;

    public function index()
    {
        $allparameters = Parameter::all();
        return view('admin/parameter/allparameter', compact('allparameters'));
    }

    public function parameterAddForm()
    {
        return view('admin/parameter/parameterAddForm');
    }
    public function parameterAddChk(Request $request)
    {
        // dd($request->ft);
        // dd($request->cp);
        // dd($request->effective);
        // dd($request->ch);
        // dd($request->cop); ft อ่ะ ออก เลยคิดว่าไม่น่าเกี่ยว ลองก่อนมั๊ย มันจะไปเซฟลงด้าต้าเบสแล้ว
        $request->validate([
            'ft' => ['required', 'max:10'],
            'cp' => ['required', 'max:10'],
            'ch' => ['required', 'max:10'],
            'cop' => ['required', 'max:10'],
            'effective_start' => ['required', 'unique:parameters'],
            'effective_end' => ['required', 'unique:parameters', 'after:effective_start'],

        ], [
            'ft.required' => 'กรุณากรอกข้อมูล Ft',
            'ft.max' => 'กรุณากรอกข้อมูล Ft',
            'cp.required' => 'กรุณากรอกข้อมูล Cp',
            'cp.max' => 'กรุณากรอกข้อมูล Cp',
            'ch.required' => 'กรุณากรอกข้อมูล Ch',
            'ch.max' => 'กรุณากรอกข้อมูล Ch',
            'cop.required' => 'กรุณากรอกข้อมูล Cop',
            'cop.max' => 'กรุณากรอกข้อมูล Cop',
            'effective_start.required' => 'กรุณากเลือกวันที่มีผลบังคับใช้',
            'effective_end.required' => 'กรุณากเลือกวันสิ้นสุดผลบังคับใช้',
            'effective_start.unique' => 'วันที่มีผลบังคับใช้ เคยใช้งานแล้ว',
            'effective_end.unique' => 'วันสิ้นสุดผลบังคับใช้ เคยใช้งานแล้ว',
            'effective_end.after' => 'ตรวจสอบวันที่สิ้นสุดอีกครั้ง',
        ]);
        //บันทึกข้อมูล
        $adminmodel = new Parameter;
        $adminmodel->ft = $request->ft;
        $adminmodel->cp = $request->cp;
        $adminmodel->ch = $request->ch;
        $adminmodel->cop = $request->cop;
        $adminmodel->effective_start = $request->effective_start;
        $adminmodel->effective_end = $request->effective_end;
        $adminmodel->save();
        // return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");

        // return redirect('/admin/parameter/allparameter')->with('success',"บันทึกข้อมูลเรียบร้อย");
        return redirect()->route('allparameter')->with('success', "บันทึกข้อมูลเรียบร้อย");
    }
    public function parameterEditID($id)
    {
        // dd($id);
        // echo $id;

        $parameter = Parameter::findOrFail($id);
        // dd($parameter->ft);
        return view('admin/parameter/parameterEditForm', compact('parameter'));
    }
    public function parameterEditChk(Request $request, $id)
    {
        // dd($request->ft);
        // dd($request->cp);
        // dd($request->effective);
        // dd($request->ch);
        // dd($request->cop); ft อ่ะ ออก เลยคิดว่าไม่น่าเกี่ยว ลองก่อนมั๊ย มันจะไปเซฟลงด้าต้าเบสแล้ว
        $request->validate([
            'ft' => ['required', 'max:10'],
            'cp' => ['required', 'max:10'],
            'ch' => ['required', 'max:10'],
            'cop' => ['required', 'max:10'],
            'effective_start' => ['required'],
            'effective_end' => ['required', 'after:effective_start'],

        ], [
            'ft.required' => 'กรุณากรอกข้อมูล Ft',
            'ft.max' => 'กรุณากรอกข้อมูล Ft',
            'cp.required' => 'กรุณากรอกข้อมูล Cp',
            'cp.max' => 'กรุณากรอกข้อมูล Cp',
            'ch.required' => 'กรุณากรอกข้อมูล Ch',
            'ch.max' => 'กรุณากรอกข้อมูล Ch',
            'cop.required' => 'กรุณากรอกข้อมูล Cop',
            'cop.max' => 'กรุณากรอกข้อมูล Cop',
            'effective_start.required' => 'กรุณากเลือกวันที่มีผลบังคับใช้',
            'effective_end.required' => 'กรุณากเลือกวันสิ้นสุดผลบังคับใช้',
            'effective_start.unique' => 'วันที่มีผลบังคับใช้ เคยใช้งานแล้ว',
            'effective_end.unique' => 'วันสิ้นสุดผลบังคับใช้ เคยใช้งานแล้ว',
            'effective_end.after' => 'ตรวจสอบวันที่สิ้นสุดอีกครั้ง',
        ]);

        $update = Parameter::find($id);
        $update->ft = $request->ft;
        $update->cp = $request->cp;
        $update->cop = $request->cop;
        $update->ch = $request->ch;
        $update->effective_start = $request->effective_start;
        $update->effective_end = $request->effective_end;
        $update->save();



        // return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");

        // return redirect('/admin/parameter/allparameter')->with('success',"บันทึกข้อมูลเรียบร้อย");
        return redirect()->route('allparameter')->with('success', "บันทึกข้อมูล ID : " . $id . " เรียบร้อย");
    }
    public function parameterDelete($id)
    {
        $delete = Parameter::find($id)->delete();
        // return redirect()->route('allparameter')->with('success', "ลบข้อมูล ID : ".$id." เรียบร้อย");

        if ($delete) {
            $success = true;
            $message = "Deleted successfully";
        } else {
            $success = true;
            $message = "Not found";
        }

        //  return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
    public function contractView()
    {
        // $contractnum = DB::table('contracts')
        //     ->orderBy('id', 'desc')
        //     ->limit(1)
        //     ->get()
        //     ->count();
        // if ($contractnum > 0) {
        //     $contractviews = DB::table('contracts')
        //         ->orderBy('id', 'desc')
        //         ->limit(1)
        //         ->get();
        // } else {
        //     $contractviews = null;
        // }
        $contractviews = DB::table('contracts')->orderBy('id', 'desc')->first();

        return view('admin/contract/contractView', compact('contractviews'));
    }
    public function contractEditForm()
    {
        $contractviews = DB::table('contracts')->orderBy('id', 'desc')->first();
        return view('admin/contract/contractEditForm', compact('contractviews'));
    }
    public function contractChk(Request $request)
    {
        $request->validate([
            'start_contract' => ['required'],
            'end_contract' => ['required', 'after:start_contract'],
        ], [
            'start_contract.required' => 'กรุณากรอกข้อมูล วันที่เริ่มสัญญา',
            'end_contract.after' => 'ตรวจสอบวันที่สิ้นสุดอีกครั้ง',

        ]);
        //บันทึกข้อมูล
        $add_contract = new Contract;
        $add_contract->start_contract = $request->start_contract;
        $add_contract->end_contract = $request->end_contract;
        $add_contract->contract_no = $request->contract_no;
        $add_contract->contract_companyTH = $request->contract_companyTH;
        $add_contract->contract_companyEN = $request->contract_companyEN;
        $add_contract->contract_address = $request->contract_address;
        $add_contract->kWh_meter_SN = $request->kWh_meter_SN;
        $add_contract->type = $request->type;
        $add_contract->voltage = $request->voltage;
        // $add_contract->CT_VT_Factor = $request->CT_VT_Factor;
        // $add_contract->meter_date = $request->meter_date;
        $add_contract->date_billing = $request->date_billing;
        $add_contract->save();
        // return redirect()->back()->with('success',"บันทึกข้อมูลเรียบร้อย");

        // return redirect('/admin/parameter/allparameter')->with('success',"บันทึกข้อมูลเรียบร้อย");
        return redirect()->route('contractView')->with('success', "บันทึกข้อมูลเรียบร้อย");
    }
    public function billingAuto()
    {
        $date_now = date("Y-m-d");
        $date_now_path = date("Y-m-d H:i:s");
        // $date_now = date("Y-06-01");// สำหรับเทส

        $key_id_On_Peak = $this->key_id_On_Peak;
        $key_id_Off_Peak = $this->key_id_Off_Peak;
        $key_id_Holiday = $this->key_id_Holiday;

        $billingsChk = DB::table('billings')
            ->whereYear('created_at', '=', date("Y"))
            ->whereMonth('created_at', '=', date("m"))
            ->where('type', '=', 'Auto')
            ->get()->count();
        if ($billingsChk <= 0) {
            $count_contract = DB::table('contracts')->orderBy('id', 'desc')->get()->count();
            if ($count_contract > 0) {
                echo "Have date contract  ====> " . $count_contract . "<br>";

                $contract = DB::table('contracts')->orderBy('id', 'desc')->first();
                $contract_companyEN = $contract->contract_companyEN;
                $contract_companyTH = $contract->contract_companyTH;
                $contract_address = $contract->contract_address;
                $kWh_meter_SN = $contract->kWh_meter_SN;
                $type =  $contract->type;
                $voltage = $contract->voltage;
                // $CT_VT_Factor = $contract->CT_VT_Factor;
                // echo "CT_VT_Factor = " . $CT_VT_Factor . "<br>";


                $start_contract = $contract->start_contract;
                echo "start_contract " . $start_contract . "<br>";




                if ($date_now >= $start_contract) {
                    echo "date_now >= start_contract อยู่ในสัญญา<br>";

                    $getbilling_date = $contract->date_billing;
                    if ($getbilling_date < 10) {
                        $getbilling_date = '0' . $getbilling_date;
                    }
                    $billing_date = date("Y-m-$getbilling_date");
                    // $billing_date = date("Y-06-$getbilling_date"); // สำหรับเทส
                    echo "billing_date " . $billing_date . "<br>";

                    if ($date_now == $billing_date) {
                        echo "billing_date เท่า date_now <br>";

                        $parametersBetween_date_now = DB::table('parameters')
                            // ->whereBetween($date_now, ['effective_start', 'effective_end'])
                            ->where('effective_end', '>=', $date_now)
                            ->where('effective_start', '<=', $date_now)
                            ->orderBy('id', 'desc')
                            ->get()
                            ->count();
                        // echo  $parametersBetween_date_now;

                        if ($parametersBetween_date_now > 0) {

                            echo "มีค่า Ft <br>";

                            // $Ft_4M_chk = DB::table('parameters')->orderBy('id', 'desc')->first();
                            $Ft_4M_chk = DB::table('parameters')
                                // ->whereBetween($date_now, ['effective_start', 'effective_end'])
                                ->where('effective_end', '>=', $date_now)
                                ->where('effective_start', '<=', $date_now)
                                ->orderBy('id', 'desc')
                                ->get()->first();
                            $ft = $Ft_4M_chk->ft;
                            $cp = $Ft_4M_chk->cp;
                            $ch = $Ft_4M_chk->ch;
                            $cop = $Ft_4M_chk->cop;
                            $effective_start = $Ft_4M_chk->effective_start;
                            $effective_end = $Ft_4M_chk->effective_end;

                            $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
                            $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
                            echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

                            ////strtotime  date_now////
                            $strtotime_date_now =  strtotime("$date_now") * 1000;
                            $end_billing = $strtotime_date_now;
                            echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br><br>";

                            /////////////////////////////////On_Peak///////////////////////////////////////////////////////////////
                            /////kwhp_gain/////
                            $kwhp_get_gain = $this->get_gain($key_id_On_Peak);
                            $kwhp_gain = $kwhp_get_gain->gain;

                            ////kWhp_first////////
                            $ts_kv_On_Peak_first = $this->ts_kv_first($key_id_On_Peak, $start_billing);
                            $kWhp_first = $ts_kv_On_Peak_first->long_v;
                            $kWhp_firstDivideGain = $kWhp_first / $kwhp_gain;
                            $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
                            echo "พลังงานไฟฟ้า Peak เลขอ่านครั้งก่อน = " . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . " long_v = " . $kWhp_firstDivideGain . "<br>";

                            ////kWhp_last////////
                            $ts_kv_On_Peak_last = $this->ts_kv_first($key_id_On_Peak, $end_billing);
                            $kWhp_last = $ts_kv_On_Peak_last->long_v;
                            $kWhp_lastDivideGain = $kWhp_last / $kwhp_gain;
                            $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
                            echo "พลังงานไฟฟ้า Peak เลขอ่านครั้งหลัง = " . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . " long_v = " . $kWhp_lastDivideGain . "<br>";

                            ////kWhp////////
                            // $kWhp_lastMinusfirst_DivideGain = ($kWhp_lastDivideGain - $kWhp_firstDivideGain) * $CT_VT_Factor;
                            $kWhp_lastMinusfirst_DivideGain = $kWhp_lastDivideGain - $kWhp_firstDivideGain;
                            echo "พลังงานไฟฟ้า Peak = " . $kWhp_lastMinusfirst_DivideGain . "<br>";

                            echo "อัตราค่าไฟฟ้า Peak = " . $cp . "<br>";

                            // $kWhp = $kWhp_lastMinusfirst * $CT_VT_Factor;
                            // $kWhp_DivideGain = $kWhp / $kwhp_gain;
                            // echo "(kWhp_last-first*CT_VT_Factor)/kwhp_gain  = " . $kWhp . "<br>";

                            // $energy_money_kWhp = number_format($cp * $kWhp_lastMinusfirst_DivideGain,2,".","");
                            $energy_money_kWhp = $cp * $kWhp_lastMinusfirst_DivideGain;
                            echo "จำนวนเงิน kWhp = " . number_format($energy_money_kWhp, 2, ".", "") . "<br><br>";


                            /////////////////////////////////Off_Peak///////////////////////////////////////////////////////////////
                            ////kWhop_gain////////
                            $kwhop_get_gain = $this->get_gain($key_id_Off_Peak);
                            $kwhop_gain = $kwhop_get_gain->gain;

                            ////kWhop_first////////
                            $ts_kv_Off_Peak_first = $this->ts_kv_first($key_id_Off_Peak, $start_billing);
                            $kWhop_first = $ts_kv_Off_Peak_first->long_v;
                            $kWhop_first_DivideGain = $kWhop_first / $kwhop_gain;
                            $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
                            echo "พลังงานไฟฟ้า Off-Peak เลขอ่านครั้งก่อน = " . date("Y-m-d H:i:s", $kWhop_first_ts / 1000) . " long_v = " . $kWhop_first_DivideGain . "<br>";

                            ////kWhop_last////////
                            $ts_kv_Off_Peak_last = $this->ts_kv_first($key_id_Off_Peak, $end_billing);
                            $kWhop_last = $ts_kv_Off_Peak_last->long_v;
                            $kWhop_last_DivideGain = $kWhop_last / $kwhop_gain;
                            $kWhop_last_ts = $ts_kv_Off_Peak_last->ts;
                            echo "พลังงานไฟฟ้า Off-Peak เลขอ่านครั้งหลัง = " . date("Y-m-d H:i:s", $kWhop_last_ts / 1000) . " long_v = " . $kWhop_last_DivideGain . "<br>";

                            ////kWhop////////
                            // $kWhop_lastMinusfirst_DivideGain = ($kWhop_last_DivideGain - $kWhop_first_DivideGain) * $CT_VT_Factor;
                            $kWhop_lastMinusfirst_DivideGain = $kWhop_last_DivideGain - $kWhop_first_DivideGain;
                            echo "พลังงานไฟฟ้า Off-Peak = " . $kWhop_lastMinusfirst_DivideGain . "<br>";

                            echo "อัตราค่าไฟฟ้า Off-Peak = " . $cop . "<br>";

                            // $energy_money_kWhop = number_format($cop * $kWhop_lastMinusfirst_DivideGain,2,".","");
                            $energy_money_kWhop = $cop * $kWhop_lastMinusfirst_DivideGain;
                            echo "จำนวนเงิน kWhop = " . number_format($energy_money_kWhop, 2, ".", "") . "<br><br>";


                            /////////////////////////////////Holiday///////////////////////////////////////////////////////////////
                            ////kWhh_gain////////
                            $kWhh_get_gain = $this->get_gain($key_id_Holiday);
                            $kWhh_gain = $kWhh_get_gain->gain;

                            ////kWhh_first////////
                            $ts_kv_Holiday_first = $this->ts_kv_first($key_id_Holiday, $start_billing);
                            $kWhh_first = $ts_kv_Holiday_first->long_v;
                            $kWhh_first_DivideGain = $kWhh_first / $kWhh_gain;
                            $kWhh_first_ts = $ts_kv_Holiday_first->ts;
                            echo "พลังงานไฟฟ้า Holiday เลขอ่านครั้งก่อน = " . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . " long_v = " . $kWhh_first_DivideGain . "<br>";

                            ////kWhp_last////////
                            $ts_kv_Holiday_last = $this->ts_kv_first($key_id_Holiday, $end_billing);
                            $kWhh_last = $ts_kv_Holiday_last->long_v;
                            $kWhh_last_DivideGain = $kWhh_last / $kWhh_gain;
                            $kWhh_last_ts = $ts_kv_Holiday_last->ts;
                            echo "พลังงานไฟฟ้า Holiday เลขอ่านครั้งหลัง = " . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . " long_v = " . $kWhh_last_DivideGain . "<br>";

                            ////kWhh////////
                            // $kWhh_lastMinusfirst_DivideGain = ($kWhh_last_DivideGain - $kWhh_first_DivideGain) * $CT_VT_Factor;
                            $kWhh_lastMinusfirst_DivideGain = $kWhh_last_DivideGain - $kWhh_first_DivideGain;
                            echo "พลังงานไฟฟ้า Holiday = " . $kWhh_lastMinusfirst_DivideGain . "<br>";

                            echo "อัตราค่าไฟฟ้า Holiday = " . $ch . "<br>";


                            // $energy_money_kWhh = number_format($ch * $kWhh_lastMinusfirst_DivideGain,2,".","");
                            $energy_money_kWhh = $ch * $kWhh_lastMinusfirst_DivideGain;
                            echo "จำนวนเงิน kWhh = " . number_format($energy_money_kWhh, 2, ".", "") . "<br><br>";


                            ////sum kWh_DivideGain/////
                            $sum_kwh_DivideGain = $kWhp_lastMinusfirst_DivideGain + $kWhop_lastMinusfirst_DivideGain + $kWhh_lastMinusfirst_DivideGain;


                            // $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);



                            $EC = $energy_money_kWhp + $energy_money_kWhop + $energy_money_kWhh;
                            echo "ค่าไฟฟ้า (บาท) = " . number_format($EC, 2, ".", "") . " <br>";

                            $money_ft = $sum_kwh_DivideGain * $ft;
                            // $EC_Plus_money_ft = number_format($EC + $money_ft,2,".","");
                            $EC_Plus_money_ft = $EC + $money_ft;
                            echo "ค่าไฟฟ้า+ค่า FT (บาท) =" . number_format($EC_Plus_money_ft, 2, ".", "") . "<br>";

                            ////////////เช็คส่วนลด DF////////////
                            $from = \Carbon\Carbon::createFromFormat('Y-m-d', "$start_contract");
                            $to = \Carbon\Carbon::createFromFormat('Y-m-d', "$date_now");

                            // $interval = $from->diff($to);
                            // $diffInYears =  $interval->y;
                            // $diffInMonths = $interval->m;
                            // $diffInDays = $interval->d;
                            // echo "difference " . $diffInYears . " years, " . $diffInMonths . " months, " . $diffInDays . " days <br>";

                            $diff_in_months = $to->diffInMonths($from);
                            echo "diff_in_months = " . $diff_in_months . "<br>";


                            if ($diff_in_months < 61) {
                                $DF = 17;
                            } elseif ($diff_in_months < 121) {
                                $DF = 20;
                            } elseif ($diff_in_months >= 121) {
                                $DF = 25;
                            }

                            // $discount = number_format($EC_Plus_money_ft * ($DF / 100),2,".","");
                            $discount = $EC_Plus_money_ft * ($DF / 100);
                            echo "ส่วนลดค่าไฟฟ้า (บาท) (ส่วนลด $DF%) =  " . number_format($discount, 2, ".", "") . "<br>";

                            // $amount = number_format($EC_Plus_money_ft - $discount,2,".","");
                            $amount = $EC_Plus_money_ft - $discount;
                            echo "รวมเงินค่าไฟฟ้า (บาท) = " . number_format($amount, 2, ".", "") . "<br>";

                            // $vat = number_format($amount * 0.07,2,".","");
                            $vat = $amount * 0.07;
                            echo "ภาษีมูลค่าเพิ่ม 7% (บาท) = " . number_format($vat, 2, ".", "") . "<br>";

                            // $total_amount = number_format($amount + $vat,2,".","");
                            $total_amount = $amount + $vat;
                            echo "รวมเงินที่ต้องชำระ (บาท) = " . number_format($total_amount, 2, ".", "") . "<br>";

                            $Billingmodel = new Billing;

                            $Billingmodel->ft = $ft;
                            $Billingmodel->cp = $cp;
                            $Billingmodel->ch = $ch;
                            $Billingmodel->cop = $cop;
                            $Billingmodel->effective_start = $effective_start;
                            $Billingmodel->effective_end = $effective_end;

                            $Billingmodel->kwhp = $kWhp_lastMinusfirst_DivideGain;
                            $Billingmodel->kwhp_first_ts = $kWhp_first_ts;
                            $Billingmodel->kwhp_first = $kWhp_firstDivideGain;
                            $Billingmodel->kwhp_last_ts = $kWhp_last_ts;
                            $Billingmodel->kwhp_last = $kWhp_lastDivideGain;

                            $Billingmodel->kwhop = $kWhop_lastMinusfirst_DivideGain;
                            $Billingmodel->kwhop_first_ts = $kWhop_first_ts;
                            $Billingmodel->kwhop_first = $kWhop_first_DivideGain;
                            $Billingmodel->kwhop_last_ts = $kWhop_last_ts;
                            $Billingmodel->kwhop_last = $kWhop_last_DivideGain;

                            $Billingmodel->kwhh = $kWhh_lastMinusfirst_DivideGain;
                            $Billingmodel->kwhh_first_ts = $kWhh_first_ts;
                            $Billingmodel->kwhh_first = $kWhh_first_DivideGain;
                            $Billingmodel->kwhh_last_ts = $kWhh_last_ts;
                            $Billingmodel->kwhh_last = $kWhh_last_DivideGain;

                            $Billingmodel->sum_kwh = $sum_kwh_DivideGain;
                            $Billingmodel->energy_money_kwhp = $energy_money_kWhp;
                            $Billingmodel->energy_money_kwhop = $energy_money_kWhop;
                            $Billingmodel->energy_money_kwhh = $energy_money_kWhh;
                            $Billingmodel->ec = $EC;
                            $Billingmodel->money_ft = $money_ft;
                            $Billingmodel->EC_Plus_money_ft = $EC_Plus_money_ft;
                            $Billingmodel->discount = $discount;
                            $Billingmodel->df = $DF;
                            $Billingmodel->amount = $amount;
                            $Billingmodel->vat = $vat;
                            $Billingmodel->total_amount = $total_amount;


                            $month_billing = date("Y-m", $start_billing / 1000);
                            echo $month_billing . "<br>";
                            $Billingmodel->month_billing = $month_billing;


                            $Billingmodel->type = "Auto";
                            $Billingmodel->status = "Darft";


                            //////หา ts ของเดือน////////
                            $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing - 1);
                            $ts_last = $ts_kv_On_Peak_last->ts;
                            echo "ts สุดท้ายของเดือน = " . date("Y-m-d H:i:s", $ts_last / 1000) . "<br>";

                            $date_now2 = $this->ThaiDate($date_now);
                            $pay_date = "20 " . $this->ThaiMonthYear($date_now);
                            $month_billing2 = $this->ThaiMonthYear($month_billing);
                            $date_last = $this->ThaiDate(date("Y-m-d H:i:s", $ts_last / 1000));

                            $pdf = PDF::loadView('admin/billing/billingPDF', compact('kWh_meter_SN', 'contract_companyTH', 'contract_address', 'month_billing2', 'date_now2', 'contract_companyEN', 'type', 'voltage', 'date_last', 'kWhp_lastDivideGain', 'kWhp_firstDivideGain', 'kWhp_lastMinusfirst_DivideGain', 'cp', 'energy_money_kWhp', 'kWhop_last_DivideGain', 'kWhop_first_DivideGain', 'kWhop_lastMinusfirst_DivideGain', 'cop', 'energy_money_kWhop', 'kWhh_last_DivideGain', 'kWhh_first_DivideGain', 'kWhh_lastMinusfirst_DivideGain', 'ch', 'energy_money_kWhh', 'sum_kwh_DivideGain', 'EC', 'ft', 'money_ft', 'EC_Plus_money_ft', 'discount', 'amount', 'vat', 'total_amount', 'pay_date'));
                            $part_pdf = "pdf/" . $month_billing . "_" . strtotime("$date_now_path") . ".pdf";
                            $storage_path_pdf = public_path("$part_pdf");



                            $pdf->save($storage_path_pdf); //save เฉยๆ

                            $Billingmodel->pdf = "$part_pdf";

                            $Billingmodel->save();
                            $this->billingSendEmail($Billingmodel->id);
                            // return true;
                        } else {
                            echo "ไม่มีค่า Ft ที่มีผลบังคับใช้ <br>";
                            $messagefail = "Please check Ft";
                            $this->billingFailSendEmail($messagefail);
                            return false;
                        }
                    } else {
                        echo "billing_date ไม่ตรง date_now <br>";

                        return false;
                    }
                } else {
                    echo "date_now < start_contract ยังไม่ถึงสัญญา<br>";
                    $messagefail = "Please check contract";
                    $this->billingFailSendEmail($messagefail);
                    return false;
                }
            } else {
                echo "No date contract  ====> " . $count_contract;
                $messagefail = "Please check contract";
                $this->billingFailSendEmail($messagefail);
                return false;
            }
        } else {
            echo "เคยทำ billing เดือนนี้แล้ว";
            // $messagefail = "เคยทำ billing เดือนนี้แล้ว";
            // $this->billingFailSendEmail($messagefail);
            return false;
        }
    }

    // public function billingAuto_backup2()
    // {
    //     $key_id_On_Peak = $this->key_id_On_Peak;
    //     $key_id_Off_Peak = $this->key_id_Off_Peak;
    //     $key_id_Holiday = $this->key_id_Holiday;
    //     // $CT_VT_Factor = 1200;


    //     // $date_now = date('Y-m-d');
    //     $date_now = date('Y-05-01');

    //     // $getbilling_date = DB::table('contracts')->orderBy('id', 'desc')->first();
    //     // $billing_date = $getbilling_date->date_billing;
    //     // // $billing_date = date("Y-05-01");

    //     // echo "billing_date " . $billing_date . "<br>";

    //     $count_contract = DB::table('contracts')->orderBy('id', 'desc')->get()->count();
    //     if ($count_contract > 0) {

    //         $date_contract = DB::table('contracts')->orderBy('id', 'desc')->first();
    //         $start_contract = $date_contract->start_contract;
    //         echo "start_contract " . $start_contract . "<br>";

    //         $getbilling_date = $date_contract->date_billing;
    //         if ($getbilling_date < 10) {
    //             $getbilling_date = '0' . $getbilling_date;
    //         }
    //         $billing_date = date("Y-05-$getbilling_date");
    //         echo "billing_date " . $billing_date . "<br>";

    //         if ($date_now >= $start_contract) {
    //             echo "date_now > start_contract อยู่ในสัญญา<br>";

    //             //เช็ควัน billing
    //             if ($date_now == $billing_date) {
    //                 echo "billing_date เท่า date_now <br>";

    //                 $year_now = date('Y', strtotime($date_now));
    //                 $month_now = date('m', strtotime($date_now));

    //                 echo "year_now " . $year_now . "<br>";
    //                 echo "month_now " . $month_now . "<br>";

    //                 ///เช็คเคยทำ billing////////
    //                 $billing_create = DB::table('billings')
    //                     ->whereYear('created_at', $year_now)
    //                     ->whereMonth('created_at',  $month_now)
    //                     ->get()
    //                     ->count();
    //                 echo "billingtest  " . $billing_create . "<br>";
    //                 if ($billing_create < 1) {


    //                     $count_parameters4month = DB::table('parameters')
    //                         // ->whereBetween($date_now, ['effective_start', 'effective_end'])
    //                         ->where('effective_end', '>=', $date_now)
    //                         ->where('effective_start', '<=', $date_now)
    //                         ->orderBy('id', 'desc')
    //                         ->get()
    //                         ->count();
    //                     echo  $count_parameters4month;


    //                     if ($count_parameters4month > 0) {
    //                         echo "Have parameter <br>";
    //                         $Ft_4M_chk = DB::table('parameters')->orderBy('id', 'desc')->first();
    //                         $ft = $Ft_4M_chk->ft;
    //                         $cp = $Ft_4M_chk->cp;
    //                         $ch = $Ft_4M_chk->ch;
    //                         $cop = $Ft_4M_chk->cop;
    //                         $effective_start = $Ft_4M_chk->effective_start;
    //                         $effective_end = $Ft_4M_chk->effective_end;

    //                         $from = \Carbon\Carbon::createFromFormat('Y-m-d', "$start_contract");

    //                         $to = \Carbon\Carbon::createFromFormat('Y-m-d', "$date_now");

    //                         $interval = $from->diff($to);
    //                         $diffInYears =  $interval->y;
    //                         $diffInMonths = $interval->m;
    //                         $diffInDays = $interval->d;
    //                         echo "difference " . $diffInYears . " years, " . $diffInMonths . " months, " . $diffInDays . " days <br>";

    //                         $strtotime_date_now =  strtotime("$date_now") * 1000;


    //                         // $count_parameters = DB::table('parameters')
    //                         //     ->orderBy('id', 'desc')
    //                         //     ->get()
    //                         //     ->count();
    //                         // //เช็ค parameters ว่าง
    //                         // if ($count_parameters > 0) {

    //                         //     echo "Have parameter<br>";

    //                         //     // $Ft_4M_chk = DB::table('parameters')
    //                         //     //     ->orderBy('id', 'desc')
    //                         //     //     ->limit(1)
    //                         //     //     ->get();
    //                         //     // foreach ($Ft_4M_chk as $Ft_4M_chk) {
    //                         //     //     $ft = $Ft_4M_chk->ft;
    //                         //     //     $cp = $Ft_4M_chk->cp;
    //                         //     //     $ch = $Ft_4M_chk->ch;
    //                         //     //     $cop = $Ft_4M_chk->cop;
    //                         //     //     $effective = $Ft_4M_chk->effective;
    //                         //     // }
    //                         //     $Ft_4M_chk = DB::table('parameters')->orderBy('id', 'desc')->first();
    //                         //     $ft = $Ft_4M_chk->ft;
    //                         //     $cp = $Ft_4M_chk->cp;
    //                         //     $ch = $Ft_4M_chk->ch;
    //                         //     $cop = $Ft_4M_chk->cop;
    //                         //     $effective_start = $Ft_4M_chk->effective_start;
    //                         //     $effective_end = $Ft_4M_chk->effective_end;


    //                         //     $befor4month = (new DateTime($date_now))->modify('-4 month')->format('Y-m-d');

    //                         //     echo "effective_start " . $effective_start . "<br>";
    //                         //     echo "befor4month " . $befor4month . "<br>";
    //                         //     //เช็ค parameters มี effective_start น้อยกว่า4เดือน
    //                         //     if ($effective_start > $befor4month) {
    //                         //         // $date_contract = DB::table('contracts')
    //                         //         //     ->orderBy('id', 'desc')
    //                         //         //     ->limit(1)
    //                         //         //     ->get();
    //                         //         // foreach ($date_contract as $date_contract) {
    //                         //         //     $start_contract = $date_contract->start_contract;
    //                         //         // }



    //                         //         $from = \Carbon\Carbon::createFromFormat('Y-m-d', "$start_contract");
    //                         //         // echo "from start_contract" . $from . "<br>";

    //                         //         $to = \Carbon\Carbon::createFromFormat('Y-m-d', "$date_now");
    //                         //         // echo "to date_now " . $to . "<br>";

    //                         //         // $diffInYears = $to->diffInYears($from);
    //                         //         // echo "diffInYears " . $diffInYears . "<br>";

    //                         //         // // $diffInMonths = $to->diffInMonths($from);
    //                         //         // $diffInMonths = $from->diffInMonths($to);
    //                         //         // echo "diffInMonths " . $diffInMonths . "<br>";


    //                         //         // $interval = $to->diff($from);
    //                         //         $interval = $from->diff($to);
    //                         //         $diffInYears =  $interval->y;
    //                         //         $diffInMonths = $interval->m;
    //                         //         $diffInDays = $interval->d;
    //                         //         echo "difference " . $diffInYears . " years, " . $diffInMonths . " months, " . $diffInDays . " days <br>";

    //                         //         $strtotime_date_now =  strtotime("$date_now") * 1000;

    //                         // echo $testdate2."<br>";
    //                         if ($diffInYears < 5) { //เช็ค 1-5ปี

    //                             $DF = 0.17;
    //                             echo "DF = $DF<br>";
    //                             $billing = DB::table('billings')
    //                                 ->get()
    //                                 ->count();

    //                             //เช็ค เคยทำ billing
    //                             // $date_end_billing = (new DateTime($date_now))->modify('-1 day')->format('Y-m-d');
    //                             // echo "date_end_billing ".$date_end_billing. "<br>";

    //                             $end_billing = $strtotime_date_now - 1;
    //                             echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br>";

    //                             if ($billing > 0) {
    //                                 echo "billing > 0 <br>";
    //                                 $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                 /////////////On_Peak//////////
    //                                 $kWhp_first = $billing->kwhp_last_long_v;
    //                                 $kWhp_first_ts = $billing->kwhp_last_ts;
    //                                 echo "kWhp_first = " . $kWhp_first . "<br>";
    //                                 echo "kWhp_first_ts" . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . "<br>";
    //                                 echo "kWhp_first_ts = " . $kWhp_first_ts . "<br>";
    //                                 // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', '62'],
    //                                 //         ['ts', '>', $start_billing_kwhp],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'asc')->first();
    //                                 // $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                 // $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                 // echo "kWhp_first = " . $kWhp_first . "<br>";


    //                                 // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_On_Peak],
    //                                 //         ['ts', '<', $end_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'desc')->first();
    //                                 $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing);


    //                                 $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                 $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                 echo "kWhp_last = " . $kWhp_last . "<br>";
    //                                 echo "kWhp_last" . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . "<br>";
    //                                 echo "kWhp_last_ts = " . $kWhp_last_ts . "<br>";


    //                                 echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                 $kWhp = $kWhp_last - $kWhp_first;
    //                                 // $kWhp = $kWhp * $CT_VT_Factor;
    //                                 $kWhp = $kWhp;
    //                                 echo "kWhp = " . $kWhp . "<br>";


    //                                 ///////////////Off Peak////////////////
    //                                 $kWhop_first = $billing->kwhop_last_long_v;
    //                                 $kWhop_first_ts = $billing->kwhop_last_ts;
    //                                 echo "kWhop_first = " . $kWhop_first . "<br>";
    //                                 echo "kWhop_first_ts = " . $kWhop_first_ts . "<br>";
    //                                 // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', '63'],
    //                                 //         ['ts', '>', $start_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'asc')->first();
    //                                 // $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                 // $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                 // echo "kWhop_first = " . $kWhop_first . "<br>";

    //                                 // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_Off_Peak],
    //                                 //         ['ts', '<', $end_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'desc')->first();
    //                                 $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_Off_Peak, $end_billing);
    //                                 $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                 $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                 echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                 echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                 $kWhop = $kWhop_last - $kWhop_first;
    //                                 // $kWhop = $kWhop * $CT_VT_Factor;
    //                                 $kWhop = $kWhop;
    //                                 echo "kWhop = " . $kWhop . "<br>";


    //                                 ///////////////Holiday////////////////
    //                                 $kWhh_first = $billing->kwhh_last_long_v;
    //                                 $kWhh_first_ts = $billing->kwhh_last_ts;
    //                                 echo "kWhh_first = " . $kWhh_first . "<br>";
    //                                 echo "kWhh_first" . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . "<br>";
    //                                 echo "kWhh_first_ts = " . $kWhh_first_ts . "<br>";
    //                                 // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', '64'],
    //                                 //         ['ts', '>', $start_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'asc')->first();
    //                                 // $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                 // $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                 // echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                 // $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_Holiday],
    //                                 //         ['ts', '<', $end_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'desc')->first();
    //                                 $ts_kv_Holiday_last = $this->ts_kv_last($key_id_Holiday, $end_billing);
    //                                 $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                 $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                 echo "kWhh_last = " . $kWhh_last . "<br>";
    //                                 echo "kWhh_last" . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . "<br>";
    //                                 echo "kWhh_last_ts = " . $kWhh_last_ts . "<br>";

    //                                 echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                 $kWhh = $kWhh_last - $kWhh_first;
    //                                 // $kWhh = $kWhh * $CT_VT_Factor;
    //                                 $kWhh = $kWhh;
    //                                 echo "kWhh = " . $kWhh . "<br>";




    //                                 $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                 $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                 $EPP = (1 - $DF) * ($EC + $FC);

    //                                 echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                 echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                 echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                 echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                 echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                 echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                 echo "EPP = " . $EPP . "<br>";
    //                             } else {
    //                                 echo "billing < 0 <br>";
    //                                 // $start_billing = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                 $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                 $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                 // $end_billing = $strtotime_date_now - 1;
    //                                 /////////////On_Peak//////////
    //                                 echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

    //                                 echo "start_billing" . $start_billing . "<br>";

    //                                 // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_On_Peak],
    //                                 //         ['ts', '>', $start_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'asc')->first();
    //                                 $ts_kv_On_Peak_first = $this->ts_kv_first($key_id_On_Peak, $start_billing);

    //                                 $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                 $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                 echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                 // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_On_Peak],
    //                                 //         ['ts', '<', $end_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'desc')->first();
    //                                 $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing);
    //                                 $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                 $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                 echo "kWhp_last = " . $kWhp_last . "<br>";


    //                                 echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                 $kWhp = $kWhp_last - $kWhp_first;
    //                                 // $kWhp = $kWhp * $CT_VT_Factor;
    //                                 $kWhp = $kWhp;
    //                                 echo "kWhp = " . $kWhp . "<br>";


    //                                 ///////////////Off Peak////////////////
    //                                 // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_Off_Peak],
    //                                 //         ['ts', '>', $start_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'asc')->first();
    //                                 $ts_kv_Off_Peak_first = $this->ts_kv_first($key_id_Off_Peak, $start_billing);

    //                                 $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                 $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                 echo "kWhop_first = " . $kWhop_first . "<br>";


    //                                 // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_Off_Peak],
    //                                 //         ['ts', '<', $end_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'desc')->first();
    //                                 $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_Off_Peak, $end_billing);

    //                                 $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                 $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                 echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                 echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                 $kWhop = $kWhop_last - $kWhop_first;
    //                                 // $kWhop = $kWhop * $CT_VT_Factor;
    //                                 $kWhop = $kWhop;
    //                                 echo "kWhop = " . $kWhop . "<br>";


    //                                 ///////////////Holiday////////////////
    //                                 // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_Holiday],
    //                                 //         ['ts', '>', $start_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'asc')->first();
    //                                 $ts_kv_Holiday_first = $this->ts_kv_first($key_id_Holiday, $start_billing);

    //                                 $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                 $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                 echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                 // $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                 //     ->where([
    //                                 //         ['key', '=', $key_id_Holiday],
    //                                 //         ['ts', '<', $end_billing],
    //                                 //     ])
    //                                 //     ->orderBy('ts', 'desc')->first();
    //                                 $ts_kv_Holiday_last = $this->ts_kv_last($key_id_Holiday, $end_billing);

    //                                 $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                 $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                 echo "kWhh_last = " . $kWhh_last . "<br>";

    //                                 echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                 $kWhh = $kWhh_last - $kWhh_first;
    //                                 // $kWhh = $kWhh * $CT_VT_Factor;
    //                                 $kWhh = $kWhh;
    //                                 echo "kWhh = " . $kWhh . "<br>";




    //                                 $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                 $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                 $EPP = (1 - $DF) * ($EC + $FC);

    //                                 echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                 echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                 echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                 echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                 echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                 echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                 echo "EPP = " . $EPP . "<br>";
    //                             }
    //                         } elseif ($diffInYears < 10) { //เช็ค 6-10ปี
    //                             echo "diffInYears < 10  <br>";

    //                             if ($diffInYears == 5 && $diffInMonths < 1) { //เช็ค คร่อมเดือน
    //                                 echo "diffInYears == 5 && diffInMonths < 1 <br>";
    //                                 $DF1 = 0.17;
    //                                 $DF2 = 0.20;


    //                                 $billing = DB::table('billings')
    //                                     ->get()
    //                                     ->count();
    //                                 if ($billing > 0) {
    //                                     echo "diffInYears == 5 && diffInMonths < 1 && billing > 0 <br>";
    //                                     $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                     $end_billing = (new DateTime($start_contract))->modify('+5 Year')->format('Y-m-d');
    //                                     $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                     echo "end_billing1 " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                     /////////////On_Peak//////////
    //                                     /////////////On_Peak1//////////
    //                                     ////kWhp_first1//
    //                                     $kWhp_first1 = $billing->kwhp_last_long_v;
    //                                     $kWhp_first_ts1 = $billing->kwhp_last_ts;
    //                                     echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                     echo "kWhp_first1 = " . date("Y-m-d H:i:s", $kWhp_first_ts1 / 1000) . "<br>";
    //                                     echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";

    //                                     $kWhp_first = $kWhp_first1;
    //                                     $kWhp_first_ts = $kWhp_first_ts1;

    //                                     ////kWhp_last1//
    //                                     $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '<', $end_billing_ts1],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last1 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts1);

    //                                     $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                     $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;



    //                                     echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                     echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                     ////kWhp1//
    //                                     echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                     $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                     echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                     /////////////On_Peak2//////////
    //                                     ////kWhp_first2//
    //                                     $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                     // $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first2 = $this->ts_kv_first($key_id_On_Peak, $start_billing_ts2);

    //                                     $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                     $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                     echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                     echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                     ////kWhp_last2//
    //                                     $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                     $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '<', $end_billing_ts2],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last2 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts2);

    //                                     $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                     $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;
    //                                     echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                     echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                     $kWhp_last = $kWhp_last2;
    //                                     $kWhp_last_ts = $kWhp_last_ts2;

    //                                     ////kWhp2//
    //                                     echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                     $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                     echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                     ///////////// kWhp//////////
    //                                     $kWhp = $kWhp1 + $kWhp2;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = kWhp1 + kWhp2 <br>";
    //                                     echo "kWhp = $kWhp <br>";




    //                                     ///////////// Off Peak//////////
    //                                     ///////////// Off Peak1//////////
    //                                     ///////////// kWhop_first1//////////
    //                                     $kWhop_first1 = $billing->kwhop_last_long_v;
    //                                     $kWhop_first_ts1 = $billing->kwhop_last_ts;
    //                                     echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                     echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                     $kWhop_first = $kWhop_first1;
    //                                     $kWhop_first_ts = $kWhop_first_ts1;

    //                                     ///////////// kWhop_last1//////////

    //                                     // $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last1 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts1);

    //                                     $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                     $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;

    //                                     echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                     echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                     ///////////// kWhop1//////////
    //                                     echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                     $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                     echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                     /////////////Off_Peak2//////////
    //                                     ////start ts2//
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_first2//////////
    //                                     // $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first2 = $this->ts_kv_first($key_id_Off_Peak, $start_billing_ts2);

    //                                     $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                     $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                     echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                     echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                     ////end ts2//
    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_last2//////////
    //                                     // $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last2 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts2);

    //                                     $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                     $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                     echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                     echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                     $kWhop_last = $kWhop_last2;
    //                                     $kWhop_last_ts = $kWhop_last_ts2;

    //                                     /////////////kWhop2//////////
    //                                     echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                     $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                     echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                     ///////////// kWhop//////////
    //                                     $kWhop = $kWhop1 + $kWhop2;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = kWhop1 + kWhop2 <br>";
    //                                     echo "kWhop = $kWhop <br>";





    //                                     ///////////// Holiday//////////
    //                                     ///////////// Holiday1//////////

    //                                     ///////////// kWhh_first1//////////
    //                                     $kWhh_first1 = $billing->kwhh_last_long_v;
    //                                     $kWhh_first_ts1 = $billing->kwhh_last_ts;
    //                                     echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                     echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                     $kWhh_first = $kWhh_first1;
    //                                     $kWhh_first_ts = $kWhh_first_ts1;

    //                                     ///////////// kWhh_last1//////////
    //                                     // $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();

    //                                     $ts_kv_Holiday_last1 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts1);

    //                                     $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                     $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                     echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                     echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                     ///////////// kWhh1//////////
    //                                     echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                     $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                     echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                     /////////////Holiday2//////////
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                     /////////////kWhh_first2//////////
    //                                     // $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();

    //                                     $ts_kv_Holiday_first2 = $this->ts_kv_first($key_id_Holiday, $start_billing_ts2);

    //                                     $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                     $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                     echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                     echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhh_last2//////////
    //                                     // $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last2 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts2);

    //                                     $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                     $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                     echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                     echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                     $kWhh_last = $kWhh_last2;
    //                                     $kWhh_last_ts = $kWhh_last_ts2;

    //                                     /////////////kWhh2//////////
    //                                     echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                     $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                     echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                     ///////////// kWhh /////////
    //                                     $kWhh = $kWhh1 + $kWhh2;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = kWhh1 + kWhh2 <br>";
    //                                     echo "kWhh = $kWhh <br>";


    //                                     $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                     $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                     $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                     echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                     echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                     echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                     echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                     echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                     echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                     $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                     $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                     $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                     echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                     echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                     echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                     echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                     echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                     echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                     $EC = $EC1 + $EC2;
    //                                     $FC = $FC1 + $FC2;
    //                                     $EPP = $EPP1 + $EPP2;
    //                                     echo "EC = " . $EC . "<br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 } else {

    //                                     echo "diffInYears > 5 && diffInMonths > 1 && billing < 0 <br>";


    //                                     // $start_billing_ts1 = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                     $date_start_billing_ts1 = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                     $start_billing_ts1 = strtotime("$date_start_billing_ts1") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                     echo "date_start_billing_ts1" . $date_start_billing_ts1 . "<br>";
    //                                     echo "start_billing_ts1 " . $start_billing_ts1 . "<br>";

    //                                     $end_billing = (new DateTime($start_contract))->modify('+5 Year')->format('Y-m-d');
    //                                     $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                     echo "end_billing1 " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                     $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";


    //                                     /////////////On_Peak//////////
    //                                     /////////////On_Peak1//////////
    //                                     ////kWhp_first1//
    //                                     // $ts_kv_On_Peak_first1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first1 = $this->ts_kv_first($key_id_On_Peak, $start_billing_ts1);

    //                                     $kWhp_first1 = $ts_kv_On_Peak_first1->long_v;
    //                                     $kWhp_first_ts1 = $ts_kv_On_Peak_first1->ts;

    //                                     $kWhp_first = $kWhp_first1;
    //                                     $kWhp_first_ts = $kWhp_first_ts1;



    //                                     echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                     echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";
    //                                     ////kWhp_last1//
    //                                     $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '<', $end_billing_ts1],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last1 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts1);

    //                                     $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                     $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;

    //                                     echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                     echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                     ////kWhp1//
    //                                     echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                     $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                     echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                     /////////////On_Peak2//////////
    //                                     ////kWhp_first2//

    //                                     $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '>', $start_billing_ts2],
    //                                         ])
    //                                         ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first2 = $this->ts_kv_first($key_id_On_Peak, $start_billing_ts2);

    //                                     $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                     $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                     echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                     echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                     ////kWhp_last2//
    //                                     $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                     // $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();

    //                                     $ts_kv_On_Peak_last2 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts2);

    //                                     $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                     $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;

    //                                     $kWhp_last = $kWhp_last2;
    //                                     $kWhp_last_ts = $kWhp_last_ts2;

    //                                     echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                     echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                     ////kWhp2//
    //                                     echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                     $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                     echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                     ///////////// kWhp//////////
    //                                     $kWhp = $kWhp1 + $kWhp2;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = kWhp1 + kWhp2 <br>";
    //                                     echo "kWhp = $kWhp <br>";

    //                                     ///////////// Off Peak//////////
    //                                     ///////////// Off Peak1//////////
    //                                     ///////////// kWhop_first1//////////
    //                                     // $ts_kv_Off_Peak_first1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first1 = $this->ts_kv_first($key_id_Off_Peak, $start_billing_ts1);

    //                                     $kWhop_first1 = $ts_kv_Off_Peak_first1->long_v;
    //                                     $kWhop_first_ts1 = $ts_kv_Off_Peak_first1->ts;
    //                                     echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                     echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                     $kWhop_first = $kWhop_first1;
    //                                     $kWhop_first_ts = $kWhop_first_ts1;

    //                                     ///////////// kWhop_last1//////////

    //                                     // $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last1 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts1);

    //                                     $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                     $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;



    //                                     echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                     echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                     ///////////// kWhop1//////////
    //                                     echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                     $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                     echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                     /////////////Off_Peak2//////////
    //                                     ////start ts2//
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_first2//////////
    //                                     // $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first2 = $this->ts_kv_first($key_id_Off_Peak, $start_billing_ts2);

    //                                     $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                     $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                     echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                     echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_last2//////////
    //                                     // $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last2 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts2);

    //                                     $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                     $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                     echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                     echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                     $kWhop_last = $kWhop_last2;
    //                                     $kWhop_last_ts = $kWhop_last_ts2;

    //                                     /////////////kWhop2//////////
    //                                     echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                     $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                     echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                     ///////////// kWhop//////////
    //                                     $kWhop = $kWhop1 + $kWhop2;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = kWhop1 + kWhop2 <br>";
    //                                     echo "kWhop = $kWhop <br>";

    //                                     ///////////// Holiday//////////
    //                                     ///////////// Holiday1//////////

    //                                     ///////////// kWhh_first1//////////
    //                                     // $ts_kv_Holiday_first1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first1 = $this->ts_kv_first($key_id_Holiday, $start_billing_ts1);

    //                                     $kWhh_first1 = $ts_kv_Holiday_first1->long_v;
    //                                     $kWhh_first_ts1 = $ts_kv_Holiday_first1->ts;

    //                                     echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                     echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                     $kWhh_first = $kWhh_first1;
    //                                     $kWhh_first_ts = $kWhh_first_ts1;

    //                                     ///////////// kWhh_last1//////////
    //                                     // $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last1 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts1);

    //                                     $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                     $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                     echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                     echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                     ///////////// kWhh1//////////
    //                                     echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                     $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                     echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                     /////////////Holiday2//////////
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                     /////////////kWhh_first2//////////
    //                                     // $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first2 = $this->ts_kv_first($key_id_Holiday, $start_billing_ts2);

    //                                     $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                     $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                     echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                     echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhh_last2//////////
    //                                     // $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last2 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts2);

    //                                     $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                     $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                     echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                     echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                     $kWhh_last = $kWhh_last2;
    //                                     $kWhh_last_ts = $kWhh_last_ts2;

    //                                     /////////////kWhh2//////////
    //                                     echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                     $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                     echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                     ///////////// kWhh /////////
    //                                     $kWhh = $kWhh1 + $kWhh2;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = kWhh1 + kWhh2 <br>";
    //                                     echo "kWhh = $kWhh <br>";


    //                                     $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                     $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                     $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                     echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                     echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                     echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                     echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                     echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                     echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                     $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                     $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                     $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                     echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                     echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                     echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                     echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                     echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                     echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                     $EC = $EC1 + $EC2;
    //                                     $FC = $FC1 + $FC2;
    //                                     $EPP = $EPP1 + $EPP2;
    //                                     echo "EC = " . $EC . "<br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 }
    //                             } else {
    //                                 $DF = 0.20;
    //                                 echo "diffInYears > 5 && diffInMonths > 1 <br>";

    //                                 $billing = DB::table('billings')
    //                                     ->get()
    //                                     ->count();

    //                                 //เช็ค เคยทำ billing
    //                                 // $date_end_billing = (new DateTime($date_now))->modify('-1 day')->format('Y-m-d');
    //                                 // echo "date_end_billing ".$date_end_billing. "<br>";

    //                                 $end_billing = $strtotime_date_now - 1;
    //                                 echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br>";

    //                                 if ($billing > 0) {
    //                                     echo "billing > 0 <br>";
    //                                     $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                     /////////////On_Peak//////////
    //                                     $kWhp_first = $billing->kwhp_last_long_v;
    //                                     $kWhp_first_ts = $billing->kwhp_last_ts;
    //                                     echo "kWhp_first = " . $kWhp_first . "<br>";
    //                                     echo "kWhp_first_ts" . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . "<br>";
    //                                     echo "kWhp_first_ts = " . $kWhp_first_ts . "<br>";
    //                                     // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '62'],
    //                                     //         ['ts', '>', $start_billing_kwhp],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                     // $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                     // echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                     // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing);

    //                                     $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                     echo "kWhp_last = " . $kWhp_last . "<br>";
    //                                     echo "kWhp_last" . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . "<br>";
    //                                     echo "kWhp_last_ts = " . $kWhp_last_ts . "<br>";


    //                                     echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                     $kWhp = $kWhp_last - $kWhp_first;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = " . $kWhp . "<br>";


    //                                     ///////////////Off Peak////////////////
    //                                     $kWhop_first = $billing->kwhop_last_long_v;
    //                                     $kWhop_first_ts = $billing->kwhop_last_ts;
    //                                     echo "kWhop_first = " . $kWhop_first . "<br>";
    //                                     echo "kWhop_first" . date("Y-m-d H:i:s", $kWhop_first_ts / 1000) . "<br>";
    //                                     echo "kWhop_first_ts = " . $kWhop_first_ts . "<br>";
    //                                     // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '63'],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                     // $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                     // echo "kWhop_first = " . $kWhop_first . "<br>";

    //                                     // $ts_kv_Off_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last = $this->ts_kv_last($key_id_Off_Peak, $end_billing);

    //                                     $kWhop_last = $ts_kv_Off_Peak_last->long_v;
    //                                     $kWhop_last_ts = $ts_kv_Off_Peak_last->ts;

    //                                     echo "kWhop_last = " . $kWhop_last . "<br>";
    //                                     echo "kWhop_last_ts" . date("Y-m-d H:i:s", $kWhop_last_ts / 1000) . "<br>";
    //                                     echo "kWhop_last_ts = " . $kWhop_last_ts . "<br>";



    //                                     echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                     $kWhop = $kWhop_last - $kWhop_first;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = " . $kWhop . "<br>";


    //                                     ///////////////Holiday////////////////
    //                                     $kWhh_first = $billing->kwhh_last_long_v;
    //                                     $kWhh_first_ts = $billing->kwhh_last_ts;
    //                                     echo "kWhh_first = " . $kWhh_first . "<br>";
    //                                     echo "kWhh_first" . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . "<br>";
    //                                     echo "kWhh_first_ts = " . $kWhh_first_ts . "<br>";
    //                                     // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '64'],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                     // $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                     // echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                     // $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last = $this->ts_kv_last($key_id_Holiday, $end_billing);

    //                                     $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                     $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                     echo "kWhh_last = " . $kWhh_last . "<br>";
    //                                     echo "kWhh_last" . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . "<br>";
    //                                     echo "kWhh_last_ts = " . $kWhh_last_ts . "<br>";

    //                                     echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                     $kWhh = $kWhh_last - $kWhh_first;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = " . $kWhh . "<br>";




    //                                     $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                     $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                     $EPP = (1 - $DF) * ($EC + $FC);

    //                                     echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                     echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                     echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                     echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                     echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                     echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 } else {
    //                                     echo "billing < 0 <br>";
    //                                     // $start_billing = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                     $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                     $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                     // $end_billing = $strtotime_date_now - 1;
    //                                     /////////////On_Peak//////////
    //                                     echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

    //                                     echo "start_billing" . $start_billing . "<br>";

    //                                     // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first = $this->ts_kv_first($key_id_On_Peak, $start_billing);

    //                                     $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                     $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                     echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                     // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing);

    //                                     $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                     echo "kWhp_last = " . $kWhp_last . "<br>";


    //                                     echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                     $kWhp = $kWhp_last - $kWhp_first;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = " . $kWhp . "<br>";


    //                                     ///////////////Off Peak////////////////
    //                                     // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first = $this->ts_kv_first($key_id_Off_Peak, $start_billing);

    //                                     $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                     $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                     echo "kWhop_first = " . $kWhop_first . "<br>";


    //                                     // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_Off_Peak, $end_billing);

    //                                     $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                     echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                     echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                     $kWhop = $kWhop_last - $kWhop_first;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = " . $kWhop . "<br>";


    //                                     ///////////////Holiday////////////////
    //                                     // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first = $this->ts_kv_first($key_id_Holiday, $start_billing);

    //                                     $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                     $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                     echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                     // $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last = $this->ts_kv_last($key_id_Holiday, $end_billing);

    //                                     $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                     $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                     echo "kWhh_last = " . $kWhh_last . "<br>";

    //                                     echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                     $kWhh = $kWhh_last - $kWhh_first;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = " . $kWhh . "<br>";




    //                                     $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                     $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                     $EPP = (1 - $DF) * ($EC + $FC);

    //                                     echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                     echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                     echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                     echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                     echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                     echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 }
    //                             }
    //                         } elseif ($diffInYears < 15) { //เช็ค 11-15ปี
    //                             echo "diffInYears < 15  <br>";

    //                             if ($diffInYears == 10 && $diffInMonths < 1) { //เช็ค คร่อมเดือน
    //                                 echo "diffInYears == 10 && diffInMonths < 1 <br>";
    //                                 $DF1 = 0.20;
    //                                 $DF2 = 0.25;
    //                                 // $DF3 = 0.25;

    //                                 $billing = DB::table('billings')
    //                                     ->get()
    //                                     ->count();
    //                                 if ($billing > 0) {
    //                                     echo "diffInYears == 10 && diffInMonths < 1 && billing > 0 <br>";
    //                                     $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                     $end_billing = (new DateTime($start_contract))->modify('+10 Year')->format('Y-m-d');
    //                                     $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                     echo "end_billing1 " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                     /////////////On_Peak//////////
    //                                     /////////////On_Peak1//////////
    //                                     ////kWhp_first1//
    //                                     $kWhp_first1 = $billing->kwhp_last_long_v;
    //                                     $kWhp_first_ts1 = $billing->kwhp_last_ts;
    //                                     echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                     echo "kWhp_first1 = " . date("Y-m-d H:i:s", $kWhp_first_ts1 / 1000) . "<br>";
    //                                     echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";

    //                                     $kWhp_first = $kWhp_first1;
    //                                     $kWhp_first_ts = $kWhp_first_ts1;

    //                                     ////kWhp_last1//
    //                                     // $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last1 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts1);

    //                                     $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                     $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;



    //                                     echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                     echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                     ////kWhp1//
    //                                     echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                     $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                     echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                     /////////////On_Peak2//////////
    //                                     ////kWhp_first2//
    //                                     $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                     // $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first2 = $this->ts_kv_first($key_id_On_Peak, $start_billing_ts2);

    //                                     $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                     $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                     echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                     echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                     ////kWhp_last2//
    //                                     $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                     // $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last2 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts2);

    //                                     $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                     $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;
    //                                     echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                     echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                     $kWhp_last = $kWhp_last2;
    //                                     $kWhp_last_ts = $kWhp_last_ts2;

    //                                     ////kWhp2//
    //                                     echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                     $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                     echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                     ///////////// kWhp//////////
    //                                     $kWhp = $kWhp1 + $kWhp2;
    //                                     echo "kWhp = kWhp1 + kWhp2 <br>";
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = $kWhp <br>";




    //                                     ///////////// Off Peak//////////
    //                                     ///////////// Off Peak1//////////
    //                                     ///////////// kWhop_first1//////////
    //                                     $kWhop_first1 = $billing->kwhop_last_long_v;
    //                                     $kWhop_first_ts1 = $billing->kwhop_last_ts;
    //                                     echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                     echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                     $kWhop_first = $kWhop_first1;
    //                                     $kWhop_first_ts = $kWhop_first_ts1;

    //                                     ///////////// kWhop_last1//////////

    //                                     // $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last1 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts1);

    //                                     $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                     $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;

    //                                     echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                     echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                     ///////////// kWhop1//////////
    //                                     echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                     $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                     echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                     /////////////Off_Peak2//////////
    //                                     ////start ts2//
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_first2//////////
    //                                     // $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first2 = $this->ts_kv_first($key_id_Off_Peak, $start_billing_ts2);

    //                                     $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                     $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                     echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                     echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                     ////end ts2//
    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_last2//////////
    //                                     // $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last2 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts2);

    //                                     $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                     $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                     echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                     echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                     $kWhop_last = $kWhop_last2;
    //                                     $kWhop_last_ts = $kWhop_last_ts2;

    //                                     /////////////kWhop2//////////
    //                                     echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                     $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                     echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                     ///////////// kWhop//////////
    //                                     $kWhop = $kWhop1 + $kWhop2;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = kWhop1 + kWhop1 <br>";
    //                                     echo "kWhop = $kWhop <br>";




    //                                     ///////////// Holiday//////////
    //                                     ///////////// Holiday1//////////

    //                                     ///////////// kWhh_first1//////////
    //                                     $kWhh_first1 = $billing->kwhh_last_long_v;
    //                                     $kWhh_first_ts1 = $billing->kwhh_last_ts;
    //                                     echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                     echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                     $kWhh_first = $kWhh_first1;
    //                                     $kWhh_first_ts = $kWhh_first_ts1;

    //                                     ///////////// kWhh_last1//////////
    //                                     // $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last1 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts1);

    //                                     $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                     $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                     echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                     echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                     ///////////// kWhh1//////////
    //                                     echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                     $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                     echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                     /////////////Holiday2//////////
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                     /////////////kWhh_first2//////////
    //                                     // $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first2 = $this->ts_kv_first($key_id_Holiday, $start_billing_ts2);

    //                                     $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                     $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                     echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                     echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhh_last2//////////
    //                                     // $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last2 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts2);

    //                                     $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                     $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                     echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                     echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                     $kWhh_last = $kWhh_last2;
    //                                     $kWhh_last_ts = $kWhh_last_ts2;

    //                                     /////////////kWhh2//////////
    //                                     echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                     $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                     echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                     ///////////// kWhh /////////
    //                                     $kWhh = $kWhh1 + $kWhh2;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = kWhh1 + kWhh1 <br>";
    //                                     echo "kWhh = $kWhh <br>";


    //                                     $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                     $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                     $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                     echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                     echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                     echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                     echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                     echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                     echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                     $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                     $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                     $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                     echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                     echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                     echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                     echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                     echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                     echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                     $EC = $EC1 + $EC2;
    //                                     $FC = $FC1 + $FC2;
    //                                     $EPP = $EPP1 + $EPP2;
    //                                     echo "EC = " . $EC . "<br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 } else {

    //                                     echo "diffInYears > 10 && diffInMonths > 1 && billing < 0 <br>";


    //                                     // $start_billing_ts1 = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                     $date_start_billing_ts1 = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                     $start_billing_ts1 = strtotime("$date_start_billing_ts1") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                     echo "date_start_billing_ts1 = " . $date_start_billing_ts1 . "<br>";
    //                                     echo "start_billing_ts1 = " . $start_billing_ts1 . "<br>";

    //                                     $end_billing = (new DateTime($start_contract))->modify('+10 Year')->format('Y-m-d');
    //                                     $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                     echo "end_billing1 = " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                     $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";


    //                                     /////////////On_Peak//////////
    //                                     /////////////On_Peak1//////////
    //                                     ////kWhp_first1//
    //                                     // $ts_kv_On_Peak_first1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first1 = $this->ts_kv_first($key_id_On_Peak, $start_billing_ts1);

    //                                     $kWhp_first1 = $ts_kv_On_Peak_first1->long_v;
    //                                     $kWhp_first_ts1 = $ts_kv_On_Peak_first1->ts;

    //                                     $kWhp_first = $kWhp_first1;
    //                                     $kWhp_first_ts = $kWhp_first_ts1;



    //                                     echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                     echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";
    //                                     ////kWhp_last1//
    //                                     // $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=',  $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last1 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts1);

    //                                     $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                     $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;

    //                                     echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                     echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                     ////kWhp1//
    //                                     echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                     $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                     echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                     /////////////On_Peak2//////////
    //                                     ////kWhp_first2//

    //                                     // $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=',  $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first2 = $this->ts_kv_first($key_id_On_Peak, $start_billing_ts2);

    //                                     $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                     $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                     echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                     echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                     ////kWhp_last2//
    //                                     $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                     // $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last2 = $this->ts_kv_last($key_id_On_Peak, $end_billing_ts2);

    //                                     $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                     $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;

    //                                     $kWhp_last = $kWhp_last2;
    //                                     $kWhp_last_ts = $kWhp_last_ts2;

    //                                     echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                     echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                     ////kWhp2//
    //                                     echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                     $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                     echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                     ///////////// kWhp//////////
    //                                     $kWhp = $kWhp1 + $kWhp2;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = kWhp1 + kWhp1 <br>";
    //                                     echo "kWhp = $kWhp <br>";

    //                                     ///////////// Off Peak//////////
    //                                     ///////////// Off Peak1//////////
    //                                     ///////////// kWhop_first1//////////
    //                                     // $ts_kv_Off_Peak_first1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first1 = $this->ts_kv_first($key_id_Off_Peak, $start_billing_ts1);

    //                                     $kWhop_first1 = $ts_kv_Off_Peak_first1->long_v;
    //                                     $kWhop_first_ts1 = $ts_kv_Off_Peak_first1->ts;
    //                                     echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                     echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                     $kWhop_first = $kWhop_first1;
    //                                     $kWhop_first_ts = $kWhop_first_ts1;

    //                                     ///////////// kWhop_last1//////////

    //                                     // $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last1 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts1);

    //                                     $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                     $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;



    //                                     echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                     echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                     ///////////// kWhop1//////////
    //                                     echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                     $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                     echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                     /////////////Off_Peak2//////////
    //                                     ////start ts2//
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_first2//////////
    //                                     // $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first2 = $this->ts_kv_first($key_id_Off_Peak, $start_billing_ts2);

    //                                     $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                     $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                     echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                     echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhop_last2//////////
    //                                     // $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last2 = $this->ts_kv_last($key_id_Off_Peak, $end_billing_ts2);

    //                                     $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                     $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                     echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                     echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                     $kWhop_last = $kWhop_last2;
    //                                     $kWhop_last_ts = $kWhop_last_ts2;

    //                                     /////////////kWhop2//////////
    //                                     echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                     $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                     echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                     ///////////// kWhop//////////
    //                                     $kWhop = $kWhop1 + $kWhop2;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = kWhop1 + kWhop1 <br>";
    //                                     echo "kWhop = $kWhop <br>";

    //                                     ///////////// Holiday//////////
    //                                     ///////////// Holiday1//////////

    //                                     ///////////// kWhh_first1//////////
    //                                     // $ts_kv_Holiday_first1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first1 = $this->ts_kv_first($key_id_Holiday, $start_billing_ts1);

    //                                     $kWhh_first1 = $ts_kv_Holiday_first1->long_v;
    //                                     $kWhh_first_ts1 = $ts_kv_Holiday_first1->ts;

    //                                     echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                     echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                     $kWhh_first = $kWhh_first1;
    //                                     $kWhh_first_ts = $kWhh_first_ts1;

    //                                     ///////////// kWhh_last1//////////
    //                                     // $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts1],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last1 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts1);

    //                                     $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                     $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                     echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                     echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                     ///////////// kWhh1//////////
    //                                     echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                     $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                     echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                     /////////////Holiday2//////////
    //                                     // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                     // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                     /////////////kWhh_first2//////////
    //                                     // $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first2 = $this->ts_kv_first($key_id_Holiday, $start_billing_ts2);

    //                                     $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                     $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                     echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                     echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                     // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                     // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                     /////////////kWhh_last2//////////
    //                                     // $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing_ts2],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last2 = $this->ts_kv_last($key_id_Holiday, $end_billing_ts2);

    //                                     $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                     $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                     echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                     echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                     echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                     $kWhh_last = $kWhh_last2;
    //                                     $kWhh_last_ts = $kWhh_last_ts2;

    //                                     /////////////kWhh2//////////
    //                                     echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                     $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                     echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                     ///////////// kWhh /////////
    //                                     $kWhh = $kWhh1 + $kWhh2;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = kWhh1 + kWhh1 <br>";
    //                                     echo "kWhh = $kWhh <br>";


    //                                     $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                     $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                     $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                     echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                     echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                     echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                     echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                     echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                     echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                     $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                     $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                     $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                     echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                     echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                     echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                     echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                     echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                     echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                     $EC = $EC1 + $EC2;
    //                                     $FC = $FC1 + $FC2;
    //                                     $EPP = $EPP1 + $EPP2;
    //                                     echo "EC = " . $EC . "<br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 }
    //                             } else {
    //                                 $DF = 0.25;
    //                                 echo "diffInYears > 10 && diffInMonths > 1 <br>";

    //                                 $billing = DB::table('billings')
    //                                     ->get()
    //                                     ->count();

    //                                 //เช็ค เคยทำ billing
    //                                 // $date_end_billing = (new DateTime($date_now))->modify('-1 day')->format('Y-m-d');
    //                                 // echo "date_end_billing ".$date_end_billing. "<br>";

    //                                 $end_billing = $strtotime_date_now - 1;
    //                                 echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br>";

    //                                 if ($billing > 0) {
    //                                     echo "billing > 0 <br>";
    //                                     $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                     /////////////On_Peak//////////
    //                                     $kWhp_first = $billing->kwhp_last_long_v;
    //                                     $kWhp_first_ts = $billing->kwhp_last_ts;
    //                                     echo "kWhp_first = " . $kWhp_first . "<br>";
    //                                     echo "kWhp_first_ts" . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . "<br>";
    //                                     echo "kWhp_first_ts = " . $kWhp_first_ts . "<br>";
    //                                     // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '62'],
    //                                     //         ['ts', '>', $start_billing_kwhp],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                     // $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                     // echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                     // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing);

    //                                     $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                     echo "kWhp_last = " . $kWhp_last . "<br>";
    //                                     echo "kWhp_last" . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . "<br>";
    //                                     echo "kWhp_last_ts = " . $kWhp_last_ts . "<br>";


    //                                     echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                     $kWhp = $kWhp_last - $kWhp_first;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = " . $kWhp . "<br>";


    //                                     ///////////////Off Peak////////////////
    //                                     $kWhop_first = $billing->kwhop_last_long_v;
    //                                     $kWhop_first_ts = $billing->kwhop_last_ts;
    //                                     echo "kWhop_first = " . $kWhop_first . "<br>";
    //                                     echo "kWhop_first" . date("Y-m-d H:i:s", $kWhop_first_ts / 1000) . "<br>";
    //                                     echo "kWhop_first_ts = " . $kWhop_first_ts . "<br>";
    //                                     // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '63'],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                     // $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                     // echo "kWhop_first = " . $kWhop_first . "<br>";

    //                                     // $ts_kv_Off_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last = $this->ts_kv_last($key_id_Off_Peak, $end_billing);

    //                                     $kWhop_last = $ts_kv_Off_Peak_last->long_v;
    //                                     $kWhop_last_ts = $ts_kv_Off_Peak_last->ts;

    //                                     echo "kWhop_last = " . $kWhop_last . "<br>";
    //                                     echo "kWhop_last_ts" . date("Y-m-d H:i:s", $kWhop_last_ts / 1000) . "<br>";
    //                                     echo "kWhop_last_ts = " . $kWhop_last_ts . "<br>";



    //                                     echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                     $kWhop = $kWhop_last - $kWhop_first;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = " . $kWhop . "<br>";


    //                                     ///////////////Holiday////////////////
    //                                     $kWhh_first = $billing->kwhh_last_long_v;
    //                                     $kWhh_first_ts = $billing->kwhh_last_ts;
    //                                     echo "kWhh_first = " . $kWhh_first . "<br>";
    //                                     echo "kWhh_first" . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . "<br>";
    //                                     echo "kWhh_first_ts = " . $kWhh_first_ts . "<br>";
    //                                     // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '64'],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                     // $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                     // echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                     // $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last = $this->ts_kv_last($key_id_Holiday, $end_billing);

    //                                     $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                     $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                     echo "kWhh_last = " . $kWhh_last . "<br>";
    //                                     echo "kWhh_last" . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . "<br>";
    //                                     echo "kWhh_last_ts = " . $kWhh_last_ts . "<br>";

    //                                     echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                     $kWhh = $kWhh_last - $kWhh_first;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = " . $kWhh . "<br>";




    //                                     $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                     $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                     $EPP = (1 - $DF) * ($EC + $FC);

    //                                     echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                     echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                     echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                     echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                     echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                     echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 } else {
    //                                     echo "billing < 0 <br>";
    //                                     // $start_billing = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                     $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                     $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                     // $end_billing = $strtotime_date_now - 1;
    //                                     /////////////On_Peak//////////
    //                                     echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

    //                                     echo "start_billing" . $start_billing . "<br>";

    //                                     // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_On_Peak_first = $this->ts_kv_first($key_id_On_Peak, $start_billing);

    //                                     $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                     $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                     echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                     // $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_On_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing);

    //                                     $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                     echo "kWhp_last = " . $kWhp_last . "<br>";


    //                                     echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                     $kWhp = $kWhp_last - $kWhp_first;
    //                                     // $kWhp = $kWhp * $CT_VT_Factor;
    //                                     $kWhp = $kWhp;
    //                                     echo "kWhp = " . $kWhp . "<br>";


    //                                     ///////////////Off Peak////////////////
    //                                     // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Off_Peak_first = $this->ts_kv_first($key_id_Off_Peak, $start_billing);

    //                                     $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                     $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                     echo "kWhop_first = " . $kWhop_first . "<br>";


    //                                     // $ts_kv_Off_Peak_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Off_Peak],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Off_Peak_last = $this->ts_kv_last($key_id_Off_Peak, $end_billing);

    //                                     $kWhop_last = $ts_kv_Off_Peak_last->long_v;
    //                                     $kWhop_last_ts = $ts_kv_Off_Peak_last->ts;

    //                                     echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                     echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                     $kWhop = $kWhop_last - $kWhop_first;
    //                                     // $kWhop = $kWhop * $CT_VT_Factor;
    //                                     $kWhop = $kWhop;
    //                                     echo "kWhop = " . $kWhop . "<br>";


    //                                     ///////////////Holiday////////////////
    //                                     // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     $ts_kv_Holiday_first = $this->ts_kv_first($key_id_Holiday, $start_billing);

    //                                     $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                     $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                     echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                     // $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', $key_id_Holiday],
    //                                     //         ['ts', '<', $end_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'desc')->first();
    //                                     $ts_kv_Holiday_last = $this->ts_kv_last($key_id_Holiday, $end_billing);

    //                                     $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                     $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                     echo "kWhh_last = " . $kWhh_last . "<br>";

    //                                     echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                     $kWhh = $kWhh_last - $kWhh_first;
    //                                     // $kWhh = $kWhh * $CT_VT_Factor;
    //                                     $kWhh = $kWhh;
    //                                     echo "kWhh = " . $kWhh . "<br>";




    //                                     $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                     $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                     $EPP = (1 - $DF) * ($EC + $FC);

    //                                     echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                     echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                     echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                     echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                     echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                     echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 }
    //                             }
    //                         }
    //                         $Billingmodel = new Billing;
    //                         $Billingmodel->ft = $ft;
    //                         $Billingmodel->cp = $cp;
    //                         $Billingmodel->ch = $ch;
    //                         $Billingmodel->cop = $cop;
    //                         $Billingmodel->effective_start = $effective_start;
    //                         $Billingmodel->effective_end = $effective_end;
    //                         $Billingmodel->ec = $EC;
    //                         $Billingmodel->fc = $FC;
    //                         $Billingmodel->epp = $EPP;

    //                         $Billingmodel->kwhp = $kWhp;
    //                         $Billingmodel->kwhp_first_ts = $kWhp_first_ts;
    //                         $Billingmodel->kwhp_first_long_v = $kWhp_first;
    //                         $Billingmodel->kwhp_last_ts = $kWhp_last_ts;
    //                         $Billingmodel->kwhp_last_long_v = $kWhp_last;

    //                         $Billingmodel->kwhop = $kWhop;
    //                         $Billingmodel->kwhop_first_ts = $kWhop_first_ts;
    //                         $Billingmodel->kwhop_first_long_v = $kWhop_first;
    //                         $Billingmodel->kwhop_last_ts = $kWhop_last_ts;
    //                         $Billingmodel->kwhop_last_long_v = $kWhop_last;

    //                         $Billingmodel->kwhh = $kWhh;
    //                         $Billingmodel->kwhh_first_ts = $kWhh_first_ts;
    //                         $Billingmodel->kwhh_first_long_v = $kWhh_first;
    //                         $Billingmodel->kwhh_last_ts = $kWhh_last_ts;
    //                         $Billingmodel->kwhh_last_long_v = $kWhh_last;

    //                         $Billingmodel->save();
    //                         echo "save";
    //                         //     } else {
    //                         //         echo "effective_start > befor4month<br>";
    //                         //         echo "ส่งเมลแจ้งให้เปลี่ยน Ft<br>";
    //                         //     }
    //                     } else {
    //                         echo "No have parameter<br>";
    //                         echo "ส่งเมลแจ้งให้ใส่ parameter<br>";
    //                         return $this->sendmail();
    //                     }
    //                 } else {
    //                     echo "เคยทำ billing แล้ว<br>";
    //                 }
    //             } else {
    //                 echo "ไม่เท่า<br>";
    //             }
    //         } else {
    //             echo "ยังไม่เริ่มสัญญา<br>";
    //             // return $this->sendmail();
    //             // sendmail();
    //         }
    //     } else {
    //         // return $this->sendmail();
    //         echo "ตรวจสอบวันที่เริ่มสัญญา<br>";
    //     }
    // }
    // public function billingAuto_backup()
    // {
    //     $key_id_On_Peak = 38;
    //     $key_id_Off_Peak = 39;
    //     $key_id_Holiday = 40;

    //     // $date_now = date('Y-m-d');
    //     $date_now = date('Y-04-24');
    //     $billing_date = date("Y-04-24");

    //     echo "billing_date " . $billing_date . "<br>";
    //     $count_contract = DB::table('contracts')->orderBy('id', 'desc')->get()->count();
    //     if ($count_contract > 0) {

    //         $date_contract = DB::table('contracts')->orderBy('id', 'desc')->first();
    //         $start_contract = $date_contract->start_contract;
    //         echo "start_contract " . $start_contract . "<br>";

    //         if ($date_now >= $start_contract) {
    //             echo "date_now > start_contract อยู่ในสัญญา<br>";

    //             //เช็ควัน billing
    //             if ($date_now == $billing_date) {
    //                 echo "billing_date เท่า date_now <br>";

    //                 $year_now = date('Y', strtotime($date_now));
    //                 $month_now = date('m', strtotime($date_now));

    //                 echo "year_now " . $year_now . "<br>";
    //                 echo "month_now " . $month_now . "<br>";

    //                 ///เช็คเคยทำ billing////////
    //                 $billing_create = DB::table('billings')
    //                     ->whereYear('created_at', $year_now)
    //                     ->whereMonth('created_at',  $month_now)
    //                     ->get()
    //                     ->count();
    //                 echo "billingtest  " . $billing_create . "<br>";
    //                 if ($billing_create < 1) {
    //                     $count_parameters = DB::table('parameters')
    //                         ->orderBy('id', 'desc')
    //                         ->get()
    //                         ->count();
    //                     //เช็ค parameters ว่าง
    //                     if ($count_parameters > 0) {

    //                         echo "Have parameter<br>";

    //                         // $Ft_4M_chk = DB::table('parameters')
    //                         //     ->orderBy('id', 'desc')
    //                         //     ->limit(1)
    //                         //     ->get();
    //                         // foreach ($Ft_4M_chk as $Ft_4M_chk) {
    //                         //     $ft = $Ft_4M_chk->ft;
    //                         //     $cp = $Ft_4M_chk->cp;
    //                         //     $ch = $Ft_4M_chk->ch;
    //                         //     $cop = $Ft_4M_chk->cop;
    //                         //     $effective = $Ft_4M_chk->effective;
    //                         // }
    //                         $Ft_4M_chk = DB::table('parameters')->orderBy('id', 'desc')->first();
    //                         $ft = $Ft_4M_chk->ft;
    //                         $cp = $Ft_4M_chk->cp;
    //                         $ch = $Ft_4M_chk->ch;
    //                         $cop = $Ft_4M_chk->cop;
    //                         $effective_start = $Ft_4M_chk->effective_start;
    //                         $effective_end = $Ft_4M_chk->effective_end;


    //                         $befor4month = (new DateTime($date_now))->modify('-4 month')->format('Y-m-d');

    //                         echo "effective_start " . $effective_start . "<br>";
    //                         echo "befor4month " . $befor4month . "<br>";
    //                         //เช็ค parameters มี effective_start น้อยกว่า4เดือน
    //                         if ($effective_start > $befor4month) {
    //                             // $date_contract = DB::table('contracts')
    //                             //     ->orderBy('id', 'desc')
    //                             //     ->limit(1)
    //                             //     ->get();
    //                             // foreach ($date_contract as $date_contract) {
    //                             //     $start_contract = $date_contract->start_contract;
    //                             // }



    //                             $from = \Carbon\Carbon::createFromFormat('Y-m-d', "$start_contract");
    //                             // echo "from start_contract" . $from . "<br>";

    //                             $to = \Carbon\Carbon::createFromFormat('Y-m-d', "$date_now");
    //                             // echo "to date_now " . $to . "<br>";

    //                             // $diffInYears = $to->diffInYears($from);
    //                             // echo "diffInYears " . $diffInYears . "<br>";

    //                             // // $diffInMonths = $to->diffInMonths($from);
    //                             // $diffInMonths = $from->diffInMonths($to);
    //                             // echo "diffInMonths " . $diffInMonths . "<br>";


    //                             // $interval = $to->diff($from);
    //                             $interval = $from->diff($to);
    //                             $diffInYears =  $interval->y;
    //                             $diffInMonths = $interval->m;
    //                             $diffInDays = $interval->d;
    //                             echo "difference " . $diffInYears . " years, " . $diffInMonths . " months, " . $diffInDays . " days <br>";

    //                             $strtotime_date_now =  strtotime("$date_now") * 1000;




    //                             // echo $testdate2."<br>";
    //                             if ($diffInYears < 5) { //เช็ค 1-5ปี

    //                                 $DF = 0.17;
    //                                 echo "DF = $DF<br>";
    //                                 $billing = DB::table('billings')
    //                                     ->get()
    //                                     ->count();

    //                                 //เช็ค เคยทำ billing
    //                                 // $date_end_billing = (new DateTime($date_now))->modify('-1 day')->format('Y-m-d');
    //                                 // echo "date_end_billing ".$date_end_billing. "<br>";

    //                                 $end_billing = $strtotime_date_now - 1;
    //                                 echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br>";

    //                                 if ($billing > 0) {
    //                                     echo "billing > 0 <br>";
    //                                     $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                     /////////////On_Peak//////////
    //                                     $kWhp_first = $billing->kwhp_last_long_v;
    //                                     $kWhp_first_ts = $billing->kwhp_last_ts;
    //                                     echo "kWhp_first = " . $kWhp_first . "<br>";
    //                                     echo "kWhp_first_ts" . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . "<br>";
    //                                     echo "kWhp_first_ts = " . $kWhp_first_ts . "<br>";
    //                                     // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '62'],
    //                                     //         ['ts', '>', $start_billing_kwhp],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                     // $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                     // echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                     $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '<', $end_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                     echo "kWhp_last = " . $kWhp_last . "<br>";
    //                                     echo "kWhp_last" . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . "<br>";
    //                                     echo "kWhp_last_ts = " . $kWhp_last_ts . "<br>";


    //                                     echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                     $kWhp = $kWhp_last - $kWhp_first;
    //                                     echo "kWhp = " . $kWhp . "<br>";


    //                                     ///////////////Off Peak////////////////
    //                                     $kWhop_first = $billing->kwhop_last_long_v;
    //                                     $kWhop_first_ts = $billing->kwhop_last_ts;
    //                                     echo "kWhop_first = " . $kWhop_first . "<br>";
    //                                     echo "kWhop_first_ts = " . $kWhop_first_ts . "<br>";
    //                                     // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '63'],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                     // $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                     // echo "kWhop_first = " . $kWhop_first . "<br>";

    //                                     $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_Off_Peak],
    //                                             ['ts', '<', $end_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                     echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                     echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                     $kWhop = $kWhop_last - $kWhop_first;
    //                                     echo "kWhop = " . $kWhop . "<br>";


    //                                     ///////////////Holiday////////////////
    //                                     $kWhh_first = $billing->kwhh_last_long_v;
    //                                     $kWhh_first_ts = $billing->kwhh_last_ts;
    //                                     echo "kWhh_first = " . $kWhh_first . "<br>";
    //                                     echo "kWhh_first" . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . "<br>";
    //                                     echo "kWhh_first_ts = " . $kWhh_first_ts . "<br>";
    //                                     // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                     //     ->where([
    //                                     //         ['key', '=', '64'],
    //                                     //         ['ts', '>', $start_billing],
    //                                     //     ])
    //                                     //     ->orderBy('ts', 'asc')->first();
    //                                     // $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                     // $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                     // echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                     $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_Holiday],
    //                                             ['ts', '<', $end_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                     $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                     echo "kWhh_last = " . $kWhh_last . "<br>";
    //                                     echo "kWhh_last" . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . "<br>";
    //                                     echo "kWhh_last_ts = " . $kWhh_last_ts . "<br>";

    //                                     echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                     $kWhh = $kWhh_last - $kWhh_first;
    //                                     echo "kWhh = " . $kWhh . "<br>";




    //                                     $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                     $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                     $EPP = (1 - $DF) * ($EC + $FC);

    //                                     echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                     echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                     echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                     echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                     echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                     echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 } else {
    //                                     echo "billing < 0 <br>";
    //                                     // $start_billing = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                     $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                     $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                     // $end_billing = $strtotime_date_now - 1;
    //                                     /////////////On_Peak//////////
    //                                     echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

    //                                     echo "start_billing" . $start_billing . "<br>";

    //                                     $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '>', $start_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'asc')->first();
    //                                     $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                     $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                     echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                     $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_On_Peak],
    //                                             ['ts', '<', $end_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                     echo "kWhp_last = " . $kWhp_last . "<br>";


    //                                     echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                     $kWhp = $kWhp_last - $kWhp_first;
    //                                     echo "kWhp = " . $kWhp . "<br>";


    //                                     ///////////////Off Peak////////////////
    //                                     $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_Off_Peak],
    //                                             ['ts', '>', $start_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'asc')->first();
    //                                     $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                     $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                     echo "kWhop_first = " . $kWhop_first . "<br>";


    //                                     $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_Off_Peak],
    //                                             ['ts', '<', $end_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                     $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                     echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                     echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                     $kWhop = $kWhop_last - $kWhop_first;
    //                                     echo "kWhop = " . $kWhop . "<br>";


    //                                     ///////////////Holiday////////////////
    //                                     $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_Holiday],
    //                                             ['ts', '>', $start_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'asc')->first();
    //                                     $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                     $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                     echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                     $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                         ->where([
    //                                             ['key', '=', $key_id_Holiday],
    //                                             ['ts', '<', $end_billing],
    //                                         ])
    //                                         ->orderBy('ts', 'desc')->first();
    //                                     $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                     $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                     echo "kWhh_last = " . $kWhh_last . "<br>";

    //                                     echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                     $kWhh = $kWhh_last - $kWhh_first;
    //                                     echo "kWhh = " . $kWhh . "<br>";




    //                                     $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                     $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                     $EPP = (1 - $DF) * ($EC + $FC);

    //                                     echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                     echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                     echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                     echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                     echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                     echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                     echo "EPP = " . $EPP . "<br>";
    //                                 }
    //                             } elseif ($diffInYears < 10) { //เช็ค 6-10ปี
    //                                 echo "diffInYears < 10  <br>";

    //                                 if ($diffInYears == 5 && $diffInMonths < 1) { //เช็ค คร่อมเดือน
    //                                     echo "diffInYears == 5 && diffInMonths < 1 <br>";
    //                                     $DF1 = 0.17;
    //                                     $DF2 = 0.20;


    //                                     $billing = DB::table('billings')
    //                                         ->get()
    //                                         ->count();
    //                                     if ($billing > 0) {
    //                                         echo "diffInYears == 5 && diffInMonths < 1 && billing > 0 <br>";
    //                                         $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                         $end_billing = (new DateTime($start_contract))->modify('+5 Year')->format('Y-m-d');
    //                                         $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                         echo "end_billing1 " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                         /////////////On_Peak//////////
    //                                         /////////////On_Peak1//////////
    //                                         ////kWhp_first1//
    //                                         $kWhp_first1 = $billing->kwhp_last_long_v;
    //                                         $kWhp_first_ts1 = $billing->kwhp_last_ts;
    //                                         echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                         echo "kWhp_first1 = " . date("Y-m-d H:i:s", $kWhp_first_ts1 / 1000) . "<br>";
    //                                         echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";

    //                                         $kWhp_first = $kWhp_first1;
    //                                         $kWhp_first_ts = $kWhp_first_ts1;

    //                                         ////kWhp_last1//
    //                                         $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                         $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;



    //                                         echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                         echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                         ////kWhp1//
    //                                         echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                         $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                         echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                         /////////////On_Peak2//////////
    //                                         ////kWhp_first2//
    //                                         $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                         $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                         $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                         echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                         echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                         ////kWhp_last2//
    //                                         $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                         $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                         $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;
    //                                         echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                         echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                         $kWhp_last = $kWhp_last2;
    //                                         $kWhp_last_ts = $kWhp_last_ts2;

    //                                         ////kWhp2//
    //                                         echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                         $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                         echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                         ///////////// kWhp//////////
    //                                         $kWhp = $kWhp1 + $kWhp2;
    //                                         echo "kWhp = kWhp1 + kWhp2 <br>";
    //                                         echo "kWhp = $kWhp <br>";




    //                                         ///////////// Off Peak//////////
    //                                         ///////////// Off Peak1//////////
    //                                         ///////////// kWhop_first1//////////
    //                                         $kWhop_first1 = $billing->kwhop_last_long_v;
    //                                         $kWhop_first_ts1 = $billing->kwhop_last_ts;
    //                                         echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                         echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                         $kWhop_first = $kWhop_first1;
    //                                         $kWhop_first_ts = $kWhop_first_ts1;

    //                                         ///////////// kWhop_last1//////////

    //                                         $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                         $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;

    //                                         echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                         echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                         ///////////// kWhop1//////////
    //                                         echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                         $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                         echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                         /////////////Off_Peak2//////////
    //                                         ////start ts2//
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_first2//////////
    //                                         $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                         $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                         echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                         echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                         ////end ts2//
    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_last2//////////
    //                                         $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                         $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                         echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                         echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                         $kWhop_last = $kWhop_last2;
    //                                         $kWhop_last_ts = $kWhop_last_ts2;

    //                                         /////////////kWhop2//////////
    //                                         echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                         $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                         echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                         ///////////// kWhop//////////
    //                                         $kWhop = $kWhop1 + $kWhop2;




    //                                         ///////////// Holiday//////////
    //                                         ///////////// Holiday1//////////

    //                                         ///////////// kWhh_first1//////////
    //                                         $kWhh_first1 = $billing->kwhh_last_long_v;
    //                                         $kWhh_first_ts1 = $billing->kwhh_last_ts;
    //                                         echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                         echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                         $kWhh_first = $kWhh_first1;
    //                                         $kWhh_first_ts = $kWhh_first_ts1;

    //                                         ///////////// kWhh_last1//////////
    //                                         $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                         $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                         echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                         echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                         ///////////// kWhh1//////////
    //                                         echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                         $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                         echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                         /////////////Holiday2//////////
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                         /////////////kWhh_first2//////////
    //                                         $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                         $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                         echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                         echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhh_last2//////////
    //                                         $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                         $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                         echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                         echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                         $kWhh_last = $kWhh_last2;
    //                                         $kWhh_last_ts = $kWhh_last_ts2;

    //                                         /////////////kWhh2//////////
    //                                         echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                         $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                         echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                         ///////////// kWhh /////////
    //                                         $kWhh = $kWhh1 + $kWhh2;


    //                                         $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                         $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                         $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                         echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                         echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                         echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                         echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                         echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                         echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                         $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                         $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                         $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                         echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                         echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                         echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                         echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                         echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                         echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                         $EC = $EC1 + $EC2;
    //                                         $FC = $FC1 + $FC2;
    //                                         $EPP = $EPP1 + $EPP2;
    //                                         echo "EC = " . $EC . "<br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     } else {

    //                                         echo "diffInYears > 5 && diffInMonths > 1 && billing < 0 <br>";


    //                                         // $start_billing_ts1 = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                         $date_start_billing_ts1 = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                         $start_billing_ts1 = strtotime("$date_start_billing_ts1") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                         echo "date_start_billing_ts1" . $date_start_billing_ts1 . "<br>";
    //                                         echo "start_billing_ts1 " . $start_billing_ts1 . "<br>";

    //                                         $end_billing = (new DateTime($start_contract))->modify('+5 Year')->format('Y-m-d');
    //                                         $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                         echo "end_billing1 " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                         $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";


    //                                         /////////////On_Peak//////////
    //                                         /////////////On_Peak1//////////
    //                                         ////kWhp_first1//
    //                                         $ts_kv_On_Peak_first1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first1 = $ts_kv_On_Peak_first1->long_v;
    //                                         $kWhp_first_ts1 = $ts_kv_On_Peak_first1->ts;

    //                                         $kWhp_first = $kWhp_first1;
    //                                         $kWhp_first_ts = $kWhp_first_ts1;



    //                                         echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                         echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";
    //                                         ////kWhp_last1//
    //                                         $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                         $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;

    //                                         echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                         echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                         ////kWhp1//
    //                                         echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                         $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                         echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                         /////////////On_Peak2//////////
    //                                         ////kWhp_first2//

    //                                         $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                         $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                         echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                         echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                         ////kWhp_last2//
    //                                         $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                         $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                         $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;

    //                                         $kWhp_last = $kWhp_last2;
    //                                         $kWhp_last_ts = $kWhp_last_ts2;

    //                                         echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                         echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                         ////kWhp2//
    //                                         echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                         $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                         echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                         ///////////// kWhp//////////
    //                                         $kWhp = $kWhp1 + $kWhp2;

    //                                         ///////////// Off Peak//////////
    //                                         ///////////// Off Peak1//////////
    //                                         ///////////// kWhop_first1//////////
    //                                         $ts_kv_Off_Peak_first1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first1 = $ts_kv_Off_Peak_first1->long_v;
    //                                         $kWhop_first_ts1 = $ts_kv_Off_Peak_first1->ts;
    //                                         echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                         echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                         $kWhop_first = $kWhop_first1;
    //                                         $kWhop_first_ts = $kWhop_first_ts1;

    //                                         ///////////// kWhop_last1//////////

    //                                         $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                         $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;



    //                                         echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                         echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                         ///////////// kWhop1//////////
    //                                         echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                         $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                         echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                         /////////////Off_Peak2//////////
    //                                         ////start ts2//
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_first2//////////
    //                                         $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                         $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                         echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                         echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_last2//////////
    //                                         $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                         $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                         echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                         echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                         $kWhop_last = $kWhop_last2;
    //                                         $kWhop_last_ts = $kWhop_last_ts2;

    //                                         /////////////kWhop2//////////
    //                                         echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                         $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                         echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                         ///////////// kWhop//////////
    //                                         $kWhop = $kWhop1 + $kWhop2;

    //                                         ///////////// Holiday//////////
    //                                         ///////////// Holiday1//////////

    //                                         ///////////// kWhh_first1//////////
    //                                         $ts_kv_Holiday_first1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first1 = $ts_kv_Holiday_first1->long_v;
    //                                         $kWhh_first_ts1 = $ts_kv_Holiday_first1->ts;

    //                                         echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                         echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                         $kWhh_first = $kWhh_first1;
    //                                         $kWhh_first_ts = $kWhh_first_ts1;

    //                                         ///////////// kWhh_last1//////////
    //                                         $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                         $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                         echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                         echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                         ///////////// kWhh1//////////
    //                                         echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                         $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                         echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                         /////////////Holiday2//////////
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                         /////////////kWhh_first2//////////
    //                                         $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                         $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                         echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                         echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhh_last2//////////
    //                                         $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                         $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                         echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                         echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                         $kWhh_last = $kWhh_last2;
    //                                         $kWhh_last_ts = $kWhh_last_ts2;

    //                                         /////////////kWhh2//////////
    //                                         echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                         $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                         echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                         ///////////// kWhh /////////
    //                                         $kWhh = $kWhh1 + $kWhh2;


    //                                         $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                         $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                         $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                         echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                         echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                         echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                         echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                         echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                         echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                         $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                         $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                         $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                         echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                         echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                         echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                         echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                         echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                         echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                         $EC = $EC1 + $EC2;
    //                                         $FC = $FC1 + $FC2;
    //                                         $EPP = $EPP1 + $EPP2;
    //                                         echo "EC = " . $EC . "<br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     }
    //                                 } else {
    //                                     $DF = 0.20;
    //                                     echo "diffInYears > 5 && diffInMonths > 1 <br>";

    //                                     $billing = DB::table('billings')
    //                                         ->get()
    //                                         ->count();

    //                                     //เช็ค เคยทำ billing
    //                                     // $date_end_billing = (new DateTime($date_now))->modify('-1 day')->format('Y-m-d');
    //                                     // echo "date_end_billing ".$date_end_billing. "<br>";

    //                                     $end_billing = $strtotime_date_now - 1;
    //                                     echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br>";

    //                                     if ($billing > 0) {
    //                                         echo "billing > 0 <br>";
    //                                         $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                         /////////////On_Peak//////////
    //                                         $kWhp_first = $billing->kwhp_last_long_v;
    //                                         $kWhp_first_ts = $billing->kwhp_last_ts;
    //                                         echo "kWhp_first = " . $kWhp_first . "<br>";
    //                                         echo "kWhp_first_ts" . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . "<br>";
    //                                         echo "kWhp_first_ts = " . $kWhp_first_ts . "<br>";
    //                                         // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                         //     ->where([
    //                                         //         ['key', '=', '62'],
    //                                         //         ['ts', '>', $start_billing_kwhp],
    //                                         //     ])
    //                                         //     ->orderBy('ts', 'asc')->first();
    //                                         // $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                         // $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                         // echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                         echo "kWhp_last = " . $kWhp_last . "<br>";
    //                                         echo "kWhp_last" . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . "<br>";
    //                                         echo "kWhp_last_ts = " . $kWhp_last_ts . "<br>";


    //                                         echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                         $kWhp = $kWhp_last - $kWhp_first;
    //                                         echo "kWhp = " . $kWhp . "<br>";


    //                                         ///////////////Off Peak////////////////
    //                                         $kWhop_first = $billing->kwhop_last_long_v;
    //                                         $kWhop_first_ts = $billing->kwhop_last_ts;
    //                                         echo "kWhop_first = " . $kWhop_first . "<br>";
    //                                         echo "kWhop_first" . date("Y-m-d H:i:s", $kWhop_first_ts / 1000) . "<br>";
    //                                         echo "kWhop_first_ts = " . $kWhop_first_ts . "<br>";
    //                                         // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                         //     ->where([
    //                                         //         ['key', '=', '63'],
    //                                         //         ['ts', '>', $start_billing],
    //                                         //     ])
    //                                         //     ->orderBy('ts', 'asc')->first();
    //                                         // $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                         // $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                         // echo "kWhop_first = " . $kWhop_first . "<br>";

    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                         echo "kWhop_last = " . $kWhop_last . "<br>";
    //                                         echo "kWhop_last_ts" . date("Y-m-d H:i:s", $kWhop_last_ts / 1000) . "<br>";
    //                                         echo "kWhop_last_ts = " . $kWhop_last_ts . "<br>";



    //                                         echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                         $kWhop = $kWhop_last - $kWhop_first;
    //                                         echo "kWhop = " . $kWhop . "<br>";


    //                                         ///////////////Holiday////////////////
    //                                         $kWhh_first = $billing->kwhh_last_long_v;
    //                                         $kWhh_first_ts = $billing->kwhh_last_ts;
    //                                         echo "kWhh_first = " . $kWhh_first . "<br>";
    //                                         echo "kWhh_first" . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . "<br>";
    //                                         echo "kWhh_first_ts = " . $kWhh_first_ts . "<br>";
    //                                         // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                         //     ->where([
    //                                         //         ['key', '=', '64'],
    //                                         //         ['ts', '>', $start_billing],
    //                                         //     ])
    //                                         //     ->orderBy('ts', 'asc')->first();
    //                                         // $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                         // $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                         // echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                         $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                         $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                         echo "kWhh_last = " . $kWhh_last . "<br>";
    //                                         echo "kWhh_last" . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . "<br>";
    //                                         echo "kWhh_last_ts = " . $kWhh_last_ts . "<br>";

    //                                         echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                         $kWhh = $kWhh_last - $kWhh_first;
    //                                         echo "kWhh = " . $kWhh . "<br>";




    //                                         $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                         $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                         $EPP = (1 - $DF) * ($EC + $FC);

    //                                         echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                         echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                         echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                         echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                         echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                         echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     } else {
    //                                         echo "billing < 0 <br>";
    //                                         // $start_billing = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                         $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                         $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                         // $end_billing = $strtotime_date_now - 1;
    //                                         /////////////On_Peak//////////
    //                                         echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

    //                                         echo "start_billing" . $start_billing . "<br>";

    //                                         $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                         $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                         echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                         echo "kWhp_last = " . $kWhp_last . "<br>";


    //                                         echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                         $kWhp = $kWhp_last - $kWhp_first;
    //                                         echo "kWhp = " . $kWhp . "<br>";


    //                                         ///////////////Off Peak////////////////
    //                                         $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                         $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                         echo "kWhop_first = " . $kWhop_first . "<br>";


    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                         echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                         echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                         $kWhop = $kWhop_last - $kWhop_first;
    //                                         echo "kWhop = " . $kWhop . "<br>";


    //                                         ///////////////Holiday////////////////
    //                                         $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                         $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                         echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                         $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                         $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                         echo "kWhh_last = " . $kWhh_last . "<br>";

    //                                         echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                         $kWhh = $kWhh_last - $kWhh_first;
    //                                         echo "kWhh = " . $kWhh . "<br>";




    //                                         $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                         $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                         $EPP = (1 - $DF) * ($EC + $FC);

    //                                         echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                         echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                         echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                         echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                         echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                         echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     }
    //                                 }
    //                             } elseif ($diffInYears < 15) { //เช็ค 11-15ปี
    //                                 echo "diffInYears < 15  <br>";

    //                                 if ($diffInYears == 10 && $diffInMonths < 1) { //เช็ค คร่อมเดือน
    //                                     echo "diffInYears == 10 && diffInMonths < 1 <br>";
    //                                     $DF1 = 0.20;
    //                                     $DF2 = 0.25;
    //                                     // $DF3 = 0.25;

    //                                     $billing = DB::table('billings')
    //                                         ->get()
    //                                         ->count();
    //                                     if ($billing > 0) {
    //                                         echo "diffInYears == 10 && diffInMonths < 1 && billing > 0 <br>";
    //                                         $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                         $end_billing = (new DateTime($start_contract))->modify('+10 Year')->format('Y-m-d');
    //                                         $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                         echo "end_billing1 " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                         /////////////On_Peak//////////
    //                                         /////////////On_Peak1//////////
    //                                         ////kWhp_first1//
    //                                         $kWhp_first1 = $billing->kwhp_last_long_v;
    //                                         $kWhp_first_ts1 = $billing->kwhp_last_ts;
    //                                         echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                         echo "kWhp_first1 = " . date("Y-m-d H:i:s", $kWhp_first_ts1 / 1000) . "<br>";
    //                                         echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";

    //                                         $kWhp_first = $kWhp_first1;
    //                                         $kWhp_first_ts = $kWhp_first_ts1;

    //                                         ////kWhp_last1//
    //                                         $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                         $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;



    //                                         echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                         echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                         ////kWhp1//
    //                                         echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                         $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                         echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                         /////////////On_Peak2//////////
    //                                         ////kWhp_first2//
    //                                         $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                         $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                         $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                         echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                         echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                         ////kWhp_last2//
    //                                         $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                         $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                         $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;
    //                                         echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                         echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                         $kWhp_last = $kWhp_last2;
    //                                         $kWhp_last_ts = $kWhp_last_ts2;

    //                                         ////kWhp2//
    //                                         echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                         $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                         echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                         ///////////// kWhp//////////
    //                                         $kWhp = $kWhp1 + $kWhp2;
    //                                         echo "kWhp = kWhp1 + kWhp2 <br>";
    //                                         echo "kWhp = $kWhp <br>";




    //                                         ///////////// Off Peak//////////
    //                                         ///////////// Off Peak1//////////
    //                                         ///////////// kWhop_first1//////////
    //                                         $kWhop_first1 = $billing->kwhop_last_long_v;
    //                                         $kWhop_first_ts1 = $billing->kwhop_last_ts;
    //                                         echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                         echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                         $kWhop_first = $kWhop_first1;
    //                                         $kWhop_first_ts = $kWhop_first_ts1;

    //                                         ///////////// kWhop_last1//////////

    //                                         $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                         $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;

    //                                         echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                         echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                         ///////////// kWhop1//////////
    //                                         echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                         $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                         echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                         /////////////Off_Peak2//////////
    //                                         ////start ts2//
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_first2//////////
    //                                         $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                         $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                         echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                         echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                         ////end ts2//
    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_last2//////////
    //                                         $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                         $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                         echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                         echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                         $kWhop_last = $kWhop_last2;
    //                                         $kWhop_last_ts = $kWhop_last_ts2;

    //                                         /////////////kWhop2//////////
    //                                         echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                         $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                         echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                         ///////////// kWhop//////////
    //                                         $kWhop = $kWhop1 + $kWhop2;




    //                                         ///////////// Holiday//////////
    //                                         ///////////// Holiday1//////////

    //                                         ///////////// kWhh_first1//////////
    //                                         $kWhh_first1 = $billing->kwhh_last_long_v;
    //                                         $kWhh_first_ts1 = $billing->kwhh_last_ts;
    //                                         echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                         echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                         $kWhh_first = $kWhh_first1;
    //                                         $kWhh_first_ts = $kWhh_first_ts1;

    //                                         ///////////// kWhh_last1//////////
    //                                         $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                         $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                         echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                         echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                         ///////////// kWhh1//////////
    //                                         echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                         $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                         echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                         /////////////Holiday2//////////
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                         /////////////kWhh_first2//////////
    //                                         $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                         $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                         echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                         echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhh_last2//////////
    //                                         $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                         $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                         echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                         echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                         $kWhh_last = $kWhh_last2;
    //                                         $kWhh_last_ts = $kWhh_last_ts2;

    //                                         /////////////kWhh2//////////
    //                                         echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                         $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                         echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                         ///////////// kWhh /////////
    //                                         $kWhh = $kWhh1 + $kWhh2;


    //                                         $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                         $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                         $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                         echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                         echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                         echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                         echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                         echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                         echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                         $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                         $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                         $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                         echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                         echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                         echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                         echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                         echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                         echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                         $EC = $EC1 + $EC2;
    //                                         $FC = $FC1 + $FC2;
    //                                         $EPP = $EPP1 + $EPP2;
    //                                         echo "EC = " . $EC . "<br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     } else {

    //                                         echo "diffInYears > 10 && diffInMonths > 1 && billing < 0 <br>";


    //                                         // $start_billing_ts1 = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                         $date_start_billing_ts1 = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                         $start_billing_ts1 = strtotime("$date_start_billing_ts1") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                         echo "date_start_billing_ts1 = " . $date_start_billing_ts1 . "<br>";
    //                                         echo "start_billing_ts1 = " . $start_billing_ts1 . "<br>";

    //                                         $end_billing = (new DateTime($start_contract))->modify('+10 Year')->format('Y-m-d');
    //                                         $end_billing_ts1 = strtotime("$end_billing") * 1000 - 1;
    //                                         echo "end_billing1 = " . date("Y-m-d H:i:s", $end_billing_ts1 / 1000) . "<br>";

    //                                         $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";


    //                                         /////////////On_Peak//////////
    //                                         /////////////On_Peak1//////////
    //                                         ////kWhp_first1//
    //                                         $ts_kv_On_Peak_first1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first1 = $ts_kv_On_Peak_first1->long_v;
    //                                         $kWhp_first_ts1 = $ts_kv_On_Peak_first1->ts;

    //                                         $kWhp_first = $kWhp_first1;
    //                                         $kWhp_first_ts = $kWhp_first_ts1;



    //                                         echo "kWhp_first1 = " . $kWhp_first1 . "<br>";
    //                                         echo "kWhp_first_ts1 = " . $kWhp_first_ts1 . "<br>";
    //                                         ////kWhp_last1//
    //                                         $ts_kv_On_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=',  $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last1 = $ts_kv_On_Peak_last1->long_v;
    //                                         $kWhp_last_ts1 = $ts_kv_On_Peak_last1->ts;

    //                                         echo "kWhp_last1 = " . $kWhp_last1 . "<br>";
    //                                         echo "kWhp_last1 = " . date("Y-m-d H:i:s", $kWhp_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts1 = " . $kWhp_last_ts1 . "<br>";
    //                                         ////kWhp1//
    //                                         echo "kWhp1 = kWhp_last1 - kWhp_first1 <br>";
    //                                         $kWhp1 = $kWhp_last1 - $kWhp_first1;
    //                                         echo "kWhp1 = " . $kWhp1 . "<br>";

    //                                         /////////////On_Peak2//////////
    //                                         ////kWhp_first2//

    //                                         $ts_kv_On_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=',  $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first2 = $ts_kv_On_Peak_first2->long_v;
    //                                         $kWhp_first_ts2 = $ts_kv_On_Peak_first2->ts;
    //                                         echo "kWhp_first2 = " . $kWhp_first2 . "<br>";
    //                                         echo "date_kWhp_first_ts2 = " . date("Y-m-d H:i:s", $kWhp_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_first_ts2 = " . $kWhp_first_ts2 . "<br>";

    //                                         ////kWhp_last2//
    //                                         $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";
    //                                         $ts_kv_On_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last2 = $ts_kv_On_Peak_last2->long_v;
    //                                         $kWhp_last_ts2 = $ts_kv_On_Peak_last2->ts;

    //                                         $kWhp_last = $kWhp_last2;
    //                                         $kWhp_last_ts = $kWhp_last_ts2;

    //                                         echo "kWhp_last2 = " . $kWhp_last2 . "<br>";
    //                                         echo "date_kWhp_last_ts2 = " . date("Y-m-d H:i:s", $kWhp_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhp_last_ts2 = " . $kWhp_last_ts2 . "<br>";
    //                                         ////kWhp2//
    //                                         echo "kWhp2 = kWhp_last2 - kWhp_first2 <br>";
    //                                         $kWhp2 = $kWhp_last2 - $kWhp_first2;
    //                                         echo "kWhp2 = " . $kWhp2 . "<br>";

    //                                         ///////////// kWhp//////////
    //                                         $kWhp = $kWhp1 + $kWhp2;

    //                                         ///////////// Off Peak//////////
    //                                         ///////////// Off Peak1//////////
    //                                         ///////////// kWhop_first1//////////
    //                                         $ts_kv_Off_Peak_first1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first1 = $ts_kv_Off_Peak_first1->long_v;
    //                                         $kWhop_first_ts1 = $ts_kv_Off_Peak_first1->ts;
    //                                         echo "kWhop_first1 = " . $kWhop_first1 . "<br>";
    //                                         echo "kWhop_first_ts1 = " . $kWhop_first_ts1 . "<br>";

    //                                         $kWhop_first = $kWhop_first1;
    //                                         $kWhop_first_ts = $kWhop_first_ts1;

    //                                         ///////////// kWhop_last1//////////

    //                                         $ts_kv_Off_Peak_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last1 = $ts_kv_Off_Peak_last1->long_v;
    //                                         $kWhop_last_ts1 = $ts_kv_Off_Peak_last1->ts;



    //                                         echo "kWhop_last1 = " . $kWhop_last1 . "<br>";
    //                                         echo "kWhop_last1 = " . date("Y-m-d H:i:s", $kWhop_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts1 = " . $kWhop_last_ts1 . "<br>";

    //                                         ///////////// kWhop1//////////
    //                                         echo "kWhop1 = kWhop_last1 - kWhop_first1 <br>";
    //                                         $kWhop1 = $kWhop_last1 - $kWhop_first1;
    //                                         echo "kWhop1 = " . $kWhop1 . "<br>";

    //                                         /////////////Off_Peak2//////////
    //                                         ////start ts2//
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_first2//////////
    //                                         $ts_kv_Off_Peak_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first2 = $ts_kv_Off_Peak_first2->long_v;
    //                                         $kWhop_first_ts2 = $ts_kv_Off_Peak_first2->ts;
    //                                         echo "kWhop_first2 = " . $kWhop_first2 . "<br>";
    //                                         echo "date_kWhop_first_ts2 = " . date("Y-m-d H:i:s", $kWhop_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_first_ts2 = " . $kWhop_first_ts2 . "<br>";


    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhop_last2//////////
    //                                         $ts_kv_Off_Peak_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last2 = $ts_kv_Off_Peak_last2->long_v;
    //                                         $kWhop_last_ts2 = $ts_kv_Off_Peak_last2->ts;
    //                                         echo "kWhop_last2 = " . $kWhop_last2 . "<br>";
    //                                         echo "date_kWhop_last_ts2 = " . date("Y-m-d H:i:s", $kWhop_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhop_last_ts2 = " . $kWhop_last_ts2 . "<br>";

    //                                         $kWhop_last = $kWhop_last2;
    //                                         $kWhop_last_ts = $kWhop_last_ts2;

    //                                         /////////////kWhop2//////////
    //                                         echo "kWhop2 = kWhop_last2 - kWhop_first2 <br>";
    //                                         $kWhop2 = $kWhop_last2 - $kWhop_first2;
    //                                         echo "kWhop2 = " . $kWhop2 . "<br>";

    //                                         ///////////// kWhop//////////
    //                                         $kWhop = $kWhop1 + $kWhop2;

    //                                         ///////////// Holiday//////////
    //                                         ///////////// Holiday1//////////

    //                                         ///////////// kWhh_first1//////////
    //                                         $ts_kv_Holiday_first1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first1 = $ts_kv_Holiday_first1->long_v;
    //                                         $kWhh_first_ts1 = $ts_kv_Holiday_first1->ts;

    //                                         echo "kWhh_first1 = " . $kWhh_first1 . "<br>";
    //                                         echo "kWhh_first_ts1 = " . $kWhh_first_ts1 . "<br>";

    //                                         $kWhh_first = $kWhh_first1;
    //                                         $kWhh_first_ts = $kWhh_first_ts1;

    //                                         ///////////// kWhh_last1//////////
    //                                         $ts_kv_Holiday_last1 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts1],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last1 = $ts_kv_Holiday_last1->long_v;
    //                                         $kWhh_last_ts1 = $ts_kv_Holiday_last1->ts;

    //                                         echo "kWhh_last1 = " . $kWhh_last1 . "<br>";
    //                                         echo "kWhh_last1 = " . date("Y-m-d H:i:s", $kWhh_last_ts1 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts1 = " . $kWhh_last_ts1 . "<br>";

    //                                         ///////////// kWhh1//////////
    //                                         echo "kWhh1 = kWhh_last1 - kWhh_first1 <br>";
    //                                         $kWhh1 = $kWhh_last1 - $kWhh_first1;
    //                                         echo "kWhh1 = " . $kWhh1 . "<br>";

    //                                         /////////////Holiday2//////////
    //                                         // $start_billing_ts2 = strtotime("$end_billing") * 1000;
    //                                         // echo "start_billing_ts2 = " . date("Y-m-d H:i:s", $start_billing_ts2 / 1000) . "<br>";
    //                                         /////////////kWhh_first2//////////
    //                                         $ts_kv_Holiday_first2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first2 = $ts_kv_Holiday_first2->long_v;
    //                                         $kWhh_first_ts2 = $ts_kv_Holiday_first2->ts;
    //                                         echo "kWhh_first2 = " . $kWhh_first2 . "<br>";
    //                                         echo "date_kWhh_first_ts2 = " . date("Y-m-d H:i:s", $kWhh_first_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_first_ts2 = " . $kWhh_first_ts2 . "<br>";

    //                                         // $end_billing_ts2 = strtotime("$date_now") * 1000 - 1;
    //                                         // echo "end_billing_ts2 = " . date("Y-m-d H:i:s", $end_billing_ts2 / 1000) . "<br>";

    //                                         /////////////kWhh_last2//////////
    //                                         $ts_kv_Holiday_last2 = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing_ts2],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last2 = $ts_kv_Holiday_last2->long_v;
    //                                         $kWhh_last_ts2 = $ts_kv_Holiday_last2->ts;
    //                                         echo "kWhh_last2 = " . $kWhh_last2 . "<br>";
    //                                         echo "date_kWhh_last_ts2 = " . date("Y-m-d H:i:s", $kWhh_last_ts2 / 1000) . "<br>";
    //                                         echo "kWhh_last_ts2 = " . $kWhh_last_ts2 . "<br>";

    //                                         $kWhh_last = $kWhh_last2;
    //                                         $kWhh_last_ts = $kWhh_last_ts2;

    //                                         /////////////kWhh2//////////
    //                                         echo "kWhh2 = kWhh_last2 - kWhh_first2 <br>";
    //                                         $kWhh2 = $kWhh_last2 - $kWhh_first2;
    //                                         echo "kWhh2 = " . $kWhh2 . "<br>";

    //                                         ///////////// kWhh /////////
    //                                         $kWhh = $kWhh1 + $kWhh2;


    //                                         $EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1);
    //                                         $FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1);
    //                                         $EPP1 = (1 - $DF1) * ($EC1 + $FC1);
    //                                         echo "EC1 = (cp * kWhp1) + (cop * kWhop1) + (ch * kWhh1) <br>";
    //                                         echo "EC1 = ($cp * $kWhp1) + ($cop * $kWhop1) + ($ch * $kWhh1) <br>";
    //                                         echo "FC1 = ft * (kWhp1 + kWhop1 + kWhh1) <br>";
    //                                         echo "FC1 = $ft * ($kWhp1 + $kWhop1 + $kWhh1) <br>";
    //                                         echo "EPP1 = (1 - DF1) * (EC1 + FC1) <br>";
    //                                         echo "EPP1 = (1 - $DF1) * ($EC1 + $FC1) <br>";

    //                                         $EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2);
    //                                         $FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2);
    //                                         $EPP2 = (1 - $DF2) * ($EC2 + $FC2);
    //                                         echo "EC2 = (cp * kWhp2) + (cop * kWhop2) + (ch * kWhh2) <br>";
    //                                         echo "EC2 = ($cp * $kWhp2) + ($cop * $kWhop2) + ($ch * $kWhh2) <br>";
    //                                         echo "FC2 = ft * (kWhp2 + kWhop2 + kWhh2) <br>";
    //                                         echo "FC2 = $ft * ($kWhp2 + $kWhop2 + $kWhh2) <br>";
    //                                         echo "EPP2 = (1 - DF2) * (EC2 + FC2) <br>";
    //                                         echo "EPP2 = (1 - $DF2) * ($EC2 + $FC2) <br>";

    //                                         $EC = $EC1 + $EC2;
    //                                         $FC = $FC1 + $FC2;
    //                                         $EPP = $EPP1 + $EPP2;
    //                                         echo "EC = " . $EC . "<br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     }
    //                                 } else {
    //                                     $DF = 0.25;
    //                                     echo "diffInYears > 10 && diffInMonths > 1 <br>";

    //                                     $billing = DB::table('billings')
    //                                         ->get()
    //                                         ->count();

    //                                     //เช็ค เคยทำ billing
    //                                     // $date_end_billing = (new DateTime($date_now))->modify('-1 day')->format('Y-m-d');
    //                                     // echo "date_end_billing ".$date_end_billing. "<br>";

    //                                     $end_billing = $strtotime_date_now - 1;
    //                                     echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br>";

    //                                     if ($billing > 0) {
    //                                         echo "billing > 0 <br>";
    //                                         $billing = DB::table('billings')->orderBy('id', 'desc')->first();


    //                                         /////////////On_Peak//////////
    //                                         $kWhp_first = $billing->kwhp_last_long_v;
    //                                         $kWhp_first_ts = $billing->kwhp_last_ts;
    //                                         echo "kWhp_first = " . $kWhp_first . "<br>";
    //                                         echo "kWhp_first_ts" . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . "<br>";
    //                                         echo "kWhp_first_ts = " . $kWhp_first_ts . "<br>";
    //                                         // $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                         //     ->where([
    //                                         //         ['key', '=', '62'],
    //                                         //         ['ts', '>', $start_billing_kwhp],
    //                                         //     ])
    //                                         //     ->orderBy('ts', 'asc')->first();
    //                                         // $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                         // $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                         // echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                         echo "kWhp_last = " . $kWhp_last . "<br>";
    //                                         echo "kWhp_last" . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . "<br>";
    //                                         echo "kWhp_last_ts = " . $kWhp_last_ts . "<br>";


    //                                         echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                         $kWhp = $kWhp_last - $kWhp_first;
    //                                         echo "kWhp = " . $kWhp . "<br>";


    //                                         ///////////////Off Peak////////////////
    //                                         $kWhop_first = $billing->kwhop_last_long_v;
    //                                         $kWhop_first_ts = $billing->kwhop_last_ts;
    //                                         echo "kWhop_first = " . $kWhop_first . "<br>";
    //                                         echo "kWhop_first" . date("Y-m-d H:i:s", $kWhop_first_ts / 1000) . "<br>";
    //                                         echo "kWhop_first_ts = " . $kWhop_first_ts . "<br>";
    //                                         // $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                         //     ->where([
    //                                         //         ['key', '=', '63'],
    //                                         //         ['ts', '>', $start_billing],
    //                                         //     ])
    //                                         //     ->orderBy('ts', 'asc')->first();
    //                                         // $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                         // $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                         // echo "kWhop_first = " . $kWhop_first . "<br>";

    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                         echo "kWhop_last = " . $kWhop_last . "<br>";
    //                                         echo "kWhop_last_ts" . date("Y-m-d H:i:s", $kWhop_last_ts / 1000) . "<br>";
    //                                         echo "kWhop_last_ts = " . $kWhop_last_ts . "<br>";



    //                                         echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                         $kWhop = $kWhop_last - $kWhop_first;
    //                                         echo "kWhop = " . $kWhop . "<br>";


    //                                         ///////////////Holiday////////////////
    //                                         $kWhh_first = $billing->kwhh_last_long_v;
    //                                         $kWhh_first_ts = $billing->kwhh_last_ts;
    //                                         echo "kWhh_first = " . $kWhh_first . "<br>";
    //                                         echo "kWhh_first" . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . "<br>";
    //                                         echo "kWhh_first_ts = " . $kWhh_first_ts . "<br>";
    //                                         // $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                         //     ->where([
    //                                         //         ['key', '=', '64'],
    //                                         //         ['ts', '>', $start_billing],
    //                                         //     ])
    //                                         //     ->orderBy('ts', 'asc')->first();
    //                                         // $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                         // $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                         // echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                         $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                         $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                         echo "kWhh_last = " . $kWhh_last . "<br>";
    //                                         echo "kWhh_last" . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . "<br>";
    //                                         echo "kWhh_last_ts = " . $kWhh_last_ts . "<br>";

    //                                         echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                         $kWhh = $kWhh_last - $kWhh_first;
    //                                         echo "kWhh = " . $kWhh . "<br>";




    //                                         $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                         $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                         $EPP = (1 - $DF) * ($EC + $FC);

    //                                         echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                         echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                         echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                         echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                         echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                         echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     } else {
    //                                         echo "billing < 0 <br>";
    //                                         // $start_billing = strtotime("$start_contract") * 1000; //ตั้งแต่วันที่เริ่มสัญญา
    //                                         $date_start_billing = (new DateTime($date_now))->modify('-1 month')->format('Y-m-d');
    //                                         $start_billing = strtotime("$date_start_billing") * 1000; //ตั้งแต่ 1เดือนก่อน
    //                                         // $end_billing = $strtotime_date_now - 1;
    //                                         /////////////On_Peak//////////
    //                                         echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";

    //                                         echo "start_billing" . $start_billing . "<br>";

    //                                         $ts_kv_On_Peak_first = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '>', $start_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhp_first = $ts_kv_On_Peak_first->long_v;
    //                                         $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
    //                                         echo "kWhp_first = " . $kWhp_first . "<br>";

    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_On_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhp_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
    //                                         echo "kWhp_last = " . $kWhp_last . "<br>";


    //                                         echo "kWhp = kWhp_last - kWhp_first <br>";
    //                                         $kWhp = $kWhp_last - $kWhp_first;
    //                                         echo "kWhp = " . $kWhp . "<br>";


    //                                         ///////////////Off Peak////////////////
    //                                         $ts_kv_Off_Peak_first = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '>', $start_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhop_first = $ts_kv_Off_Peak_first->long_v;
    //                                         $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
    //                                         echo "kWhop_first = " . $kWhop_first . "<br>";


    //                                         $ts_kv_On_Peak_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Off_Peak],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhop_last = $ts_kv_On_Peak_last->long_v;
    //                                         $kWhop_last_ts = $ts_kv_On_Peak_last->ts;

    //                                         echo "kWhop_last = " . $kWhop_last . "<br>";

    //                                         echo "kWhop = kWhop_last - kWhop_first <br>";
    //                                         $kWhop = $kWhop_last - $kWhop_first;
    //                                         echo "kWhop = " . $kWhop . "<br>";


    //                                         ///////////////Holiday////////////////
    //                                         $ts_kv_Holiday_first = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '>', $start_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'asc')->first();
    //                                         $kWhh_first = $ts_kv_Holiday_first->long_v;
    //                                         $kWhh_first_ts = $ts_kv_Holiday_first->ts;

    //                                         echo "kWhh_first = " . $kWhh_first . "<br>";


    //                                         $ts_kv_Holiday_last = DB::table('ts_kv')
    //                                             ->where([
    //                                                 ['key', '=', $key_id_Holiday],
    //                                                 ['ts', '<', $end_billing],
    //                                             ])
    //                                             ->orderBy('ts', 'desc')->first();
    //                                         $kWhh_last = $ts_kv_Holiday_last->long_v;
    //                                         $kWhh_last_ts = $ts_kv_Holiday_last->ts;

    //                                         echo "kWhh_last = " . $kWhh_last . "<br>";

    //                                         echo "kWhh = kWhh_last - kWhh_first <br>";
    //                                         $kWhh = $kWhh_last - $kWhh_first;
    //                                         echo "kWhh = " . $kWhh . "<br>";




    //                                         $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
    //                                         $FC = $ft * ($kWhp + $kWhop + $kWhh);
    //                                         $EPP = (1 - $DF) * ($EC + $FC);

    //                                         echo "EC = (cp * kWhp) + (cop * kWhop) + (ch * kWhh) <br>";
    //                                         echo "EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh) <br>";
    //                                         echo "FC = ft * (kWhp + kWhop + kWhh) <br>";
    //                                         echo "FC = $ft * ($kWhp + $kWhop + $kWhh) <br>";
    //                                         echo "EPP = (1 - DF) * (EC + FC) <br>";
    //                                         echo "EPP = (1 - $DF) * ($EC + $FC) <br>";
    //                                         echo "EPP = " . $EPP . "<br>";
    //                                     }
    //                                 }
    //                             }
    //                             $Billingmodel = new Billing;
    //                             $Billingmodel->ft = $ft;
    //                             $Billingmodel->cp = $cp;
    //                             $Billingmodel->ch = $ch;
    //                             $Billingmodel->cop = $cop;
    //                             $Billingmodel->effective_start = $effective_start;
    //                             $Billingmodel->effective_end = $effective_end;
    //                             $Billingmodel->ec = $EC;
    //                             $Billingmodel->fc = $FC;
    //                             $Billingmodel->epp = $EPP;

    //                             $Billingmodel->kwhp = $kWhp;
    //                             $Billingmodel->kwhp_first_ts = $kWhp_first_ts;
    //                             $Billingmodel->kwhp_first_long_v = $kWhp_first;
    //                             $Billingmodel->kwhp_last_ts = $kWhp_last_ts;
    //                             $Billingmodel->kwhp_last_long_v = $kWhp_last;

    //                             $Billingmodel->kwhop = $kWhop;
    //                             $Billingmodel->kwhop_first_ts = $kWhop_first_ts;
    //                             $Billingmodel->kwhop_first_long_v = $kWhop_first;
    //                             $Billingmodel->kwhop_last_ts = $kWhop_last_ts;
    //                             $Billingmodel->kwhop_last_long_v = $kWhop_last;

    //                             $Billingmodel->kwhh = $kWhh;
    //                             $Billingmodel->kwhh_first_ts = $kWhh_first_ts;
    //                             $Billingmodel->kwhh_first_long_v = $kWhh_first;
    //                             $Billingmodel->kwhh_last_ts = $kWhh_last_ts;
    //                             $Billingmodel->kwhh_last_long_v = $kWhh_last;

    //                             $Billingmodel->save();
    //                         } else {
    //                             echo "effective_start > befor4month<br>";
    //                             echo "ส่งเมลแจ้งให้เปลี่ยน Ft<br>";
    //                         }
    //                     } else {
    //                         echo "No have parameter<br>";
    //                         echo "ส่งเมลแจ้งให้ใส่ parameter<br>";
    //                     }
    //                 } else {
    //                     echo "เคยทำ billing แล้ว<br>";
    //                 }
    //             } else {
    //                 echo "ไม่เท่า<br>";
    //             }
    //         } else {
    //             echo "ยังไม่เริ่มสัญญา<br>";
    //         }
    //     } else {
    //         echo "ยังไม่เริ่มสัญญา<br>";
    //     }
    // }
    public function allBillings()
    {
        // $allbillings = DB::table('billings')->orderBy('id', 'asc')->get();
        $allbillings = Billing::all();
        return view('admin/billing/allbillings', compact('allbillings'));
    }

    public function billingManualAuto()
    {
        $allparameters = Parameter::all();
        return view('admin/billing/billingManualAuto', compact('allparameters'));
    }
    public function billingManualAutoChk(Request $request)
    {
        $request->validate([
            'parameter_id' => ['required'],
            'month_billing' => ['required'],
        ]);
        //บันทึกข้อมูล


        $key_id_On_Peak = $this->key_id_On_Peak;
        $key_id_Off_Peak = $this->key_id_Off_Peak;
        $key_id_Holiday = $this->key_id_Holiday;


        $parameters_id = DB::table('parameters')
            // ->whereBetween($date_now, ['effective_start', 'effective_end'])
            ->where('id', '=', $request->parameter_id)
            ->get()->first();

        $ft = $parameters_id->ft;
        $cp = $parameters_id->cp;
        $ch = $parameters_id->ch;
        $cop = $parameters_id->cop;
        $effective_start = $parameters_id->effective_start;
        $effective_end = $parameters_id->effective_end;


        $count_contract = DB::table('contracts')->orderBy('id', 'desc')->get()->count();
        if ($count_contract > 0) {
            echo "Have date contract  ====> " . $count_contract . "<br>";
            $date_now = date("Y-m-d H:i:s");
            $month_now = date("Y-m");
            echo "$request->month_billing > $month_now" . "<br>";
            if ($request->month_billing < $month_now) {
                $contract = DB::table('contracts')->orderBy('id', 'desc')->first();
                $contract_companyEN = $contract->contract_companyEN;
                $contract_companyTH = $contract->contract_companyTH;
                $contract_address = $contract->contract_address;
                $kWh_meter_SN = $contract->kWh_meter_SN;
                $type =  $contract->type;
                $voltage = $contract->voltage;
                // $CT_VT_Factor = $contract->CT_VT_Factor;
                $start_contract = $contract->start_contract;

                $billing_date = date("$request->month_billing-01");
                echo $billing_date;

                ////start_billing////
                // $date_start_billing = (new DateTime($billing_date))->modify('-1 month')->format('Y-m-d');
                $start_billing = strtotime("$billing_date") * 1000; //ตั้งแต่ 1เดือนก่อน
                echo "start_billing" . date("Y-m-d H:i:s", $start_billing / 1000) . "<br>";



                ////end_billing////
                $date_end_billing = (new DateTime($billing_date))->modify('+1 month')->format('Y-m-d');
                $strtotime_end_billing =  strtotime("$date_end_billing") * 1000;
                $end_billing = $strtotime_end_billing;
                echo "end_billing" . date("Y-m-d H:i:s", $end_billing / 1000) . "<br><br>";

                //////หา ts ของเดือน////////
                $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $strtotime_end_billing - 1);
                $ts_last = $ts_kv_On_Peak_last->ts;
                echo "ts สุดท้ายของเดือน = " . date("Y-m-d H:i:s", $ts_last / 1000) . "<br>";

                /////////////////////////////////On_Peak///////////////////////////////////////////////////////////////
                /////kwhp_gain/////
                $kwhp_get_gain = $this->get_gain($key_id_On_Peak);
                $kwhp_gain = $kwhp_get_gain->gain;

                ////kWhp_first////////
                $ts_kv_On_Peak_first = $this->ts_kv_first($key_id_On_Peak, $start_billing);
                $kWhp_first = $ts_kv_On_Peak_first->long_v;
                $kWhp_firstDivideGain = $kWhp_first / $kwhp_gain;
                $kWhp_first_ts = $ts_kv_On_Peak_first->ts;
                echo "พลังงานไฟฟ้า Peak เลขอ่านครั้งก่อน = " . date("Y-m-d H:i:s", $kWhp_first_ts / 1000) . " long_v = " . $kWhp_firstDivideGain . "<br>";

                ////kWhp_last////////
                $ts_kv_On_Peak_last = $this->ts_kv_first($key_id_On_Peak, $end_billing);
                $kWhp_last = $ts_kv_On_Peak_last->long_v;
                $kWhp_lastDivideGain = $kWhp_last / $kwhp_gain;
                $kWhp_last_ts = $ts_kv_On_Peak_last->ts;
                echo "พลังงานไฟฟ้า Peak เลขอ่านครั้งหลัง = " . date("Y-m-d H:i:s", $kWhp_last_ts / 1000) . " long_v = " . $kWhp_lastDivideGain . "<br>";

                ////kWhp////////
                // $kWhp_lastMinusfirst_DivideGain = ($kWhp_lastDivideGain - $kWhp_firstDivideGain) * $CT_VT_Factor;
                $kWhp_lastMinusfirst_DivideGain = $kWhp_lastDivideGain - $kWhp_firstDivideGain;
                echo "พลังงานไฟฟ้า Peak = " . $kWhp_lastMinusfirst_DivideGain . "<br>";

                echo "อัตราค่าไฟฟ้า Peak = " . $cp . "<br>";

                // $kWhp = $kWhp_lastMinusfirst * $CT_VT_Factor;
                // $kWhp_DivideGain = $kWhp / $kwhp_gain;
                // echo "(kWhp_last-first*CT_VT_Factor)/kwhp_gain  = " . $kWhp . "<br>";

                // $energy_money_kWhp = number_format($cp * $kWhp_lastMinusfirst_DivideGain,2,".","");
                $energy_money_kWhp = $cp * $kWhp_lastMinusfirst_DivideGain;
                echo "จำนวนเงิน kWhp = " . number_format($energy_money_kWhp, 2, ".", "") . "<br><br>";


                /////////////////////////////////Off_Peak///////////////////////////////////////////////////////////////
                ////kWhop_gain////////
                $kwhop_get_gain = $this->get_gain($key_id_Off_Peak);
                $kwhop_gain = $kwhop_get_gain->gain;

                ////kWhop_first////////
                $ts_kv_Off_Peak_first = $this->ts_kv_first($key_id_Off_Peak, $start_billing);
                $kWhop_first = $ts_kv_Off_Peak_first->long_v;
                $kWhop_first_DivideGain = $kWhop_first / $kwhop_gain;
                $kWhop_first_ts = $ts_kv_Off_Peak_first->ts;
                echo "พลังงานไฟฟ้า Off-Peak เลขอ่านครั้งก่อน = " . date("Y-m-d H:i:s", $kWhop_first_ts / 1000) . " long_v = " . $kWhop_first_DivideGain . "<br>";

                ////kWhop_last////////
                $ts_kv_Off_Peak_last = $this->ts_kv_first($key_id_Off_Peak, $end_billing);
                $kWhop_last = $ts_kv_Off_Peak_last->long_v;
                $kWhop_last_DivideGain = $kWhop_last / $kwhop_gain;
                $kWhop_last_ts = $ts_kv_Off_Peak_last->ts;
                echo "พลังงานไฟฟ้า Off-Peak เลขอ่านครั้งหลัง = " . date("Y-m-d H:i:s", $kWhop_last_ts / 1000) . " long_v = " . $kWhop_last_DivideGain . "<br>";

                ////kWhop////////
                // $kWhop_lastMinusfirst_DivideGain = ($kWhop_last_DivideGain - $kWhop_first_DivideGain) * $CT_VT_Factor;
                $kWhop_lastMinusfirst_DivideGain = $kWhop_last_DivideGain - $kWhop_first_DivideGain;
                echo "พลังงานไฟฟ้า Off-Peak = " . $kWhop_lastMinusfirst_DivideGain . "<br>";

                echo "อัตราค่าไฟฟ้า Off-Peak = " . $cop . "<br>";

                // $energy_money_kWhop = number_format($cop * $kWhop_lastMinusfirst_DivideGain,2,".","");
                $energy_money_kWhop = $cop * $kWhop_lastMinusfirst_DivideGain;
                echo "จำนวนเงิน kWhop = " . number_format($energy_money_kWhop, 2, ".", "") . "<br><br>";


                /////////////////////////////////Holiday///////////////////////////////////////////////////////////////
                ////kWhh_gain////////
                $kWhh_get_gain = $this->get_gain($key_id_Holiday);
                $kWhh_gain = $kWhh_get_gain->gain;

                ////kWhh_first////////
                $ts_kv_Holiday_first = $this->ts_kv_first($key_id_Holiday, $start_billing);
                $kWhh_first = $ts_kv_Holiday_first->long_v;
                $kWhh_first_DivideGain = $kWhh_first / $kWhh_gain;
                $kWhh_first_ts = $ts_kv_Holiday_first->ts;
                echo "พลังงานไฟฟ้า Holiday เลขอ่านครั้งก่อน = " . date("Y-m-d H:i:s", $kWhh_first_ts / 1000) . " long_v = " . $kWhh_first_DivideGain . "<br>";

                ////kWhp_last////////
                $ts_kv_Holiday_last = $this->ts_kv_first($key_id_Holiday, $end_billing);
                $kWhh_last = $ts_kv_Holiday_last->long_v;
                $kWhh_last_DivideGain = $kWhh_last / $kWhh_gain;
                $kWhh_last_ts = $ts_kv_Holiday_last->ts;
                echo "พลังงานไฟฟ้า Holiday เลขอ่านครั้งหลัง = " . date("Y-m-d H:i:s", $kWhh_last_ts / 1000) . " long_v = " . $kWhh_last_DivideGain . "<br>";

                ////kWhh////////
                // $kWhh_lastMinusfirst_DivideGain = ($kWhh_last_DivideGain - $kWhh_first_DivideGain) * $CT_VT_Factor;
                $kWhh_lastMinusfirst_DivideGain = $kWhh_last_DivideGain - $kWhh_first_DivideGain;
                echo "พลังงานไฟฟ้า Holiday = " . $kWhh_lastMinusfirst_DivideGain . "<br>";

                echo "อัตราค่าไฟฟ้า Holiday = " . $ch . "<br>";


                // $energy_money_kWhh = number_format($ch * $kWhh_lastMinusfirst_DivideGain,2,".","");
                $energy_money_kWhh = $ch * $kWhh_lastMinusfirst_DivideGain;
                echo "จำนวนเงิน kWhh = " . number_format($energy_money_kWhh, 2, ".", "") . "<br><br>";

                ////sum kWh_DivideGain/////
                $sum_kwh_DivideGain = $kWhp_lastMinusfirst_DivideGain + $kWhop_lastMinusfirst_DivideGain + $kWhh_lastMinusfirst_DivideGain;

                // $EC = ($cp * $kWhp) + ($cop * $kWhop) + ($ch * $kWhh);
                $EC = $energy_money_kWhp + $energy_money_kWhop + $energy_money_kWhh;
                echo "ค่าไฟฟ้า (บาท) = " . number_format($EC, 2, ".", "") . " <br>";

                $money_ft = $sum_kwh_DivideGain * $ft;
                // $EC_Plus_money_ft = number_format($EC + $money_ft,2,".","");
                $EC_Plus_money_ft = $EC + $money_ft;
                echo "ค่าไฟฟ้า+ค่า FT (บาท) =" . number_format($EC_Plus_money_ft, 2, ".", "") . "<br>";

                ////////////เช็คส่วนลด DF////////////
                $from = \Carbon\Carbon::createFromFormat('Y-m-d', "$start_contract");
                $to = \Carbon\Carbon::createFromFormat('Y-m-d', "$billing_date");

                $diff_in_months = $to->diffInMonths($from);
                echo "diff_in_months = " . $diff_in_months . "<br>";

                if ($diff_in_months < 61) {
                    $DF = 17;
                } elseif ($diff_in_months < 121) {
                    $DF = 20;
                } elseif ($diff_in_months >= 121) {
                    $DF = 25;
                }
                // $discount = number_format($EC_Plus_money_ft * ($DF / 100),2,".","");
                $discount = $EC_Plus_money_ft * ($DF / 100);
                echo "ส่วนลดค่าไฟฟ้า (บาท) (ส่วนลด $DF%) =  " . number_format($discount, 2, ".", "") . "<br>";

                // $amount = number_format($EC_Plus_money_ft - $discount,2,".","");
                $amount = $EC_Plus_money_ft - $discount;
                echo "รวมเงินค่าไฟฟ้า (บาท) = " . number_format($amount, 2, ".", "") . "<br>";

                // $vat = number_format($amount * 0.07,2,".","");
                $vat = $amount * 0.07;
                echo "ภาษีมูลค่าเพิ่ม 7% (บาท) = " . number_format($vat, 2, ".", "") . "<br>";

                // $total_amount = number_format($amount + $vat,2,".","");
                $total_amount = $amount + $vat;
                echo "รวมเงินที่ต้องชำระ (บาท) = " . number_format($total_amount, 2, ".", "") . "<br>";

                $Billingmodel = new Billing;
                $Billingmodel->ft = $ft;
                $Billingmodel->cp = $cp;
                $Billingmodel->ch = $ch;
                $Billingmodel->cop = $cop;
                $Billingmodel->effective_start = $effective_start;
                $Billingmodel->effective_end = $effective_end;

                $Billingmodel->kwhp = $kWhp_lastMinusfirst_DivideGain;
                $Billingmodel->kwhp_first_ts = $kWhp_first_ts;
                $Billingmodel->kwhp_first = $kWhp_firstDivideGain;
                $Billingmodel->kwhp_last_ts = $kWhp_last_ts;
                $Billingmodel->kwhp_last = $kWhp_lastDivideGain;

                $Billingmodel->kwhop = $kWhop_lastMinusfirst_DivideGain;
                $Billingmodel->kwhop_first_ts = $kWhop_first_ts;
                $Billingmodel->kwhop_first = $kWhop_first_DivideGain;
                $Billingmodel->kwhop_last_ts = $kWhop_last_ts;
                $Billingmodel->kwhop_last = $kWhop_last_DivideGain;

                $Billingmodel->kwhh = $kWhh_lastMinusfirst_DivideGain;
                $Billingmodel->kwhh_first_ts = $kWhh_first_ts;
                $Billingmodel->kwhh_first = $kWhh_first_DivideGain;
                $Billingmodel->kwhh_last_ts = $kWhh_last_ts;
                $Billingmodel->kwhh_last = $kWhh_last_DivideGain;
                $Billingmodel->sum_kwh = $sum_kwh_DivideGain;
                $Billingmodel->energy_money_kwhp = $energy_money_kWhp;
                $Billingmodel->energy_money_kwhop = $energy_money_kWhop;
                $Billingmodel->energy_money_kwhh = $energy_money_kWhh;
                $Billingmodel->ec = $EC;
                $Billingmodel->money_ft = $money_ft;
                $Billingmodel->EC_Plus_money_ft = $EC_Plus_money_ft;
                $Billingmodel->discount = $discount;
                $Billingmodel->df = $DF;
                $Billingmodel->amount = $amount;
                $Billingmodel->vat = $vat;
                $Billingmodel->total_amount = $total_amount;


                $month_billing = $request->month_billing;
                echo $month_billing;
                $Billingmodel->month_billing = $month_billing;


                $Billingmodel->type = "Manual Auto";
                $Billingmodel->status = "Darft";



                // $date_now2 = thaidate('l j F Y', $date_now);
                $date_now2 = $this->ThaiDate($date_now);
                $pay_date = "20 " . $this->ThaiMonthYear($date_now);
                $month_billing2 = $this->ThaiMonthYear($month_billing);
                $date_last = $this->ThaiDate(date("Y-m-d H:i:s", $ts_last / 1000));;
                $pdf = PDF::loadView('admin/billing/billingPDF', compact('kWh_meter_SN', 'contract_companyTH', 'contract_address', 'month_billing2', 'date_now2', 'contract_companyEN', 'type', 'voltage', 'date_last', 'kWhp_lastDivideGain', 'kWhp_firstDivideGain', 'kWhp_lastMinusfirst_DivideGain', 'cp', 'energy_money_kWhp', 'kWhop_last_DivideGain', 'kWhop_first_DivideGain', 'kWhop_lastMinusfirst_DivideGain', 'cop', 'energy_money_kWhop', 'kWhh_last_DivideGain', 'kWhh_first_DivideGain', 'kWhh_lastMinusfirst_DivideGain', 'ch', 'energy_money_kWhh', 'sum_kwh_DivideGain', 'EC', 'ft', 'money_ft', 'EC_Plus_money_ft', 'discount', 'amount', 'vat', 'total_amount', 'pay_date'));
                $part_pdf = "pdf/" . $month_billing . "_" . strtotime("$date_now") . ".pdf";
                $pdf->save("$part_pdf"); //save เฉยๆ

                // return $pdf->stream();
                $Billingmodel->pdf = "$part_pdf";

                $Billingmodel->save();
                return redirect()->route('allBillings')->with('success', "บันทึกข้อมูลเรียบร้อย");
            } else {
                echo "ไม่สามารถทำ billing ได้";
            }
        } else {
            echo "No date contract  ====> " . $count_contract;
        }
    }
    public function billingManualAdd()
    {
        $allparameters = Parameter::all();
        return view('admin/billing/billingManualAdd', compact('allparameters'));
    }
    public function billingManualAddChk(Request $request)
    {
        $request->validate([
            'ft' => ['required'],
            'cp' => ['required'],
            'cop' => ['required'],
            'ch' => ['required'],
            'df' => ['required'],
            'month_billing' => ['required'],
            'kwhp_first_long_v' => ['required'],
            'kwhp_last_long_v' => ['required'],
            'kwhop_first_long_v' => ['required'],
            'kwhop_last_long_v' => ['required'],
            'kwhh_first_long_v' => ['required'],
            'kwhh_last_long_v' => ['required'],

        ]);
        //บันทึกข้อมูล
        $date_now = date("Y-m-d H:i:s");

        /////////CT_VT_Factor///////////////
        // $date_contract = DB::table('contracts')->orderBy('id', 'desc')->first();
        // $CT_VT_Factor = $date_contract->CT_VT_Factor;
        // echo "CT_VT_Factor = " . $CT_VT_Factor . "<br>";
        $contract = DB::table('contracts')->orderBy('id', 'desc')->first();
        $contract_companyEN = $contract->contract_companyEN;
        $contract_companyTH = $contract->contract_companyTH;
        $contract_address = $contract->contract_address;
        $kWh_meter_SN = $contract->kWh_meter_SN;
        $type =  $contract->type;
        $voltage = $contract->voltage;

        $ft = $request->ft;

        // $kwhp = ($request->kwhp_last_long_v - $request->kwhp_first_long_v) * $CT_VT_Factor;
        $kwhp = $request->kwhp_last_long_v - $request->kwhp_first_long_v;
        echo "kwhp = " . $kwhp . "<br>";

        // $kwhop = ($request->kwhop_last_long_v - $request->kwhop_first_long_v) * $CT_VT_Factor;
        $kwhop = $request->kwhop_last_long_v - $request->kwhop_first_long_v;
        echo "kwhop = " . $kwhop . "<br>";

        // $kwhh = ($request->kwhh_last_long_v - $request->kwhh_first_long_v) * $CT_VT_Factor;
        $kwhh = $request->kwhh_last_long_v - $request->kwhh_first_long_v;
        echo "kwhh = " . $kwhh . "<br>";

        $sum_kwh = $kwhp + $kwhop + $kwhh;

        $energy_money_kWhp = $kwhp * $request->cp;
        $energy_money_kWhop = $kwhop * $request->cop;
        $energy_money_kWhh = $kwhh * $request->ch;

        $EC = $energy_money_kWhp + $energy_money_kWhop + $energy_money_kWhh;

        $money_ft = $sum_kwh * $request->ft;
        $EC_Plus_money_ft = $EC + $money_ft;
        $discount =  $EC_Plus_money_ft * ($request->df / 100);
        $DF = $request->df;
        $amount = $EC_Plus_money_ft - $discount;
        echo "amount = EC_Plus_money_ft $EC_Plus_money_ft + discount $discount =" . $amount;
        $vat = $amount * 0.07;
        $total_amount = $amount + $vat;


        $BillingManualAdd = new Billing;
        $BillingManualAdd->ft = $request->ft;
        $BillingManualAdd->cp = $request->cp;
        $cp = $request->cp;
        $BillingManualAdd->cop = $request->cop;
        $cop = $request->cop;
        $BillingManualAdd->ch = $request->ch;
        $ch = $request->ch;
        // $BillingManualAdd->effective_start = $effective_start;
        // $BillingManualAdd->effective_end = $effective_end;

        $BillingManualAdd->kwhp = $kwhp;
        $kWhp_lastMinusfirst_DivideGain = $kwhp;
        // $BillingManualAdd->kwhp_first_ts = "";
        $BillingManualAdd->kwhp_first = $request->kwhp_first_long_v;
        $kWhp_firstDivideGain = $request->kwhp_first_long_v;

        // $BillingManualAdd->kwhp_last_ts = "";
        $BillingManualAdd->kwhp_last = $request->kwhp_last_long_v;
        $kWhp_lastDivideGain = $request->kwhp_last_long_v;

        $BillingManualAdd->kwhop = $kwhop;
        $kWhop_lastMinusfirst_DivideGain = $kwhop;
        // $BillingManualAdd->kwhop_first_ts = "";
        $BillingManualAdd->kwhop_first = $request->kwhop_first_long_v;
        $kWhop_first_DivideGain = $request->kwhop_first_long_v;

        // $BillingManualAdd->kwhop_last_ts = "";
        $BillingManualAdd->kwhop_last = $request->kwhop_last_long_v;
        $kWhop_last_DivideGain = $request->kwhop_last_long_v;

        $BillingManualAdd->kwhh = $kwhh;
        $kWhh_lastMinusfirst_DivideGain = $kwhh;
        // $BillingManualAdd->kwhh_first_ts = "";
        $BillingManualAdd->kwhh_first = $request->kwhh_first_long_v;
        $kWhh_first_DivideGain = $request->kwhh_first_long_v;
        // $BillingManualAdd->kwhh_last_ts = "";
        $BillingManualAdd->kwhh_last = $request->kwhh_last_long_v;
        $kWhh_last_DivideGain = $request->kwhh_last_long_v;

        $BillingManualAdd->sum_kwh = $sum_kwh;
        $sum_kwh_DivideGain = $sum_kwh;
        $BillingManualAdd->energy_money_kwhp = $energy_money_kWhp;
        $BillingManualAdd->energy_money_kwhop = $energy_money_kWhop;
        $BillingManualAdd->energy_money_kwhh = $energy_money_kWhh;
        $BillingManualAdd->ec = $EC;
        $BillingManualAdd->money_ft = $money_ft;
        $BillingManualAdd->EC_Plus_money_ft = $EC_Plus_money_ft;
        $BillingManualAdd->discount = $discount;
        $BillingManualAdd->df = $DF;
        $BillingManualAdd->amount = $amount;
        $BillingManualAdd->vat = $vat;
        $BillingManualAdd->total_amount = $total_amount;



        $BillingManualAdd->month_billing = $request->month_billing;


        $BillingManualAdd->type = "Manual Add";
        $BillingManualAdd->status = "Darft";


        //////หา ts ของเดือน////////
        // $ts_kv_On_Peak_last = $this->ts_kv_last($key_id_On_Peak, $end_billing - 1);
        // $ts_last = $ts_kv_On_Peak_last->ts;
        // echo "ts สุดท้ายของเดือน = " . date("Y-m-d H:i:s", $ts_last / 1000) . "<br>";

        $date_now2 = $this->ThaiDate($date_now);
        $pay_date = "20 " . $this->ThaiMonthYear($date_now);
        // $month_billing2 = $this->ThaiMonthYear($month_billing);
        // $date_last = $this->ThaiDate(date("Y-m-d H:i:s", $ts_last / 1000));

        $month_billing2 = $this->ThaiMonthYear($request->month_billing);
        $date_last_month = (new DateTime($request->month_billing . "-01"))->modify('+1 month')->format('Y-m-d');
        $date_last_Ymd = (new DateTime($date_last_month))->modify('-1 day')->format('Y-m-d');
        $date_last = $this->ThaiDate($date_last_Ymd);

        $pdf = PDF::loadView('admin/billing/billingPDF', compact('kWh_meter_SN', 'contract_companyTH', 'contract_address', 'month_billing2', 'date_now2', 'contract_companyEN', 'type', 'voltage', 'date_last', 'kWhp_lastDivideGain', 'kWhp_firstDivideGain', 'kWhp_lastMinusfirst_DivideGain', 'cp', 'energy_money_kWhp', 'kWhop_last_DivideGain', 'kWhop_first_DivideGain', 'kWhop_lastMinusfirst_DivideGain', 'cop', 'energy_money_kWhop', 'kWhh_last_DivideGain', 'kWhh_first_DivideGain', 'kWhh_lastMinusfirst_DivideGain', 'ch', 'energy_money_kWhh', 'sum_kwh_DivideGain', 'EC', 'ft', 'money_ft', 'EC_Plus_money_ft', 'discount', 'amount', 'vat', 'total_amount', 'pay_date'));
        $part_pdf = "pdf/" . $request->month_billing . "_" . strtotime("$date_now") . ".pdf";
        $pdf->save("$part_pdf"); //save เฉยๆ
        $BillingManualAdd->pdf = "$part_pdf";



        $BillingManualAdd->save();

        // $manualAdd->save();
        return redirect()->route('allBillings')->with('success', "บันทึกข้อมูลเรียบร้อย");
    }

    // public function billingManualAddChk_backup(Request $request)
    // {
    //     $request->validate([
    //         'ft' => ['required'],
    //         'cp' => ['required'],
    //         'cop' => ['required'],
    //         'ch' => ['required'],
    //         'df' => ['required'],
    //         'month_billing' => ['required'],
    //         'kwhp_first_long_v' => ['required'],
    //         'kwhp_last_long_v' => ['required'],
    //         'kwhop_first_long_v' => ['required'],
    //         'kwhop_last_long_v' => ['required'],
    //         'kwhh_first_long_v' => ['required'],
    //         'kwhh_last_long_v' => ['required'],

    //     ]);
    //     //บันทึกข้อมูล

    //     $key_id_On_Peak = $this->key_id_On_Peak;
    //     $key_id_Off_Peak = $this->key_id_Off_Peak;
    //     $key_id_Holiday = $this->key_id_Holiday;

    //     /////////CT_VT_Factor///////////////
    //     // $date_contract = DB::table('contracts')->orderBy('id', 'desc')->first();
    //     // $CT_VT_Factor = $date_contract->CT_VT_Factor;
    //     // echo "CT_VT_Factor = " . $CT_VT_Factor . "<br>";



    //     $manualAdd = new Billing;
    //     $manualAdd->ft = $request->ft;
    //     $manualAdd->cp = $request->cp;
    //     $manualAdd->cop = $request->cop;
    //     $manualAdd->ch = $request->ch;
    //     $manualAdd->df = $request->df;
    //     $manualAdd->month_billing = $request->month_billing;

    //     $kwhp_get_gain = $this->get_gain($key_id_On_Peak);
    //     $kwhp_gain = $kwhp_get_gain->gain;
    //     $kwhp = $request->kwhp_last_long_v - $request->kwhp_first_long_v;
    //     // $manualAdd->kwhp = $kwhp * $kwhp_gain * $CT_VT_Factor;
    //     $manualAdd->kwhp = $kwhp * $kwhp_gain;
    //     $manualAdd->kwhp_first_long_v = $request->kwhp_first_long_v * $kwhp_gain;
    //     $manualAdd->kwhp_last_long_v = $request->kwhp_last_long_v * $kwhp_gain;


    //     $kwhop_get_gain = $this->get_gain($key_id_Off_Peak);
    //     $kwhop_gain = $kwhop_get_gain->gain;
    //     $kwhop = $request->kwhop_last_long_v - $request->kwhop_first_long_v;
    //     // $manualAdd->kwhop =  $kwhop * $kwhop_gain * $CT_VT_Factor;
    //     $manualAdd->kwhop =  $kwhop * $kwhop_gain;
    //     $manualAdd->kwhop_first_long_v = $request->kwhop_first_long_v * $kwhop_gain;
    //     $manualAdd->kwhop_last_long_v = $request->kwhop_last_long_v * $kwhop_gain;

    //     $kwhh_get_gain = $this->get_gain($key_id_Holiday);
    //     $kwhh_gain = $kwhh_get_gain->gain;
    //     $kwhh = $request->kwhh_last_long_v - $request->kwhh_first_long_v;
    //     // $manualAdd->kwhh = $kwhh * $kwhh_gain * $CT_VT_Factor;
    //     $manualAdd->kwhh = $kwhh * $kwhh_gain;
    //     $manualAdd->kwhh_first_long_v = $request->kwhh_first_long_v * $kwhh_gain;
    //     $manualAdd->kwhh_last_long_v = $request->kwhh_last_long_v * $kwhh_gain;
    //     $manualAdd->type = "Manual Add";
    //     $manualAdd->status = "Review";

    //     //คำนวณ EC =(Cp x kWhp) + (Cop x kWhop) + (Ch x kWhh)
    //     $ec = ($request->cp * $kwhp) + ($request->cop * $kwhop) + ($request->ch * $kwhh);
    //     $manualAdd->ec = $ec;

    //     //คำนวณ FC = Ft x (kWhp + kWhop + kWhh)
    //     $fc = $request->ft * ($kwhp + $kwhop + $kwhh);
    //     $manualAdd->fc = $fc;

    //     //คำนวณ EPP =(1 - DF) x (EC + FC)
    //     $epp = (1 - $request->df / 100) * ($ec + $fc);
    //     $manualAdd->epp = $epp;


    //     $manualAdd->save();
    //     return redirect()->route('allBillings')->with('success', "บันทึกข้อมูลเรียบร้อย");
    // }
    public function billingPDF()
    {
        // $Billing = Billing::findOrFail($id);
        // return view('admin/billing/billingPDF');
        // return view('admin/billing/billingPDF', compact('Billing'));

        $Contract = Contract::all();

        $pdf = PDF::loadView('admin/billing/billingPDF', compact('Contract'));
        // $pdf->save('result.pdf'); //save เฉยๆ
        return $pdf->stream(); //เปิดไฟล์เลยไม่ save
    }
    public function viewData(Request $request)
    {

        $date_start = date($request->date_start);
        $strtotime_date_start =  strtotime("$date_start") * 1000;
        $date_end = date($request->date_end);
        $strtotime_date_end = (strtotime("$date_end") + 86400) * 1000;

        // $ts_kv_dictionary = DB::table('ts_kv_dictionary')
        //     ->orderBy('key', 'asc')->get();

        $ts_kv_dictionary = DB::table('ts_kv_latest')
            ->rightJoin('device', 'ts_kv_latest.entity_id', '=', 'device.id')
            ->leftJoin('ts_kv_dictionary', 'ts_kv_latest.key', '=', 'ts_kv_dictionary.key_id')
            ->WhereNotNull('ts_kv_latest.entity_id')
            ->where('ts_kv_dictionary.key', 'NOT LIKE', '%events%')
            ->where('ts_kv_dictionary.key', 'NOT LIKE', '%Events%')
            ->select('ts_kv_latest.entity_id', 'ts_kv_latest.key', 'ts_kv_latest.ts', 'ts_kv_latest.long_v', 'ts_kv_dictionary.key', 'ts_kv_dictionary.key_id')
            ->orderBy('ts_kv_dictionary.key', 'asc')->get();

        if ($request->ts_kv_dictionary != "") {
            $order = $request->order;
            $sort = $request->sort;

            $ts_kv = DB::table('ts_kv')
                ->leftJoin('ts_kv_dictionary', 'ts_kv.key', '=', 'ts_kv_dictionary.key_id')
                ->leftJoin('gains', 'ts_kv.key', '=', 'gains.key')
                ->WhereIn('ts_kv.key', $request->ts_kv_dictionary)
                ->Where('ts', '>', $strtotime_date_start)
                ->Where('ts', '<', $strtotime_date_end)
                ->select('ts_kv.*', 'ts_kv_dictionary.key AS key_name', 'gains.gain', 'gains.unit')
                ->orderBy($order, $sort)->get();
        } else {
            $ts_kv = null;
        }
        return view('admin/data/viewData', compact('ts_kv_dictionary'), compact('ts_kv'));
    }
    public function viewGain()
    {
        $ts_kv_dictionary = DB::table('ts_kv_dictionary')
            ->leftJoin('gains', 'ts_kv_dictionary.key_id', '=', 'gains.key')
            ->select('ts_kv_dictionary.*', 'gains.gain', 'gains.unit', 'gains.created_at', 'gains.updated_at')
            ->orderBy('key', 'asc')->get();

        $ts_kv_dictionary = DB::table('ts_kv_latest')
            ->rightJoin('device', 'ts_kv_latest.entity_id', '=', 'device.id')
            ->leftJoin('ts_kv_dictionary', 'ts_kv_latest.key', '=', 'ts_kv_dictionary.key_id')
            ->leftJoin('gains', 'ts_kv_dictionary.key_id', '=', 'gains.key')
            ->where('ts_kv_dictionary.key', 'NOT LIKE', '%events%')
            ->where('ts_kv_dictionary.key', 'NOT LIKE', '%Events%')
            ->WhereNotNull('ts_kv_latest.entity_id')
            // ->select('ts_kv_latest.entity_id', 'ts_kv_latest.key', 'ts_kv_latest.ts', 'ts_kv_latest.long_v', 'ts_kv_dictionary.key', 'ts_kv_dictionary.key_id')
            ->select('ts_kv_dictionary.*', 'gains.gain', 'gains.unit', 'gains.created_at', 'gains.updated_at')

            ->orderBy('ts_kv_latest.key', 'asc')->get();
        return view('admin/data/viewGain', compact('ts_kv_dictionary'));
    }


    public function gainEditID($id)
    {

        $ts_kv_dictionary = DB::table('ts_kv_dictionary')
            ->leftJoin('gains', 'ts_kv_dictionary.key_id', '=', 'gains.key')
            ->where([
                ['ts_kv_dictionary.key_id', '=', $id],
            ])
            ->select('ts_kv_dictionary.*', 'gains.gain', 'gains.unit', 'gains.created_at', 'gains.updated_at')
            ->orderBy('key', 'asc')->first();
        return view('admin/data/gainEditForm', compact('ts_kv_dictionary'));
    }
    public function gainChk(Request $request, $key)
    {
        $request->validate([
            'gain' => ['required'],
        ], [
            'gain.required' => 'กรุณากรอกข้อมูล gain',
        ]);

        $count = DB::table('gains')
            ->where("key", "=", "$key")
            ->count();
        // echo $request->gain;
        // dd($count);

        if ($count > 0) {
            // $update = Gain::updateOrCreate("key", "$key");
            // $update->gain = $request->gain;

            // $update->save();
            Gain::where('key', $key)
                ->update(['gain' => $request->gain, 'unit' => $request->unit]);
        } else {
            $Gain = new Gain;
            $Gain->key = $key;
            $Gain->gain = $request->gain;
            $Gain->unit = $request->unit;
            $Gain->save();
        }


        return redirect()->route('viewGain')->with('success', "บันทึกข้อมูล เรียบร้อย");
    }


    function ts_kv_first($key_id, $start_billing)
    {
        $ts_kv = DB::table('ts_kv')
            ->where([
                ['key', '=', $key_id],
                ['ts', '>', $start_billing],
            ])
            ->orderBy('ts', 'asc')->first();
        return $ts_kv;
    }
    function ts_kv_last($key_id, $end_billing)
    {
        $ts_kv = DB::table('ts_kv')
            ->where([
                ['key', '=', $key_id],
                ['ts', '<', $end_billing],
            ])
            ->orderBy('ts', 'desc')->first();
        return $ts_kv;
    }
    function get_gain($key)
    {
        $get_gain = DB::table('gains')
            ->where([
                ['key', '=', $key],
            ])->first();
        return $get_gain;
    }
    public static function ThaiDate($arg)
    {
        $thai_months = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];
        $date = Carbon::parse($arg);
        $month = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("j $month $year");
    }
    public static function ThaiMonthYear($arg)
    {
        $thai_months = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];
        $date = Carbon::parse($arg);
        $month = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("$month $year");
    }
    public static function ThaiDateShot($arg)
    {
        $thai_months = [
            1 => 'ม.ค.',
            2 => 'ก.พ.',
            3 => 'มี.ค.',
            4 => 'เม.ย.',
            5 => 'พ.ค.',
            6 => 'มิ.ย.',
            7 => 'ก.ค.',
            8 => 'ส.ค.',
            9 => 'ก.ย.',
            10 => 'ต.ค.',
            11 => 'พ.ย.',
            12 => 'ธ.ค.',
        ];
        $date = Carbon::parse($arg);
        $month = $thai_months[$date->month];
        $year = $date->year + 543;
        return $date->format("j $month $year H:i:s");
    }
    // ========== [ Compose Email ] ================

    function sendmail()
    {
        // $file =  public_path('pdf/2022-05_1654016400.pdf');
        // $mailData = [
        //     'title' => 'Mail from PICO',
        //     'body' => 'This is for testing email using smtp.',
        //     'file' => $file // file attached here
        // ];
        // Mail::to('benchapol@pico.co.th')->send(new Mailer($mailData));
        // // dd("Email is sent successfully.");
        // return 'Email was sent';

        $data["email"] = "benchapol@pico.co.th";
        $data["title"] = "Mail from PICO 1";
        $data["body"] = "This is for testing email using smtp.";

        $title = "Mail from PICO";

        $files = [
            public_path('pdf/2022-05_1654016400.pdf')
        ];

        Mail::send('mailForm.mailBilling', compact('title'), function ($message) use ($data, $files) {
            $message->to($data["email"])
                ->subject($data["title"]);

            foreach ($files as $file) {
                $message->attach($file);
            }
        });

        echo "Mail send successfully !!";
    }

    function billingSendEmail($id)
    {

        $billings = DB::table('billings')
            ->where('id', '=', $id)
            ->get()->first();


        $data["email"] = "benchapol@pico.co.th";
        // $pay_date = "20 ".$this->ThaiMonthYear($date_now);
        $data["title"] = "บิลค่าไฟประจำเดือน " . $this->ThaiMonthYear($billings->month_billing);
        $data["body"] = "รายละเอียดตามไฟล์แนบ";

        // $title = "Mail from PICO";

        $files = [
            public_path("$billings->pdf")
        ];

        Mail::send('mailForm.billingSendEmail', compact('data'), function ($message) use ($data, $files) {
            $message->to($data["email"])
                ->subject($data["title"]);

            foreach ($files as $file) {
                $message->attach($file);
            }
        });

        $Billingupdate = Billing::find($id);
        $Billingupdate->status = "Sent Email";
        $Billingupdate->save();

        // return redirect()->route('allBillings')->with('success', "ส่งเมลเรียบร้อย");

        // echo "Mail send successfully !!";
    }
    function billingFailSendEmail($messagefail)
    {

        $data["email"] = "benchapol@pico.co.th";
        // $pay_date = "20 ".$this->ThaiMonthYear($date_now);
        $month_now = date("Y-m");
        $data["title"] = "Fail บิลค่าไฟประจำเดือน " . $this->ThaiMonthYear($month_now);
        $data["body"] = "$messagefail";


        Mail::send('mailForm.billingSendEmail', compact('data'), function ($message) use ($data) {
            $message->to($data["email"])
                ->subject($data["title"]);
        });
    }
    public function test()
    {
        return true;
    }
}
