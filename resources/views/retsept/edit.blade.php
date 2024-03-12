@extends('retsept.layout')

@section('content')
@if (session('status'))
<h6 class="alert alert-success">{{ session('status') }}</h6>
@endif
{{-- @dd($retsept) --}}
<div class="bg-light rounded p-5">
                            <img src="{{route('retsept-index').'/storage//'.$retsept->image}}" alt="photo" style="width: 85vw">
                        <h3 class="mb-4 section-title">Retseptni tahrirlash</h3>
                        <form action="{{route('retsept-edit',$retsept)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="name">Nomi </label>
                                    <input type="text" class="form-control" name='name' id="name" value="{{$retsept->name}}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="file">Rasm *</label>
                                    <input type="file" class="form-control" name='image' id="file">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message">Matn *</label>
                                <textarea id="message" cols="30" rows="5" name='message' class="form-control">{{$retsept->message}}</textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Yangilash" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>


@endsection