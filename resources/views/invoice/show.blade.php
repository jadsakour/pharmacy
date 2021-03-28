@extends('/layouts.master')
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
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <!-- /col-md-9 -->
                            <div class="col-md-4">
                                <br>
                                <div>
                                    <div class="pull-left">رقم الفاتورة:</div>
                                    <div class="pull-right">{{ $invoice->id }}</div>
                                    <div class="clearfix"></div>
                                </div>
                                <div>
                                    <!-- /col-md-3 -->
                                    <div class="pull-left">تاريخ الفاتورة:</div>
                                    <div class="pull-right">{{ $invoice->date }}</div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <!-- /invoice-body -->
                        </div>
                        <!-- /col-lg-10 -->
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-left">الدواء</th>
                                    <th style="width:100px" class="text-center">عدد العلب</th>
                                    <th style="width:100px" class="text-center">عدد الظروف</th>
                                    <th class="text-left">حالة الفاتوة</th>
                                    <th style="width:140px" class="text-left">سعر المبيع للظرف</th>
                                    <th style="width:140px" class="text-left">سعر المبيع للعلبة</th>
                                    <th style="width:90px" class="text-left">السعر الكلي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->drugs as $drug)
                                <tr>
                                    <td>{{ $drug->name_arabic }}</td>
                                    <td class="text-center">{{ $drug->pivot->drug_package_number }}</td>
                                    <td class="text-center">{{ $drug->pivot->drug_unit_number }}</td>
                                    @if($invoice->is_paid == 0)
                                        <td>لم يتم دفع كامل الفاتورة بعد</td>
                                    @else
                                        <td>تم دفع كامل الفاتورة</td>
                                    @endif
                                    @if($drug->modified_drugs_unit_sell_price == 0)
                                        <td class="text-left">{{ $drug->repo()->where([['drug_id', '=', $drug->id], ['isDisposed', '=', false]])->orderBy('exp_date', 'ASC')->get()->first()->unit_sell_price }}</td>
                                    @else
                                        <td class="text-left">{{ $drug->modified_drugs_unit_sell_price }}</td>
                                    @endif
                                    @if($drug->modified_drugs_package_sell_price == 0)
                                        <td class="text-left">{{ $drug->repo()->where([['drug_id', '=', $drug->id], ['isDisposed', '=', false]])->orderBy('exp_date', 'ASC')->first()->package_sell_price }}</td>
                                    @else
                                        <td class="text-left">{{ $drug->modified_drugs_package_sell_price }}</td>
                                    @endif
                                    <td class="text-left">{{ $invoice->sell_price }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" rowspan="4">
                                        <h5 class="text-left "><strong>سبب الخصم</strong></h5>
                                        <p class="text-left">{{ $invoice->discount_reason }}</p>
                                        <td class="text-left"><strong></strong>السعر قبل الخصم</td>
                                        <td class="text-left">{{ $invoice->sell_price }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left no-border"><strong>الخصم</strong></td>
                                        <td class="text-left">{{ $invoice->discount_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left no-border">
                                            <div class="well well-small green"><strong>السعر بعد الخصم</strong></div>
                                        </td>
                                        <td class="text-left"><strong>{{ $invoice->sell_price_after_discount }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <br>

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
