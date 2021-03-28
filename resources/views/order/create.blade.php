@extends('layouts.master')
@section('custom-css')
    <link rel="stylesheet" type="text/css" href="/css/select2.min.css" />
    <script type="text/javascript" src="/js/select2.min.js"></script>
@endsection
@section('content')
<section id="main-content">
    <section class="wrapper" >
        <h3><i class="fa fa-angle-right"></i>إضافة طلبية</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h3 class="mb"><i class="fa fa-angle-right mr"></i> معلومات</h3>
                    <div class="form-group" dir="rtl">
                        <label class="col-sm-2 col-sm-2 control-label">الشركة</label>
                        <div class="col-sm-2">
                            <select id="company_id" class="form-control">
                                <option   value="0" selected></option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-2 col-sm-2 control-label">المستودع</label>
                        <div class="col-sm-2">
                            <select class="form-control" id="warehouse_id">
                                <option value="0" selected></option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div>
                        <label>اختر معايير البحث:</label>
                    </div>
                    <div class="mt-3">
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
                    <div>
                        <label for="search_drugs">
                            أبحث عن الدواء
                        </label>
                        <select class="js-states form-control" multiple="multiple" id="search_drugs" style="width: 50%"></select>
                    </div>
                    <br>
                    <br>
                    <br>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">اسم الدواء بالعربي</th>
                                <th class="text-left">تاريخ انتهاء الصلاحية</th>
                                <th  class="text-center">عدد العلب المتوفرة</th>
                                <th  class="text-center">عدد الظروف المتوفرة</th>
                                <th  class="text-center">عدد العلب المراد طلبها</th>
                                <th  class="text-center">عدد الظروف المراد طلبها</th>
                            </tr>
                        </thead>
                        <tbody id="drugs">
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-theme" id="submit_order">إضافة طلبية</button>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection

@section('scripts')
    <script>
        $("#submit_order").click(function() {
            let drugs = {
                'ids' : [],
                'packages_number' : [],
                'units_number' : []
            };
            let table_rows = $('#drugs').children();
            for (let i = 0; i < table_rows.length; i++) {
                drugs['ids'].push(table_rows[i].children[0].innerHTML);
                drugs['packages_number'].push(table_rows[i].children[5].firstElementChild.value === "" ? 0 : table_rows[i].children[5].firstElementChild.value);
                drugs['units_number'].push(table_rows[i].children[6].firstElementChild.value === "" ? 0 : table_rows[i].children[6].firstElementChild.value);
            }
            let supplier_id = null;
            let company_id = $("#company_id").val();
            let warehouse_id = $("#warehouse_id").val();
            if (company_id != 0) {
                supplier_id = company_id;
            }
            else {
                supplier_id = warehouse_id;
            }
            $.ajax({
                method: 'POST', // Type of response
                url: '{{ route("invoice.store") }}', // This is the url we gave in the route
                data: {
                    "_token": "{{ csrf_token() }}",
                    'drugs' : drugs,
                    'supplier_id' : supplier_id,
                    'invoice_type_id' : 2}, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                    window.location.href = "/orders";
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    alert("حدث خطأ أثناء عملية إنشاء فاتورة الشراء");
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
                url:"{{ route('drug.get_repo_by_id_for_order') }}",
                method:'GET',
                data:{drug_id:drug["id"]},
                dataType:'json',
                success:function(data)
                {
                    $('#drugs').append(data.table_data);
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
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
