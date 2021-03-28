@extends('layouts.master')
@section('custom-css')
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css" />
    <script type="text/javascript" src="/js/select2.min.js"></script>
@endsection
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="col-lg-12 mt">
            <div class="row content-panel">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="invoice-body">
                        <div class="pull-left">
                            <h1>صيدلية عضيمه</h1>
                            <address>
                                شارع الزراعة الرئيسي<br>
                                اللاذقية<br>
                                <abbr title="Phone">P:</abbr>0994337308
                            </address>
                        </div>
                        <!-- /pull-left -->
                        <div class="pull-right">
                            <h2>فاتورة زبون</h2>
                        </div>
                        <!-- /pull-right -->
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-9"></div>
                            <!-- /col-md-9 -->
                            <div class="col-md-3">
                                <div>
                                    <!-- /col-md-3 -->
                                    <div class="pull-left">تاريخ الفاتورة:</div>
                                    <div class="pull-right">{{ date('Y-m-d') }}</div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- /invoice-body -->
                        </div>
                        <!-- /col-lg-10 -->
                        <input type="text" name="search" id="search" style="display:none" autofocus/>
                        <div class="row">
                            <label>اختر معايير البحث:</label>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group" dir="rtl">
                                <label class="col-sm-6 control-label">الأشكال الدوائية</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="shape">
                                        <option value="0" default>اختر شكل دوائي</option>
                                        @foreach ($shapes as $shape)
                                          <option value="{{ $shape->id }}">{{ $shape->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" dir="rtl">
                                <label class="col-sm-6 control-label">الأصناف الدوائية</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="category">
                                        <option value="0" default>اختر صنف</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" dir="rtl">
                                <label class="col-sm-6 control-label">الشركات الدوائية</label>
                                <div class="col-sm-6">
                                    <select class="form-control" id="company">
                                        <option value="0" default>اختر شركة دوائية</option>
                                        @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="search_type" id="search_name_arabic" value="search_name_arabic" checked>
                                </span>
                                <label>حسب الاسم العربي</label>
                              </div>
                            </div>
                            <div class="col-lg-4">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <input type="radio" name="search_type" id="search_name_english" value="search_name_english">
                                </span>
                                <label>حسب الاسم الأجبني</label>
                              </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <input type="radio" name="search_type" id="search_composition" value="search_composition">
                                  </span>
                                  <label>حسب التركيبة الكيميائية</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="search_drugs">
                                أبحث عن الدواء
                            </label>
                            <select class="js-states form-control" multiple="multiple" id="search_drugs" style="width: 50%"></select>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-left">اسم الدواء بالعربي</th>
                                    <th class="text-left">تاريخ انتهاء الصلاحية</th>
                                    <th style="width:150px" class="text-center">عدد العلب</th>
                                    <th style="width:150px" class="text-center">عدد الظروف</th>
                                    <th style="width:150px" class="text-left">السعر المعدل للظرف</th>
                                    <th style="width:150px" class="text-left">السعر المعدل للعلبة</th>
                                </tr>
                            </thead>
                            <tbody id="drugs">
                            </tbody>
                        </table>
                        <hr style="border-color:#ddd;">
                        <br>
                        <div class="from-group">
                            <button type="button" id="calculate_price" class="btn btn-theme" data-toggle="modal" data-target="#myModal">حساب ودفع</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" role="dialog"  aria-labelledby="basicModal" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">حفظ الفاتورة</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">السعر الصافي</label>
                                            <input type="text" class="form-control" id="net_price" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">سعر المبيع</label>
                                            <input type="text" class="form-control" id="sell_price" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">خصم بدون شركة تأمين</label>
                                            <input type="text" class="form-control" id="discount_amount">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">سعر المبيع بعد الحسم</label>
                                            <input type="text" class="form-control" id="sell_price_after_discount" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">سبب الخصم</label>
                                            <input type="text" class="form-control" id="discount_reason">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">المبلغ المراد دفعه حالياً</label>
                                            <input type="text" class="form-control" id="amount">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default" id="submit_invoice" data-toggle="modal" data-target="#myModal2" data-dismiss="modal">حفظ</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="myModal2" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">حفظ الفاتورة</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4 class="">تم الحفظ بنجاح</h4>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
@section('scripts')
    <script>
        $('#discount_amount').keypress(function(event){
            if (event.keyCode === 13) {
                if ($("#discount_amount").val() != null) {
                    $("#sell_price_after_discount").val($("#sell_price").val() - $("#discount_amount").val());
                }
            }
        });
    </script>
    <script>
        $("#calculate_price").click( function () {
            let drugs = {
                'ids' : [],
                'packages_number' : [],
                'units_number' : [],
                'modified_drugs_package_sell_price' : [],
                'modified_drugs_unit_sell_price' : []
            };
            let table_rows = $('#drugs').children();
            for (let i = 0; i < table_rows.length; i++) {
                drugs['ids'].push(table_rows[i].children[0].innerHTML);
                drugs['packages_number'].push(table_rows[i].children[3].firstElementChild.value);
                drugs['units_number'].push(table_rows[i].children[4].firstElementChild.value);
                drugs['modified_drugs_package_sell_price'].push(table_rows[i].children[5].firstElementChild.value);
                drugs['modified_drugs_unit_sell_price'].push(table_rows[i].children[6].firstElementChild.value);
            }
            $.ajax({
                method: 'POST', // Type of response
                url: '{{ route("drug.calculate") }}', // This is the url we gave in the route
                data: {
                    "_token": "{{ csrf_token() }}",
                    'drugs' : drugs }, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                    $("#net_price").val(response[0]);
                    $("#sell_price").val(response[1]);
                    $("#sell_price_after_discount").val(response[1]);
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });
    </script>
    <script>
        // Disable the submit button if the amout is empty
        if ($("#amount").val() == "") {
            $("#submit_invoice").prop('disabled', true);
        }
        $('#amount').keyup(function() {
            if($(this).val() != '') {
                $('#submit_invoice').prop('disabled', false);
            }
            if($(this).val() == '') {
                $("#submit_invoice").prop('disabled', true);
            }
        });
        $("#submit_invoice").click(function() {
        let drugs = {
            'ids' : [],
            'packages_number' : [],
            'units_number' : [],
            'modified_drugs_package_sell_price' : [],
            'modified_drugs_unit_sell_price' : []
        };
        let table_rows = $('#drugs').children();
        for (let i = 0; i < table_rows.length; i++) {
            drugs['ids'].push(table_rows[i].children[0].innerHTML);
            drugs['packages_number'].push(table_rows[i].children[3].firstElementChild.value);
            drugs['units_number'].push(table_rows[i].children[4].firstElementChild.value);
            drugs['modified_drugs_unit_sell_price'].push(table_rows[i].children[5].firstElementChild.value);
            drugs['modified_drugs_package_sell_price'].push(table_rows[i].children[6].firstElementChild.value);
        }
        let amount = $("#amount").val();
        let discount_amount = $("#discount_amount").val();
        let discount_reason = $("#discount_reason").val();

        $.ajax({
            method: 'POST', // Type of response
            url: "{{ route('invoice.store') }}", // This is the url we gave in the route
            data: {
                "_token": "{{ csrf_token() }}",
                'drugs' : drugs,
                'amount' : amount,
                'discount_amount' : discount_amount,
                'discount_reason' : discount_reason,
                'invoice_type_id' : 1}, // a JSON object to send back
            success: function(response){ // What to do if we succeed
                window.location.href = "/invoices"
            },
            error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                console.log(JSON.stringify(jqXHR));
                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
            }
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        // Search for drug using select2
        $("#search_drugs").select2({
            dir: "rtl",
            minimumInputLength: 3,
            ajax: {
                delay: 500,
                url: "{{ route('drug.search') }}",
                type: "GET",
                dataType: 'json',
                data: function (params) {
                    var query_params =  {
                        search: params.term,
                        searchBy: $('input[name=search_type]:checked').val(),
                        shape: $("#shape").children("option:selected").val(),
                        category: $("#category").children("option:selected").val(),
                        company: $("#company").children("option:selected").val()
                    }
                    return query_params;
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            "language": {
                "noResults": function() {
                    return "لا توجد أي نتائج";
                },
                "inputTooShort": function () {
                    return "يجب أن تكتب 3 أحرف أو أكثر للبحث";
                }
            }
        });

        // This function will be called when a selection is made
        function fetch_drugs(drug = '')
        {
            $.ajax ({
                url:"{{ route('drug.get_repo_by_id_for_sell') }}",
                method:'GET',
                data:{drug_id:drug["id"]},
                dataType:'json',
                success:function(data)
                {
                    $('#drugs').append(data.table_data);
                }
            })
        }

        // The selection event
        $('#search_drugs').on("select2:select", function(e) {
            var drug = e.params.data;
            fetch_drugs(drug);
        });

        // Unselect event
        $('#search_drugs').on("select2:unselect", function(e) {
            var drug = e.params.data.text;
            var table_rows = $('#drugs').children();
            if (table_rows.length === 1) {
                table_rows[0].remove();
            }
            else {
                for (i = 0; i < table_rows.length; i++) {
                    if (table_rows[i].children[1].innerHTML === drug) {
                        table_rows[i].remove();
                    }
                }
            }
        });
    });
    </script>
@endsection
