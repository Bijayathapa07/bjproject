@extends('layouts.app')
@section('content')
<h2 class="font-bold text-4xl text-blue-700">Edit Category</h2>
<hr class="h-1 bg-blue-200">

<form action="{{route('category.update',$category->id)}}"  method="POST" class="mt-5">
    @csrf

    @error('name')
    <p class="text-red-600 text-xs -mt-2">{{$message}}</p>
    @enderror
    <input type="text" placeholder="Category Name" name="name" value="{{$category->name}}" class="w-full rounded-lg border-gray-300 my-2">
    @error('priority')
    <p class="text-red-600 text-xs -mt-2">{{$message}}</p>
    @enderror
    <input type="text" placeholder="Priority" name="priority"  value="{{$category->priority}}" class="w-full rounded-lg border-gray-300 my-2">

    <div class="flex">
        <input type="submit" class="bg-blue-600 text-white px-4 py-2 mx-2 rounded-lg" value="Update Category">

        <a href="{{route('category.index')}}" class="bg-red-600 text-white px-10 py-2 mx-2 rounded-lg">Exit</a>

    </div>

</form>

@endsection