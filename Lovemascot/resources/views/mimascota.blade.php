@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <form>
                <textarea name="editor1" id="editor1" rows="10" cols="80">
                </textarea>

                <input type="button" value="Conseguir valor" id="getvaluebtn">

                <textarea name="editor2" id="editor2" cols="30" rows="10"></textarea>
                <input type="button" value="Conseguir valor" id="setvaluebtn">
            </form>
        </div>
        <!-- <form action="test" method="post">
           1 <input type="checkbox" name="test" id="1">
           2 <input type="checkbox" name="test1" id="2">
           3 <input type="checkbox" name="test2" id="3">
           4 <input type="checkbox" name="test3" id="4">
           <input type="submit" value="send">
        </form> -->
    </div>
</div>


@endsection
