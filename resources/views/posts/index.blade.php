@extends('layouts.app')

@section('content')


   <nav class="nav nav-tabs nav-stacked my-5">

       <a class="nav-link @if($tab == 'list') active @endif" href="{{route('posts.index')}}">List</a>
       <a class="nav-link @if($tab == 'archive') active @endif" href="{{route('posts.archive')}}">Archive</a>
       <a class="nav-link @if($tab == 'all') active @endif" href="{{route('posts.all')}}">all</a>  
   
   </nav>

   <div>
       <h4>{{$posts->count()}} posts</h4> 
   </div>


    @forelse ($posts as $post)
        <p>
            <h3>
                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
            </h3>

            @if($post->comments_count)
                <p>{{ $post->comments_count }} comments</p>
            @else
                <p>No comments yet!</p>
            @endif


            <p class="text-muted">

                {{$post->updated_at->diffForHumans()}} , By {{$post->user->name}}

            </p>

            <a href="{{ route('posts.edit', ['post' => $post->id]) }}"
                class="btn btn-primary">
                Edit
            </a>

            @if($post->deleted_at)


            <form method="POST" class="fm-inline" action="{{ route('posts.restore', ['post' => $post->id]) }}">
                @csrf
                @method('PATCH')

                <input type="submit" value="Retsore" class="btn btn-success"/>
            </form>

            <form method="POST" class="fm-inline" action="{{ route('posts.force', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')

                <input type="submit" value="Force delete" class="btn btn-danger"/>
            </form>

            @else

            <form method="POST" class="fm-inline" action="{{ route('posts.destroy', ['post' => $post->id]) }}">
                @csrf
                @method('DELETE')

                <input type="submit" value="Delete!" class="btn btn-primary"/>
            </form>

           

            @endif

        </p>
    @empty
        <p>No blog posts yet!</p>
    @endforelse
@endsection('content')