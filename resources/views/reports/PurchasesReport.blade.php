@extends('/layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تقرير مشتريات </h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"><i class="fa fa-angle-left"></i>هذا التقرير يقوم بعرض مجموع وتفصيل المشتريات في يوم معين او خلال مدة معين</h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="">
                                <thead>
                                    <tr>
                                        <th>رقم فاتورة الشراء</th>
                                        <th class="numeric">المبلغ المدفوع</th>
                                        <th class="numeric">المبلغ المتبقي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td class="numeric">{{ $order->operations->sum('amount') }}</td>
                                            <td class="numeric">{{  $order->net_price - $order->operations->sum('amount') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr colspan="2" rowspan="4">
                                        <td class="text-left"><strong>المجموع النهائي</strong></td>
                                        <td class="text-left">{{ $orders->sum('net_price') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
                <!-- /content-panel -->
            </div>
            <!-- /col-lg-4 -->
        </div>
        <!-- /row -->
    </section>
        <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
@endsection
