@extends('/layouts.master')
@section('content')

<!--main content start-->
<section id="main-content">
    <section class="wrapper">
        <h3><i class="fa fa-angle-left"></i>تقرير يومية المبيعات </h3>
        <div class="row mt">
            <div class="col-lg-12">
                <div class="content-panel">
                    <h4 class="float-right"><i class="fa fa-angle-left"></i>يقوم بعرض محصلة المبيعات في يوم معين </h4>
                    <button type="button" onclick="printFunction()" class="btn btn-theme float-left ml">طباعة</button>
                    <section id="unseen">
                        <div class="">
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="">
                                <thead>
                                    <tr>
                                        <th>رقم الفاتورة</th>
                                        <th class="numeric">المجموع النهائي</th>
                                        <th class="numeric">المجموع المتبقي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td class="numeric"><a href="{{ route('invoice.show', $invoice->id) }}" target="_blank">{{ $invoice->id }}</a></td>
                                            <td class="numeric">{{ $invoice->operations->sum('amount') }}</td>
                                            <td class="numeric">{{ $invoice->sell_price_after_discount - $invoice->operations->sum('amount') }}</td>
                                        </tr>
                                    @endforeach
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
