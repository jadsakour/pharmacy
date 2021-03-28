@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover">
                        <h3><i class="fa fa-angle-left  mr"></i> نوع فاتورة</h3>
                        <a type="submit" class="btn btn-theme  mr" href="{{ route('accountingType.create') }}" >إضافة نوع جديد</a>
                        <hr>
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn ml"></i>اسم النوع</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach($types as $types)
                                <td>
                                    {{ $types->name }}
                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                    <a href="{{route('accountingType.edit', $types->id)}}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                    <form class="delete-form" action="{{ route('accountingType.destroy', $types->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-xs" onClick="alert('are you sure')"><i class="fa fa-trash-o "></i></button>
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
