@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper" >
        <h3><i class="fa fa-angle-right"></i>تفاصيل الطلبية</h3>
        <div class="row mt" dir="rtl">
            <div class="col-lg-12">
                <div class="form-panel">
                    <h4 class="mb"><i class="fa fa-angle-right"></i>رقم الطلبية {{ $order->id }}</h4>
                    @if($order->is_delivered == 0)
                        <h3>لم يتم استلام الطلبية بعد</h3>
                    @else
                        <h3>تم الاستلام</h3>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th>اسم الدواء</th>
                                <th class="text-left">عدد العلب المطلوبة</th>
                                <th class="text-left">عدد العلب المستلمة</th>
                                <th class="text-left">عدد الظروف المطلوبة</th>
                                <th class="text-left">عدد الظروف المستلمة</th>
                            </tr>
                        </thead>
                        <tbody id="drugs">
                            @foreach($order->drugs_send as $drug)
                            <tr>
                                <td>{{ $drug->drug->name_arabic }}</td>
                                <td>{{ $drug->ordered_packages_number }}</td>
                                @if($order->is_delivered == 0)
                                    <td>0</td>
                                @else
                                    <td>{{ $drug->order->drugs_receive()->where('order_id', $drug->order_id)->where('drug_id', $drug->drug_id)->first()->recieved_packages_number }}</td>
                                @endif
                                <td>{{ $drug->ordered_units_number }}</td>
                                @if($order->is_delivered == 0)
                                    <td>0</td>
                                @else
                                    <td>{{ $drug->order->drugs_receive()->where('order_id', $drug->order_id)->where('drug_id', $drug->drug_id)->first()->recieved_units_number }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
<td>
