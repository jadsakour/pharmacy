@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                   <div class="adv-table">
                        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered"
                            id="hidden-table-info">
                            <h3><i class="fa fa-angle-left mr"></i> الفواتير</h3>
                            <a type="submit" class="btn btn-theme mr" href="{{ route('invoice.create') }}">إضافة فاتورة بدون تأمين</a>
                            <a type="submit" class="btn btn-theme mr" href="{{ route('invoice.create_with_insurance') }}">إضافة فاتورة مع تأمين</a>
                            <hr>
                            <thead>
                                <tr>
                                    <th><i class="fa fa-barcode ml"></i>رقم الفاتورة</th>
                                    <th><i class="fa fa-calendar ml"></i>تاريخ الفاتورة</th>
                                    <th><i class="fa fa-info ml"></i>معلومات الدفع</th>
                                    <th><i class="fa fa-money ml"></i>سعر المبيع</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($invoices as $invoice)
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ date('d-m-Y', strtotime($invoice->date)) }}</td>
                                    @if($invoice->is_paid == 0)
                                        <td>لم يتم دفع كامل الفاتورة بعد</td>
                                    @else
                                        <td>تم دفع كامل الفاتورة</td>
                                    @endif
                                  <td>{{ $invoice->sell_price }}</td>

                                    <td>
                                        @if($invoice->is_paid == 0)
                                            <button id="payment" class="btn btn-success btn-xs" onclick="window.location.href = '{{ route('invoice.payment', $invoice->id) }}';"><i class="fa fa-money"></i></button>
                                        @endif
                                        <button class="btn btn-primary btn-xs" onclick="window.location.href = '{{ route('invoice.show', $invoice->id) }}';"><i class="fa fa-eye"></i></button>
                                        <a href=""><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                        <form class="delete-form" action="{{ route('invoice.delete', $invoice->id) }}" method="post">
                                            @csrf
                                            <button class="btn btn-danger btn-xs" onClick="alert('Are you sure!!')"><i class="fa fa-trash-o"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
