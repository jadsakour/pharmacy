@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                   <div class="adv-table">
                        <h4><i class="fa fa-angle-left"></i>شركات التأمين</h4>
                        <a type="submit" class="btn btn-theme" href="{{ route('insurnce-company.create') }}"
                            style="margin-right:10px;">إضافة شركة تأمين</a>
                        <hr>
                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                            <thead>
                                <tr>
                                    <th><i class="fa fa-bullhorn"></i>اسم الشركة</th>
                                    <th><i class="fa fa-bookmark"></i>العنوان</th>
                                    <th class="hidden-phone"><i class="fa fa-question-circle"></i>رقم الهاتف</th>
                                    <th>البريد الالكتروني</th>
                                    <th>الحسم</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($insurance_companies  as $insurance_company)
                                    <td>{{ $insurance_company->name }}</td>
                                    <td>{{ $insurance_company->address }}</td>
                                    <td>{{ $insurance_company->phone }}</td>
                                    <td>{{ $insurance_company->email }}</td>
                                    <td>{{ $insurance_company->discount }}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                        <a href="{{ route('insurnce-company.edit', $insurance_company->id) }}"><button
                                                class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                        <form class="delete-form" action="{{ route('insurnce-company.destroy', $insurance_company->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs" onClick="alert('are you sure')"><i
                                                    class="fa fa-trash-o "></i></button>
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
