@extends('layouts.master')
@section('content')
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <table class="table table-striped table-advance table-hover">
                        <h3><i class="fa fa-angle-left mr"></i>الأشكال</h3>
                        <a type="submit" class="btn btn-theme mr" href="{{ route('shape.create') }}" >إضافة شكل</a>
                        <hr>
                        <thead>
                            <tr>
                                <th><i class="fa fa-bullhorn"></i> الشكل</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shapes as $shape)
                            <tr>

                                <td>
                                    {{ $shape->name }}
                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                    <a href="{{ route('shape.edit', $shape->id) }}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
                                    <form class="delete-form" action="{{ route('shape.destroy', $shape->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-xs" onClick="alert('are you sure')"><i class="fa fa-trash-o "></i></button>
                                    </form>
                                </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
