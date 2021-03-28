@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover">
                        <h3><i class="fa fa-angle-left  mr"></i>الدفعات</h3>
                        <a type="submit" class="btn btn-theme  mr" href="{{ route('accountingOperation.create') }}">إضافة دفعة جديدة</a>
                        <hr>
                        <thead>
                            <tr>
                              <th class="hidden-phone"><i class="fa fa-question-circle ml"></i>نوع الفاتورة</th>
                              <th class="hidden-phone"><i class="fa fa-question-circle ml"></i>السعر</th>
                              <th><i class="fa fa-bookmark ml "></i>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($operations as $operations)
                                <td>
                                    {{ $operations->type->name }}
                                </td>
                                <td>
                                    {{ $operations->amount }}
                                </td>
                                <td>
                                    {{ $operations->date }}
                                </td>
                                  <td>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                    <a href=""><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                    <form class="delete-form" action="{{ route('accountingOperation.destroy', $operations->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-xs" onClick="alert('are you sure')"><i class="fa fa-trash-o"></i></button>
                                    </form>
                                </td>
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
