@extends('/layouts.master')
@section('content')
<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <div class="col-lg-12 mt">
            <div class="row content-panel">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="invoice-body">
                        <div class="">
                            <h3 class="text-left">اسم المريض: {{ $prescriptions->customer->name }}</h3>
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
                        <!-- /col-lg-10 -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">اسم الدواء</th>
                                    <th class="text-left">عددالعلب</th>
                                    <th class="text-left">سعر العلبة</th>
                                    <th class="text-left">عدد الظروف</th>
                                    <th class="text-left">سعر الظرف</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prescriptions->drugs as $drug)
                                <tr>
                                    <td>{{ $drug->name_arabic }}</td>
                                    <td class="text-left">{{ $drug->pivot->packages_number }}</td>
                                    <td class="text-left">{{ $drug->pivot->package_sell_price }}</td>
                                    <td class="text-left">{{ $drug->pivot->units_number }}</td>
                                    <td class="text-left">{{ $drug->pivot->unit_sell_price }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <br>
                        <table class="table table-striped">
                             <tbody>
                              <tr>
                                <td class="text-left no-border"><strong>الخصم</strong></td>
                                <td class="text-left">{{ $prescriptions->discount_amount }}</td>
                                <td class="text-left "><strong>شركة التأمين</strong></td>
                                <td class="text-left">{{ $prescriptions->insurance_company->name }}</td>
                                  </tr>
                                  <tr>
                                      <td class="text-left no-border"><strong>الرقم الوطني</strong></td>
                                      <td class="text-left">{{ $prescriptions->customer->national_id }}</td>
                                      <td class="text-left no-border">
                                          <strong>رقم الهاتف</strong>
                                      </td>
                                      <td class="text-left"><strong>{{ $prescriptions->customer->phone }}</strong></td>
                                  </tr>
                            </tbody>
                          </table>
                          <br>
                          <br>
                          <hr>
                           <h4 class="text-left"><strong>إجمالي الفاتورة: {{ $prescriptions->sell_price }} ل س </strong></h4>
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
