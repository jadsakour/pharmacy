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
                            <h3><i class="fa fa-angle-left  mr"></i> الشركات</h3>
                            <a type="submit" class="btn btn-theme  mr" href="{{ route('company.create') }}">إضافة شركة</a>
                            <hr>
                            <thead>
                                <tr>
                                    <th style="width:200px;"><i class="fa fa-bullhorn ml"></i>اسم الشركة</th>
                                    <th><i class="fa fa-bullhorn ml"></i>اسم المندوب</th>
                                    <th class="hidden-phone "><i class="fa fa-question-circle ml"></i>رقم الهاتف</th>
                                    <th><i class="fa fa-bookmark ml"></i>العنوان</th>
                                    <th><i class=" fa fa-edit ml"></i>الموقع الالكتروني</th>
                                    <th>البريد الالكتروني</th>
                                    <th>الفاكس</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($companies as $company)
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->delegate_name }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>{{ $company->address }}</td>
                                    <td>{{ $company->web_site }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->fax }}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                        <a href="{{ route('company.edit', $company->id) }}"><button
                                                class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                        <form class="delete-form" action="{{ route('company.destroy', $company->id) }}"
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
