@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" >
        <h3><i class="fa fa-angle-right"></i>استلام طلبية</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i>معلومات الطلب ذو الرقم {{ $order->id }}</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">اسم الدواء بالعربي</th>
                                <th class="text-left">عدد العلب التي تم طلبها</th>
                                <th class="text-left">عدد الظروف التي تم طلبها</th>
                                <th style="width:200px" class="text-left">عدد الوحدات ضمن العلبة</th>
                                <th style="width:200px" class="text-left">عدد الوحدات</th>
                                <th style="width:200px" class="text-center">عدد العلب</th>
                                <th style="width:200px" class="text-left">سعر المبيع للعلبة</th>
                                <th style="width:200px" class="text-center">السعر الصافي للعلبة</th>
                                <th style="width:200px" class="text-left">سعر المبيع للظرف</th>
                                <th style="width:200px" class="text-left">السعر الصافي للظرف</th>
                                <th style="width:200px" class="text-left">تاريخ الإنتاج</th>
                                <th style="width:200px" class="text-left">تاريخ الانتهاء</th>
                            </tr>
                        </thead>
                        <tbody id="drugs">
                            @foreach($order->drugs_send as $drug)
                            <tr>
                                <td hidden>{{ $drug->drug()->first()->id }}</td>
                                <td >{{ $drug->drug()->first()->name_arabic }}</td>
                                <td class="text-center">{{ $drug->ordered_packages_number }}</td>
                                <td class="text-center">{{ $drug->ordered_units_number }}</td>
                                <td class="text-center" id="unit_number"><input type="text" class="form-control" name="unit_number"></td>
                                <td class="text-center" id="units_number"><input type="text" class="form-control" name="units_number"></td>
                                <td class="text-center" id="packages_number"><input type="text" class="form-control" name="packages_number"></td>
                                <td class="text-center" id="package_sell_price"><input type="text" class="form-control" name="package_sell_price"></td>
                                <td class="text-center" id="package_net_price"><input type="text" class="form-control" name="package_net_price"></td>
                                <td class="text-center" id="unit_sell_price"><input type="text" class="form-control" name="unit_sell_price"></td>
                                <td class="text-center" id="unit_net_price"><input type="text" class="form-control" name="unit_net_price"></td>
                                <td class="text-center" id="pro_date"><input type="date" class="form-control" name="pro_date"></td>
                                <td class="text-center" id="exp_date"><input type="date" class="form-control" name="exp_date"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <label>قيمة فاتورة الشراء كاملة</label>
                    <input type="text" class="form-control" id="net_price">
                    <label>المبلغ المراد دفعه حالياً</label>
                    <input type="text" class="form-control" id="amount">
                    <button type="submit" class="btn btn-theme" id="submit_receive">إضافة</button>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
@section('scripts')
    <script>
        document.getElementById("submit_receive").onclick = submit_receive;
        function submit_receive() {
            let drugs = {
                'ids' : [],
                'unit_number' : [],
                'packages_number' : [],
                'units_number' : [],
                'package_net_price' : [],
                'unit_net_price' : [],
                'package_sell_price' : [],
                'unit_sell_price' : [],
                'expiration_date' : [],
                'production_date' : []
            };
            let table_rows = document.getElementById('drugs').children;
            for (let i = 0; i < table_rows.length; i++) {
                drugs['ids'].push(table_rows[i].children[0].innerHTML);
                drugs['unit_number'].push(table_rows[i].children[4].firstElementChild.value);
                drugs['units_number'].push(table_rows[i].children[5].firstElementChild.value);
                drugs['packages_number'].push(table_rows[i].children[6].firstElementChild.value);
                drugs['package_sell_price'].push(table_rows[i].children[7].firstElementChild.value);
                drugs['package_net_price'].push(table_rows[i].children[8].firstElementChild.value);
                drugs['unit_sell_price'].push(table_rows[i].children[9].firstElementChild.value);
                drugs['unit_net_price'].push(table_rows[i].children[10].firstElementChild.value);
                drugs['production_date'].push(table_rows[i].children[11].firstElementChild.value);
                drugs['expiration_date'].push(table_rows[i].children[12].firstElementChild.value);
            }
            let net_price = document.getElementById('net_price').value;
            let amount = document.getElementById('amount').value;
            $.ajax({
                method: 'POST', // Type of response
                url: '{{ route("invoice.store") }}', // This is the url we gave in the route
                data: {
                    "_token": "{{ csrf_token() }}",
                    'drugs' : drugs,
                    'net_price' : net_price,
                    'amount' : amount,
                    'order_id' : {{ $order->id }},
                    'invoice_type_id' : 3}, // a JSON object to send back
                success: function(response){ // What to do if we succeed
                    window.location.href = "/orders";
                },
                error: function(jqXHR, textStatus, errorThrown) { // What to do if we fail
                    alert("حدث خطأ أثناء عملية استقبال فاتورة الشراء");
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        }
    </script>
@endsection
