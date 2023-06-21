@inject('carbon', 'Carbon\Carbon')

@extends('layouts.front-core.main')

@section('content')
    <section class="page-title bg-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <h1>{{ $title }}</h1>
                        <p>Lebih lengkapnya dijelaskan di halaman ini.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="post post-single">
                        <h2 class="post-title">{{ $post->title }}</h2>
                        <div class="post-meta">
                            <ul>
                                <li>
                                    <i class="ion-calendar"></i> {{ $carbon::parse($post->created_at)->format('l, d M Y') }}
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
                        <div class="post-thumb">
                            <img width="100%" class="img-fluid" style="max-height: 500px;"
                                src="{{ asset('storage/image-cover/' . $post->img_cover) }}" alt="">
                        </div>
                        <div class="post-content post-excerpt">
                            {!! $post->desc !!}
                        </div>

                        {{-- comments --}}
                        @auth
                            <div class="post-comments">
                                <h3 class="post-sub-heading">{{ $post->comments_count }} Comments</h3>
                                <ul class="media-list comments-list m-bot-50 clearlist">
                                    <!-- Comment Item start-->
                                    @foreach ($post->comments as $firstLevelComment)
                                        <li class="media">
                                            <a class="pull-left" href="#!">
                                                <img class="media-object comment-avatar rounded-circle"
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($firstLevelComment->user->name) }}&background=random"
                                                    alt="" width="50" height="50">
                                            </a>
                                            <div class="media-body">
                                                <div class="comment-info">
                                                    <h4 class="comment-author">
                                                        <a href="#!">{{ $firstLevelComment->user->name }}</a>
                                                    </h4>
                                                    <time>{{ $carbon::parse($firstLevelComment->created_at)->format('l, d M Y, H:i') }}</time>
                                                    <a class="comment-button" role="button"
                                                        data-postid="{{ $firstLevelComment->post_id }}"
                                                        data-commentid="{{ $firstLevelComment->id }}">
                                                        <i class="tf-ion-chatbubbles"></i>
                                                        Reply
                                                    </a>
                                                    @if ($firstLevelComment->replies->count() <= 0 && auth()->user()->id == $firstLevelComment->user_id)
                                                        &ensp;|&nbsp;
                                                        <a class="comment-delete" role="button"
                                                            data-commenttext="{{ $firstLevelComment->comment }}"
                                                            data-commentid="{{ $firstLevelComment->id }}">
                                                            Hapus
                                                        </a>
                                                    @endif
                                                </div>
                                                <p id="{{ $firstLevelComment->id }}">
                                                    {{ $firstLevelComment->comment }}
                                                </p>

                                                <!--  second level Comment start-->
                                                @foreach ($firstLevelComment->replies as $secondLevelComment)
                                                    <div class="media">
                                                        <a class="pull-left" href="#!">
                                                            <img class="media-object comment-avatar rounded-circle"
                                                                src="https://ui-avatars.com/api/?name={{ urlencode($secondLevelComment->user->name) }}&background=random"
                                                                alt="" width="50" height="50">
                                                        </a>
                                                        <div class="media-body">
                                                            <div class="comment-info">
                                                                <h4 class="comment-author">
                                                                    <a href="#!">{{ $secondLevelComment->user->name }}</a>
                                                                </h4>
                                                                <time>{{ $carbon::parse($secondLevelComment->created_at)->format('l, d M Y, H:i') }}</time>
                                                                <a class="comment-button" role="button"
                                                                    data-postid="{{ $firstLevelComment->post_id }}"
                                                                    data-commentid="{{ $secondLevelComment->id }}">
                                                                    Reply
                                                                </a>
                                                                @if ($secondLevelComment->replies->count() <= 0 && auth()->user()->id == $secondLevelComment->user_id)
                                                                    &ensp;|&nbsp;
                                                                    <a class="comment-delete" role="button"
                                                                        data-commenttext="{{ $secondLevelComment->comment }}"
                                                                        data-commentid="{{ $secondLevelComment->id }}">
                                                                        Hapus
                                                                    </a>
                                                                @endif
                                                            </div>
                                                            <p id="{{ $secondLevelComment->id }}">
                                                                {{ $secondLevelComment->comment }}
                                                            </p>

                                                            <!-- third level Comment start -->
                                                            @foreach ($secondLevelComment->replies as $thirdLevelComment)
                                                                <div class="media">
                                                                    <a class="pull-left" href="#!">
                                                                        <img class="media-object comment-avatar rounded-circle"
                                                                            src="https://ui-avatars.com/api/?name={{ urlencode($thirdLevelComment->user->name) }}&background=random"
                                                                            alt="" width="50" height="50">
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <div class="comment-info">
                                                                            <h4 class="comment-author">
                                                                                <a href="#!">
                                                                                    {{ $thirdLevelComment->user->name }}
                                                                                </a>
                                                                            </h4>
                                                                            <time>{{ $carbon::parse($thirdLevelComment->created_at)->format('l, d M Y, H:i') }}</time>
                                                                            @if (auth()->user()->id == $thirdLevelComment->user_id)
                                                                                <a class="comment-delete" role="button"
                                                                                    data-commenttext="{{ $thirdLevelComment->comment }}"
                                                                                    data-commentid="{{ $thirdLevelComment->id }}">
                                                                                    Hapus
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                        <p>{{ $thirdLevelComment->comment }}</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <!-- third level Comment end -->
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <!-- second level Comment end -->
                                            </div>
                                        </li>
                                    @endforeach
                                    <!-- End Comment Item -->
                                </ul>
                            </div>

                            <div class="post-comments-form">
                                <h3 class="post-sub-heading">Add a You Comment</h3>
                                <form method="post" action="{{ url('posts/comment/store') }}" role="form">
                                    @csrf
                                    <div class="row">
                                        <!-- Comment -->
                                        <div class="form-group col-md-12">
                                            <textarea name="comment_txt" id="text" class=" form-control" rows="5" placeholder="Comment"></textarea>
                                        </div>
                                        <input type="hidden" id="postId" name="post_id" value="{{ $post->id }}">
                                        <!-- Send Button -->
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-main ">
                                                Send comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Reply Comment -->
                            <div class="reply" style="display: none">
                                <form method="post" id="formReply" role="form">
                                    <div class="row">
                                        <!-- Comment -->
                                        <div class="form-group col-md-12">
                                            <textarea name="reply_txt" id="replyText" class=" form-control" rows="5" placeholder="Comment"></textarea>
                                        </div>

                                        <input type="hidden" id="post-id" name="post_id">
                                        <input type="hidden" id="commentId" name="comment_id">

                                        <!-- Send Button -->
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-main ">
                                                Send comment
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>

    <script>
        $(document).ready(function() {
            $('.comment-button').click(function(e) {
                e.preventDefault();

                let [commentId, postId] = [$(this).data('commentid'), $(this).attr('data-postid')];

                $('#post-id').val(postId);
                $('#commentId').val(commentId);

                $('.reply').insertAfter($(`#${commentId}`));
                $('.reply').toggle();
                $('textarea').val('');
            });

            $('#formReply').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: `{{ url('posts/comment/store-reply') }}`,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function() {
                        $('textarea').val('');
                        window.location.reload();
                    },
                });
            });

            $('.comment-delete').click(function(e) {
                e.preventDefault();

                let [commentId, commentName] = [
                    $(this).data('commentid'),
                    $(this).data('commenttext')
                ];

                Confirm.fire({
                    title: 'Konfirmasi hapus Komentar !',
                    html: `Apakah anda yakin ingin menghapus Komentar <b>${commentName}</b>`,
                    confirmButtonText: 'Ya, Hapus',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'delete',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: `{{ url('posts/comment/${commentId}/delete') }}`,
                            success: function() {
                                window.location.reload();
                            },
                        })
                    }
                })
            });
        });
    </script>
@endpush
