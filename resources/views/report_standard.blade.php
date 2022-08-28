
<x-app-layout>
    <style>
        div.dt-buttons {
            float: right;
        }
    </style>
    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Report Standard</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{ route('report_standard') }}">Report Standard</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-1">
                            <label>Date Start</label>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" id="date_search_start" class="form-control" readonly="">
                        </div>
                        <div class="col-md-1">
                            <label>Date End</label>
                        </div>
                        <div class="col-md-2 form-group">
                            <input type="text" id="date_search_end" class="form-control" readonly="">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="TableReportStandard" style="white-space: nowrap;">
                            <thead>
                                <tr>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                    <th colspan="14" class="text-center">Cost</th>
                                    <th class="text-center"></th>
                                    <th class="text-center"></th>
                                </tr>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">DATE</th>
                                    <th class="text-center">JOB NO</th>
                                    <th class="text-center">C'NEE</th>
                                    <th class="text-center">SHIPPER</th>
                                    <th class="text-center">AWB/BL</th>
                                    <th class="text-center">Flight/Date</th>
                                    <th class="text-center">Package</th>
                                    <th class="text-center">Weight</th>
                                    <th class="text-center">INV. NO.</th>
                                    <th class="text-center">INV.DATE</th>
                                    <th class="text-center">REV. NO.</th>
                                    <th class="text-center">REV. DATE</th>
                                    <th class="text-center">ADVANCE</th>
                                    <th class="text-center">CHARGE</th>
                                    <th class="text-center">AMOUNT</th>
                                    <th class="text-center">7%</th>
                                    <th class="text-center">{{ $mycompany->with_holding_tax/100 }}</th>
                                    <th class="text-center">Debtor</th>
                                    <th class="text-center">DUTY</th>
                                    <th class="text-center">CF</th>
                                    <th class="text-center">STORA</th>
                                    <th class="text-center">D/O</th>
                                    <th class="text-center">OT</th>
                                    <th class="text-center">DEM</th>
                                    <th class="text-center">AMEND</th>
                                    <th class="text-center">DL</th>
                                    <th class="text-center">EDI</th>
                                    <th class="text-center">Massenger</th>
                                    <th class="text-center">INSPEC</th>
                                    <th class="text-center">Formality</th>
                                    <th class="text-center">SHIPPING</th>
                                    <th class="text-center">TOTAL</th>
                                    <th class="text-center">Profit/Loss</th>
                                    <th class="text-center">REMARK</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">รวม</th>
                                    <th class="text-right"><span id="sum_advance">0.00</span></th>
                                    <th class="text-right"><span id="sum_charge">0.00</span></th>
                                    <th class="text-right"><span id="sum_amount">0.00</span></th>
                                    <th class="text-right"><span id="sum_7">0.00</span></th>
                                    <th class="text-right"><span id="sum_003">0.00</span></th>
                                    <th class="text-right"><span id="sum_debtor">0.00</span></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot> 
                        </table>   
                    </div>
                </div>
            </div>

        </section>

    </div>

</x-app-layout>

<script>

    //ฟังก์ชั่นใส่ลูกน้ำให้
    function formatNumber(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    }

    get_table_report_standard($("#date_search_start").val(), $("#date_search_end").val());

    $('#date_search_start,#date_search_end').on('change', function (e, picker) {
        get_table_report_standard($("#date_search_start").val(), $('#date_search_end').val());
    })

    $('#date_search_start').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY'
        }, minDate: 0,
    });
    $('#date_search_end').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });
    $('#date_search_start').on('apply.daterangepicker', function (e, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
        get_table_report_standard(picker.startDate.format('DD-MM-YYYY'), $('#date_search_end').val());
    })
    $('#date_search_end').on('apply.daterangepicker', function (e, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
        get_table_report_standard($('#date_search_start').val(), picker.startDate.format('DD-MM-YYYY'));
    })

    var TableReportStandard;
    function get_table_report_standard(date_search_start, date_search_end, type_sort) {
        if (TableReportStandard != undefined) {
            TableReportStandard.DataTable().destroy();
        }
        TableReportStandard = $('#TableReportStandard').dataTable({
            // เซอเวอไซต์ต้องมี 2 อันนี้
            "processing": true,
            "serverSide": true,
            // -------------------
            scrollCollapse: true,
            autoWidth: false,
            responsive: true,
            columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
            dom:
                    "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row mb-3'<'col-sm-12'tr>>" +
                    "<'row mb-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>B",
            buttons: [{
                    extend: 'excel',
                    className: 'btn btn-primary',
                    text: 'Export Excel',
                    footer: true,
                    title: 'Report Standard',
                    messageTop: false,
                }
            ],
//            paging: false,
//            ordering: false,
//            searching: false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax": {
                "url": url_gb + "/report_standard/get_datatable_report_standard",
                "data": function (d) {
                    d.date_search_start = date_search_start;
                    d.date_search_end = date_search_end;
                }
            },
            "columns": [
                {"data": "DT_RowIndex", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "our_reference_number", "className": "text-center"},
                {"data": "customer.company_name_eng", "className": "text-left"},
                {"data": "dealer.name", "className": "text-left"},
                {"data": "house_way_number", "className": "text-center"},
                {"data": "vessel_date", "className": "text-center"},
                {"data": "no_of_packages1", "className": "text-center"},
                {"data": "act_weight", "className": "text-center"},
                {"data": "invoice_number", "className": "text-center"},
                {"data": "invoice_date", "className": "text-center", "searchable": false},
                {"data": "receipt_detail.receipt.receipt_no", "className": "text-center"},
                {"data": "receipt_detail.receipt.date_add", "className": "text-center", "searchable": false},
                {"data": "non_taxable_total", "className": "text-right", "orderable": false, "searchable": false},
                {"data": "taxable_total", "className": "text-right", "orderable": false, "searchable": false},
                {"data": "total_amount", "className": "text-right", "orderable": false, "searchable": false},
                {"data": "vat_7", "className": "text-right", "orderable": false, "searchable": false},
                {"data": "with_holding_tax_3", "className": "text-right", "orderable": false, "searchable": false},
                {"data": "total_invioced_thb", "className": "text-right", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "bank", "className": "text-center", "orderable": false, "searchable": false},
            ], "order": [2, "desc"]
            , drawCallback: function () {
                var api = this.api();
                var sum_advance = 0;
                var sum_charge = 0;
                var sum_amount = 0;
                var sum_7 = 0;
                var sum_003 = 0;
                var sum_debtor = 0;
                api.column(13).data().reduce(function (a, value) {
                    sum_advance = Number(sum_advance) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                api.column(14).data().reduce(function (a, value) {
                    sum_charge = Number(sum_charge) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                api.column(15).data().reduce(function (a, value) {
                    sum_amount = Number(sum_amount) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                api.column(16).data().reduce(function (a, value) {
                    sum_7 = Number(sum_7) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                api.column(17).data().reduce(function (a, value) {
                    sum_003 = Number(sum_003) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                api.column(18).data().reduce(function (a, value) {
                    sum_debtor = Number(sum_debtor) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                $('#sum_advance').html(formatNumber(Number(sum_advance).toFixed(2)));
                $('#sum_charge').html(formatNumber(Number(sum_charge).toFixed(2)));
                $('#sum_amount').html(formatNumber(Number(sum_amount).toFixed(2)));
                $('#sum_7').html(formatNumber(Number(sum_7).toFixed(2)));
                $('#sum_003').html(formatNumber(Number(sum_003).toFixed(2)));
                $('#sum_debtor').html(formatNumber(Number(sum_debtor).toFixed(2)));
            }
        });
    }

</script>