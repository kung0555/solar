<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> -->
    <title>PDF Billing</title>
    <style>
        /* tr {
            height: 15px;
        }

        td {
            font-size: 16px;
        } */

        /* @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        } */

        /* @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        }
*/
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: 'THSarabunNew';
        }

        .head {
            
            margin: 0px;
            padding: 0px;
            font-weight: bolder;
            font-size: 22px;
            line-height: 80%;
        }

        .tablebody {
            /* margin: 0px;
            padding: 0px; */
            line-height: 70%;
        }
    </style>
</head>

<body>
    

    <table class="tablebody" border="1" style="border-color:white;padding-left: 40px;padding-top: 10px;" cellpadding="0" cellspacing="0" width="100%">
        <tr >
            <td colspan="4" style="border-right-style:hidden;border-bottom-style:hidden;">
                <table border="0" style="border-color: white;" cellpadding="5" cellspacing="0" width="100%">
                    <tr>
                        <td style="text-align:center;border-style-right:hidden;" width="10%">
                            <img src="img/logo_RPCG.png" width="150px" alt="tag">
                        </td>
                        <td>
                            <span class="head">บริษัท อาร์พีซี จำกัด (มหาชน)</span>
                            <br>
                            <span class="head">RPCG PUBLIC COMPANY LIMITED</span>
                            <br>
                            <span style="font-size:20px;line-height: 80%">Tax ID Number 0-1075-46000-20-2</span>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="text-align:center;padding:20px;border-right-style: hidden;font-weight:bold;">
                <span style="font-size:20px;">หนังสือแจ้งค่าไฟฟ้า</span>
                <br>
                <span style="font-size:20px;">PPA Electric Bill</span>
            </td>
        </tr>
        <tr style="border-style:hidden;">
            <td style="border-style:hidden;">สัญญาเลขที่ : </td>
            <td style="border-style:hidden;">{{$kWh_meter_SN}}</td>
            <td style="border-style:hidden;"></td>
            <td style="color:blue;border-style:hidden;"><span style="color:black">วันที่ : </span> {{ $date_now2 }}</td>
        </tr>
        <tr style="border-style:hidden;">
            <td style="border-style:hidden;">เรื่อง : </td>
            <td style="border-style:hidden;">แจ้งค่าไฟฟ้า</td>
            <td style="border-style:hidden;"></td>
            <td style="border-style:hidden;"></td>
        </tr>
        <tr>
            <td style="border-style:hidden;">เรียน : </td>
            <td style="border-style:hidden;">{{ $contract_companyTH }}</td>
            <td style="border-style:hidden;"></td>
            <td style="border-style:hidden;"></td>
        </tr>
        <tr>
            <td style="border-style:hidden;"></td>
            <td style="border-style:hidden;">{{ $contract_address }}</td>
            <td style="border-style:hidden;"></td>
            <td style="border-style:hidden;"></td>
        </tr>
        <tr>
            <td style="border-style:hidden;"></td>
            <td style="padding-top: 20px;border-style:hidden;">หนังสือแจ้งค่าไฟฟ้าประจำเดือน &nbsp;&nbsp;&nbsp;&nbsp;<span
                    style="color:blue;">{{ $month_billing2 }}</span></td>
            <td style="border-style:hidden;"></td>
            <td style="border-style:hidden;"></td>
            
        </tr>
        <tr>
            <td colspan="4" style="border-style:hidden;">
                <table border="1" style="text-align:center;border-color:black;font-weight:bold;" width="100%" cellpadding="0"
                    cellspacing="0">
                        <tr>
                            <th width="200px">Customer</th>
                            <th>kWg Meter S/N:</th>
                            <th>Type</th>
                            <th>Voltage</th>
                            <th>Date</th>
                        </tr>
                    <tr>
                        <td>{{$contract_companyEN}}</td>
                        <td>{{ $kWh_meter_SN }}</td>
                        <td>{{ $type }}</td>
                        <td>{{$voltage}}</td>
                        <td style="color:blue;">{{$date_last}}</td>
                    </tr>
                </table>
               
            </td>
        </tr>

        <tr>
            <td colspan="4" style="padding-top: 20px;border-right-style: hidden;border-bottom-style:hidden;" >
                <table border="1" width="100%" height="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td rowspan="5" style="width:110px;padding-left:3px;">
                            พลังงานไฟฟ้า (หน่วย) <br>
                            <b>
                                Energy Power (kWh)
                            </b>
                        </td>
                        <td></td>
                        <td style="text-align: center;">เลขอ่านครั้งหลัง</td>
                        <td style="text-align: center;">เลขอ่านครั้งก่อน</td>
                        <td style="text-align: center;">หน่วย(kWh)</td>
                        <td style="text-align: center;">อัตราค่าไฟฟ้า</td>
                        <td style="text-align: center;">จำนวนเงิน</td>
                    </tr>
                    
                    <tr style="border-bottom-style: hidden;">
                        <td style="padding-left:3px;"><b>Peak</b></td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhp_lastDivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhp_firstDivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhp_lastMinusfirst_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:red;padding-right:3px;">{{$cp}}</td>
                        <td style="text-align:right;color:blue;padding-right:3px;">{{number_format($energy_money_kWhp, 2, ".", ",")}}</td>
                    </tr>
                    <tr style="border-bottom-style: hidden;">
                        <td style="padding-left:3px;"><b>Off-Peak</b></td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhop_last_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhop_first_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhop_lastMinusfirst_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:red;padding-right:3px;">{{$cop}}</td>
                        <td style="text-align:right;color:blue;padding-right:3px;">{{number_format($energy_money_kWhop, 2, ".", ",")}}</td>
                    </tr>
                    <tr >
                        <td style="padding-left:3px;"><b>Holiday</b></td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhh_last_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhh_first_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($kWhh_lastMinusfirst_DivideGain, 3, ".", "")}}</td>
                        <td style="border-right-style:hidden;text-align:right;color:red;padding-right:3px;">{{$ch}}</td>
                        <td style="text-align:right;color:blue;padding-right:3px;">{{number_format($energy_money_kWhh, 2, ".", ",")}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2" style="text-align:center;font-weight:bold;">Total Energy Power (kWh)</td>
                        <td style="text-align:right;color:blue;padding-right:3px;">{{number_format($sum_kwh_DivideGain, 3, ".", "")}}</td>
                        <td style="text-align:center;font-weight:bold;border-right-style:hidden;">Total(THB)</td>
                        <td style="text-align:right;color:blue;padding-right:3px;">{{number_format($EC, 2, ".", ",")}}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2"></td>

            <td colspan="2" style="border-style:hidden;">
                <table border="1" width="100%" cellpadding="0" cellspacing="0">
                    <tr>

                        <td style="text-align: right;padding-right: 20px;border-style:hidden;">ค่า FT(THB/kWh)</td>
                        <td style="border-style:hidden;text-align:right;color:red;padding-right:3px;">{{$ft}}</td>
                    </tr>
                    <tr>

                        <td style="text-align: right;padding-right: 20px;border-style:hidden">จำนวนเงินค่า FT(THB)</td>
                        <td style="border-style:hidden;text-align:right;color:blue;padding-right:3px;">{{number_format($money_ft, 2, ".", ",")}}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-style:hidden;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border-top-style:hidden;border-left-style:hidden;border-right-style: hidden;">&nbsp;</td>
                    </tr>
                    <tr  style="border-bottom-style: hidden;">

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;">ค่าไฟฟ้า (บาท)</td>
                        <td style="color:blue;text-align:right;padding-right:3px;">{{number_format($EC, 2, ".", ",")}}</td>
                    </tr>
                    
                    <tr style="border-bottom-style: hidden;">

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;">ค่าไฟฟ้า+ค่า FT(บาท)</td>
                            <td style="color:blue;text-align:right;padding-right:3px;">{{number_format($EC_Plus_money_ft, 2, ".", ",")}}</td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align:right;font-weight:bold;border-bottom-style:hidden;">&nbsp;</td>

                    </tr>

                    <tr style="border-bottom-style: hidden;">

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;font-weight:bold;">ส่วนลดค่าไฟฟ้า (บาท)</td>
                        <td style="color:blue;text-align:right;font-weight:bold;padding-right:3px;">{{number_format($discount, 2, ".", ",")}}</td>
                    </tr>
                    <tr style="border-bottom-style: hidden;">

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;font-weight:bold;">(ส่วนลด 17%)</td>
                        <td style="color:blue;text-align:right;font-weight:bold;"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:right;font-weight:bold;border-bottom-style:hidden;">&nbsp;</td>

                    </tr>

                    <tr style="border-bottom-style: hidden;">

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;">รวมเงินค่าไฟฟ้า (บาท)</td>
                        <td style="color:blue;text-align:right;padding-right:3px;">{{number_format($amount, 2, ".", ",")}}</td>
                    </tr>
                    <tr >

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;">ภาษีมูลค่าเพิ่ม 7% (บาท)</td>
                        <td style="color:blue;text-align:right;padding-right:3px;">{{number_format($vat, 2, ".", ",")}}</td>
                    </tr>
                    <tr>

                        <td style="text-align: right;padding-right: 20px;border-right-style:hidden;font-weight:bold;">รวมเงินที่ต้องชำระ (บาท)</td>
                        <td style="font-weight:bold;color:blue;text-align:right;padding-right:3px;">{{number_format($total_amount, 2, ".", ",")}}</td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- <tr style="padding-top: 100px;">
            <td></td>
            <td></td>
            <td>ค่า FT(THB/kWh)</td>
            <td>-0.1243</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>จำนวนเงินค่า FT(THB)</td>
            <td>(16,647.75)</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>ค่าไฟฟ้า (บาท)</td>
            <td>425,128.17</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>ค่าไฟฟ้า+ค่า FT(บาท)</td>
            <td>408,480.42</td>
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td>ส่วนลดค่าไฟฟ้า (บาท)<br>(ส่วนลด 17%)</td>
            <td>69,441.67</td>
        </tr>
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td>รวมเงินค่าไฟฟ้า (บาท)</td>
            <td>23,732.71</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>รวมเงินที่ต้องชำระ (บาท)</td>
            <td>362.771.46</td>
        </tr> --}}
        <tr>
            <td colspan="4" style="border-style: hidden;">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4" style="border-style: hidden;">&nbsp;</td>
        </tr>
        <tr>
            <td  style="border-style: hidden;width:60px;font-weight:bold;">หมายเหตุ : </td>
            <td  style="border-style: hidden;font-weight:bold;font-style: italic;">1. โปรดชำระเงินภายในวันที่ <span style="color:blue;margin-left:50px;">{{ $pay_date }}</span></td>
            <td  style="border-style: hidden;"></td>
            <td  style="border-style: hidden;"></td>

        </tr>
        <tr>
            <td  style="border-style: hidden;"></td>
            <td  style="border-style: hidden;font-style: italic;">2. ส่วนลดค่าไฟฟ้าตลอดอายุสัญญา</td>
            <td  style="border-style: hidden;"></td>
            <td  style="border-style: hidden;"></td>
        </tr>
        <tr>
            <td></td>
            <td style="border-style: hidden;padding-left:40px;font-style: italic;">ปีที่ 1-5 :17%</td>
            <td style="border-style: hidden;"></td>
            <td style="border-style: hidden;"></td>
        </tr>
        <tr>
            <td style="border-style: hidden;"></td>
            <td style="border-style: hidden;padding-left:40px;font-style: italic;">ปีที่ 6-10 :20%</td>
            <td style="border-style: hidden;"></td>
            <td style="border-style: hidden;"></td>
        </tr>
        <tr>
            <td style="border-style: hidden;"></td>
            <td style="border-style: hidden;padding-left:40px;font-style: italic;">ปีที่ 11-15 :25%</td>
            <td style="border-style: hidden;"></td>
            <td style="border-style: hidden;"></td>
        </tr>
        <tr>
            <td  style="border-style: hidden;"></td>
            <td  style="border-style: hidden;font-style: italic;color:red">3. เริ่มเก็บข้อมูลการจ่ายไฟฟ้าเข้าระบบตั้งแต่วันที่ 6 พฤษภาคม 2565</td>
            <td  style="border-style: hidden;"></td>
            <td  style="border-style: hidden;"></td>
        </tr>
    </table>
    <br>
    {{-- <center><a href="{{ route('downloadPdf') }}">Download PDF</a></center> --}}
</body>

</html>
