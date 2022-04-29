@extends('layouts.layoutUser')
@section('content')
    <div class="main main-raised">
        <div class="profile-content">
            <div class="container">
                <div class="tab-content">
                    <div class="tab-pane active work" id="work">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="title"><img src="../img/faces/christian.jpg" alt="Circle Image"
                                        class="img-circle img-responsive img-raised" width="60px">
                                </h4>
                                <ul class="list-unstyled" id="list-option">

                                </ul>

                            </div>
                            <div class="col-md-6" id="title-option">

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
    <script src="js/ID-user.js"></script>
@endsection
