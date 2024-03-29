@extends('retsept.layout')

@section('meta-data')
<title>Retseptlar</title>
@endsection


@section('content')
    @if (session('status'))
        <h6 class="alert alert-success">{{ session('status') }}</h6>
    @endif
    {{-- @dd($retsepts[0]->comments()->where('id', '4')) --}}
    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row align-items-end mb-4">
                <div class="col-lg-6">
                    <h6 class="text-secondary font-weight-semi-bold text-uppercase mb-3">Retseptlar</h6>
                    <h4 class="section-title mb-3">Tajribangizni biz bilan ulashing</h4>
                </div>
                <div class="col-lg-6">
                    <h4 class="font-weight-normal text-muted mb-3">Retsept almashish tizimi</h4>
                </div>
            </div>
        
            <div class="row">
                @foreach ($retsepts as $retsept)
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded w-100" style="width: 200px;height: 200px;" src="{{route('retsept-index').'/storage//'.$retsept->image}}" alt="">
                    </div>
                    <div class="d-flex mb-2">
                      @if (count($retsept->like)!=0)
                      <div class="blog-date">
                        <h4 class="font-weight-bold mb-n1">{{round($retsept->like->avg('ball'),1)}}</h4>
                      </div>
                      @endif
                        <p class="text-secondary text-uppercase font-weight-medium" ><a href="{{route('user-profil',$retsept->user)}}">{{$retsept->user->name}}</a></p>
                        <span class="text-primary px-2">|</span>
                        <p class="text-secondary text-uppercase font-weight-medium" >{{$retsept->created_at}}</p>
                    </div>
                    <h5 class="font-weight-medium mb-2">{{substr($retsept->name,0,20)}}</h5>
                    <p class="mb-4" title="{{$retsept->message}}">{{substr($retsept->message,0,38)}}...</p>
                    <a class="btn btn-sm btn-primary py-2" href="{{route('retsept-show',$retsept)}}">Tanishish</a>
                </div>
                @endforeach

                {{-- <div class="col-12">
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-lg justify-content-center mb-0">
                        <li class="page-item disabled">
                          <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                          </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div> --}}

            </div>
        </div>
    </div>
    <!-- Blog End -->

@endsection
