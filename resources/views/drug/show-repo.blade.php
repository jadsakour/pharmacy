@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <div class="adv-table">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">اسم الدواء</th>
                                    <th class="text-left">تاريخ انتهاء الصلاحية</th>
                                    <th class="text-left">عدد الوحدات</th>
                                    <th class="text-left">عدد العلب</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> {{ $drug->name_arabic }} </td>
                                    @foreach($drug->repo as $drug_repo)
                                <tr>
                                    <td></td>
                                    <td>{{ $drug_repo->exp_date }}</td>
                                    <td>{{ $drug_repo->units_number }}</td>
                                    <td>{{ $drug_repo->packages_number }}</td>
                                    <td>
                                        <a type="submit" class="btn btn-theme mr " href="{{ route('drug.repo.edit', $drug_repo->id) }}">تعديل الدفعة</a>
                                    </td>
                                    @endforeach
                                </tr>
                                </tr>
                            </tbody>
                        </table>
                        <a class="btn btn-theme mr " href="{{ route('drug.index') }}"> رجوع</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
<!--main content end-->

@endsection
