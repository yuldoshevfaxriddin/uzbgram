@extends('retsept.layout')

@section('meta-data')
<title>{{ $retsept->user->name.' '. $retsept->name }}</title>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script> --}}

@endsection

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
                        @auth
                            @if (auth()->user()->id == $retsept->user->id)
                                <a href="{{ route('retsept-edit', $retsept) }}" class="btn btn-primary">Tahrirlash</a>
                                <a href="{{ route('retsept-delete', $retsept) }}" class="btn btn-danger">O'chirish</a>
                            @endif
                        @endauth
                        <h1 class="section-title mb-3">{{ $retsept->name }}</h1>
                    </div>

                    <div class="mb-5">
                        <img class="img-fluid rounded w-100 mb-4"
                            src="{{ route('retsept-index') . '/storage//' . $retsept->image }}" alt="Image">
                            
                        {{-- <pre style='font-family: "Poppins", sans-serif;
                        font-size: 1rem;
                        font-weight: 400;
                        line-height: 1.5;
                        color: #777777;
                        text-align: left;'
                        > --}}
                        <p style="">{{ $retsept->message }}</p>
                        
                    {{-- </pre> --}}
                    </div>
                    @if (count($retsept->like)!=0)
                      <div class="blog-date">
                        <h6 class="font-weight-bold mb-n1" id="qiymat">{{round($retsept->like->avg('ball'),1)}}</h4>
                      </div>
                      @endif
                    <div class="mb-5">
                            @auth
                            <select name="ball">
                                @for ($i = 1 ; $i<=5 ; $i++)
                                {{-- @if ( ($retsept->like->where('user_id',auth()->user()->id)  and $retsept->like->where('user_id',auth()->user()->id)->first()->ball==$i))
                                    <option value="{{$i}}" id="sel{{$i}}"  selected onclick="sendBall(this)">{{$retsept->like->where('user_id',auth()->user()->id)->first()->ball}} baho</option>
                                @else --}}
                                <option value="{{$i}}" id="sel{{$i}}" onclick="sendBall(this)">{{$i}} baho</option>
                                {{-- @endif --}}
                                
                                @endfor
                                {{-- @if ($retsept->like->where('user_id',auth()->user()->id))
                                <option value="#" disabled selected>{{$retsept->like->where('user_id',auth()->user()->id)->first()->ball}}</option>
                                @endif
                                <option value="1" onclick="sendBall(this)">1</option>
                                <option value="2" onclick="sendBall(this)">2</option>
                                <option value="3" onclick="sendBall(this)">3</option>
                                <option value="4" onclick="sendBall(this)">4</option>
                                <option value="5" onclick="sendBall(this)">5</option> --}}
                            </select>
                            <p class="mb-4 " id="ball">
                                @if ($retsept->like->where('user_id',auth()->user()->id)->first())
                                    {{$retsept->like->where('user_id',auth()->user()->id)->first()->ball}}
                                @endif
                            </p>
                            <script>
                                function sendBall(event){
                                    var old_selcted = 0;
                                    var send_url= "/ball?qiymat="+event.value+'&retsept_id='+{{$retsept->id}};
                                    var xhttp = new XMLHttpRequest();
                                    xhttp.onreadystatechange = function() {
                                        old_selcted = 'sel'+event.value;
                                        if ( this.status == 200) {
                                            var respons_data = JSON.parse(this.responseText);
                                            console.log(respons_data['qiymat']);
                                            document.getElementById("ball").innerHTML = respons_data['qiymat'];
                                            document.getElementById("qiymat").innerHTML = respons_data['avg_qiymat'];
                                            document.getElementById("reyting").innerHTML = respons_data['reyting'];
                                        }
                                    };
                                    xhttp.open("GET", send_url , true);
                                    xhttp.send();
                                }
                                </script>
                                @endauth
                      
                    </div>
                    <div class="mb-5">
                        <h3 class="mb-4 section-title">{{ count($retsept->comments) }} ta izoh </h3>
                        @foreach ($retsept->comments as $comment)
                            <div class="media mb-4">
                                <img src="{{ route('retsept-index') }}/storage/{{ $comment->user->image }}" alt="Image"
                                    class="img-fluid rounded-circle mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <h6>{{ $comment->user->name }} <small> <i>{{ $comment->created_at }}</i></small></h6>
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
                    
                    {{-- <h1>Classic editor</h1>
                    <div id="editor">
                        <p>This is some sample content.</p>
                    </div>
                    <script>
                        ClassicEditor
                            .create( document.querySelector( '#editor' ) )
                            .catch( error => {
                                console.error( error );
                            } );
                    </script> --}}


                    <div class="bg-light rounded p-5">
                        <h3 class="mb-4 section-title">Izoh qoldirish</h3>
                        <form action="{{ route('izoh') }}" method="POST">

                            @csrf
                            <input type="hidden" name="retsept_id" value="{{ $retsept->id }}">
                            <div class="form-group">
                                <label for="message">Habar mazmuni *</label>
                                <textarea id="message" name='message' cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Izoh qoldirish" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0"><a href="{{route('user-profil',$retsept->user)}}">
                    <div class="d-flex flex-column text-center bg-secondary rounded mb-5 py-5 px-4">
                        <img src="{{ route('retsept-index') . '/storage//' . $retsept->user->image }}"
                            class="img-fluid rounded-circle mx-auto mb-3" style="width: 100px;">
                        <h3 class="text-white mb-3">{{ $retsept->user->name }}</h3>
                        <p class="text-white m-0">{{ $retsept->user->user_bio }}</p>
                        <p class="text-white m-0" id="reyting">Reyting: {{round($reyting,1)}}</p>
                    </div></a>
                    <div class="mb-5">
                        <h3 class="mb-4 section-title">Boshqa retseptlar</h3>
                        @foreach ($retsept->user->retsepts as $new_retsept)
                            <div class="d-flex align-items-center border-bottom mb-3 pb-3">

                                <img class="img-fluid rounded"
                                    src="{{ route('retsept-index') . '/storage//' . $new_retsept->user->image }}"
                                    style="width: 80px; height: 80px; object-fit: cover;" alt="">
                                <div class="d-flex flex-column pl-3">
                                    <a class="text-dark mb-2"
                                        href="{{ route('retsept-show', $new_retsept) }}">{{ $new_retsept->message }}</a>
                                    <div class="d-flex">
                                        <small><a class="text-secondary text-uppercase font-weight-medium"
                                                href="{{ route('user-profil', $new_retsept->user) }}">{{ $new_retsept->user->name }}</a></small>
                                        <small class="text-primary px-2">|</small>
                                        <small>
                                            <p class="text-secondary text-uppercase font-weight-medium">
                                                {{ $new_retsept->created_at }}</p>
                                        </small>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="mb-5">
                        <h3 class="mb-4 section-title">Taglar</h3>
                        <div class="d-flex flex-wrap m-n1">
                            {{-- @dd(Illuminate\Support\Facades\DB::table('retsepts')->orderBy('name')->distinct()->get()) --}}
                            {{-- @foreach ($retseps as $retsept) --}}
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
