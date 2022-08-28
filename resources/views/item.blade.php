<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Table Item</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{ route('item') }}">Item</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">
                <div class="card-header" style="text-align: right;">
                    <a href="{{ url('item/page_add') }}" class="btn btn-primary">Add</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_list" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Particulars</th>
                                    <th>Amount</th>
                                    <th>Vat / Non vat</th>
                                    <th>Date add</th>
                                    <th>Date update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </section>

    </div>

</x-app-layout>

<script>
    var TableList = $('#table_list').dataTable({
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
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "ajax": {
            "url": url_gb + "/item/get_datatable",
            "data": function (d) {
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {"data": "DT_RowIndex", "className": "text-center", "orderable": false, "searchable": false},
            {"data": "code", "className": "text-center"},
            {"data": "particulars", "className": "text-left"},
            {"data": "amount", "className": "text-right"},
            {"data": "select_taxable", "className": "text-left"},
            {"data": "date_add", "className": "text-center"},
            {"data": "date_update", "className": "text-center"},
            {"data": "action", "className": "action text-center text-nowrap", "orderable": false, "searchable": false}
        ], "order": [[5, "desc"]],
        rowCallback: function (row, data, index) {

        }
    });

    $('body').on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var btn = $(this);
        var id = btn.data('id');
        var name = btn.data('name');
        Swal.fire({
            title: 'คุณต้องการ',
            text: "ลบ " + name + " ใช่หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "ใช่ ฉันต้องการ",
            cancelButtonText: "ยกเลิก",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "delete",
                    url: url_gb + "/item/delete/" + id,
                    data: {ID: id}
                }).done(function (rec) {
                    if (rec.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: rec.title,
                            text: rec.content,
                        }).then(() => {
                            TableList.api().ajax.reload();
                        });
                    } else {
                        Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
                    }
                }).fail(function (data) {
                    Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
                });
            }
        })
    });
</script>