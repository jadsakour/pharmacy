@extends('/layouts.master')
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
                        <div class="form-group">
                            <h4 class="text-left col-lg-3">اسم المريض</h4>
                            <select class="col-lg-6" id="customer">
                                <option selected></option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <br>
                        <!-- /pull-left -->
                        <!-- /pull-right -->
                        <div class="clearfix"></div>
                        <br>
                        <div class="row">
                            <div class="col-md-9">
                            </div>
                            <!-- /col-md-9 -->
                            <!-- /invoice-body -->
                        </div>
                        <div class="form-group">
                            <h4 class="text-left col-lg-3">أبحث عن الدواء</h4>
                            <select class="col-lg-6" multiple="multiple" id="search_drugs"></select>
                        </div>
                        <!-- /col-lg-10 -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">اسم الدواء</th>
                                    <th class="text-left">عدد العلب</th>
                                    <th class="text-left">عدد الظروف</th>
                                    <th class="text-left">سعر العلبة</th>
                                    <th class="text-left">سعر الظرف</th>
                                </tr>
                            </thead>
                            <tbody id="drugs">

                            </tbody>
                        </table>
                        <br>
                        <br>
                        <input type="button" class="btn btn-success" id="calculate_price" value="حساب السعر" />
                        <input type="button" class="btn btn-danger" id="clear_boxes" value="تصفير الأسعار" />
                        <br>
                        <br>
                        <table class="table table-striped table-borderless">
                            <tbody>
                                 <tr>
                                     <td class="text-left no-border"><strong>الخصم</strong></td>
                                     <td><input type="text" class="form-control" id="discount_amount"></td>
                                     <td class="text-left "><strong>شركة التأمين</strong></td>
                                     <td>
                                         <select class="col-lg-9" id="company">
                                             <option selected></option>
                                             @foreach($companies as $company)
                                                 <option value="{{ json_encode($company) }}">{{ $company->name }}</option>
                                             @endforeach
                                         </select>
                                     </td>
                                  </tr>
                                  <tr>
                                     <td class="text-left no-border"><strong>السعر الصافي</strong></td>
                                     <td><input type="text" class="form-control" id="full_net_price" disabled></td>
                                     <td class="text-left no-border"><strong>سعر المبيع</strong></td>
                                     <td><input type="text" class="form-control" id="full_sell_price" disabled></td>
                                  </tr>
                            </tbody>
                        </table>
                        <br>
                        <br>
                        <hr>
                        <div class="form-group form-inline">
                            <h4 class="text-left col-lg-3">إجمالي الفاتورة</h4>
                            <input type="text col-lg-9" class="form-control" id="sell_price_after_discount" disabled>
                        </div>
                        <hr>
                        <input type="button" class="col-lg-12  btn-lg btn-success" id="save_prescription" value="حفظ الوصفة" />
                    </div>
                </div>
            </div>
        </div>
        <!--/col-lg-12 mt -->
    </section>
    <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
@endsection

@section('scripts')
    <script>
        $('#company').on('select2:select', function() {
            let dict = JSON.parse(this.value);
            let discount_amount = document.getElementById("full_sell_price").value * (dict['discount'] / 100);
            document.getElementById("sell_price_after_discount").value = document.getElementById("full_sell_price").value - discount_amount;
        });
    </script>
    <script>
        $('#company').on('select2:clear', function() {
            document.getElementById("sell_price_after_discount").value = document.getElementById("full_sell_price").value;
        });
    </script>
    <script>
        document.getElementById("clear_boxes").onclick = clear_boxes;
        function clear_boxes() {
            document.getElementById("full_net_price").value = null;
            document.getElementById("full_sell_price").value = null;
            document.getElementById("sell_price_after_discount").value = null;
        }
    </script>
    <script>
        document.getElementById("calculate_price").onclick = calculate_price;
        function calculate_price() {
            let drugs = {
                'ids' : [],
                'packages_number' : [],
                'units_number' : [],
                'modified_drugs_package_sell_price' : [],
                'modified_drugs_unit_sell_price' : []
            };
            let table_rows = document.getElementById('drugs').children;
            for (let i = 0; i < table_rows.length; i++) {
                drugs['ids'].push(table_rows[i].children[0].innerHTML);
                drugs['packages_number'].push(table_rows[i].children[2].firstElementChild.value);
                drugs['units_number'].push(table_rows[i].children[3].firstElementChild.value);
                drugs['modified_drugs_package_sell_price'].push(table_rows[i].children[4].firstElementChild.value);
                drugs['modified_drugs_unit_sell_price'].push(table_rows[i].children[5].firstElementChild.value);
            }
            $.ajax({
                method: 'POST', // Type of response
                url: '{{ route("drug.calculate") }}', // This is the url we gave in the route
                data: {
                    "_token": "{{ csrf_token() }}",
                    'drugs' : drugs }, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                    document.getElementById("full_net_price").value = response[0];
                    document.getElementById("full_sell_price").value = response[1];
                    document.getElementById("sell_price_after_discount").value = response[1];
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    </script>
    <script>
        document.getElementById("save_prescription").onclick = save_prescription;
        function save_prescription() {
            let drugs = {
                'ids' : [],
                'packages_number' : [],
                'units_number' : [],
                'modified_drugs_package_sell_price' : [],
                'modified_drugs_unit_sell_price' : []
            };
            let table_rows = document.getElementById('drugs').children;
            for (let i = 0; i < table_rows.length; i++) {
                drugs['ids'].push(table_rows[i].children[0].innerHTML);
                drugs['packages_number'].push(table_rows[i].children[2].firstElementChild.value);
                drugs['units_number'].push(table_rows[i].children[3].firstElementChild.value);
                drugs['modified_drugs_package_sell_price'].push(table_rows[i].children[4].firstElementChild.value);
                drugs['modified_drugs_unit_sell_price'].push(table_rows[i].children[5].firstElementChild.value);
            }
            let customer_option = document.getElementById('customer');
            let customer_id = customer_option.options[customer_option.selectedIndex].value;

            let insurance_company_id = null;
            let insurance_company_option = document.getElementById('company');
            let insurance_company = insurance_company_option.options[insurance_company_option.selectedIndex].value;
            if (insurance_company != '') {
                let dict = JSON.parse(insurance_company);
                insurance_company_id = dict['id'];
            }
            $.ajax({
                method: 'POST', // Type of response
                url: '{{ route("prescription.store") }}', // This is the url we gave in the route
                data: {
                    "_token": "{{ csrf_token() }}",
                    'drugs' : drugs,
                    'customer_id' : customer_id,
                    'insurance_company_id' : insurance_company_id}, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                    window.location.href = "/prescriptions"
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#customer').select2({
                placeholder: "اختر قيمة",
                allowClear: true
            });
            $('#company').select2({
                placeholder: "اختر قيمة",
                allowClear: true
            });
            // Search for drug using select2
            $("#search_drugs").select2( {
                ajax: {
                url: "{{ route('drug.search') }}",
                type: "GET",
                dataType: 'json',
                data: function (params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
                }
          });

          // This function will be called when a selection is made
          function fetch_drugs(drug = '')
          {
           $.ajax ({
            url:"{{ route('drug.get_drug_by_id_for_prescription') }}",
            method:'GET',
            data:{drug_id:drug},
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
              var table_rows = document.getElementById('drugs').children;
              for (i = 0; i < table_rows.length; i++) {
                  if (table_rows[i].children[1].innerHTML === drug) {
                      table_rows[i].remove();
                  }
              }
          });
        });
    </script>
@endsection
