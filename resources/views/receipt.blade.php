<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Table Receipt</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{ route('receipt') }}">Receipt</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">
                <div class="card-header" style="text-align: right;">
                    <a href="{{ url('receipt/page_add') }}" class="btn btn-primary">Add</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_list" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Receipt no</th>
                                    <th>Net</th>
                                    <th>Payment Type</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>     
                        </table>
                    </div>
                </div>
            </div>

        </section>

    </div>

    <div class="modal fade" id="ModalEditDate" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" id="receipt_id">
                <form id="FormEditDate">
                    <div class="modal-header">
                        <h4 class="card-title">แก้ไขวันที่</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="date_add" id="edit_date_add" class="form-control" maxlength="10">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn pull-right btn-lg btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
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
            "url": url_gb + "/receipt/get_datatable",
            "data": function (d) {
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [
            {"data": "DT_RowIndex", "className": "text-center", "orderable": false, "searchable": false},
            {"data": "receipt_no", "className": "text-center"},
            {"data": "net", "className": "text-right"},
            {"data": "payment_type", "className": "text-center"},
            {"data": "date_add", "className": "text-center"},
            {"data": "action", "className": "action text-center text-nowrap", "orderable": false, "searchable": false}
        ], "order": [[4, "desc"]],
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
                    url: url_gb + "/receipt/delete/" + id,
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

    $('body').on('click', '.btn-edit_date', function (e) {
        e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var id = $(this).data('id');
        $('#receipt_id').val(id);
        $.ajax({
            method: "get",
            url: url_gb + "/receipt/get_date_by_receipt_id/" + id,
            dataType: 'json'
        }).done(function (rec) {
            $('#edit_date_add').val(rec.date_add);
            $('#ModalEditDate').modal("show");
            btn.button("reset");
        }).fail(function () {
            Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
            btn.button("reset");
        });
    });

    $('#FormEditDate').validate({
        focusCleanup: true,
        rules: {
            date_add: {
                required: true,
            },
        },
        messages: {
            date_add: {
                required: "กรุณาระบุ",
            },
        },
        errorPlacement: function (error, element) { // คำสั่งโชกล่องข้อความ
            error.addClass("text-danger");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) { // ใส่สีเมื่อเกิด error
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) { // ใส่สีเมื่อผ่าน error แล้ว;
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
        submitHandler: function (form) {
            var btn = $(form).find('[type="submit"]');
            var id = $('#receipt_id').val();
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').attr('disabled', true);
            $.ajax({
                method: "put",
                url: url_gb + "/receipt/update_date_by_receipt_id/" + id,
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/receipt';
                        $('#ModalEditDate').modal("hide");
                    });
                } else {
                    Swal.fire({icon: 'error', title: rec.title, text: rec.content});
                    $('#ModalEditDate').modal("hide");
                }
            }).fail(function () {
                Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
                btn.html('Save').attr('disabled', false);
            });
        }
    });
</script>