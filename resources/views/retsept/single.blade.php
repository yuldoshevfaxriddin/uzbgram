@extends('retsept.layout')

@section('content')
    <!-- Detail Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <div class="d-flex mb-2">
                            <p class="text-secondary text-uppercase font-weight-medium">{{ $retsept->user->name }}</p>
                            <span class="text-primary px-2">|</span>
                            <p class="text-secondary text-uppercase font-weight-medium">{{ $retsept->created_at }}</p>
                        </div>
                        <a href="{{ route('retsept-edit', $retsept) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('retsept-delete', $retsept) }}" class="btn btn-danger">Delete</a>
                        <h1 class="section-title mb-3">{{ $retsept->name }}</h1>
                    </div>

                    <div class="mb-5">
                        <img class="img-fluid rounded w-100 mb-4"
                            src="{{ route('retsept-index') . '/storage//' . $retsept->image }}" alt="Image">
                        <p>{{ $retsept->message }}</p>
                    </div>

                    <div class="mb-5">
                        <h3 class="mb-4 section-title">{{ count($retsept->comments) }} Comments</h3>
                        @foreach ($retsept->comments as $comment)
                            <div class="media mb-4">
                                <img src="{{ route('retsept-index') }}/storage/{{ $comment->user->image }}" alt="Image"
                                    class="img-fluid rounded-circle mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <h6>{{ $comment->user->name }}<small><i>{{ $comment->created_at }}</i></small></h6>
                                    <p>{{ $comment->description }}</p>
                                    {{-- <button class="btn btn-sm btn-light">Reply</button> --}}
                                </div>
                            </div>
                        @endforeach
                        {{-- <div class="media mb-4">
                            <img src="img/user.jpg" alt="Image" class="img-fluid rounded-circle mr-3 mt-1" style="width: 45px;">
                            <div class="media-body">
                                <h6>John Doe <small><i>01 Jan 2045 at 12:00pm</i></small></h6>
                                <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum clita, at tempor amet ipsum diam tempor sit.</p>
                                <button class="btn btn-sm btn-light">Reply</button>
                                <div class="media mt-4">
                                    <img src="img/user.jpg" alt="Image" class="img-fluid rounded-circle mr-3 mt-1"
                                        style="width: 45px;">
                                    <div class="media-body">
                                        <h6>John Doe <small><i>01 Jan 2045 at 12:00pm</i></small></h6>
                                        <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum clita, at tempor amet ipsum diam tempor sit.</p>
                                        <button class="btn btn-sm btn-light">Reply</button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="bg-light rounded p-5">
                        <h3 class="mb-4 section-title">Izoh qoldirish</h3>
                        <form action="{{ route('izoh') }}" method="POST">

                            @csrf
                            {{-- <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label for="name">Name *</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email *</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="url" class="form-control" id="website">
                            </div> --}}
                            <input type="hidden" name="user_id" value="3">
                            <input type="hidden" name="retsept_id" value="{{ $retsept->id }}">
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" name='message' cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Leave Comment" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <div class="d-flex flex-column text-center bg-secondary rounded mb-5 py-5 px-4">
                        <img src="{{route('retsept-index').'/storage//'.$retsept->user->image}}" class="img-fluid rounded-circle mx-auto mb-3" style="width: 100px;">
                        <h3 class="text-white mb-3">{{ $retsept->user->name }}</h3>
                        <p class="text-white m-0">{{ $retsept->user->user_bio }}</p>
                    </div>
                    <div class="mb-5">
                        <h3 class="mb-4 section-title">Boshqa retseptlar</h3>
                        @foreach ($retsept->user->retsepts as $new_retsept)
                            <div class="d-flex align-items-center border-bottom mb-3 pb-3">

                                <img class="img-fluid rounded"
                                    src="{{ route('retsept-index') . '/storage//' . $new_retsept->user->image }}"
                                    style="width: 80px; height: 80px; object-fit: cover;" alt="">
                                <div class="d-flex flex-column pl-3">
                                    <a class="text-dark mb-2" href="">{{ $new_retsept->message }}</a>
                                    <div class="d-flex">
                                        <small><a class="text-secondary text-uppercase font-weight-medium"
                                                href="">{{ $new_retsept->user->name }}</a></small>
                                        <small class="text-primary px-2">|</small>
                                        <small><a class="text-secondary text-uppercase font-weight-medium"
                                                href="">{{ $new_retsept->created_at }}</a></small>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="mb-5">
                            <h3 class="mb-4 section-title">Taglar</h3>
                            <div class="d-flex flex-wrap m-n1">
                                @foreach (App\Models\Retsept::all() as $retsept)
                                    <a href="{{ route('retsept-filter', $retsept) }}"
                                        class="btn btn-outline-secondary m-1">{{ $retsept->name }}</a>
                                @endforeach
                            </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Detail End -->
    @endsection
