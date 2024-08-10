@extends('layouts.app')
@section('content')
@include('layouts.message')
<h2 class="font-bold text-4xl text-blue-700">Dashboard</h2>
<hr class="h-1 bg-blue-200">

<div class="mt-4 grid grid-cols-3 gap-10">
    <div class="px-4 py-8 rounded-lg bg-blue-600 text-white flex
    justify-between">
    <p class="font-bold text-lg">Total News</p>
    <p class="font-bold text-5xl">600</p>

</div>

<div class="px-4 py-8 rounded-lg bg-red-600 text-white flex
    justify-between">
    <p class="font-bold text-lg">Total Caterogies</p>
    <p class="font-bold text-5xl">800</p>

</div>


<div class="px-4 py-8 rounded-lg bg-green-600 text-white flex
    justify-between">
    <p class="font-bold text-lg">Total Notices</p>
    <p class="font-bold text-5xl">300</p>

</div>

</div>
@endsection
