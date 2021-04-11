@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Let's do it post!</h5>
                        <form action="{{ url('/post') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control" name="body" rows="3" placeholder="What do you think?"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control-file" name="image" >
                            </div>
                            <div class="btn-toolbar justify-content-end">
                                <div class="btn-group">
                                    <button class="btn btn-primary px-5" type="submit">Post</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if(!empty($posts))
                    @foreach($posts as $post)
{{--                        $posts คือ ตัวที่มีค่ามากกว่า 1 ค่า อาจจะเป็น array หรือตัวแปรชนิดอื่นๆ ที่มีการเก็บไว้หลายๆค่าไว้--}}
{{--                        $post คือ ตัวแปรที่ทำหน้าที่วิ่งส่ง วิ่งใช้ ทีละหนึ่งค่าจาก$posts วนไปเรื่อยๆตามจำนวนที่มีอยู่ใน$posts--}}
{{--                        ดังนั้น ถ้าไม่มี s คือ ตัวแปรที่ใช้วิ่งวนคล้ายกับ ตัวแปร i ใน for ของภาษาซี เช่น for(i=0; i++; i<=$posts) {cout<< i;}--}}
{{--                        for(i=1; i--; i<0)--}}
{{--                        for()--}}
{{--                            ค่าเริ่มต้น; update การเปลี่ยนแปลงค่า; เงื่อนไข;--}}
{{--                            i=2;            2<0   ;         i++;--}}
{{--                        Grammar ของตัวการเขียนโค้ด--}}
{{--                        7 ต้องการ 6-1--}}
{{--                        8 ต้องการ 7-1--}}
{{--                        9 ต้องการ 8-1--}}
{{--                        n ต้องการ n-1--}}
{{--                        dynamic programming คือ มีการเคลื่อนไหวเปลี่ยนแปลงตามเงื่อนไขต่างๆ--}}
{{--                        static คือ แก้แล้วแก้เลยไม่เปลี่ยนแปลง เช่น html css--}}
                        <div class="card mt-3">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mr-2">
                                            <a href="{{ url('/profile/'.$post->user->id) }}">
                                                <img src="{{ $post->user->image ? $post->user->image:'https://picsum.photos/50/50'}}" width="45" height="45" style="object-fit:cover;" class="rounded-circle">
                                            </a>
                                        </div>
                                        <div class="ml-2">
                                            <div class="h5 m-0">{{ $post->user->name }}</div>
                                            <div class="text-muted">
                                                <i class="far fa-clock"></i> {{ $post->created_at->diffForhumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    {{ $post->body }}
                                </p>
                                <p class="text-center">
                                    <img src="{{ $post->image }}" class="img-fluid">
                                </p>
                                <div class="d-flex justify-content-between">
                                    <div class="d-flex justify-content-between">
                                        <form action="{{ url('/post/like/'.$post->id) }}" method="post">
                                            @csrf
                                            @if(!$post->likes->contains('user_id',\Auth::user()->id))
                                                <button class="btn btn-outline-primary" type="submit"><i class="far fa-thumbs-up"></i> {{ $post->likes->count() }} Like</button>
                                            @else
                                                <button class="btn btn-primary" type="submit"><i class="far fa-thumbs-up"></i>  {{ $post->likes->count() }} Like</button>
                                            @endif
                                        </form>
                                    </div>
                                    <div>
                                        <span class="text-muted">comments {{ $post->comments->count() }}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <form action="{{ url('/post/comment/'.$post->id) }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="body" rows="3" class="form-control"></textarea>
                                        </div>
                                        <div class="btn-toolbar justify-content-end">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary"><i class="far fa-comment-alt"></i> comment</button>
                                            </div>
                                        </div>
                                    </form>
                                    @if(!$post->comments->isEmpty())
                                        <ul class="list-unstyled mt-3">
                                            @foreach($post->comments as $comment)
                                                <li class="media p-2 mt-2">
                                                    <a href="{{ url('/profile/'.$comment->user->id) }}">
                                                        <img src="{{ $comment->user->image ? $comment->user->image:'https://picsum.photos/50/50' }}" width="45" height="45" style="object-fit:cover;" class="rounded-circle mr-3">
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="h6 m-0">{{ $comment->user->name }}</div>
                                                        {{ $comment->body }}
                                                        <div class="text-muted">
                                                            <i class="far fa-clock"></i> {{ $comment->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <!-- end col-md-6 -->
        </div>
    </div>
@endsection
