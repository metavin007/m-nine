<style>
    @page { margin: 100px 25px; }
    header {
        position: fixed;
        top: -60px;
        left: 0px;
        right: 0px;
        height: 50px;
    }
    .pagenum:before {
        content: counter(page) ' / ' counter(pages);
    }
    .pageNumbers:before {
        counter-reset: pageTotal;
    }
    footer {
        position: fixed;
        bottom: 0px;
        left: 0px;
        right: 0px;
        height: 50px;
    }

    table, th, td {
        width:100%;
    }
    br{
        margin-top: -50px;
    }
    #pageCounter span {
        counter-increment: pageTotal;
    }
    .page-number:before {
        counter-increment: currentPage;
        content: counter(page) ' / ' counter(pageTotal);
    }
</style>

<body>
    <?php
    $details = $receipt->receipt_detail;
    $check_page_last = count($details);
    $limit_page = 10;
    ?>
    <div id="pageCounter">
        <span></span>
        <?php
        if (count($details) > 0) {
            foreach ($details as $key => $value) {
                if (($check_page_last - $key) <= $limit_page) {
                    $last_page = true;
                } else {
                    $last_page = false;
                }
                if (($key % $limit_page) == 0) {
                    if (!$last_page) {
                        echo '<span></span>';
                    }
                }
            }
        }
        ?>
    </div>

    <header>
        <table>
            <tr>
                <td style="width: 10%; vertical-align: top;" rowspan="5">
                    <img src="{{ asset('assets/logo/logopng.jpg') }}" width="160">
                </td>
                <td style="width: 90%;">
                    <div style="color:#000000; font-size: 26px; line-height: 60%;"><b>{{ $mycompany->name_th }}</b></div>
                    <div style="color:#000000; font-size: 20px; line-height: 60%;"><b>{{ $mycompany->name_en }}</b></div>
                    <div style="color:#000000; font-size: 18px; line-height: 30%; color: white;"><b>x</b></div>
                    <div style="color:#000000; font-size: 15px; line-height: 60%;"><b>{{ $mycompany->address_th . ' ' }} Tel :  {{ $mycompany->tel }}</b></div>
                    <div style="color:#000000; font-size: 15px; line-height: 60%;"><b>{{ $mycompany->address_en . ' ' }} Tel :  {{ $mycompany->tel }}</b></div>
                    <div style="color:#000000; font-size: 15px; line-height: 60%;"><b>เลขประจำตัวผู้เสียภาษีอากร/TAX ID NO.: {{ $mycompany->tax_id_no }}</b></div>
                </td>
            </tr>
        </table>

        <div style="margin-top: -90px;"></div>

        <table>
            <tr>
                <td style="font-size: 22px; color:#000000; text-align: center;"><b>สำเนา ใบเสร็จรับเงิน / ใบกำกับภาษี</b></td>
            </tr>
            <tr>
                <td style="font-size: 20px; color:#000000; text-align: center; line-height: 30%;"><b>OFFICIAL RECEIPT / TAX INVOICE  ORIGINAL</b></td>
            </tr>
        </table>

        <div style="margin-top: 10px;"></div>

        <table>
            <tr>
                <td style="width: 120px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b></b></div></td>
                <td style="width: 10px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                <td style="width: 100px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Page No</b></div></td>
                <td style="width: 10px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td style="width: 180px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><span class="page-number"></span></div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Vat rate 7.00%</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Receipt No.</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $receipt->receipt_no }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Date / วันที่</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ date('d/m/Y', strtotime($receipt->date_add)) }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>ได้รับเงินจาก</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $receipt->customer->company_name_thai }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Tax ID No.</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $receipt->customer->tax_id_no . ' ' . $receipt->customer->branch }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Received from</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $receipt->customer->company_name_eng }}</div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"></div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Address</b></div></td>
                <td><div style="color:#000000; font-size: 18px; line-height: 60%;"><b>:</b></div></td>
                <td colspan="4"><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $receipt->customer->address_thai }}</div></td>
            </tr>
        </table>

    </header>

    <footer>
        <table>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%; border-bottom: 1px solid;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%; border-bottom: 1px solid;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%; border-bottom: 1px solid;"><b></b></div></td>
            </tr>
            <tr>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>ผู้รับเอกสาร</b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>ผู้รับเงิน</b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>ลายมือชื่อผู้ที่ได้รับมอบอำนาจ</b></div></td>
            </tr>
            <tr>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>RECEIVED BY</b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>COLLECTOR</b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>AUTHORIZED SIGNATURE</b></div></td>
            </tr>
        </table>

        <br/>

        <table>
            <tr>
                <td style="width: 50px;"><div style="color:#000000; font-size: 16px; line-height: 60%;"><u>คำเตือน</u></div></td>
                <td><div style="color:#000000; font-size: 16px; line-height: 60%;">กรุณาตรวจสอบความถูกต้องของเอกสารที่ได้รับ หากมีการแก้ไข ขอให้แจ้งบริษัทฯ ทันที ภายใน 7 วัน มิฉะนั้น บริษัทฯ จะถือว่าเอกสารฉบับนี้สมบูรณ์แล้ว</div></td>
            </tr>
        </table>

        <table>
            <tr>
                <td colspan="2"><div style="color:#000000; font-size: 12px; line-height: 60%;">ถ้าชำระเงินด้วยเช็ค ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์ต่อเมื่อขึ้นเงินตามเช็คได้แล้ว / if payment is made by cheque,this receipt will not be valid until the cheque is honoured by the bank.</div></td>
            </tr>
            <tr>
                <td colspan="2"><div style="color:#000000; font-size: 12px; line-height: 60%;">โปรดชำระด้วยเช็คขีดคร่อมสั่งจ่าย บริษัท เอ็ม-ไนน์ (ประเทศไทย) จำกัด/ Please made a Crossed cheque payable to M-NINE (THAILAND) Limited</div></td>
            </tr>
        </table>
    </footer>

    <?php
    if (count($details) > 0) {
        foreach ($details as $key => $value) {
            if (($check_page_last - $key) <= $limit_page) {
                $last_page = true;
            } else {
                $last_page = false;
            }
            if (($key % $limit_page) == 0) {
                $receipt_details = App\Models\ReceiptDetail::where('receipt_id', $receipt->id)
                        ->skip($key)
                        ->take($limit_page)
                        ->get();
                ?>
                <div style="margin-top: 260px;"></div>
                <table style="margin-top: 10px; width: 100%; border: 1px solid; border-collapse: collapse; border-left: none; border-bottom: none;">
                    <tr>
                        <td style="width: 300px; border: 1px solid;" colspan="2"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Received for Invoice No. / ได้รับเงินตามใบแจ้งหนี้เลขที่</b></div></td>
                        <td style="width: 150px; border: 1px solid;" align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Amount<br/>Non Vat</b></div></td>
                        <td style="width: 150px; border: 1px solid;" align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Amount<br/>Vat 7%</b></div></td>
                    </tr>
                    @foreach($receipt_details as $receipt_detail)
                    <tr>
                        <td style="border-left: 1px solid; border-right: 1px solid;" colspan="2"><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $receipt_detail->invoice->invoice_number . ' - ' . $receipt_detail->invoice->house_way_number }}</div></td>
                        <td style="border-left: 1px solid; border-right: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ number_format($receipt_detail->invoice->non_taxable_total,2) }}</div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 100%;" align="right">{{ number_format($receipt_detail->invoice->taxable_total,2) }}</div></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="border-top: 1px solid;"><div style="color:#000000; font-size: 18px; line-height: 100%;"><b>{{ 'บาท Baht' . ' (' . ($last_page ? convert_to_thai(number_format($receipt->net, 2, '.', '')) : '') . ')' }}</b></div></td>
                        <td style="border-top: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="left"><b>รวมเงิน</b></div></td>
                        <td style="border: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="right"><b>{{ ($last_page ? number_format($receipt->sum_amount_non_vat,2) : '') }}</b></div></td>
                        <td style="border: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="right"><b>{{ ($last_page ? number_format($receipt->sum_amount_vat,2) : '') }}</b></div></td>
                    </tr>
                    <tr>
                        <td ><div style="color:#000000; font-size: 18px; line-height: 100%;"><b></b></div></td>
                        <td colspan="2"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="left"><b>VAT 7%</b></div></td>
                        <td style="border: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="right"><b>{{ ($last_page ? number_format($receipt->sum_vat_7,2) : '') }}</b></div></td>
                    </tr>
                    @if($receipt->sum_holding_vat_3 > 0)
                    <tr>
                        <td ><div style="color:#000000; font-size: 18px; line-height: 100%;"><b></b></div></td>
                        <td colspan="2"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="left"><b>With Holding Tax {{ $mycompany->with_holding_tax }} %</b></div></td>
                        <td style="border: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="right"><b>{{ ($last_page ? number_format($receipt->sum_holding_vat_3,2) : '') }}</b></div></td>
                    </tr>
                    @endif
                    <tr>
                        <td ><div style="color:#000000; font-size: 18px; line-height: 100%;"><b></b></div></td>
                        <td colspan="2"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="left"><b>จำนวนเงินรวมทั้งสิ้น</b></div></td>
                        <td style="border: 1px solid; border-bottom: 3px;"><div style="color:#000000; font-size: 20px; line-height: 100%;" align="right"><b>{{ ($last_page ? number_format($receipt->net,2) : '') }}</div></td>
                    </tr>
                </table>

                @if($last_page)
                <table>
                    <tr>
                        <td style="font-size: 20px; color:#000000; text-align: left;"><b>ได้รับเงินแล้ว</b></td>
                    </tr>
                </table>
                @endif

                @if($last_page && $receipt->payment_type == 'เงินสด Cash')
                <table>
                    <tr>
                        <td style="font-size: 20px; color:#000000; text-align: left;"><b>{{ ' - ' . $receipt->payment_type }}</b></td>
                    </tr>
                </table>
                @endif

                @if($last_page && $receipt->payment_type == 'เช็คธนาคาร CHQUE BANK')
                <table>
                    <tr>
                        <td style="font-size: 20px; color:#000000; text-align: left;"><b>{{ ' - ' . $receipt->payment_type . ' NO. ' . $receipt->check_no . ' Date ' . $receipt->check_date }}</b></td>
                    </tr>
                </table>
                @endif

                @if($last_page && ($receipt->payment_type == 'โอนเงินเข้าบัญชี้' || $receipt->payment_type == 'โอนเงินเข้าบัญชี'))
                <table>
                    <tr>
                        <td style="font-size: 20px; color:#000000; text-align: left;"><b>{{ ' - ' . $receipt->payment_type . ' ธนาคาร ' . $receipt->bank_name . " สาขา " . $receipt->bank_branch }}</b></td>
                    </tr>
                </table>
                @endif

                <?php
                if (!$last_page) {
                    echo '<div style="page-break-before: always;"></div>';
                }
            }
        }
    }
    ?>

</body>







