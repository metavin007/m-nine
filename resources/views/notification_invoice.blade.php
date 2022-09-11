
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
                    <h3>Invoice ค้างจ่าย</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{ route('notification_invoice') }}">Notification Invoice</a></li>
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
                        <table class="table table-bordered table-hover" id="TableNotificationInvoice">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice date</th>
                                    <th>Invoice no</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Price invoice</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">ยอดรวมค้างชำระ(ทั้งหมด)</th>
                                    <th><span id="sum_price"></span></th>
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

    get_table_notification_invoice($("#date_search_start").val(), $("#date_search_end").val());
    $('#date_search_start,#date_search_end').on('change', function (e, picker) {
        get_table_notification_invoice($("#date_search_start").val(), $('#date_search_end').val());
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
        get_table_notification_invoice(picker.startDate.format('DD-MM-YYYY'), $('#date_search_end').val());
    })
    $('#date_search_end').on('apply.daterangepicker', function (e, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));
        get_table_notification_invoice($('#date_search_start').val(), picker.startDate.format('DD-MM-YYYY'));
    })

    var TableNotificationInvoice;
    function get_table_notification_invoice(date_search_start, date_search_end, type_sort) {
        if (TableNotificationInvoice != undefined) {
            TableNotificationInvoice.DataTable().destroy();
        }
        TableNotificationInvoice = $('#TableNotificationInvoice').dataTable({
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
                    extend: 'print',
                    className: 'btn btn-primary',
                    text: 'ปริ้นรายงาน',
                    footer: true,
                    title: 'Invoice ค้างจ่าย',
                    messageTop: 'วันที่เริ่มต้น : ' + $('#date_search_start').val() + '     ' + 'วันที่สิ้นสุด : ' + $('#date_search_end').val(),
                },
                {
                    extend: 'excel',
                    className: 'btn btn-primary',
                    text: 'Export Excel',
                    footer: true,
                    title: 'Invoice ค้างจ่าย',
                    messageTop: false,
                }
            ],
//            paging: false,
//            ordering: false,
//            searching: false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "ajax": {
                "url": url_gb + "/notification_invoice/get_datatable_notification_invoice",
                "data": function (d) {
                    d.date_search_start = date_search_start;
                    d.date_search_end = date_search_end;
                }
            },
            "columns": [
                {"data": "DT_RowIndex", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "invoice_date", "className": "text-center", "searchable": false},
                {"data": "invoice_number", "className": "text-center"},
                {"data": "customer.company_name_eng"},
                {"data": "status", "className": "text-center", "orderable": false, "searchable": false},
                {"data": "total_invioced_thb", "className": "text-right", "orderable": false, "searchable": false},
            ], "order": [1, "desc"]
            , drawCallback: function () {
                var api = this.api();
                var sum_price = 0;
                api.column(5).data().reduce(function (a, value) {
                    sum_price = Number(sum_price) + parseFloat(value.replace(/,/g, ''));
                }, 0)
                $('#sum_price').html(formatNumber(Number(sum_price).toFixed(2)));
            }
        });
    }

//    $('#export_trade_tax_buy_spare_part_for_pdf').on('click', function (e, picker) {
//        var date_search_start = $('#date_search_start').val();
//        var date_search_end = $('#date_search_end').val();
//        var type_sort = $('#type_sort').val();
//        $('#export_trade_tax_buy_spare_part_for_pdf').attr('href', url_gb + '/cashier/export/export_trade_tax_buy_for_pdf/' + date_search_start + '/' + date_search_end + '/' + type_sort);
//        $('#export_trade_tax_buy_spare_part_for_pdf')[0].click();
//    })

</script>