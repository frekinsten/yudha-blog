@inject('carbon', 'Carbon\Carbon')

@extends('layouts.front-core.main')

@section('content')
    <section class="page-title bg-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1>{{ $title }}</h1>
                        <p>Apa yang anda ketahui, Bagus juga jika anda mau menulisnya disini.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="container">
            @if ($posts->count() > 0)
                <div class="row justify-content-center mb-5">
                    <div class="col-md-10">
                        <form action="{{ url('posts') }}" method="GET">
                            @if (request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif

                            @if (request('tag'))
                                <input type="hidden" name="tag" value="{{ request('tag') }}">
                            @endif

                            @if (request('author'))
                                <input type="hidden" name="author" value="{{ request('author') }}">
                            @endif

                            <div class="input-group input-group-lg">
                                <input class="form-control form-control-lg" type="text" name="search"
                                    placeholder="Cari..." value="{{ request('search') }}" />
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-secondary">
                                        Go!
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="post">
                            <div class="post-media post-thumb">
                                <a href="{{ url('posts/' . $posts[0]->slug) }}">
                                    @if ($posts[0]->img_cover)
                                        <img width="100%" class="img-fluid" style="max-height: 500px;"
                                            src="{{ asset('storage/image-cover/' . $posts[0]->img_cover) }}" alt="">
                                    @else
                                        <img class="img-fluid" src="https://dummyimage.com/1098x500/dee2e6/6c757d.jpg"
                                            alt="" />
                                    @endif
                                </a>
                            </div>
                            <h3 class="post-title">
                                <a href="{{ url('posts/' . $posts[0]->slug) }}">{{ $posts[0]->title }}</a>
                            </h3>
                            <div class="post-meta">
                                <ul>
                                    <li>
                                        <i class="ion-calendar"></i>
                                        {{ $carbon::parse($posts[0]->created_at)->format('l, d M Y') }}
                                    </li>
                                    <li>
                                        <i class="ion-android-people"></i> POSTED BY {{ $posts[0]->user->name }}
                                    </li>
                                    <li>
                                        <i class="ion-pricetags"></i>
                                        @foreach ($posts[0]->tags as $postTags)
                                            {{ $loop->first ? null : ', ' }}
                                            <a href="{{ url('posts?tag=' . $postTags->slug) }}">
                                                {{ $postTags->tag_name }}
                                            </a>
                                        @endforeach
                                    </li>

                                </ul>
                            </div>
                            <div class="post-content">
                                {!! Str::words($posts[0]->desc, 75, '...') !!}
                                <br />
                                <a href="{{ url('posts/' . $posts[0]->slug) }}" class="btn btn-main">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @foreach ($posts->skip(1) as $post)
                        <div class="col-md-6">
                            <div class="post">
                                <div class="post-thumb">
                                    <a href="{{ url('posts/' . $post->slug) }}">
                                        @if ($post->img_cover)
                                            <img class="img-fluid"
                                                src="{{ asset('storage/image-cover/' . $post->img_cover) }}"
                                                alt="">
                                        @else
                                            <img class="img-fluid" src="https://dummyimage.com/1098x500/dee2e6/6c757d.jpg"
                                                alt="" />
                                        @endif
                                    </a>
                                </div>
                                <h3 class="post-title">
                                    <a href="{{ url('posts/' . $post->slug) }}">{{ $post->title }}</a>
                                </h3>
                                <div class="post-meta">
                                    <ul>
                                        <li>
                                            <i class="ion-calendar"></i>
                                            {{ $carbon::parse($post->created_at)->format('l, d M Y') }}
                                        </li>
                                        <li>
                                            <i class="ion-android-people"></i> POSTED BY {{ $post->user->name }}
                                        </li>
                                        <li>
                                            <i class="ion-pricetags"></i>
                                            @foreach ($post->tags as $postTags)
                                                {{ $loop->first ? null : ', ' }}
                                                <a href="{{ url('posts?tag=' . $postTags->slug) }}">
                                                    {{ $postTags->tag_name }}
                                                </a>
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                                <div class="post-content">
                                    {!! Str::words($post->desc, 40, '...') !!}
                                    <br />
                                    <a href="{{ url('posts/' . $post->slug) }}" class="btn btn-main">Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination post-pagination justify-content-center">
                        {{ $posts->links() }}
                    </ul>
                </nav>
            @else
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-warning text-center mb-0">
                            Tidak ada Post.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
