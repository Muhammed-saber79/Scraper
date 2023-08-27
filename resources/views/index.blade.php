@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        <div class="header">
            There are @if($booksCount > 0) <span style="color: green; font-weight: bold">{{$booksCount}}</span> @else <span style="color: red; font-weight: bold">no</span> @endif books
        </div>
        
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Pages Count</th>
                        <th>Language</th>
                        <th>Size</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{!! $book->pages_count ? $book->pages_count : "<span style='color: cyan;'>Not Exist</span>" !!}</td>
                        <td>{!! $book->language ? $book->language : "<span style='color: yellow;'>Not Exist</span>" !!}</td>
                        <td>{!! $book->size ? $book->size : "<span style='color: red;'>Not Exist</span>" !!}</td>
                        <td><a href="{{ $book->file_path }}"><i class="fa fa-download"></i></a></td>
                        <td>
                            <a href="#" style="color: red"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin: 15px 0px">
        {{ $books->links('vendor.pagination.semantic-ui') }}
        </div>
    </div>
</div>
@endsection