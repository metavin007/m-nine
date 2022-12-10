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
    $details = $invoice->invoice_detail;
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
                <td style="font-size: 22px; color:#000000; text-align: center;"><b>สำเนา ใบแจ้งหนี้ / INVOICE</b></td>
            </tr>
        </table>

        <table>      
            <tr>
                <td style="width: 100px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Customer</b></div></td>
                <td style="width: 10px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                <td style="width: 180px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Page No</b></div></td>
                <td style="width: 10px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td style="width: 150px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><span class="page-number"></span></div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Tax ID No.</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->customer->tax_id_no . ' ' .$invoice->customer->branch }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>INVOICE NUMBER</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->invoice_number }}</div></td>
            </tr>
            <tr>
                <td colspan="3" rowspan="4"><div style="color:#000000; font-size: 20px; line-height: 60%;">{!! $invoice->customer->company_name_eng . '<br/>' . nl2br($invoice->customer->address_eng) !!}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>INVOICE DATE</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Due Date</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ date('d/m/Y', strtotime($invoice->due_date)) }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Credit Terms</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->credit_Terms . ' Days' }}</div></td>
            </tr>
            <tr>
                <td colspan="5"><div style="color:white; font-size: 20px; line-height: 60%;"><b>text</b></div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Our Reference number</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->our_reference_number }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>{{ $invoice->dealer->group }}</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->dealer->name }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>HOUSE WAYBILL NUMBER</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->house_way_number }}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>ORI</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td>
                    <div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->dealer->ori }}  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;
                        <b> DEST : </b> {{ $invoice->dealer->dest }}
                    </div>
                </td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>VESSEL/DATE</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>:</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->vessel_date }}</div></td>
            </tr>
        </table>

        <table> 
            <tr>
                <td colspan="5"><div style="color:white; font-size: 20px; line-height: 60%;"><b>text</b></div></td>
            </tr>
            <tr>
                <td style="width: 160px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Marks and Numbers</b></div></td>
                <td style="width: 180px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Description of Goods</b></div></td>
                <td style="width: 160px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>No.of Packages</b></div></td>
                <td style="width: 160px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>ACT Weight</b></div></td>
                <td style="width: 160px;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Volume</b></div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->mark_and_numbers1 }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->description_of_goods1 }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->no_of_packages1 . ' Packages' }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->act_weight . ' KGM'}}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->volume . ' CBM'}}</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->mark_and_numbers2 }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->description_of_goods2 }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice->no_of_packages2 }}</div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
            </tr>
        </table>
    </header>

    <footer>
        <table>  
            <tr>
                <td colspan="2"><div style="color:#000000; font-size: 20px; line-height: 60%; border-bottom: 1px solid;"><b></b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b></b></div></td>
                <td colspan="2"><div style="color:#000000; font-size: 20px; line-height: 60%; border-bottom: 1px solid;"><b></b></div></td>
            </tr>
            <tr>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Authorized Signature</b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Date</b></div></td>
                <td><div style="color:#000000; font-size: 20px; line-height: 60%;"><b></b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Invoice Received By</b></div></td>
                <td align="center"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>Date</b></div></td>
            </tr>
        </table>
        <br/>
        <table>  
            <tr>
                <td><div style="color:#000000; font-size: 16px; line-height: 60%;">* Please issue a crossed Cheque "A/C Payee Only" to " M-NINE (THAILAND) Limited."</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 16px; line-height: 60%;">* If you have any queries on the items mentioned herein, please notify within 7 days</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 16px; line-height: 60%;">* An interrest fee of 2% per month will be charged on your balance outstanding overdue.</div></td>
            </tr>
            <tr>
                <td><div style="color:#000000; font-size: 16px; line-height: 60%;">* Invoice due date is counted from invoice date.</div></td>
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
                $invoice_details = App\Models\InvoiceDetail::where('invoice_id', $invoice->id)
                        ->skip($key)
                        ->take($limit_page)
                        ->get();
                ?>
                <div style="margin-top: 380px;"></div>
                <table style="margin-top: 10px; border: 1px solid; border-collapse: collapse; border-left: none; border-right: none; border-bottom: none;">  
                    <tr>
                        <td style="width: 100px; border-bottom: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>CODE</b></div></td>
                        <td style="width: 250px; border-bottom: 1px solid;"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>PARTICULARS</b></div></td>
                        <td style="width: 150px; border-bottom: 1px solid;" align="right"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>AMOUNT(BAHT)<br/>Non Taxable</b></div></td>
                        <td style="width: 150px; border-bottom: 1px solid;" align="right"><div style="color:#000000; font-size: 20px; line-height: 60%;"><b>AMOUNT(BAHT)<br/>Vat 7%</b></div></td>
                    </tr>
                    @foreach($invoice_details as $invoice_detail)
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice_detail->item->code }}</div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;">{{ $invoice_detail->item->particulars }}</div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($invoice_detail->select_taxable == 0 ? number_format($invoice_detail->amount,2) : '') }}</div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($invoice_detail->select_taxable == 1 ? number_format($invoice_detail->amount,2) : '') }}</div></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4"><div style="color:white; font-size: 20px; line-height: 60%;"><b>text</b></div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>Non Taxable Total</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->non_taxable_total,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>Taxable Total</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->taxable_total,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>Total Amount</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->total_amount,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>VAT 7%</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->vat_7,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>Grand Total</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->grand_total,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>With Holding Tax {{ $mycompany->with_holding_tax }} %</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->with_holding_tax_3,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;"></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right"><b>Tatal Invoiced THB</b></div></td>
                        <td><div style="color:#000000; font-size: 20px; line-height: 60%;" align="right">{{ ($last_page ? number_format($invoice->total_invioced_thb,2) : '') }}</div></td>
                    </tr>
                    <tr>
                        <td colspan="4"><div style="color:white; font-size: 20px; line-height: 60%;"><b>text</b></div></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="color:#000000; font-size: 20px; line-height: 60%;" align="left">
                                <b>AMOUNT :</b> <span style="color:#000000; font-size: 20px; line-height: 60%;">{{ ($last_page ? $invoice->amount : '') }}</span>
                            </div>
                        </td>
                    </tr>
                </table>

                <?php
                if (!$last_page) {
                    echo '<div style="page-break-before: always;"></div>';
                }
            }
        }
    }
    ?>

</body>
